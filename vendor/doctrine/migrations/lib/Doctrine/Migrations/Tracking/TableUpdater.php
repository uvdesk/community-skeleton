<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tracking;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Throwable;
use function in_array;

/**
 * The TableUpdater class is responsible for updating the tracking table schema if it needs to be updated.
 *
 * @internal
 */
class TableUpdater
{
    /** @var Connection */
    private $connection;

    /** @var AbstractSchemaManager */
    private $schemaManager;

    /** @var TableDefinition */
    private $migrationTable;

    /** @var AbstractPlatform */
    private $platform;

    public function __construct(
        Connection $connection,
        AbstractSchemaManager $schemaManager,
        TableDefinition $migrationTable,
        AbstractPlatform $platform
    ) {
        $this->connection     = $connection;
        $this->schemaManager  = $schemaManager;
        $this->migrationTable = $migrationTable;
        $this->platform       = $platform;
    }

    public function updateMigrationTable() : void
    {
        $fromTable = $this->getFromTable();
        $toTable   = $this->migrationTable->getDBALTable();

        $fromSchema = $this->createSchema([$fromTable]);
        $toSchema   = $this->createSchema([$toTable]);

        $queries = $fromSchema->getMigrateToSql($toSchema, $this->platform);

        $this->connection->beginTransaction();

        try {
            foreach ($queries as $query) {
                $this->connection->executeQuery($query);
            }
        } catch (Throwable $e) {
            $this->connection->rollBack();

            throw $e;
        }

        $this->connection->commit();
    }

    /**
     * @param Table[] $tables
     */
    protected function createSchema(array $tables) : Schema
    {
        return new Schema($tables);
    }

    private function getFromTable() : Table
    {
        $tableName   = $this->migrationTable->getName();
        $columnNames = $this->migrationTable->getColumnNames();

        $currentTable = $this->schemaManager->listTableDetails($tableName);

        $table = $this->migrationTable->createDBALTable($currentTable->getColumns());

        // remove columns from the table definition that we don't care about
        // so we don't try to drop those columns
        foreach ($table->getColumns() as $column) {
            if (in_array($column->getName(), $columnNames, true)) {
                continue;
            }

            $table->dropColumn($column->getName());
        }

        return $table;
    }
}
