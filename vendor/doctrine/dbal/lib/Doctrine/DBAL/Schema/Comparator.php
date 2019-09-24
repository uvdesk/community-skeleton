<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Types;
use function array_intersect_key;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_shift;
use function array_unique;
use function count;
use function strtolower;

/**
 * Compares two Schemas and return an instance of SchemaDiff.
 */
class Comparator
{
    /**
     * @return SchemaDiff
     */
    public static function compareSchemas(Schema $fromSchema, Schema $toSchema)
    {
        $c = new self();

        return $c->compare($fromSchema, $toSchema);
    }

    /**
     * Returns a SchemaDiff object containing the differences between the schemas $fromSchema and $toSchema.
     *
     * The returned differences are returned in such a way that they contain the
     * operations to change the schema stored in $fromSchema to the schema that is
     * stored in $toSchema.
     *
     * @return SchemaDiff
     */
    public function compare(Schema $fromSchema, Schema $toSchema)
    {
        $diff             = new SchemaDiff();
        $diff->fromSchema = $fromSchema;

        $foreignKeysToTable = [];

        foreach ($toSchema->getNamespaces() as $namespace) {
            if ($fromSchema->hasNamespace($namespace)) {
                continue;
            }

            $diff->newNamespaces[$namespace] = $namespace;
        }

        foreach ($fromSchema->getNamespaces() as $namespace) {
            if ($toSchema->hasNamespace($namespace)) {
                continue;
            }

            $diff->removedNamespaces[$namespace] = $namespace;
        }

        foreach ($toSchema->getTables() as $table) {
            $tableName = $table->getShortestName($toSchema->getName());
            if (! $fromSchema->hasTable($tableName)) {
                $diff->newTables[$tableName] = $toSchema->getTable($tableName);
            } else {
                $tableDifferences = $this->diffTable($fromSchema->getTable($tableName), $toSchema->getTable($tableName));
                if ($tableDifferences !== false) {
                    $diff->changedTables[$tableName] = $tableDifferences;
                }
            }
        }

        /* Check if there are tables removed */
        foreach ($fromSchema->getTables() as $table) {
            $tableName = $table->getShortestName($fromSchema->getName());

            $table = $fromSchema->getTable($tableName);
            if (! $toSchema->hasTable($tableName)) {
                $diff->removedTables[$tableName] = $table;
            }

            // also remember all foreign keys that point to a specific table
            foreach ($table->getForeignKeys() as $foreignKey) {
                $foreignTable = strtolower($foreignKey->getForeignTableName());
                if (! isset($foreignKeysToTable[$foreignTable])) {
                    $foreignKeysToTable[$foreignTable] = [];
                }
                $foreignKeysToTable[$foreignTable][] = $foreignKey;
            }
        }

        foreach ($diff->removedTables as $tableName => $table) {
            if (! isset($foreignKeysToTable[$tableName])) {
                continue;
            }

            $diff->orphanedForeignKeys = array_merge($diff->orphanedForeignKeys, $foreignKeysToTable[$tableName]);

            // deleting duplicated foreign keys present on both on the orphanedForeignKey
            // and the removedForeignKeys from changedTables
            foreach ($foreignKeysToTable[$tableName] as $foreignKey) {
                // strtolower the table name to make if compatible with getShortestName
                $localTableName = strtolower($foreignKey->getLocalTableName());
                if (! isset($diff->changedTables[$localTableName])) {
                    continue;
                }

                foreach ($diff->changedTables[$localTableName]->removedForeignKeys as $key => $removedForeignKey) {
                    // We check if the key is from the removed table if not we skip.
                    if ($tableName !== strtolower($removedForeignKey->getForeignTableName())) {
                        continue;
                    }
                    unset($diff->changedTables[$localTableName]->removedForeignKeys[$key]);
                }
            }
        }

        foreach ($toSchema->getSequences() as $sequence) {
            $sequenceName = $sequence->getShortestName($toSchema->getName());
            if (! $fromSchema->hasSequence($sequenceName)) {
                if (! $this->isAutoIncrementSequenceInSchema($fromSchema, $sequence)) {
                    $diff->newSequences[] = $sequence;
                }
            } else {
                if ($this->diffSequence($sequence, $fromSchema->getSequence($sequenceName))) {
                    $diff->changedSequences[] = $toSchema->getSequence($sequenceName);
                }
            }
        }

        foreach ($fromSchema->getSequences() as $sequence) {
            if ($this->isAutoIncrementSequenceInSchema($toSchema, $sequence)) {
                continue;
            }

            $sequenceName = $sequence->getShortestName($fromSchema->getName());

            if ($toSchema->hasSequence($sequenceName)) {
                continue;
            }

            $diff->removedSequences[] = $sequence;
        }

        return $diff;
    }

    /**
     * @param Schema   $schema
     * @param Sequence $sequence
     *
     * @return bool
     */
    private function isAutoIncrementSequenceInSchema($schema, $sequence)
    {
        foreach ($schema->getTables() as $table) {
            if ($sequence->isAutoIncrementsFor($table)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function diffSequence(Sequence $sequence1, Sequence $sequence2)
    {
        if ($sequence1->getAllocationSize() !== $sequence2->getAllocationSize()) {
            return true;
        }

        return $sequence1->getInitialValue() !== $sequence2->getInitialValue();
    }

    /**
     * Returns the difference between the tables $table1 and $table2.
     *
     * If there are no differences this method returns the boolean false.
     *
     * @return TableDiff|false
     */
    public function diffTable(Table $table1, Table $table2)
    {
        $changes                     = 0;
        $tableDifferences            = new TableDiff($table1->getName());
        $tableDifferences->fromTable = $table1;

        $table1Columns = $table1->getColumns();
        $table2Columns = $table2->getColumns();

        /* See if all the fields in table 1 exist in table 2 */
        foreach ($table2Columns as $columnName => $column) {
            if ($table1->hasColumn($columnName)) {
                continue;
            }

            $tableDifferences->addedColumns[$columnName] = $column;
            $changes++;
        }
        /* See if there are any removed fields in table 2 */
        foreach ($table1Columns as $columnName => $column) {
            // See if column is removed in table 2.
            if (! $table2->hasColumn($columnName)) {
                $tableDifferences->removedColumns[$columnName] = $column;
                $changes++;
                continue;
            }

            // See if column has changed properties in table 2.
            $changedProperties = $this->diffColumn($column, $table2->getColumn($columnName));

            if (empty($changedProperties)) {
                continue;
            }

            $columnDiff                                           = new ColumnDiff($column->getName(), $table2->getColumn($columnName), $changedProperties);
            $columnDiff->fromColumn                               = $column;
            $tableDifferences->changedColumns[$column->getName()] = $columnDiff;
            $changes++;
        }

        $this->detectColumnRenamings($tableDifferences);

        $table1Indexes = $table1->getIndexes();
        $table2Indexes = $table2->getIndexes();

        /* See if all the indexes in table 1 exist in table 2 */
        foreach ($table2Indexes as $indexName => $index) {
            if (($index->isPrimary() && $table1->hasPrimaryKey()) || $table1->hasIndex($indexName)) {
                continue;
            }

            $tableDifferences->addedIndexes[$indexName] = $index;
            $changes++;
        }
        /* See if there are any removed indexes in table 2 */
        foreach ($table1Indexes as $indexName => $index) {
            // See if index is removed in table 2.
            if (($index->isPrimary() && ! $table2->hasPrimaryKey()) ||
                ! $index->isPrimary() && ! $table2->hasIndex($indexName)
            ) {
                $tableDifferences->removedIndexes[$indexName] = $index;
                $changes++;
                continue;
            }

            // See if index has changed in table 2.
            $table2Index = $index->isPrimary() ? $table2->getPrimaryKey() : $table2->getIndex($indexName);

            if (! $this->diffIndex($index, $table2Index)) {
                continue;
            }

            $tableDifferences->changedIndexes[$indexName] = $table2Index;
            $changes++;
        }

        $this->detectIndexRenamings($tableDifferences);

        $fromFkeys = $table1->getForeignKeys();
        $toFkeys   = $table2->getForeignKeys();

        foreach ($fromFkeys as $key1 => $constraint1) {
            foreach ($toFkeys as $key2 => $constraint2) {
                if ($this->diffForeignKey($constraint1, $constraint2) === false) {
                    unset($fromFkeys[$key1], $toFkeys[$key2]);
                } else {
                    if (strtolower($constraint1->getName()) === strtolower($constraint2->getName())) {
                        $tableDifferences->changedForeignKeys[] = $constraint2;
                        $changes++;
                        unset($fromFkeys[$key1], $toFkeys[$key2]);
                    }
                }
            }
        }

        foreach ($fromFkeys as $constraint1) {
            $tableDifferences->removedForeignKeys[] = $constraint1;
            $changes++;
        }

        foreach ($toFkeys as $constraint2) {
            $tableDifferences->addedForeignKeys[] = $constraint2;
            $changes++;
        }

        return $changes ? $tableDifferences : false;
    }

    /**
     * Try to find columns that only changed their name, rename operations maybe cheaper than add/drop
     * however ambiguities between different possibilities should not lead to renaming at all.
     *
     * @return void
     */
    private function detectColumnRenamings(TableDiff $tableDifferences)
    {
        $renameCandidates = [];
        foreach ($tableDifferences->addedColumns as $addedColumnName => $addedColumn) {
            foreach ($tableDifferences->removedColumns as $removedColumn) {
                if (count($this->diffColumn($addedColumn, $removedColumn)) !== 0) {
                    continue;
                }

                $renameCandidates[$addedColumn->getName()][] = [$removedColumn, $addedColumn, $addedColumnName];
            }
        }

        foreach ($renameCandidates as $candidateColumns) {
            if (count($candidateColumns) !== 1) {
                continue;
            }

            [$removedColumn, $addedColumn] = $candidateColumns[0];
            $removedColumnName             = strtolower($removedColumn->getName());
            $addedColumnName               = strtolower($addedColumn->getName());

            if (isset($tableDifferences->renamedColumns[$removedColumnName])) {
                continue;
            }

            $tableDifferences->renamedColumns[$removedColumnName] = $addedColumn;
            unset(
                $tableDifferences->addedColumns[$addedColumnName],
                $tableDifferences->removedColumns[$removedColumnName]
            );
        }
    }

    /**
     * Try to find indexes that only changed their name, rename operations maybe cheaper than add/drop
     * however ambiguities between different possibilities should not lead to renaming at all.
     *
     * @return void
     */
    private function detectIndexRenamings(TableDiff $tableDifferences)
    {
        $renameCandidates = [];

        // Gather possible rename candidates by comparing each added and removed index based on semantics.
        foreach ($tableDifferences->addedIndexes as $addedIndexName => $addedIndex) {
            foreach ($tableDifferences->removedIndexes as $removedIndex) {
                if ($this->diffIndex($addedIndex, $removedIndex)) {
                    continue;
                }

                $renameCandidates[$addedIndex->getName()][] = [$removedIndex, $addedIndex, $addedIndexName];
            }
        }

        foreach ($renameCandidates as $candidateIndexes) {
            // If the current rename candidate contains exactly one semantically equal index,
            // we can safely rename it.
            // Otherwise it is unclear if a rename action is really intended,
            // therefore we let those ambiguous indexes be added/dropped.
            if (count($candidateIndexes) !== 1) {
                continue;
            }

            [$removedIndex, $addedIndex] = $candidateIndexes[0];

            $removedIndexName = strtolower($removedIndex->getName());
            $addedIndexName   = strtolower($addedIndex->getName());

            if (isset($tableDifferences->renamedIndexes[$removedIndexName])) {
                continue;
            }

            $tableDifferences->renamedIndexes[$removedIndexName] = $addedIndex;
            unset(
                $tableDifferences->addedIndexes[$addedIndexName],
                $tableDifferences->removedIndexes[$removedIndexName]
            );
        }
    }

    /**
     * @return bool
     */
    public function diffForeignKey(ForeignKeyConstraint $key1, ForeignKeyConstraint $key2)
    {
        if (array_map('strtolower', $key1->getUnquotedLocalColumns()) !== array_map('strtolower', $key2->getUnquotedLocalColumns())) {
            return true;
        }

        if (array_map('strtolower', $key1->getUnquotedForeignColumns()) !== array_map('strtolower', $key2->getUnquotedForeignColumns())) {
            return true;
        }

        if ($key1->getUnqualifiedForeignTableName() !== $key2->getUnqualifiedForeignTableName()) {
            return true;
        }

        if ($key1->onUpdate() !== $key2->onUpdate()) {
            return true;
        }

        return $key1->onDelete() !== $key2->onDelete();
    }

    /**
     * Returns the difference between the fields $field1 and $field2.
     *
     * If there are differences this method returns $field2, otherwise the
     * boolean false.
     *
     * @return string[]
     */
    public function diffColumn(Column $column1, Column $column2)
    {
        $properties1 = $column1->toArray();
        $properties2 = $column2->toArray();

        $changedProperties = [];

        foreach (['type', 'notnull', 'unsigned', 'autoincrement'] as $property) {
            if ($properties1[$property] === $properties2[$property]) {
                continue;
            }

            $changedProperties[] = $property;
        }

        // This is a very nasty hack to make comparator work with the legacy json_array type, which should be killed in v3
        if ($this->isALegacyJsonComparison($properties1['type'], $properties2['type'])) {
            array_shift($changedProperties);

            $changedProperties[] = 'comment';
        }

        // Null values need to be checked additionally as they tell whether to create or drop a default value.
        // null != 0, null != false, null != '' etc. This affects platform's table alteration SQL generation.
        if (($properties1['default'] === null) !== ($properties2['default'] === null)
            || $properties1['default'] != $properties2['default']) {
            $changedProperties[] = 'default';
        }

        if (($properties1['type'] instanceof Types\StringType && ! $properties1['type'] instanceof Types\GuidType) ||
            $properties1['type'] instanceof Types\BinaryType
        ) {
            // check if value of length is set at all, default value assumed otherwise.
            $length1 = $properties1['length'] ?: 255;
            $length2 = $properties2['length'] ?: 255;
            if ($length1 !== $length2) {
                $changedProperties[] = 'length';
            }

            if ($properties1['fixed'] !== $properties2['fixed']) {
                $changedProperties[] = 'fixed';
            }
        } elseif ($properties1['type'] instanceof Types\DecimalType) {
            if (($properties1['precision'] ?: 10) !== ($properties2['precision'] ?: 10)) {
                $changedProperties[] = 'precision';
            }
            if ($properties1['scale'] !== $properties2['scale']) {
                $changedProperties[] = 'scale';
            }
        }

        // A null value and an empty string are actually equal for a comment so they should not trigger a change.
        if ($properties1['comment'] !== $properties2['comment'] &&
            ! ($properties1['comment'] === null && $properties2['comment'] === '') &&
            ! ($properties2['comment'] === null && $properties1['comment'] === '')
        ) {
            $changedProperties[] = 'comment';
        }

        $customOptions1 = $column1->getCustomSchemaOptions();
        $customOptions2 = $column2->getCustomSchemaOptions();

        foreach (array_merge(array_keys($customOptions1), array_keys($customOptions2)) as $key) {
            if (! array_key_exists($key, $properties1) || ! array_key_exists($key, $properties2)) {
                $changedProperties[] = $key;
            } elseif ($properties1[$key] !== $properties2[$key]) {
                $changedProperties[] = $key;
            }
        }

        $platformOptions1 = $column1->getPlatformOptions();
        $platformOptions2 = $column2->getPlatformOptions();

        foreach (array_keys(array_intersect_key($platformOptions1, $platformOptions2)) as $key) {
            if ($properties1[$key] === $properties2[$key]) {
                continue;
            }

            $changedProperties[] = $key;
        }

        return array_unique($changedProperties);
    }

    /**
     * TODO: kill with fire on v3.0
     *
     * @deprecated
     */
    private function isALegacyJsonComparison(Types\Type $one, Types\Type $other) : bool
    {
        if (! $one instanceof Types\JsonType || ! $other instanceof Types\JsonType) {
            return false;
        }

        return ( ! $one instanceof Types\JsonArrayType && $other instanceof Types\JsonArrayType)
            || ( ! $other instanceof Types\JsonArrayType && $one instanceof Types\JsonArrayType);
    }

    /**
     * Finds the difference between the indexes $index1 and $index2.
     *
     * Compares $index1 with $index2 and returns $index2 if there are any
     * differences or false in case there are no differences.
     *
     * @return bool
     */
    public function diffIndex(Index $index1, Index $index2)
    {
        return ! ($index1->isFullfilledBy($index2) && $index2->isFullfilledBy($index1));
    }
}
