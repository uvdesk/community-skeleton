<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Version;

use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Exception\MigrationNotConvertibleToSql;
use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\OutputWriter;
use Doctrine\Migrations\Tracking\TableDefinition;
use function assert;
use function count;
use function date_default_timezone_get;
use function in_array;
use function str_replace;

/**
 * The Version class represents a single migration version. It wraps around your migration class
 * that extends the AbstractMigration class.
 *
 * @internal
 */
class Version
{
    /** @var Configuration */
    private $configuration;

    /** @var OutputWriter */
    private $outputWriter;

    /** @var string */
    private $version;

    /** @var AbstractMigration */
    private $migration;

    /** @var Connection */
    private $connection;

    /** @var string */
    private $class;

    /** @var int */
    private $state = State::NONE;

    /** @var ExecutorInterface */
    private $versionExecutor;

    public function __construct(
        Configuration $configuration,
        string $version,
        string $class,
        ExecutorInterface $versionExecutor
    ) {
        $this->configuration   = $configuration;
        $this->outputWriter    = $configuration->getOutputWriter();
        $this->class           = $class;
        $this->connection      = $configuration->getConnection();
        $this->migration       = new $class($this);
        $this->version         = $version;
        $this->versionExecutor = $versionExecutor;
    }

    public function __toString() : string
    {
        return $this->version;
    }

    public function getVersion() : string
    {
        return $this->version;
    }

    public function getDateTime() : string
    {
        $datetime = str_replace('Version', '', $this->version);
        $datetime = DateTimeImmutable::createFromFormat('YmdHis', $datetime);

        if ($datetime === false) {
            return '';
        }

        return $datetime->format('Y-m-d H:i:s');
    }

    public function getConfiguration() : Configuration
    {
        return $this->configuration;
    }

    public function getMigration() : AbstractMigration
    {
        return $this->migration;
    }

    public function isMigrated() : bool
    {
        return $this->configuration->hasVersionMigrated($this);
    }

    public function getExecutedAt() : ?DateTimeImmutable
    {
        $versionData          = $this->configuration->getVersionData($this);
        $executedAtColumnName = $this->configuration->getMigrationsExecutedAtColumnName();

        if (! isset($versionData[$executedAtColumnName])) {
            return null;
        }

        return (new DateTimeImmutable($versionData[$executedAtColumnName], new DateTimeZone('UTC')))
            ->setTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    public function setState(int $state) : void
    {
        assert(in_array($state, State::STATES, true));

        $this->state = $state;
    }

    public function getExecutionState() : string
    {
        switch ($this->state) {
            case State::PRE:
                return 'Pre-Checks';
            case State::POST:
                return 'Post-Checks';
            case State::EXEC:
                return 'Execution';
            default:
                return 'No State';
        }
    }

    /**
     * @param mixed[] $params
     * @param mixed[] $types
     */
    public function addSql(string $sql, array $params = [], array $types = []) : void
    {
        $this->versionExecutor->addSql($sql, $params, $types);
    }

    public function writeSqlFile(
        string $path,
        string $direction = Direction::UP
    ) : bool {
        $versionExecutionResult = $this->execute(
            $direction,
            $this->getWriteSqlFileMigratorConfig()
        );

        if (count($versionExecutionResult->getParams()) !== 0) {
            throw MigrationNotConvertibleToSql::new($this->class);
        }

        $this->outputWriter->write("\n-- Version " . $this->version . "\n");

        $sqlQueries = [$this->version => $versionExecutionResult->getSql()];

        /*
         * Since the configuration object changes during the creation we cannot inject things
         * properly, so I had to violate LoD here (so please, let's find a way to solve it on v2).
         */
        return $this->configuration
            ->getQueryWriter()
            ->write($path, $direction, $sqlQueries);
    }

    public function execute(
        string $direction,
        ?MigratorConfiguration $migratorConfiguration = null
    ) : ExecutionResult {
        return $this->versionExecutor->execute(
            $this,
            $this->migration,
            $direction,
            $migratorConfiguration
        );
    }

    public function markMigrated() : void
    {
        $this->markVersion(Direction::UP);
    }

    public function markNotMigrated() : void
    {
        $this->markVersion(Direction::DOWN);
    }

    public function markVersion(string $direction) : void
    {
        $this->configuration->createMigrationTable();

        $migrationsColumnName = $this->configuration
            ->getQuotedMigrationsColumnName();

        $migrationsExecutedAtColumnName = $this->configuration
            ->getQuotedMigrationsExecutedAtColumnName();

        if ($direction === Direction::UP) {
            $this->connection->insert(
                $this->configuration->getMigrationsTableName(),
                [
                    $migrationsColumnName => $this->version,
                    $migrationsExecutedAtColumnName => $this->getExecutedAtDatabaseValue(),
                ]
            );

            return;
        }

        $this->connection->delete(
            $this->configuration->getMigrationsTableName(),
            [
                $migrationsColumnName => $this->version,
            ]
        );
    }

    private function getWriteSqlFileMigratorConfig() : MigratorConfiguration
    {
        return (new MigratorConfiguration())->setDryRun(true);
    }

    private function getExecutedAtDatabaseValue() : string
    {
        return Type::getType(TableDefinition::MIGRATION_EXECUTED_AT_COLUMN_TYPE)->convertToDatabaseValue(
            (new DateTimeImmutable('now'))->setTimezone(new DateTimeZone('UTC')),
            $this->connection->getDatabasePlatform()
        );
    }
}
