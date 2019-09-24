<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tracking;

use Doctrine\DBAL\Schema\AbstractSchemaManager;

/**
 * The TableStatus class is responsible for checking if the tracking table needs to be created or updated.
 *
 * @internal
 */
class TableStatus
{
    /** @var AbstractSchemaManager */
    private $schemaManager;

    /** @var TableDefinition */
    private $migrationTable;

    /** @var bool|null */
    private $created;

    /** @var bool|null */
    private $upToDate;

    public function __construct(
        AbstractSchemaManager $schemaManager,
        TableDefinition $migrationTable
    ) {
        $this->schemaManager  = $schemaManager;
        $this->migrationTable = $migrationTable;
    }

    public function setCreated(bool $created) : void
    {
        $this->created = $created;
    }

    public function isCreated() : bool
    {
        if ($this->created !== null) {
            return $this->created;
        }

        $this->created = $this->schemaManager->tablesExist([$this->migrationTable->getName()]);

        return $this->created;
    }

    public function setUpToDate(bool $upToDate) : void
    {
        $this->upToDate = $upToDate;
    }

    public function isUpToDate() : bool
    {
        if ($this->upToDate !== null) {
            return $this->upToDate;
        }

        $table = $this->schemaManager->listTableDetails($this->migrationTable->getName());

        $this->upToDate = true;

        foreach ($this->migrationTable->getColumnNames() as $columnName) {
            if ($table->hasColumn($columnName)) {
                continue;
            }

            $this->upToDate = false;
            break;
        }

        return $this->upToDate;
    }
}
