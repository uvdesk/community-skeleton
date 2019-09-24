<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tracking;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\Migrations\Configuration\Configuration;

/**
 * The TableManipulator class is responsible for creating and updating the schema of the table used to track
 * the execution state of each migration version.
 *
 * @internal
 */
class TableManipulator
{
    /** @var Configuration */
    private $configuration;

    /** @var AbstractSchemaManager */
    private $schemaManager;

    /** @var TableDefinition */
    private $migrationTable;

    /** @var TableStatus */
    private $migrationTableStatus;

    /** @var TableUpdater */
    private $migrationTableUpdater;

    public function __construct(
        Configuration $configuration,
        AbstractSchemaManager $schemaManager,
        TableDefinition $migrationTable,
        TableStatus $migrationTableStatus,
        TableUpdater $migrationTableUpdater
    ) {
        $this->configuration         = $configuration;
        $this->schemaManager         = $schemaManager;
        $this->migrationTable        = $migrationTable;
        $this->migrationTableStatus  = $migrationTableStatus;
        $this->migrationTableUpdater = $migrationTableUpdater;
    }

    public function createMigrationTable() : bool
    {
        $this->configuration->validate();

        if ($this->configuration->isDryRun()) {
            return false;
        }

        if ($this->migrationTableStatus->isCreated()) {
            if (! $this->migrationTableStatus->isUpToDate()) {
                $this->migrationTableUpdater->updateMigrationTable();

                $this->migrationTableStatus->setUpToDate(true);

                return true;
            }

            return false;
        }

        $table = $this->migrationTable->getNewDBALTable();

        $this->schemaManager->createTable($table);

        $this->migrationTableStatus->setCreated(true);

        return true;
    }
}
