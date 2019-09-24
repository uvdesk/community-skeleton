<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Event\SchemaColumnDefinitionEventArgs;
use Doctrine\DBAL\Event\SchemaIndexDefinitionEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Throwable;
use function array_filter;
use function array_intersect;
use function array_map;
use function array_values;
use function call_user_func_array;
use function count;
use function func_get_args;
use function is_array;
use function preg_match;
use function str_replace;
use function strtolower;

/**
 * Base class for schema managers. Schema managers are used to inspect and/or
 * modify the database schema/structure.
 */
abstract class AbstractSchemaManager
{
    /**
     * Holds instance of the Doctrine connection for this schema manager.
     *
     * @var Connection
     */
    protected $_conn;

    /**
     * Holds instance of the database platform used for this schema manager.
     *
     * @var AbstractPlatform
     */
    protected $_platform;

    /**
     * Constructor. Accepts the Connection instance to manage the schema for.
     */
    public function __construct(Connection $conn, ?AbstractPlatform $platform = null)
    {
        $this->_conn     = $conn;
        $this->_platform = $platform ?: $this->_conn->getDatabasePlatform();
    }

    /**
     * Returns the associated platform.
     *
     * @return AbstractPlatform
     */
    public function getDatabasePlatform()
    {
        return $this->_platform;
    }

    /**
     * Tries any method on the schema manager. Normally a method throws an
     * exception when your DBMS doesn't support it or if an error occurs.
     * This method allows you to try and method on your SchemaManager
     * instance and will return false if it does not work or is not supported.
     *
     * <code>
     * $result = $sm->tryMethod('dropView', 'view_name');
     * </code>
     *
     * @return mixed
     */
    public function tryMethod()
    {
        $args   = func_get_args();
        $method = $args[0];
        unset($args[0]);
        $args = array_values($args);

        try {
            return call_user_func_array([$this, $method], $args);
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Lists the available databases for this connection.
     *
     * @return string[]
     */
    public function listDatabases()
    {
        $sql = $this->_platform->getListDatabasesSQL();

        $databases = $this->_conn->fetchAll($sql);

        return $this->_getPortableDatabasesList($databases);
    }

    /**
     * Returns a list of all namespaces in the current database.
     *
     * @return string[]
     */
    public function listNamespaceNames()
    {
        $sql = $this->_platform->getListNamespacesSQL();

        $namespaces = $this->_conn->fetchAll($sql);

        return $this->getPortableNamespacesList($namespaces);
    }

    /**
     * Lists the available sequences for this connection.
     *
     * @param string|null $database
     *
     * @return Sequence[]
     */
    public function listSequences($database = null)
    {
        if ($database === null) {
            $database = $this->_conn->getDatabase();
        }
        $sql = $this->_platform->getListSequencesSQL($database);

        $sequences = $this->_conn->fetchAll($sql);

        return $this->filterAssetNames($this->_getPortableSequencesList($sequences));
    }

    /**
     * Lists the columns for a given table.
     *
     * In contrast to other libraries and to the old version of Doctrine,
     * this column definition does try to contain the 'primary' field for
     * the reason that it is not portable across different RDBMS. Use
     * {@see listTableIndexes($tableName)} to retrieve the primary key
     * of a table. We're a RDBMS specifies more details these are held
     * in the platformDetails array.
     *
     * @param string      $table    The name of the table.
     * @param string|null $database
     *
     * @return Column[]
     */
    public function listTableColumns($table, $database = null)
    {
        if (! $database) {
            $database = $this->_conn->getDatabase();
        }

        $sql = $this->_platform->getListTableColumnsSQL($table, $database);

        $tableColumns = $this->_conn->fetchAll($sql);

        return $this->_getPortableTableColumnList($table, $database, $tableColumns);
    }

    /**
     * Lists the indexes for a given table returning an array of Index instances.
     *
     * Keys of the portable indexes list are all lower-cased.
     *
     * @param string $table The name of the table.
     *
     * @return Index[]
     */
    public function listTableIndexes($table)
    {
        $sql = $this->_platform->getListTableIndexesSQL($table, $this->_conn->getDatabase());

        $tableIndexes = $this->_conn->fetchAll($sql);

        return $this->_getPortableTableIndexesList($tableIndexes, $table);
    }

    /**
     * Returns true if all the given tables exist.
     *
     * @param string[] $tableNames
     *
     * @return bool
     */
    public function tablesExist($tableNames)
    {
        $tableNames = array_map('strtolower', (array) $tableNames);

        return count($tableNames) === count(array_intersect($tableNames, array_map('strtolower', $this->listTableNames())));
    }

    /**
     * Returns a list of all tables in the current database.
     *
     * @return string[]
     */
    public function listTableNames()
    {
        $sql = $this->_platform->getListTablesSQL();

        $tables     = $this->_conn->fetchAll($sql);
        $tableNames = $this->_getPortableTablesList($tables);

        return $this->filterAssetNames($tableNames);
    }

    /**
     * Filters asset names if they are configured to return only a subset of all
     * the found elements.
     *
     * @param mixed[] $assetNames
     *
     * @return mixed[]
     */
    protected function filterAssetNames($assetNames)
    {
        $filter = $this->_conn->getConfiguration()->getSchemaAssetsFilter();
        if (! $filter) {
            return $assetNames;
        }

        return array_values(array_filter($assetNames, $filter));
    }

    /**
     * @deprecated Use Configuration::getSchemaAssetsFilter() instead
     *
     * @return string|null
     */
    protected function getFilterSchemaAssetsExpression()
    {
        return $this->_conn->getConfiguration()->getFilterSchemaAssetsExpression();
    }

    /**
     * Lists the tables for this connection.
     *
     * @return Table[]
     */
    public function listTables()
    {
        $tableNames = $this->listTableNames();

        $tables = [];
        foreach ($tableNames as $tableName) {
            $tables[] = $this->listTableDetails($tableName);
        }

        return $tables;
    }

    /**
     * @param string $tableName
     *
     * @return Table
     */
    public function listTableDetails($tableName)
    {
        $columns     = $this->listTableColumns($tableName);
        $foreignKeys = [];
        if ($this->_platform->supportsForeignKeyConstraints()) {
            $foreignKeys = $this->listTableForeignKeys($tableName);
        }
        $indexes = $this->listTableIndexes($tableName);

        return new Table($tableName, $columns, $indexes, $foreignKeys, false, []);
    }

    /**
     * Lists the views this connection has.
     *
     * @return View[]
     */
    public function listViews()
    {
        $database = $this->_conn->getDatabase();
        $sql      = $this->_platform->getListViewsSQL($database);
        $views    = $this->_conn->fetchAll($sql);

        return $this->_getPortableViewsList($views);
    }

    /**
     * Lists the foreign keys for the given table.
     *
     * @param string      $table    The name of the table.
     * @param string|null $database
     *
     * @return ForeignKeyConstraint[]
     */
    public function listTableForeignKeys($table, $database = null)
    {
        if ($database === null) {
            $database = $this->_conn->getDatabase();
        }
        $sql              = $this->_platform->getListTableForeignKeysSQL($table, $database);
        $tableForeignKeys = $this->_conn->fetchAll($sql);

        return $this->_getPortableTableForeignKeysList($tableForeignKeys);
    }

    /* drop*() Methods */

    /**
     * Drops a database.
     *
     * NOTE: You can not drop the database this SchemaManager is currently connected to.
     *
     * @param string $database The name of the database to drop.
     *
     * @return void
     */
    public function dropDatabase($database)
    {
        $this->_execSql($this->_platform->getDropDatabaseSQL($database));
    }

    /**
     * Drops the given table.
     *
     * @param string $tableName The name of the table to drop.
     *
     * @return void
     */
    public function dropTable($tableName)
    {
        $this->_execSql($this->_platform->getDropTableSQL($tableName));
    }

    /**
     * Drops the index from the given table.
     *
     * @param Index|string $index The name of the index.
     * @param Table|string $table The name of the table.
     *
     * @return void
     */
    public function dropIndex($index, $table)
    {
        if ($index instanceof Index) {
            $index = $index->getQuotedName($this->_platform);
        }

        $this->_execSql($this->_platform->getDropIndexSQL($index, $table));
    }

    /**
     * Drops the constraint from the given table.
     *
     * @param Table|string $table The name of the table.
     *
     * @return void
     */
    public function dropConstraint(Constraint $constraint, $table)
    {
        $this->_execSql($this->_platform->getDropConstraintSQL($constraint, $table));
    }

    /**
     * Drops a foreign key from a table.
     *
     * @param ForeignKeyConstraint|string $foreignKey The name of the foreign key.
     * @param Table|string                $table      The name of the table with the foreign key.
     *
     * @return void
     */
    public function dropForeignKey($foreignKey, $table)
    {
        $this->_execSql($this->_platform->getDropForeignKeySQL($foreignKey, $table));
    }

    /**
     * Drops a sequence with a given name.
     *
     * @param string $name The name of the sequence to drop.
     *
     * @return void
     */
    public function dropSequence($name)
    {
        $this->_execSql($this->_platform->getDropSequenceSQL($name));
    }

    /**
     * Drops a view.
     *
     * @param string $name The name of the view.
     *
     * @return void
     */
    public function dropView($name)
    {
        $this->_execSql($this->_platform->getDropViewSQL($name));
    }

    /* create*() Methods */

    /**
     * Creates a new database.
     *
     * @param string $database The name of the database to create.
     *
     * @return void
     */
    public function createDatabase($database)
    {
        $this->_execSql($this->_platform->getCreateDatabaseSQL($database));
    }

    /**
     * Creates a new table.
     *
     * @return void
     */
    public function createTable(Table $table)
    {
        $createFlags = AbstractPlatform::CREATE_INDEXES|AbstractPlatform::CREATE_FOREIGNKEYS;
        $this->_execSql($this->_platform->getCreateTableSQL($table, $createFlags));
    }

    /**
     * Creates a new sequence.
     *
     * @param Sequence $sequence
     *
     * @return void
     *
     * @throws ConnectionException If something fails at database level.
     */
    public function createSequence($sequence)
    {
        $this->_execSql($this->_platform->getCreateSequenceSQL($sequence));
    }

    /**
     * Creates a constraint on a table.
     *
     * @param Table|string $table
     *
     * @return void
     */
    public function createConstraint(Constraint $constraint, $table)
    {
        $this->_execSql($this->_platform->getCreateConstraintSQL($constraint, $table));
    }

    /**
     * Creates a new index on a table.
     *
     * @param Table|string $table The name of the table on which the index is to be created.
     *
     * @return void
     */
    public function createIndex(Index $index, $table)
    {
        $this->_execSql($this->_platform->getCreateIndexSQL($index, $table));
    }

    /**
     * Creates a new foreign key.
     *
     * @param ForeignKeyConstraint $foreignKey The ForeignKey instance.
     * @param Table|string         $table      The name of the table on which the foreign key is to be created.
     *
     * @return void
     */
    public function createForeignKey(ForeignKeyConstraint $foreignKey, $table)
    {
        $this->_execSql($this->_platform->getCreateForeignKeySQL($foreignKey, $table));
    }

    /**
     * Creates a new view.
     *
     * @return void
     */
    public function createView(View $view)
    {
        $this->_execSql($this->_platform->getCreateViewSQL($view->getQuotedName($this->_platform), $view->getSql()));
    }

    /* dropAndCreate*() Methods */

    /**
     * Drops and creates a constraint.
     *
     * @see dropConstraint()
     * @see createConstraint()
     *
     * @param Table|string $table
     *
     * @return void
     */
    public function dropAndCreateConstraint(Constraint $constraint, $table)
    {
        $this->tryMethod('dropConstraint', $constraint, $table);
        $this->createConstraint($constraint, $table);
    }

    /**
     * Drops and creates a new index on a table.
     *
     * @param Table|string $table The name of the table on which the index is to be created.
     *
     * @return void
     */
    public function dropAndCreateIndex(Index $index, $table)
    {
        $this->tryMethod('dropIndex', $index->getQuotedName($this->_platform), $table);
        $this->createIndex($index, $table);
    }

    /**
     * Drops and creates a new foreign key.
     *
     * @param ForeignKeyConstraint $foreignKey An associative array that defines properties of the foreign key to be created.
     * @param Table|string         $table      The name of the table on which the foreign key is to be created.
     *
     * @return void
     */
    public function dropAndCreateForeignKey(ForeignKeyConstraint $foreignKey, $table)
    {
        $this->tryMethod('dropForeignKey', $foreignKey, $table);
        $this->createForeignKey($foreignKey, $table);
    }

    /**
     * Drops and create a new sequence.
     *
     * @return void
     *
     * @throws ConnectionException If something fails at database level.
     */
    public function dropAndCreateSequence(Sequence $sequence)
    {
        $this->tryMethod('dropSequence', $sequence->getQuotedName($this->_platform));
        $this->createSequence($sequence);
    }

    /**
     * Drops and creates a new table.
     *
     * @return void
     */
    public function dropAndCreateTable(Table $table)
    {
        $this->tryMethod('dropTable', $table->getQuotedName($this->_platform));
        $this->createTable($table);
    }

    /**
     * Drops and creates a new database.
     *
     * @param string $database The name of the database to create.
     *
     * @return void
     */
    public function dropAndCreateDatabase($database)
    {
        $this->tryMethod('dropDatabase', $database);
        $this->createDatabase($database);
    }

    /**
     * Drops and creates a new view.
     *
     * @return void
     */
    public function dropAndCreateView(View $view)
    {
        $this->tryMethod('dropView', $view->getQuotedName($this->_platform));
        $this->createView($view);
    }

    /* alterTable() Methods */

    /**
     * Alters an existing tables schema.
     *
     * @return void
     */
    public function alterTable(TableDiff $tableDiff)
    {
        $queries = $this->_platform->getAlterTableSQL($tableDiff);
        if (! is_array($queries) || ! count($queries)) {
            return;
        }

        foreach ($queries as $ddlQuery) {
            $this->_execSql($ddlQuery);
        }
    }

    /**
     * Renames a given table to another name.
     *
     * @param string $name    The current name of the table.
     * @param string $newName The new name of the table.
     *
     * @return void
     */
    public function renameTable($name, $newName)
    {
        $tableDiff          = new TableDiff($name);
        $tableDiff->newName = $newName;
        $this->alterTable($tableDiff);
    }

    /**
     * Methods for filtering return values of list*() methods to convert
     * the native DBMS data definition to a portable Doctrine definition
     */

    /**
     * @param mixed[] $databases
     *
     * @return string[]
     */
    protected function _getPortableDatabasesList($databases)
    {
        $list = [];
        foreach ($databases as $value) {
            $value = $this->_getPortableDatabaseDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * Converts a list of namespace names from the native DBMS data definition to a portable Doctrine definition.
     *
     * @param mixed[][] $namespaces The list of namespace names in the native DBMS data definition.
     *
     * @return string[]
     */
    protected function getPortableNamespacesList(array $namespaces)
    {
        $namespacesList = [];

        foreach ($namespaces as $namespace) {
            $namespacesList[] = $this->getPortableNamespaceDefinition($namespace);
        }

        return $namespacesList;
    }

    /**
     * @param mixed $database
     *
     * @return mixed
     */
    protected function _getPortableDatabaseDefinition($database)
    {
        return $database;
    }

    /**
     * Converts a namespace definition from the native DBMS data definition to a portable Doctrine definition.
     *
     * @param mixed[] $namespace The native DBMS namespace definition.
     *
     * @return mixed
     */
    protected function getPortableNamespaceDefinition(array $namespace)
    {
        return $namespace;
    }

    /**
     * @param mixed[][] $functions
     *
     * @return mixed[][]
     */
    protected function _getPortableFunctionsList($functions)
    {
        $list = [];
        foreach ($functions as $value) {
            $value = $this->_getPortableFunctionDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed[] $function
     *
     * @return mixed
     */
    protected function _getPortableFunctionDefinition($function)
    {
        return $function;
    }

    /**
     * @param mixed[][] $triggers
     *
     * @return mixed[][]
     */
    protected function _getPortableTriggersList($triggers)
    {
        $list = [];
        foreach ($triggers as $value) {
            $value = $this->_getPortableTriggerDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed[] $trigger
     *
     * @return mixed
     */
    protected function _getPortableTriggerDefinition($trigger)
    {
        return $trigger;
    }

    /**
     * @param mixed[][] $sequences
     *
     * @return Sequence[]
     */
    protected function _getPortableSequencesList($sequences)
    {
        $list = [];
        foreach ($sequences as $value) {
            $value = $this->_getPortableSequenceDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed[] $sequence
     *
     * @return Sequence
     *
     * @throws DBALException
     */
    protected function _getPortableSequenceDefinition($sequence)
    {
        throw DBALException::notSupported('Sequences');
    }

    /**
     * Independent of the database the keys of the column list result are lowercased.
     *
     * The name of the created column instance however is kept in its case.
     *
     * @param string    $table        The name of the table.
     * @param string    $database
     * @param mixed[][] $tableColumns
     *
     * @return Column[]
     */
    protected function _getPortableTableColumnList($table, $database, $tableColumns)
    {
        $eventManager = $this->_platform->getEventManager();

        $list = [];
        foreach ($tableColumns as $tableColumn) {
            $column           = null;
            $defaultPrevented = false;

            if ($eventManager !== null && $eventManager->hasListeners(Events::onSchemaColumnDefinition)) {
                $eventArgs = new SchemaColumnDefinitionEventArgs($tableColumn, $table, $database, $this->_conn);
                $eventManager->dispatchEvent(Events::onSchemaColumnDefinition, $eventArgs);

                $defaultPrevented = $eventArgs->isDefaultPrevented();
                $column           = $eventArgs->getColumn();
            }

            if (! $defaultPrevented) {
                $column = $this->_getPortableTableColumnDefinition($tableColumn);
            }

            if (! $column) {
                continue;
            }

            $name        = strtolower($column->getQuotedName($this->_platform));
            $list[$name] = $column;
        }

        return $list;
    }

    /**
     * Gets Table Column Definition.
     *
     * @param mixed[] $tableColumn
     *
     * @return Column
     */
    abstract protected function _getPortableTableColumnDefinition($tableColumn);

    /**
     * Aggregates and groups the index results according to the required data result.
     *
     * @param mixed[][]   $tableIndexRows
     * @param string|null $tableName
     *
     * @return Index[]
     */
    protected function _getPortableTableIndexesList($tableIndexRows, $tableName = null)
    {
        $result = [];
        foreach ($tableIndexRows as $tableIndex) {
            $indexName = $keyName = $tableIndex['key_name'];
            if ($tableIndex['primary']) {
                $keyName = 'primary';
            }
            $keyName = strtolower($keyName);

            if (! isset($result[$keyName])) {
                $options = [
                    'lengths' => [],
                ];

                if (isset($tableIndex['where'])) {
                    $options['where'] = $tableIndex['where'];
                }

                $result[$keyName] = [
                    'name' => $indexName,
                    'columns' => [],
                    'unique' => $tableIndex['non_unique'] ? false : true,
                    'primary' => $tableIndex['primary'],
                    'flags' => $tableIndex['flags'] ?? [],
                    'options' => $options,
                ];
            }

            $result[$keyName]['columns'][]            = $tableIndex['column_name'];
            $result[$keyName]['options']['lengths'][] = $tableIndex['length'] ?? null;
        }

        $eventManager = $this->_platform->getEventManager();

        $indexes = [];
        foreach ($result as $indexKey => $data) {
            $index            = null;
            $defaultPrevented = false;

            if ($eventManager !== null && $eventManager->hasListeners(Events::onSchemaIndexDefinition)) {
                $eventArgs = new SchemaIndexDefinitionEventArgs($data, $tableName, $this->_conn);
                $eventManager->dispatchEvent(Events::onSchemaIndexDefinition, $eventArgs);

                $defaultPrevented = $eventArgs->isDefaultPrevented();
                $index            = $eventArgs->getIndex();
            }

            if (! $defaultPrevented) {
                $index = new Index($data['name'], $data['columns'], $data['unique'], $data['primary'], $data['flags'], $data['options']);
            }

            if (! $index) {
                continue;
            }

            $indexes[$indexKey] = $index;
        }

        return $indexes;
    }

    /**
     * @param mixed[][] $tables
     *
     * @return string[]
     */
    protected function _getPortableTablesList($tables)
    {
        $list = [];
        foreach ($tables as $value) {
            $value = $this->_getPortableTableDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed $table
     *
     * @return string
     */
    protected function _getPortableTableDefinition($table)
    {
        return $table;
    }

    /**
     * @param mixed[][] $users
     *
     * @return string[][]
     */
    protected function _getPortableUsersList($users)
    {
        $list = [];
        foreach ($users as $value) {
            $value = $this->_getPortableUserDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed[] $user
     *
     * @return mixed[]
     */
    protected function _getPortableUserDefinition($user)
    {
        return $user;
    }

    /**
     * @param mixed[][] $views
     *
     * @return View[]
     */
    protected function _getPortableViewsList($views)
    {
        $list = [];
        foreach ($views as $value) {
            $view = $this->_getPortableViewDefinition($value);

            if (! $view) {
                continue;
            }

            $viewName        = strtolower($view->getQuotedName($this->_platform));
            $list[$viewName] = $view;
        }

        return $list;
    }

    /**
     * @param mixed[] $view
     *
     * @return View|false
     */
    protected function _getPortableViewDefinition($view)
    {
        return false;
    }

    /**
     * @param mixed[][] $tableForeignKeys
     *
     * @return ForeignKeyConstraint[]
     */
    protected function _getPortableTableForeignKeysList($tableForeignKeys)
    {
        $list = [];
        foreach ($tableForeignKeys as $value) {
            $value = $this->_getPortableTableForeignKeyDefinition($value);

            if (! $value) {
                continue;
            }

            $list[] = $value;
        }

        return $list;
    }

    /**
     * @param mixed $tableForeignKey
     *
     * @return ForeignKeyConstraint
     */
    protected function _getPortableTableForeignKeyDefinition($tableForeignKey)
    {
        return $tableForeignKey;
    }

    /**
     * @param string[]|string $sql
     *
     * @return void
     */
    protected function _execSql($sql)
    {
        foreach ((array) $sql as $query) {
            $this->_conn->executeUpdate($query);
        }
    }

    /**
     * Creates a schema instance for the current database.
     *
     * @return Schema
     */
    public function createSchema()
    {
        $namespaces = [];

        if ($this->_platform->supportsSchemas()) {
            $namespaces = $this->listNamespaceNames();
        }

        $sequences = [];

        if ($this->_platform->supportsSequences()) {
            $sequences = $this->listSequences();
        }

        $tables = $this->listTables();

        return new Schema($tables, $sequences, $this->createSchemaConfig(), $namespaces);
    }

    /**
     * Creates the configuration for this schema.
     *
     * @return SchemaConfig
     */
    public function createSchemaConfig()
    {
        $schemaConfig = new SchemaConfig();
        $schemaConfig->setMaxIdentifierLength($this->_platform->getMaxIdentifierLength());

        $searchPaths = $this->getSchemaSearchPaths();
        if (isset($searchPaths[0])) {
            $schemaConfig->setName($searchPaths[0]);
        }

        $params = $this->_conn->getParams();
        if (! isset($params['defaultTableOptions'])) {
            $params['defaultTableOptions'] = [];
        }
        if (! isset($params['defaultTableOptions']['charset']) && isset($params['charset'])) {
            $params['defaultTableOptions']['charset'] = $params['charset'];
        }
        $schemaConfig->setDefaultTableOptions($params['defaultTableOptions']);

        return $schemaConfig;
    }

    /**
     * The search path for namespaces in the currently connected database.
     *
     * The first entry is usually the default namespace in the Schema. All
     * further namespaces contain tables/sequences which can also be addressed
     * with a short, not full-qualified name.
     *
     * For databases that don't support subschema/namespaces this method
     * returns the name of the currently connected database.
     *
     * @return string[]
     */
    public function getSchemaSearchPaths()
    {
        return [$this->_conn->getDatabase()];
    }

    /**
     * Given a table comment this method tries to extract a typehint for Doctrine Type, or returns
     * the type given as default.
     *
     * @param string $comment
     * @param string $currentType
     *
     * @return string
     */
    public function extractDoctrineTypeFromComment($comment, $currentType)
    {
        if (preg_match('(\(DC2Type:(((?!\)).)+)\))', $comment, $match)) {
            $currentType = $match[1];
        }

        return $currentType;
    }

    /**
     * @param string $comment
     * @param string $type
     *
     * @return string
     */
    public function removeDoctrineTypeFromComment($comment, $type)
    {
        return str_replace('(DC2Type:' . $type . ')', '', $comment);
    }
}
