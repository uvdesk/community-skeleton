<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Types\Type;
use function explode;
use function strtolower;
use function trim;

/**
 * Schema manager for the Drizzle RDBMS.
 */
class DrizzleSchemaManager extends AbstractSchemaManager
{
    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        $dbType = strtolower($tableColumn['DATA_TYPE']);

        $type                          = $this->_platform->getDoctrineTypeMapping($dbType);
        $type                          = $this->extractDoctrineTypeFromComment($tableColumn['COLUMN_COMMENT'], $type);
        $tableColumn['COLUMN_COMMENT'] = $this->removeDoctrineTypeFromComment($tableColumn['COLUMN_COMMENT'], $type);

        $options = [
            'notnull' => ! (bool) $tableColumn['IS_NULLABLE'],
            'length' => (int) $tableColumn['CHARACTER_MAXIMUM_LENGTH'],
            'default' => $tableColumn['COLUMN_DEFAULT'] ?? null,
            'autoincrement' => (bool) $tableColumn['IS_AUTO_INCREMENT'],
            'scale' => (int) $tableColumn['NUMERIC_SCALE'],
            'precision' => (int) $tableColumn['NUMERIC_PRECISION'],
            'comment' => isset($tableColumn['COLUMN_COMMENT']) && $tableColumn['COLUMN_COMMENT'] !== ''
                ? $tableColumn['COLUMN_COMMENT']
                : null,
        ];

        $column = new Column($tableColumn['COLUMN_NAME'], Type::getType($type), $options);

        if (! empty($tableColumn['COLLATION_NAME'])) {
            $column->setPlatformOption('collation', $tableColumn['COLLATION_NAME']);
        }

        return $column;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableDatabaseDefinition($database)
    {
        return $database['SCHEMA_NAME'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableDefinition($table)
    {
        return $table['TABLE_NAME'];
    }

    /**
     * {@inheritdoc}
     */
    public function _getPortableTableForeignKeyDefinition($tableForeignKey)
    {
        $columns = [];
        foreach (explode(',', $tableForeignKey['CONSTRAINT_COLUMNS']) as $value) {
            $columns[] = trim($value, ' `');
        }

        $refColumns = [];
        foreach (explode(',', $tableForeignKey['REFERENCED_TABLE_COLUMNS']) as $value) {
            $refColumns[] = trim($value, ' `');
        }

        return new ForeignKeyConstraint(
            $columns,
            $tableForeignKey['REFERENCED_TABLE_NAME'],
            $refColumns,
            $tableForeignKey['CONSTRAINT_NAME'],
            [
                'onUpdate' => $tableForeignKey['UPDATE_RULE'],
                'onDelete' => $tableForeignKey['DELETE_RULE'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableIndexesList($tableIndexes, $tableName = null)
    {
        $indexes = [];
        foreach ($tableIndexes as $k) {
            $k['primary'] = (bool) $k['primary'];
            $indexes[]    = $k;
        }

        return parent::_getPortableTableIndexesList($indexes, $tableName);
    }
}
