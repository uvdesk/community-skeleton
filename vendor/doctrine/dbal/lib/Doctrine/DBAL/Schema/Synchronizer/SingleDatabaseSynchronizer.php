<?php

namespace Doctrine\DBAL\Schema\Synchronizer;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Visitor\DropSchemaSqlCollector;
use function count;

/**
 * Schema Synchronizer for Default DBAL Connection.
 */
class SingleDatabaseSynchronizer extends AbstractSchemaSynchronizer
{
    /** @var AbstractPlatform */
    private $platform;

    public function __construct(Connection $conn)
    {
        parent::__construct($conn);
        $this->platform = $conn->getDatabasePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateSchema(Schema $createSchema)
    {
        return $createSchema->toSql($this->platform);
    }


    /**
     * {@inheritdoc}
     */
    public function getUpdateSchema(Schema $toSchema, $noDrops = false)
    {
        $comparator = new Comparator();
        $sm         = $this->conn->getSchemaManager();

        $fromSchema = $sm->createSchema();
        $schemaDiff = $comparator->compare($fromSchema, $toSchema);

        if ($noDrops) {
            return $schemaDiff->toSaveSql($this->platform);
        }

        return $schemaDiff->toSql($this->platform);
    }

    /**
     * {@inheritdoc}
     */
    public function getDropSchema(Schema $dropSchema)
    {
        $visitor = new DropSchemaSqlCollector($this->platform);
        $sm      = $this->conn->getSchemaManager();

        $fullSchema = $sm->createSchema();

        foreach ($fullSchema->getTables() as $table) {
            if ($dropSchema->hasTable($table->getName())) {
                $visitor->acceptTable($table);
            }

            foreach ($table->getForeignKeys() as $foreignKey) {
                if (! $dropSchema->hasTable($table->getName())) {
                    continue;
                }

                if (! $dropSchema->hasTable($foreignKey->getForeignTableName())) {
                    continue;
                }

                $visitor->acceptForeignKey($table, $foreignKey);
            }
        }

        if (! $this->platform->supportsSequences()) {
            return $visitor->getQueries();
        }

        foreach ($dropSchema->getSequences() as $sequence) {
            $visitor->acceptSequence($sequence);
        }

        foreach ($dropSchema->getTables() as $table) {
            if (! $table->hasPrimaryKey()) {
                continue;
            }

            $columns = $table->getPrimaryKey()->getColumns();
            if (count($columns) > 1) {
                continue;
            }

            $checkSequence = $table->getName() . '_' . $columns[0] . '_seq';
            if (! $fullSchema->hasSequence($checkSequence)) {
                continue;
            }

            $visitor->acceptSequence($fullSchema->getSequence($checkSequence));
        }

        return $visitor->getQueries();
    }

    /**
     * {@inheritdoc}
     */
    public function getDropAllSchema()
    {
        $sm      = $this->conn->getSchemaManager();
        $visitor = new DropSchemaSqlCollector($this->platform);

        $schema = $sm->createSchema();
        $schema->visit($visitor);

        return $visitor->getQueries();
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
    public function dropAllSchema()
    {
        $this->processSql($this->getDropAllSchema());
    }
}
