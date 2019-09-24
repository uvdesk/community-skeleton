<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tracking;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

/**
 * The TableDefinition class is responsible for defining the schema of the table used to track the execution state of
 * each migration version.
 *
 * @internal
 */
class TableDefinition
{
    public const MIGRATION_COLUMN_TYPE             = 'string';
    public const MIGRATION_EXECUTED_AT_COLUMN_TYPE = 'datetime_immutable';

    /** @var AbstractSchemaManager */
    private $schemaManager;

    /** @var string */
    private $name;

    /** @var string */
    private $columnName;

    /** @var int */
    private $columnLength;

    /** @var string */
    private $executedAtColumnName;

    public function __construct(
        AbstractSchemaManager $schemaManager,
        string $name,
        string $columnName,
        int $columnLength,
        string $executedAtColumnName
    ) {
        $this->schemaManager        = $schemaManager;
        $this->name                 = $name;
        $this->columnName           = $columnName;
        $this->columnLength         = $columnLength;
        $this->executedAtColumnName = $executedAtColumnName;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getColumnName() : string
    {
        return $this->columnName;
    }

    public function getColumnLength() : int
    {
        return $this->columnLength;
    }

    public function getExecutedAtColumnName() : string
    {
        return $this->executedAtColumnName;
    }

    public function getMigrationsColumn() : Column
    {
        return new Column(
            $this->columnName,
            Type::getType(self::MIGRATION_COLUMN_TYPE),
            ['length' => $this->columnLength]
        );
    }

    public function getExecutedAtColumn() : Column
    {
        return new Column(
            $this->executedAtColumnName,
            Type::getType(self::MIGRATION_EXECUTED_AT_COLUMN_TYPE)
        );
    }

    /**
     * @return string[]
     */
    public function getColumnNames() : array
    {
        return [
            $this->columnName,
            $this->executedAtColumnName,
        ];
    }

    public function getDBALTable() : Table
    {
        $executedAtColumn = $this->getExecutedAtColumn();
        $executedAtColumn->setNotnull(false);

        $columns = [
            $this->columnName           => $this->getMigrationsColumn(),
            $this->executedAtColumnName => $executedAtColumn,
        ];

        return $this->createDBALTable($columns);
    }

    public function getNewDBALTable() : Table
    {
        $executedAtColumn = $this->getExecutedAtColumn();
        $executedAtColumn->setNotnull(true);

        $columns = [
            $this->columnName           => $this->getMigrationsColumn(),
            $this->executedAtColumnName => $executedAtColumn,
        ];

        return $this->createDBALTable($columns);
    }

    /**
     * @param Column[] $columns
     */
    public function createDBALTable(array $columns) : Table
    {
        $schemaConfig = $this->schemaManager->createSchemaConfig();

        $table = new Table($this->getName(), $columns);
        $table->setPrimaryKey([$this->getColumnName()]);

        foreach ($schemaConfig->getDefaultTableOptions() as $name => $value) {
            $table->addOption($name, $value);
        }

        return $table;
    }
}
