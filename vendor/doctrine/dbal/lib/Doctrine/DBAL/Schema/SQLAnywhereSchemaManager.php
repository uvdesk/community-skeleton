<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Platforms\SQLAnywherePlatform;
use Doctrine\DBAL\Types\Type;
use function assert;
use function preg_replace;

/**
 * SAP Sybase SQL Anywhere schema manager.
 */
class SQLAnywhereSchemaManager extends AbstractSchemaManager
{
    /**
     * {@inheritdoc}
     *
     * Starts a database after creation
     * as SQL Anywhere needs a database to be started
     * before it can be used.
     *
     * @see startDatabase
     */
    public function createDatabase($database)
    {
        parent::createDatabase($database);
        $this->startDatabase($database);
    }

    /**
     * {@inheritdoc}
     *
     * Tries stopping a database before dropping
     * as SQL Anywhere needs a database to be stopped
     * before it can be dropped.
     *
     * @see stopDatabase
     */
    public function dropDatabase($database)
    {
        $this->tryMethod('stopDatabase', $database);
        parent::dropDatabase($database);
    }

    /**
     * Starts a database.
     *
     * @param string $database The name of the database to start.
     */
    public function startDatabase($database)
    {
        assert($this->_platform instanceof SQLAnywherePlatform);
        $this->_execSql($this->_platform->getStartDatabaseSQL($database));
    }

    /**
     * Stops a database.
     *
     * @param string $database The name of the database to stop.
     */
    public function stopDatabase($database)
    {
        assert($this->_platform instanceof SQLAnywherePlatform);
        $this->_execSql($this->_platform->getStopDatabaseSQL($database));
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableDatabaseDefinition($database)
    {
        return $database['name'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableSequenceDefinition($sequence)
    {
        return new Sequence($sequence['sequence_name'], $sequence['increment_by'], $sequence['start_with']);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        $type                   = $this->_platform->getDoctrineTypeMapping($tableColumn['type']);
        $type                   = $this->extractDoctrineTypeFromComment($tableColumn['comment'], $type);
        $tableColumn['comment'] = $this->removeDoctrineTypeFromComment($tableColumn['comment'], $type);
        $precision              = null;
        $scale                  = null;
        $fixed                  = false;
        $default                = null;

        if ($tableColumn['default'] !== null) {
            // Strip quotes from default value.
            $default = preg_replace(["/^'(.*)'$/", "/''/"], ['$1', "'"], $tableColumn['default']);

            if ($default === 'autoincrement') {
                $default = null;
            }
        }

        switch ($tableColumn['type']) {
            case 'binary':
            case 'char':
            case 'nchar':
                $fixed = true;
        }

        switch ($type) {
            case 'decimal':
            case 'float':
                $precision = $tableColumn['length'];
                $scale     = $tableColumn['scale'];
        }

        return new Column(
            $tableColumn['column_name'],
            Type::getType($type),
            [
                'length'        => $type === 'string' ? $tableColumn['length'] : null,
                'precision'     => $precision,
                'scale'         => $scale,
                'unsigned'      => (bool) $tableColumn['unsigned'],
                'fixed'         => $fixed,
                'notnull'       => (bool) $tableColumn['notnull'],
                'default'       => $default,
                'autoincrement' => (bool) $tableColumn['autoincrement'],
                'comment'       => isset($tableColumn['comment']) && $tableColumn['comment'] !== ''
                    ? $tableColumn['comment']
                    : null,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableDefinition($table)
    {
        return $table['table_name'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableForeignKeyDefinition($tableForeignKey)
    {
        return new ForeignKeyConstraint(
            $tableForeignKey['local_columns'],
            $tableForeignKey['foreign_table'],
            $tableForeignKey['foreign_columns'],
            $tableForeignKey['name'],
            $tableForeignKey['options']
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableForeignKeysList($tableForeignKeys)
    {
        $foreignKeys = [];

        foreach ($tableForeignKeys as $tableForeignKey) {
            if (! isset($foreignKeys[$tableForeignKey['index_name']])) {
                $foreignKeys[$tableForeignKey['index_name']] = [
                    'local_columns'   => [$tableForeignKey['local_column']],
                    'foreign_table'   => $tableForeignKey['foreign_table'],
                    'foreign_columns' => [$tableForeignKey['foreign_column']],
                    'name'            => $tableForeignKey['index_name'],
                    'options'         => [
                        'notnull'           => $tableForeignKey['notnull'],
                        'match'             => $tableForeignKey['match'],
                        'onUpdate'          => $tableForeignKey['on_update'],
                        'onDelete'          => $tableForeignKey['on_delete'],
                        'check_on_commit'   => $tableForeignKey['check_on_commit'],
                        'clustered'         => $tableForeignKey['clustered'],
                        'for_olap_workload' => $tableForeignKey['for_olap_workload'],
                    ],
                ];
            } else {
                $foreignKeys[$tableForeignKey['index_name']]['local_columns'][]   = $tableForeignKey['local_column'];
                $foreignKeys[$tableForeignKey['index_name']]['foreign_columns'][] = $tableForeignKey['foreign_column'];
            }
        }

        return parent::_getPortableTableForeignKeysList($foreignKeys);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableIndexesList($tableIndexRows, $tableName = null)
    {
        foreach ($tableIndexRows as &$tableIndex) {
            $tableIndex['primary'] = (bool) $tableIndex['primary'];
            $tableIndex['flags']   = [];

            if ($tableIndex['clustered']) {
                $tableIndex['flags'][] = 'clustered';
            }

            if ($tableIndex['with_nulls_not_distinct']) {
                $tableIndex['flags'][] = 'with_nulls_not_distinct';
            }

            if (! $tableIndex['for_olap_workload']) {
                continue;
            }

            $tableIndex['flags'][] = 'for_olap_workload';
        }

        return parent::_getPortableTableIndexesList($tableIndexRows, $tableName);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableViewDefinition($view)
    {
        return new View(
            $view['table_name'],
            preg_replace('/^.*\s+as\s+SELECT(.*)/i', 'SELECT$1', $view['view_def'])
        );
    }
}
