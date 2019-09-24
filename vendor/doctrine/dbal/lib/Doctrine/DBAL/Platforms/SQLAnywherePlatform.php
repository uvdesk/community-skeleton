<?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\LockMode;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use InvalidArgumentException;
use function array_merge;
use function array_unique;
use function array_values;
use function count;
use function explode;
use function func_get_args;
use function get_class;
use function implode;
use function is_string;
use function preg_replace;
use function sprintf;
use function strlen;
use function strpos;
use function strtoupper;
use function substr;

/**
 * The SQLAnywherePlatform provides the behavior, features and SQL dialect of the
 * SAP Sybase SQL Anywhere 10 database platform.
 */
class SQLAnywherePlatform extends AbstractPlatform
{
    public const FOREIGN_KEY_MATCH_SIMPLE        = 1;
    public const FOREIGN_KEY_MATCH_FULL          = 2;
    public const FOREIGN_KEY_MATCH_SIMPLE_UNIQUE = 129;
    public const FOREIGN_KEY_MATCH_FULL_UNIQUE   = 130;

    /**
     * {@inheritdoc}
     */
    public function appendLockHint($fromClause, $lockMode)
    {
        switch (true) {
            case $lockMode === LockMode::NONE:
                return $fromClause . ' WITH (NOLOCK)';

            case $lockMode === LockMode::PESSIMISTIC_READ:
                return $fromClause . ' WITH (UPDLOCK)';

            case $lockMode === LockMode::PESSIMISTIC_WRITE:
                return $fromClause . ' WITH (XLOCK)';

            default:
                return $fromClause;
        }
    }

    /**
     * {@inheritdoc}
     *
     * SQL Anywhere supports a maximum length of 128 bytes for identifiers.
     */
    public function fixSchemaElementName($schemaElementName)
    {
        $maxIdentifierLength = $this->getMaxIdentifierLength();

        if (strlen($schemaElementName) > $maxIdentifierLength) {
            return substr($schemaElementName, 0, $maxIdentifierLength);
        }

        return $schemaElementName;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdvancedForeignKeyOptionsSQL(ForeignKeyConstraint $foreignKey)
    {
        $query = '';

        if ($foreignKey->hasOption('match')) {
            $query = ' MATCH ' . $this->getForeignKeyMatchClauseSQL($foreignKey->getOption('match'));
        }

        $query .= parent::getAdvancedForeignKeyOptionsSQL($foreignKey);

        if ($foreignKey->hasOption('check_on_commit') && (bool) $foreignKey->getOption('check_on_commit')) {
            $query .= ' CHECK ON COMMIT';
        }

        if ($foreignKey->hasOption('clustered') && (bool) $foreignKey->getOption('clustered')) {
            $query .= ' CLUSTERED';
        }

        if ($foreignKey->hasOption('for_olap_workload') && (bool) $foreignKey->getOption('for_olap_workload')) {
            $query .= ' FOR OLAP WORKLOAD';
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlterTableSQL(TableDiff $diff)
    {
        $sql          = [];
        $columnSql    = [];
        $commentsSQL  = [];
        $tableSql     = [];
        $alterClauses = [];

        foreach ($diff->addedColumns as $column) {
            if ($this->onSchemaAlterTableAddColumn($column, $diff, $columnSql)) {
                continue;
            }

            $alterClauses[] = $this->getAlterTableAddColumnClause($column);

            $comment = $this->getColumnComment($column);

            if ($comment === null || $comment === '') {
                continue;
            }

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $diff->getName($this)->getQuotedName($this),
                $column->getQuotedName($this),
                $comment
            );
        }

        foreach ($diff->removedColumns as $column) {
            if ($this->onSchemaAlterTableRemoveColumn($column, $diff, $columnSql)) {
                continue;
            }

            $alterClauses[] = $this->getAlterTableRemoveColumnClause($column);
        }

        foreach ($diff->changedColumns as $columnDiff) {
            if ($this->onSchemaAlterTableChangeColumn($columnDiff, $diff, $columnSql)) {
                continue;
            }

            $alterClause = $this->getAlterTableChangeColumnClause($columnDiff);

            if ($alterClause !== null) {
                $alterClauses[] = $alterClause;
            }

            if (! $columnDiff->hasChanged('comment')) {
                continue;
            }

            $column = $columnDiff->column;

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $diff->getName($this)->getQuotedName($this),
                $column->getQuotedName($this),
                $this->getColumnComment($column)
            );
        }

        foreach ($diff->renamedColumns as $oldColumnName => $column) {
            if ($this->onSchemaAlterTableRenameColumn($oldColumnName, $column, $diff, $columnSql)) {
                continue;
            }

            $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' .
                $this->getAlterTableRenameColumnClause($oldColumnName, $column);
        }

        if (! $this->onSchemaAlterTable($diff, $tableSql)) {
            if (! empty($alterClauses)) {
                $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' . implode(', ', $alterClauses);
            }

            $sql = array_merge($sql, $commentsSQL);

            if ($diff->newName !== false) {
                $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' .
                    $this->getAlterTableRenameTableClause($diff->getNewName());
            }

            $sql = array_merge(
                $this->getPreAlterTableIndexForeignKeySQL($diff),
                $sql,
                $this->getPostAlterTableIndexForeignKeySQL($diff)
            );
        }

        return array_merge($sql, $tableSql, $columnSql);
    }

    /**
     * Returns the SQL clause for creating a column in a table alteration.
     *
     * @param Column $column The column to add.
     *
     * @return string
     */
    protected function getAlterTableAddColumnClause(Column $column)
    {
        return 'ADD ' . $this->getColumnDeclarationSQL($column->getQuotedName($this), $column->toArray());
    }

    /**
     * Returns the SQL clause for altering a table.
     *
     * @param Identifier $tableName The quoted name of the table to alter.
     *
     * @return string
     */
    protected function getAlterTableClause(Identifier $tableName)
    {
        return 'ALTER TABLE ' . $tableName->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for dropping a column in a table alteration.
     *
     * @param Column $column The column to drop.
     *
     * @return string
     */
    protected function getAlterTableRemoveColumnClause(Column $column)
    {
        return 'DROP ' . $column->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for renaming a column in a table alteration.
     *
     * @param string $oldColumnName The quoted name of the column to rename.
     * @param Column $column        The column to rename to.
     *
     * @return string
     */
    protected function getAlterTableRenameColumnClause($oldColumnName, Column $column)
    {
        $oldColumnName = new Identifier($oldColumnName);

        return 'RENAME ' . $oldColumnName->getQuotedName($this) . ' TO ' . $column->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for renaming a table in a table alteration.
     *
     * @param Identifier $newTableName The quoted name of the table to rename to.
     *
     * @return string
     */
    protected function getAlterTableRenameTableClause(Identifier $newTableName)
    {
        return 'RENAME ' . $newTableName->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for altering a column in a table alteration.
     *
     * This method returns null in case that only the column comment has changed.
     * Changes in column comments have to be handled differently.
     *
     * @param ColumnDiff $columnDiff The diff of the column to alter.
     *
     * @return string|null
     */
    protected function getAlterTableChangeColumnClause(ColumnDiff $columnDiff)
    {
        $column = $columnDiff->column;

        // Do not return alter clause if only comment has changed.
        if (! ($columnDiff->hasChanged('comment') && count($columnDiff->changedProperties) === 1)) {
            $columnAlterationClause = 'ALTER ' .
                $this->getColumnDeclarationSQL($column->getQuotedName($this), $column->toArray());

            if ($columnDiff->hasChanged('default') && $column->getDefault() === null) {
                $columnAlterationClause .= ', ALTER ' . $column->getQuotedName($this) . ' DROP DEFAULT';
            }

            return $columnAlterationClause;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'BIGINT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryDefaultLength()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryMaxLength()
    {
        return 32767;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        return 'LONG BINARY';
    }

    /**
     * {@inheritdoc}
     *
     * BIT type columns require an explicit NULL declaration
     * in SQL Anywhere if they shall be nullable.
     * Otherwise by just omitting the NOT NULL clause,
     * SQL Anywhere will declare them NOT NULL nonetheless.
     */
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        $nullClause = isset($columnDef['notnull']) && (bool) $columnDef['notnull'] === false ? ' NULL' : '';

        return 'BIT' . $nullClause;
    }

    /**
     * {@inheritdoc}
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        return 'TEXT';
    }

    /**
     * {@inheritdoc}
     */
    public function getCommentOnColumnSQL($tableName, $columnName, $comment)
    {
        $tableName  = new Identifier($tableName);
        $columnName = new Identifier($columnName);
        $comment    = $comment === null ? 'NULL' : $this->quoteStringLiteral($comment);

        return sprintf(
            'COMMENT ON COLUMN %s.%s IS %s',
            $tableName->getQuotedName($this),
            $columnName->getQuotedName($this),
            $comment
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConcatExpression()
    {
        return 'STRING(' . implode(', ', (array) func_get_args()) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateConstraintSQL(Constraint $constraint, $table)
    {
        if ($constraint instanceof ForeignKeyConstraint) {
            return $this->getCreateForeignKeySQL($constraint, $table);
        }

        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        return 'ALTER TABLE ' . $table .
               ' ADD ' . $this->getTableConstraintDeclarationSQL($constraint, $constraint->getQuotedName($this));
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "CREATE DATABASE '" . $database->getName() . "'";
    }

    /**
     * {@inheritdoc}
     *
     * Appends SQL Anywhere specific flags if given.
     */
    public function getCreateIndexSQL(Index $index, $table)
    {
        return parent::getCreateIndexSQL($index, $table) . $this->getAdvancedIndexOptionsSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatePrimaryKeySQL(Index $index, $table)
    {
        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        return 'ALTER TABLE ' . $table . ' ADD ' . $this->getPrimaryKeyDeclarationSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateTemporaryTableSnippetSQL()
    {
        return 'CREATE ' . $this->getTemporaryTableSQL() . ' TABLE';
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateViewSQL($name, $sql)
    {
        return 'CREATE VIEW ' . $name . ' AS ' . $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentDateSQL()
    {
        return 'CURRENT DATE';
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTimeSQL()
    {
        return 'CURRENT TIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTimestampSQL()
    {
        return 'CURRENT TIMESTAMP';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDateArithmeticIntervalExpression($date, $operator, $interval, $unit)
    {
        $factorClause = '';

        if ($operator === '-') {
            $factorClause = '-1 * ';
        }

        return 'DATEADD(' . $unit . ', ' . $factorClause . $interval . ', ' . $date . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateDiffExpression($date1, $date2)
    {
        return 'DATEDIFF(day, ' . $date2 . ', ' . $date1 . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormatString()
    {
        return 'Y-m-d H:i:s.u';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATETIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzFormatString()
    {
        return $this->getDateTimeFormatString();
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATE';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTransactionIsolationLevel()
    {
        return TransactionIsolationLevel::READ_UNCOMMITTED;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "DROP DATABASE '" . $database->getName() . "'";
    }

    /**
     * {@inheritdoc}
     */
    public function getDropIndexSQL($index, $table = null)
    {
        if ($index instanceof Index) {
            $index = $index->getQuotedName($this);
        }

        if (! is_string($index)) {
            throw new InvalidArgumentException(
                'SQLAnywherePlatform::getDropIndexSQL() expects $index parameter to be string or ' . Index::class . '.'
            );
        }

        if (! isset($table)) {
            return 'DROP INDEX ' . $index;
        }

        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        if (! is_string($table)) {
            throw new InvalidArgumentException(
                'SQLAnywherePlatform::getDropIndexSQL() expects $table parameter to be string or ' . Index::class . '.'
            );
        }

        return 'DROP INDEX ' . $table . '.' . $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropViewSQL($name)
    {
        return 'DROP VIEW ' . $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyBaseDeclarationSQL(ForeignKeyConstraint $foreignKey)
    {
        $sql              = '';
        $foreignKeyName   = $foreignKey->getName();
        $localColumns     = $foreignKey->getQuotedLocalColumns($this);
        $foreignColumns   = $foreignKey->getQuotedForeignColumns($this);
        $foreignTableName = $foreignKey->getQuotedForeignTableName($this);

        if (! empty($foreignKeyName)) {
            $sql .= 'CONSTRAINT ' . $foreignKey->getQuotedName($this) . ' ';
        }

        if (empty($localColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'local' required.");
        }

        if (empty($foreignColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'foreign' required.");
        }

        if (empty($foreignTableName)) {
            throw new InvalidArgumentException("Incomplete definition. 'foreignTable' required.");
        }

        if ($foreignKey->hasOption('notnull') && (bool) $foreignKey->getOption('notnull')) {
            $sql .= 'NOT NULL ';
        }

        return $sql .
            'FOREIGN KEY (' . $this->getIndexFieldDeclarationListSQL($localColumns) . ') ' .
            'REFERENCES ' . $foreignKey->getQuotedForeignTableName($this) .
            ' (' . $this->getIndexFieldDeclarationListSQL($foreignColumns) . ')';
    }

    /**
     * Returns foreign key MATCH clause for given type.
     *
     * @param int $type The foreign key match type
     *
     * @return string
     *
     * @throws InvalidArgumentException If unknown match type given.
     */
    public function getForeignKeyMatchClauseSQL($type)
    {
        switch ((int) $type) {
            case self::FOREIGN_KEY_MATCH_SIMPLE:
                return 'SIMPLE';
                break;
            case self::FOREIGN_KEY_MATCH_FULL:
                return 'FULL';
                break;
            case self::FOREIGN_KEY_MATCH_SIMPLE_UNIQUE:
                return 'UNIQUE SIMPLE';
                break;
            case self::FOREIGN_KEY_MATCH_FULL_UNIQUE:
                return 'UNIQUE FULL';
            default:
                throw new InvalidArgumentException('Invalid foreign key match type: ' . $type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyReferentialActionSQL($action)
    {
        // NO ACTION is not supported, therefore falling back to RESTRICT.
        if (strtoupper($action) === 'NO ACTION') {
            return 'RESTRICT';
        }

        return parent::getForeignKeyReferentialActionSQL($action);
    }

    /**
     * {@inheritdoc}
     */
    public function getForUpdateSQL()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Use application-generated UUIDs instead
     */
    public function getGuidExpression()
    {
        return 'NEWID()';
    }

    /**
     * {@inheritdoc}
     */
    public function getGuidTypeDeclarationSQL(array $field)
    {
        return 'UNIQUEIDENTIFIER';
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexDeclarationSQL($name, Index $index)
    {
        // Index declaration in statements like CREATE TABLE is not supported.
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'INT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * {@inheritdoc}
     */
    public function getListDatabasesSQL()
    {
        return 'SELECT db_name(number) AS name FROM sa_db_list()';
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        $user = 'USER_NAME()';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
        }

        return sprintf(
            <<<'SQL'
SELECT    col.column_name,
          COALESCE(def.user_type_name, def.domain_name) AS 'type',
          def.declared_width AS 'length',
          def.scale,
          CHARINDEX('unsigned', def.domain_name) AS 'unsigned',
          IF col.nulls = 'Y' THEN 0 ELSE 1 ENDIF AS 'notnull',
          col."default",
          def.is_autoincrement AS 'autoincrement',
          rem.remarks AS 'comment'
FROM      sa_describe_query('SELECT * FROM "%s"') AS def
JOIN      SYS.SYSTABCOL AS col
ON        col.table_id = def.base_table_id AND col.column_id = def.base_column_id
LEFT JOIN SYS.SYSREMARK AS rem
ON        col.object_id = rem.object_id
WHERE     def.base_owner_name = %s
ORDER BY  def.base_column_id ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     *
     * @todo Where is this used? Which information should be retrieved?
     */
    public function getListTableConstraintsSQL($table)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT con.*
FROM   SYS.SYSCONSTRAINT AS con
JOIN   SYS.SYSTAB AS tab ON con.table_object_id = tab.object_id
WHERE  tab.table_name = %s
AND    tab.creator = USER_ID(%s)
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableForeignKeysSQL($table)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT    fcol.column_name AS local_column,
          ptbl.table_name AS foreign_table,
          pcol.column_name AS foreign_column,
          idx.index_name,
          IF fk.nulls = 'N'
              THEN 1
              ELSE NULL
          ENDIF AS notnull,
          CASE ut.referential_action
              WHEN 'C' THEN 'CASCADE'
              WHEN 'D' THEN 'SET DEFAULT'
              WHEN 'N' THEN 'SET NULL'
              WHEN 'R' THEN 'RESTRICT'
              ELSE NULL
          END AS  on_update,
          CASE dt.referential_action
              WHEN 'C' THEN 'CASCADE'
              WHEN 'D' THEN 'SET DEFAULT'
              WHEN 'N' THEN 'SET NULL'
              WHEN 'R' THEN 'RESTRICT'
              ELSE NULL
          END AS on_delete,
          IF fk.check_on_commit = 'Y'
              THEN 1
              ELSE NULL
          ENDIF AS check_on_commit, -- check_on_commit flag
          IF ftbl.clustered_index_id = idx.index_id
              THEN 1
              ELSE NULL
          ENDIF AS 'clustered', -- clustered flag
          IF fk.match_type = 0
              THEN NULL
              ELSE fk.match_type
          ENDIF AS 'match', -- match option
          IF pidx.max_key_distance = 1
              THEN 1
              ELSE NULL
          ENDIF AS for_olap_workload -- for_olap_workload flag
FROM      SYS.SYSFKEY AS fk
JOIN      SYS.SYSIDX AS idx
ON        fk.foreign_table_id = idx.table_id
AND       fk.foreign_index_id = idx.index_id
JOIN      SYS.SYSPHYSIDX pidx
ON        idx.table_id = pidx.table_id
AND       idx.phys_index_id = pidx.phys_index_id
JOIN      SYS.SYSTAB AS ptbl
ON        fk.primary_table_id = ptbl.table_id
JOIN      SYS.SYSTAB AS ftbl
ON        fk.foreign_table_id = ftbl.table_id
JOIN      SYS.SYSIDXCOL AS idxcol
ON        idx.table_id = idxcol.table_id
AND       idx.index_id = idxcol.index_id
JOIN      SYS.SYSTABCOL AS pcol
ON        ptbl.table_id = pcol.table_id
AND       idxcol.primary_column_id = pcol.column_id
JOIN      SYS.SYSTABCOL AS fcol
ON        ftbl.table_id = fcol.table_id
AND       idxcol.column_id = fcol.column_id
LEFT JOIN SYS.SYSTRIGGER ut
ON        fk.foreign_table_id = ut.foreign_table_id
AND       fk.foreign_index_id = ut.foreign_key_id
AND       ut.event = 'C'
LEFT JOIN SYS.SYSTRIGGER dt
ON        fk.foreign_table_id = dt.foreign_table_id
AND       fk.foreign_index_id = dt.foreign_key_id
AND       dt.event = 'D'
WHERE     ftbl.table_name = %s
AND       ftbl.creator = USER_ID(%s)
ORDER BY  fk.foreign_index_id ASC, idxcol.sequence ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableIndexesSQL($table, $currentDatabase = null)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT   idx.index_name AS key_name,
         IF idx.index_category = 1
             THEN 1
             ELSE 0
         ENDIF AS 'primary',
         col.column_name,
         IF idx."unique" IN(1, 2, 5)
             THEN 0
             ELSE 1
         ENDIF AS non_unique,
         IF tbl.clustered_index_id = idx.index_id
             THEN 1
             ELSE NULL
         ENDIF AS 'clustered', -- clustered flag
         IF idx."unique" = 5
             THEN 1
             ELSE NULL
         ENDIF AS with_nulls_not_distinct, -- with_nulls_not_distinct flag
         IF pidx.max_key_distance = 1
              THEN 1
              ELSE NULL
          ENDIF AS for_olap_workload -- for_olap_workload flag
FROM     SYS.SYSIDX AS idx
JOIN     SYS.SYSPHYSIDX pidx
ON       idx.table_id = pidx.table_id
AND      idx.phys_index_id = pidx.phys_index_id
JOIN     SYS.SYSIDXCOL AS idxcol
ON       idx.table_id = idxcol.table_id AND idx.index_id = idxcol.index_id
JOIN     SYS.SYSTABCOL AS col
ON       idxcol.table_id = col.table_id AND idxcol.column_id = col.column_id
JOIN     SYS.SYSTAB AS tbl
ON       idx.table_id = tbl.table_id
WHERE    tbl.table_name = %s
AND      tbl.creator = USER_ID(%s)
AND      idx.index_category != 2 -- exclude indexes implicitly created by foreign key constraints
ORDER BY idx.index_id ASC, idxcol.sequence ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTablesSQL()
    {
        return "SELECT   tbl.table_name
                FROM     SYS.SYSTAB AS tbl
                JOIN     SYS.SYSUSER AS usr ON tbl.creator = usr.user_id
                JOIN     dbo.SYSOBJECTS AS obj ON tbl.object_id = obj.id
                WHERE    tbl.table_type IN(1, 3) -- 'BASE', 'GBL TEMP'
                AND      usr.user_name NOT IN('SYS', 'dbo', 'rs_systabgroup') -- exclude system users
                AND      obj.type = 'U' -- user created tables only
                ORDER BY tbl.table_name ASC";
    }

    /**
     * {@inheritdoc}
     *
     * @todo Where is this used? Which information should be retrieved?
     */
    public function getListUsersSQL()
    {
        return 'SELECT * FROM SYS.SYSUSER ORDER BY user_name ASC';
    }

    /**
     * {@inheritdoc}
     */
    public function getListViewsSQL($database)
    {
        return "SELECT   tbl.table_name, v.view_def
                FROM     SYS.SYSVIEW v
                JOIN     SYS.SYSTAB tbl ON v.view_object_id = tbl.object_id
                JOIN     SYS.SYSUSER usr ON tbl.creator = usr.user_id
                JOIN     dbo.SYSOBJECTS obj ON tbl.object_id = obj.id
                WHERE    usr.user_name NOT IN('SYS', 'dbo', 'rs_systabgroup') -- exclude system users
                ORDER BY tbl.table_name ASC";
    }

    /**
     * {@inheritdoc}
     */
    public function getLocateExpression($str, $substr, $startPos = false)
    {
        if ($startPos === false) {
            return 'LOCATE(' . $str . ', ' . $substr . ')';
        }

        return 'LOCATE(' . $str . ', ' . $substr . ', ' . $startPos . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxIdentifierLength()
    {
        return 128;
    }

    /**
     * {@inheritdoc}
     */
    public function getMd5Expression($column)
    {
        return 'HASH(' . $column . ", 'MD5')";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sqlanywhere';
    }

    /**
     * Obtain DBMS specific SQL code portion needed to set a primary key
     * declaration to be used in statements like ALTER TABLE.
     *
     * @param Index  $index Index definition
     * @param string $name  Name of the primary key
     *
     * @return string DBMS specific SQL code portion needed to set a primary key
     *
     * @throws InvalidArgumentException If the given index is not a primary key.
     */
    public function getPrimaryKeyDeclarationSQL(Index $index, $name = null)
    {
        if (! $index->isPrimary()) {
            throw new InvalidArgumentException(
                'Can only create primary key declarations with getPrimaryKeyDeclarationSQL()'
            );
        }

        return $this->getTableConstraintDeclarationSQL($index, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSetTransactionIsolationSQL($level)
    {
        return 'SET TEMPORARY OPTION isolation_level = ' . $this->_getTransactionIsolationLevelSQL($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'SMALLINT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * Returns the SQL statement for starting an existing database.
     *
     * In SQL Anywhere you can start and stop databases on a
     * database server instance.
     * This is a required statement after having created a new database
     * as it has to be explicitly started to be usable.
     * SQL Anywhere does not automatically start a database after creation!
     *
     * @param string $database Name of the database to start.
     *
     * @return string
     */
    public function getStartDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "START DATABASE '" . $database->getName() . "' AUTOSTOP OFF";
    }

    /**
     * Returns the SQL statement for stopping a running database.
     *
     * In SQL Anywhere you can start and stop databases on a
     * database server instance.
     * This is a required statement before dropping an existing database
     * as it has to be explicitly stopped before it can be dropped.
     *
     * @param string $database Name of the database to stop.
     *
     * @return string
     */
    public function getStopDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return 'STOP DATABASE "' . $database->getName() . '" UNCONDITIONALLY';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubstringExpression($value, $from, $length = null)
    {
        if ($length === null) {
            return 'SUBSTRING(' . $value . ', ' . $from . ')';
        }

        return 'SUBSTRING(' . $value . ', ' . $from . ', ' . $length . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemporaryTableSQL()
    {
        return 'GLOBAL TEMPORARY';
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeFormatString()
    {
        return 'H:i:s.u';
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getTrimExpression($str, $pos = TrimMode::UNSPECIFIED, $char = false)
    {
        if (! $char) {
            switch ($pos) {
                case TrimMode::LEADING:
                    return $this->getLtrimExpression($str);
                case TrimMode::TRAILING:
                    return $this->getRtrimExpression($str);
                default:
                    return 'TRIM(' . $str . ')';
            }
        }

        $pattern = "'%[^' + " . $char . " + ']%'";

        switch ($pos) {
            case TrimMode::LEADING:
                return 'SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))';
            case TrimMode::TRAILING:
                return 'REVERSE(SUBSTR(REVERSE(' . $str . '), PATINDEX(' . $pattern . ', REVERSE(' . $str . '))))';
            default:
                return 'REVERSE(SUBSTR(REVERSE(SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))), ' .
                    'PATINDEX(' . $pattern . ', REVERSE(SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))))))';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        $tableIdentifier = new Identifier($tableName);

        return 'TRUNCATE TABLE ' . $tableIdentifier->getQuotedName($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueConstraintDeclarationSQL($name, Index $index)
    {
        if ($index->isPrimary()) {
            throw new InvalidArgumentException(
                'Cannot create primary key constraint declarations with getUniqueConstraintDeclarationSQL().'
            );
        }

        if (! $index->isUnique()) {
            throw new InvalidArgumentException(
                'Can only create unique constraint declarations, no common index declarations with ' .
                'getUniqueConstraintDeclarationSQL().'
            );
        }

        return $this->getTableConstraintDeclarationSQL($index, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharDefaultLength()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharMaxLength()
    {
        return 32767;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNativeGuidType()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function prefersIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsCommentOnStatement()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        $unsigned      = ! empty($columnDef['unsigned']) ? 'UNSIGNED ' : '';
        $autoincrement = ! empty($columnDef['autoincrement']) ? ' IDENTITY' : '';

        return $unsigned . $columnDef['integer_type'] . $autoincrement;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCreateTableSQL($tableName, array $columns, array $options = [])
    {
        $columnListSql = $this->getColumnDeclarationListSQL($columns);
        $indexSql      = [];

        if (! empty($options['uniqueConstraints'])) {
            foreach ((array) $options['uniqueConstraints'] as $name => $definition) {
                $columnListSql .= ', ' . $this->getUniqueConstraintDeclarationSQL($name, $definition);
            }
        }

        if (! empty($options['indexes'])) {
            /** @var Index $index */
            foreach ((array) $options['indexes'] as $index) {
                $indexSql[] = $this->getCreateIndexSQL($index, $tableName);
            }
        }

        if (! empty($options['primary'])) {
            $flags = '';

            if (isset($options['primary_index']) && $options['primary_index']->hasFlag('clustered')) {
                $flags = ' CLUSTERED ';
            }

            $columnListSql .= ', PRIMARY KEY' . $flags . ' (' . implode(', ', array_unique(array_values((array) $options['primary']))) . ')';
        }

        if (! empty($options['foreignKeys'])) {
            foreach ((array) $options['foreignKeys'] as $definition) {
                $columnListSql .= ', ' . $this->getForeignKeyDeclarationSQL($definition);
            }
        }

        $query = 'CREATE TABLE ' . $tableName . ' (' . $columnListSql;
        $check = $this->getCheckDeclarationSQL($columns);

        if (! empty($check)) {
            $query .= ', ' . $check;
        }

        $query .= ')';

        return array_merge([$query], $indexSql);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getTransactionIsolationLevelSQL($level)
    {
        switch ($level) {
            case TransactionIsolationLevel::READ_UNCOMMITTED:
                return 0;
            case TransactionIsolationLevel::READ_COMMITTED:
                return 1;
            case TransactionIsolationLevel::REPEATABLE_READ:
                return 2;
            case TransactionIsolationLevel::SERIALIZABLE:
                return 3;
            default:
                throw new InvalidArgumentException('Invalid isolation level:' . $level);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doModifyLimitQuery($query, $limit, $offset)
    {
        $limitOffsetClause = $this->getTopClauseSQL($limit, $offset);

        return $limitOffsetClause === ''
            ? $query
            : preg_replace('/^\s*(SELECT\s+(DISTINCT\s+)?)/i', '\1' . $limitOffsetClause . ' ', $query);
    }

    private function getTopClauseSQL(?int $limit, ?int $offset) : string
    {
        if ($offset > 0) {
            return sprintf('TOP %s START AT %d', $limit ?? 'ALL', $offset + 1);
        }

        return $limit === null ? '' : 'TOP ' . $limit;
    }

    /**
     * Return the INDEX query section dealing with non-standard
     * SQL Anywhere options.
     *
     * @param Index $index Index definition
     *
     * @return string
     */
    protected function getAdvancedIndexOptionsSQL(Index $index)
    {
        $sql = '';

        if (! $index->isPrimary() && $index->hasFlag('for_olap_workload')) {
            $sql .= ' FOR OLAP WORKLOAD';
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBinaryTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed
            ? 'BINARY(' . ($length ?: $this->getBinaryDefaultLength()) . ')'
            : 'VARBINARY(' . ($length ?: $this->getBinaryDefaultLength()) . ')';
    }

    /**
     * Returns the SQL snippet for creating a table constraint.
     *
     * @param Constraint  $constraint The table constraint to create the SQL snippet for.
     * @param string|null $name       The table constraint name to use if any.
     *
     * @return string
     *
     * @throws InvalidArgumentException If the given table constraint type is not supported by this method.
     */
    protected function getTableConstraintDeclarationSQL(Constraint $constraint, $name = null)
    {
        if ($constraint instanceof ForeignKeyConstraint) {
            return $this->getForeignKeyDeclarationSQL($constraint);
        }

        if (! $constraint instanceof Index) {
            throw new InvalidArgumentException('Unsupported constraint type: ' . get_class($constraint));
        }

        if (! $constraint->isPrimary() && ! $constraint->isUnique()) {
            throw new InvalidArgumentException(
                'Can only create primary, unique or foreign key constraint declarations, no common index declarations ' .
                'with getTableConstraintDeclarationSQL().'
            );
        }

        $constraintColumns = $constraint->getQuotedColumns($this);

        if (empty($constraintColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'columns' required.");
        }

        $sql   = '';
        $flags = '';

        if (! empty($name)) {
            $name = new Identifier($name);
            $sql .= 'CONSTRAINT ' . $name->getQuotedName($this) . ' ';
        }

        if ($constraint->hasFlag('clustered')) {
            $flags = 'CLUSTERED ';
        }

        if ($constraint->isPrimary()) {
            return $sql . 'PRIMARY KEY ' . $flags . '(' . $this->getIndexFieldDeclarationListSQL($constraintColumns) . ')';
        }

        return $sql . 'UNIQUE ' . $flags . '(' . $this->getIndexFieldDeclarationListSQL($constraintColumns) . ')';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCreateIndexSQLFlags(Index $index)
    {
        $type = '';
        if ($index->hasFlag('virtual')) {
            $type .= 'VIRTUAL ';
        }

        if ($index->isUnique()) {
            $type .= 'UNIQUE ';
        }

        if ($index->hasFlag('clustered')) {
            $type .= 'CLUSTERED ';
        }

        return $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRenameIndexSQL($oldIndexName, Index $index, $tableName)
    {
        return ['ALTER INDEX ' . $oldIndexName . ' ON ' . $tableName . ' RENAME TO ' . $index->getQuotedName($this)];
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLAnywhereKeywords::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed
            ? ($length ? 'CHAR(' . $length . ')' : 'CHAR(' . $this->getVarcharDefaultLength() . ')')
            : ($length ? 'VARCHAR(' . $length . ')' : 'VARCHAR(' . $this->getVarcharDefaultLength() . ')');
    }

    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'char' => 'string',
            'long nvarchar' => 'text',
            'long varchar' => 'text',
            'nchar' => 'string',
            'ntext' => 'text',
            'nvarchar' => 'string',
            'text' => 'text',
            'uniqueidentifierstr' => 'guid',
            'varchar' => 'string',
            'xml' => 'text',
            'bigint' => 'bigint',
            'unsigned bigint' => 'bigint',
            'bit' => 'boolean',
            'decimal' => 'decimal',
            'double' => 'float',
            'float' => 'float',
            'int' => 'integer',
            'integer' => 'integer',
            'unsigned int' => 'integer',
            'numeric' => 'decimal',
            'smallint' => 'smallint',
            'unsigned smallint' => 'smallint',
            'tinyint' => 'smallint',
            'unsigned tinyint' => 'smallint',
            'money' => 'decimal',
            'smallmoney' => 'decimal',
            'long varbit' => 'text',
            'varbit' => 'string',
            'date' => 'date',
            'datetime' => 'datetime',
            'smalldatetime' => 'datetime',
            'time' => 'time',
            'timestamp' => 'datetime',
            'binary' => 'binary',
            'image' => 'blob',
            'long binary' => 'blob',
            'uniqueidentifier' => 'guid',
            'varbinary' => 'binary',
        ];
    }
}
