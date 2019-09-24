<?php

namespace Doctrine\DBAL\Sharding\SQLAzure;

use Closure;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Synchronizer\AbstractSchemaSynchronizer;
use Doctrine\DBAL\Schema\Synchronizer\SchemaSynchronizer;
use Doctrine\DBAL\Schema\Synchronizer\SingleDatabaseSynchronizer;
use Doctrine\DBAL\Types\Type;
use RuntimeException;
use function array_merge;

/**
 * SQL Azure Schema Synchronizer.
 *
 * Will iterate over all shards when performing schema operations. This is done
 * by partitioning the passed schema into subschemas for the federation and the
 * global database and then applying the operations step by step using the
 * {@see \Doctrine\DBAL\Schema\Synchronizer\SingleDatabaseSynchronizer}.
 */
class SQLAzureFederationsSynchronizer extends AbstractSchemaSynchronizer
{
    public const FEDERATION_TABLE_FEDERATED   = 'azure.federated';
    public const FEDERATION_DISTRIBUTION_NAME = 'azure.federatedOnDistributionName';

    /** @var SQLAzureShardManager */
    private $shardManager;

    /** @var SchemaSynchronizer */
    private $synchronizer;

    public function __construct(Connection $conn, SQLAzureShardManager $shardManager, ?SchemaSynchronizer $sync = null)
    {
        parent::__construct($conn);
        $this->shardManager = $shardManager;
        $this->synchronizer = $sync ?: new SingleDatabaseSynchronizer($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateSchema(Schema $createSchema)
    {
        $sql = [];

        [$global, $federation] = $this->partitionSchema($createSchema);

        $globalSql = $this->synchronizer->getCreateSchema($global);
        if ($globalSql) {
            $sql[] = "-- Create Root Federation\n" .
                     'USE FEDERATION ROOT WITH RESET;';
            $sql   = array_merge($sql, $globalSql);
        }

        $federationSql = $this->synchronizer->getCreateSchema($federation);

        if ($federationSql) {
            $defaultValue = $this->getFederationTypeDefaultValue();

            $sql[] = $this->getCreateFederationStatement();
            $sql[] = 'USE FEDERATION ' . $this->shardManager->getFederationName() . ' (' . $this->shardManager->getDistributionKey() . ' = ' . $defaultValue . ') WITH RESET, FILTERING = OFF;';
            $sql   = array_merge($sql, $federationSql);
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdateSchema(Schema $toSchema, $noDrops = false)
    {
        return $this->work($toSchema, static function ($synchronizer, $schema) use ($noDrops) {
            return $synchronizer->getUpdateSchema($schema, $noDrops);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getDropSchema(Schema $dropSchema)
    {
        return $this->work($dropSchema, static function ($synchronizer, $schema) {
            return $synchronizer->getDropSchema($schema);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function createSchema(Schema $createSchema)
    {
        $this->processSql($this->getCreateSchema($createSchema));
    }

    /**
     * {@inheritdoc}
     */
    public function updateSchema(Schema $toSchema, $noDrops = false)
    {
        $this->processSql($this->getUpdateSchema($toSchema, $noDrops));
    }

    /**
     * {@inheritdoc}
     */
    public function dropSchema(Schema $dropSchema)
    {
        $this->processSqlSafely($this->getDropSchema($dropSchema));
    }

    /**
     * {@inheritdoc}
     */
    public function getDropAllSchema()
    {
        $this->shardManager->selectGlobal();
        $globalSql = $this->synchronizer->getDropAllSchema();

        if ($globalSql) {
            $sql[] = "-- Work on Root Federation\nUSE FEDERATION ROOT WITH RESET;";
            $sql   = array_merge($sql, $globalSql);
        }

        $shards = $this->shardManager->getShards();
        foreach ($shards as $shard) {
            $this->shardManager->selectShard($shard['rangeLow']);

            $federationSql = $this->synchronizer->getDropAllSchema();
            if (! $federationSql) {
                continue;
            }

            $sql[] = '-- Work on Federation ID ' . $shard['id'] . "\n" .
                     'USE FEDERATION ' . $this->shardManager->getFederationName() . ' (' . $this->shardManager->getDistributionKey() . ' = ' . $shard['rangeLow'] . ') WITH RESET, FILTERING = OFF;';
            $sql   = array_merge($sql, $federationSql);
        }

        $sql[] = 'USE FEDERATION ROOT WITH RESET;';
        $sql[] = 'DROP FEDERATION ' . $this->shardManager->getFederationName();

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function dropAllSchema()
    {
        $this->processSqlSafely($this->getDropAllSchema());
    }

    /**
     * @return Schema[]
     */
    private function partitionSchema(Schema $schema)
    {
        return [
            $this->extractSchemaFederation($schema, false),
            $this->extractSchemaFederation($schema, true),
        ];
    }

    /**
     * @param bool $isFederation
     *
     * @return Schema
     *
     * @throws RuntimeException
     */
    private function extractSchemaFederation(Schema $schema, $isFederation)
    {
        $partitionedSchema = clone $schema;

        foreach ($partitionedSchema->getTables() as $table) {
            if ($isFederation) {
                $table->addOption(self::FEDERATION_DISTRIBUTION_NAME, $this->shardManager->getDistributionKey());
            }

            if ($table->hasOption(self::FEDERATION_TABLE_FEDERATED) !== $isFederation) {
                $partitionedSchema->dropTable($table->getName());
            } else {
                foreach ($table->getForeignKeys() as $fk) {
                    $foreignTable = $schema->getTable($fk->getForeignTableName());
                    if ($foreignTable->hasOption(self::FEDERATION_TABLE_FEDERATED) !== $isFederation) {
                        throw new RuntimeException('Cannot have foreign key between global/federation.');
                    }
                }
            }
        }

        return $partitionedSchema;
    }

    /**
     * Work on the Global/Federation based on currently existing shards and
     * perform the given operation on the underlying schema synchronizer given
     * the different partitioned schema instances.
     *
     * @return string[]
     */
    private function work(Schema $schema, Closure $operation)
    {
        [$global, $federation] = $this->partitionSchema($schema);
        $sql                   = [];

        $this->shardManager->selectGlobal();
        $globalSql = $operation($this->synchronizer, $global);

        if ($globalSql) {
            $sql[] = "-- Work on Root Federation\nUSE FEDERATION ROOT WITH RESET;";
            $sql   = array_merge($sql, $globalSql);
        }

        $shards = $this->shardManager->getShards();

        foreach ($shards as $shard) {
            $this->shardManager->selectShard($shard['rangeLow']);

            $federationSql = $operation($this->synchronizer, $federation);
            if (! $federationSql) {
                continue;
            }

            $sql[] = '-- Work on Federation ID ' . $shard['id'] . "\n" .
                     'USE FEDERATION ' . $this->shardManager->getFederationName() . ' (' . $this->shardManager->getDistributionKey() . ' = ' . $shard['rangeLow'] . ') WITH RESET, FILTERING = OFF;';
            $sql   = array_merge($sql, $federationSql);
        }

        return $sql;
    }

    /**
     * @return string
     */
    private function getFederationTypeDefaultValue()
    {
        $federationType = Type::getType($this->shardManager->getDistributionType());

        switch ($federationType->getName()) {
            case Type::GUID:
                $defaultValue = '00000000-0000-0000-0000-000000000000';
                break;
            case Type::INTEGER:
            case Type::SMALLINT:
            case Type::BIGINT:
                $defaultValue = '0';
                break;
            default:
                $defaultValue = '';
                break;
        }

        return $defaultValue;
    }

    /**
     * @return string
     */
    private function getCreateFederationStatement()
    {
        $federationType    = Type::getType($this->shardManager->getDistributionType());
        $federationTypeSql = $federationType->getSQLDeclaration([], $this->conn->getDatabasePlatform());

        return "--Create Federation\n" .
               'CREATE FEDERATION ' . $this->shardManager->getFederationName() . ' (' . $this->shardManager->getDistributionKey() . ' ' . $federationTypeSql . '  RANGE)';
    }
}
