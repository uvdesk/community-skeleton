<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Persisters\Collection;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Persisters\SqlValueVisitor;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\Utility\PersisterHelper;

/**
 * Persister for many-to-many collections.
 *
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Alexander <iam.asm89@gmail.com>
 * @since   2.0
 */
class ManyToManyPersister extends AbstractCollectionPersister
{
    /**
     * {@inheritdoc}
     */
    public function delete(PersistentCollection $collection)
    {
        $mapping = $collection->getMapping();

        if ( ! $mapping['isOwningSide']) {
            return; // ignore inverse side
        }

        $types = [];
        $class = $this->em->getClassMetadata($mapping['sourceEntity']);

        foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) {
            $types[] = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $class, $this->em);
        }

        $this->conn->executeUpdate($this->getDeleteSQL($collection), $this->getDeleteSQLParameters($collection), $types);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PersistentCollection $collection)
    {
        $mapping = $collection->getMapping();

        if ( ! $mapping['isOwningSide']) {
            return; // ignore inverse side
        }

        list($deleteSql, $deleteTypes) = $this->getDeleteRowSQL($collection);
        list($insertSql, $insertTypes) = $this->getInsertRowSQL($collection);

        foreach ($collection->getDeleteDiff() as $element) {
            $this->conn->executeUpdate(
                $deleteSql,
                $this->getDeleteRowSQLParameters($collection, $element),
                $deleteTypes
            );
        }

        foreach ($collection->getInsertDiff() as $element) {
            $this->conn->executeUpdate(
                $insertSql,
                $this->getInsertRowSQLParameters($collection, $element),
                $insertTypes
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(PersistentCollection $collection, $index)
    {
        $mapping = $collection->getMapping();

        if ( ! isset($mapping['indexBy'])) {
            throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections.");
        }

        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);
        $mappedKey = $mapping['isOwningSide']
            ? $mapping['inversedBy']
            : $mapping['mappedBy'];

        return $persister->load([$mappedKey => $collection->getOwner(), $mapping['indexBy'] => $index], null, $mapping, [], 0, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function count(PersistentCollection $collection)
    {
        $conditions     = [];
        $params         = [];
        $types          = [];
        $mapping        = $collection->getMapping();
        $id             = $this->uow->getEntityIdentifier($collection->getOwner());
        $sourceClass    = $this->em->getClassMetadata($mapping['sourceEntity']);
        $targetClass    = $this->em->getClassMetadata($mapping['targetEntity']);
        $association    = ( ! $mapping['isOwningSide'])
            ? $targetClass->associationMappings[$mapping['mappedBy']]
            : $mapping;

        $joinTableName  = $this->quoteStrategy->getJoinTableName($association, $sourceClass, $this->platform);
        $joinColumns    = ( ! $mapping['isOwningSide'])
            ? $association['joinTable']['inverseJoinColumns']
            : $association['joinTable']['joinColumns'];

        foreach ($joinColumns as $joinColumn) {
            $columnName     = $this->quoteStrategy->getJoinColumnName($joinColumn, $sourceClass, $this->platform);
            $referencedName = $joinColumn['referencedColumnName'];
            $conditions[]   = 't.' . $columnName . ' = ?';
            $params[]       = $id[$sourceClass->getFieldForColumn($referencedName)];
            $types[]        = PersisterHelper::getTypeOfColumn($referencedName, $sourceClass, $this->em);
        }

        list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($mapping);

        if ($filterSql) {
            $conditions[] = $filterSql;
        }

        // If there is a provided criteria, make part of conditions
        // @todo Fix this. Current SQL returns something like:
        //
        /*if ($criteria && ($expression = $criteria->getWhereExpression()) !== null) {
            // A join is needed on the target entity
            $targetTableName = $this->quoteStrategy->getTableName($targetClass, $this->platform);
            $targetJoinSql   = ' JOIN ' . $targetTableName . ' te'
                . ' ON' . implode(' AND ', $this->getOnConditionSQL($association));

            // And criteria conditions needs to be added
            $persister    = $this->uow->getEntityPersister($targetClass->name);
            $visitor      = new SqlExpressionVisitor($persister, $targetClass);
            $conditions[] = $visitor->dispatch($expression);

            $joinTargetEntitySQL = $targetJoinSql . $joinTargetEntitySQL;
        }*/

        $sql = 'SELECT COUNT(*)'
            . ' FROM ' . $joinTableName . ' t'
            . $joinTargetEntitySQL
            . ' WHERE ' . implode(' AND ', $conditions);

        return $this->conn->fetchColumn($sql, $params, 0, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function slice(PersistentCollection $collection, $offset, $length = null)
    {
        $mapping   = $collection->getMapping();
        $persister = $this->uow->getEntityPersister($mapping['targetEntity']);

        return $persister->getManyToManyCollection($mapping, $collection->getOwner(), $offset, $length);
    }
    /**
     * {@inheritdoc}
     */
    public function containsKey(PersistentCollection $collection, $key)
    {
        $mapping = $collection->getMapping();

        if ( ! isset($mapping['indexBy'])) {
            throw new \BadMethodCallException("Selecting a collection by index is only supported on indexed collections.");
        }

        list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictionsWithKey($collection, $key, true);

        $sql = 'SELECT 1 FROM ' . $quotedJoinTable . ' WHERE ' . implode(' AND ', $whereClauses);

        return (bool) $this->conn->fetchColumn($sql, $params, 0, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function contains(PersistentCollection $collection, $element)
    {
        if ( ! $this->isValidEntityState($element)) {
            return false;
        }

        list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictions($collection, $element, true);

        $sql = 'SELECT 1 FROM ' . $quotedJoinTable . ' WHERE ' . implode(' AND ', $whereClauses);

        return (bool) $this->conn->fetchColumn($sql, $params, 0, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function removeElement(PersistentCollection $collection, $element)
    {
        if ( ! $this->isValidEntityState($element)) {
            return false;
        }

        list($quotedJoinTable, $whereClauses, $params, $types) = $this->getJoinTableRestrictions($collection, $element, false);

        $sql = 'DELETE FROM ' . $quotedJoinTable . ' WHERE ' . implode(' AND ', $whereClauses);

        return (bool) $this->conn->executeUpdate($sql, $params, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function loadCriteria(PersistentCollection $collection, Criteria $criteria)
    {
        $mapping       = $collection->getMapping();
        $owner         = $collection->getOwner();
        $ownerMetadata = $this->em->getClassMetadata(get_class($owner));
        $id            = $this->uow->getEntityIdentifier($owner);
        $targetClass   = $this->em->getClassMetadata($mapping['targetEntity']);
        $onConditions  = $this->getOnConditionSQL($mapping);
        $whereClauses  = $params = [];

        if ( ! $mapping['isOwningSide']) {
            $associationSourceClass = $targetClass;
            $mapping = $targetClass->associationMappings[$mapping['mappedBy']];
            $sourceRelationMode = 'relationToTargetKeyColumns';
        } else {
            $associationSourceClass = $ownerMetadata;
            $sourceRelationMode = 'relationToSourceKeyColumns';
        }

        foreach ($mapping[$sourceRelationMode] as $key => $value) {
            $whereClauses[] = sprintf('t.%s = ?', $key);
            $params[] = $ownerMetadata->containsForeignIdentifier
                ? $id[$ownerMetadata->getFieldForColumn($value)]
                : $id[$ownerMetadata->fieldNames[$value]];
        }

        $parameters = $this->expandCriteriaParameters($criteria);

        foreach ($parameters as $parameter) {
            [$name, $value, $operator] = $parameter;

            $field          = $this->quoteStrategy->getColumnName($name, $targetClass, $this->platform);
            $whereClauses[] = sprintf('te.%s %s ?', $field, $operator);
            $params[]       = $value;
        }

        $tableName    = $this->quoteStrategy->getTableName($targetClass, $this->platform);
        $joinTable    = $this->quoteStrategy->getJoinTableName($mapping, $associationSourceClass, $this->platform);

        $rsm = new Query\ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata($targetClass->name, 'te');

        $sql = 'SELECT ' . $rsm->generateSelectClause()
            . ' FROM ' . $tableName . ' te'
            . ' JOIN ' . $joinTable  . ' t ON'
            . implode(' AND ', $onConditions)
            . ' WHERE ' . implode(' AND ', $whereClauses);

        $sql .= $this->getOrderingSql($criteria, $targetClass);

        $sql .= $this->getLimitSql($criteria);

        $stmt = $this->conn->executeQuery($sql, $params);

        return $this
            ->em
            ->newHydrator(Query::HYDRATE_OBJECT)
            ->hydrateAll($stmt, $rsm);
    }

    /**
     * Generates the filter SQL for a given mapping.
     *
     * This method is not used for actually grabbing the related entities
     * but when the extra-lazy collection methods are called on a filtered
     * association. This is why besides the many to many table we also
     * have to join in the actual entities table leading to additional
     * JOIN.
     *
     * @param array $mapping Array containing mapping information.
     *
     * @return string[] ordered tuple:
     *                   - JOIN condition to add to the SQL
     *                   - WHERE condition to add to the SQL
     */
    public function getFilterSql($mapping)
    {
        $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);
        $rootClass   = $this->em->getClassMetadata($targetClass->rootEntityName);
        $filterSql   = $this->generateFilterConditionSQL($rootClass, 'te');

        if ('' === $filterSql) {
            return ['', ''];
        }

        // A join is needed if there is filtering on the target entity
        $tableName = $this->quoteStrategy->getTableName($rootClass, $this->platform);
        $joinSql   = ' JOIN ' . $tableName . ' te'
            . ' ON' . implode(' AND ', $this->getOnConditionSQL($mapping));

        return [$joinSql, $filterSql];
    }

    /**
     * Generates the filter SQL for a given entity and table alias.
     *
     * @param ClassMetadata $targetEntity     Metadata of the target entity.
     * @param string        $targetTableAlias The table alias of the joined/selected table.
     *
     * @return string The SQL query part to add to a query.
     */
    protected function generateFilterConditionSQL(ClassMetadata $targetEntity, $targetTableAlias)
    {
        $filterClauses = [];

        foreach ($this->em->getFilters()->getEnabledFilters() as $filter) {
            if ($filterExpr = $filter->addFilterConstraint($targetEntity, $targetTableAlias)) {
                $filterClauses[] = '(' . $filterExpr . ')';
            }
        }

        return $filterClauses
            ? '(' . implode(' AND ', $filterClauses) . ')'
            : '';
    }

    /**
     * Generate ON condition
     *
     * @param  array $mapping
     *
     * @return array
     */
    protected function getOnConditionSQL($mapping)
    {
        $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);
        $association = ( ! $mapping['isOwningSide'])
            ? $targetClass->associationMappings[$mapping['mappedBy']]
            : $mapping;

        $joinColumns = $mapping['isOwningSide']
            ? $association['joinTable']['inverseJoinColumns']
            : $association['joinTable']['joinColumns'];

        $conditions = [];

        foreach ($joinColumns as $joinColumn) {
            $joinColumnName = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
            $refColumnName  = $this->quoteStrategy->getReferencedJoinColumnName($joinColumn, $targetClass, $this->platform);

            $conditions[] = ' t.' . $joinColumnName . ' = ' . 'te.' . $refColumnName;
        }

        return $conditions;
    }

    /**
     * {@inheritdoc}
     *
     * @override
     */
    protected function getDeleteSQL(PersistentCollection $collection)
    {
        $columns    = [];
        $mapping    = $collection->getMapping();
        $class      = $this->em->getClassMetadata(get_class($collection->getOwner()));
        $joinTable  = $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform);

        foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) {
            $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform);
        }

        return 'DELETE FROM ' . $joinTable
            . ' WHERE ' . implode(' = ? AND ', $columns) . ' = ?';
    }

    /**
     * {@inheritdoc}
     *
     * Internal note: Order of the parameters must be the same as the order of the columns in getDeleteSql.
     * @override
     */
    protected function getDeleteSQLParameters(PersistentCollection $collection)
    {
        $mapping    = $collection->getMapping();
        $identifier = $this->uow->getEntityIdentifier($collection->getOwner());

        // Optimization for single column identifier
        if (count($mapping['relationToSourceKeyColumns']) === 1) {
            return [reset($identifier)];
        }

        // Composite identifier
        $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']);
        $params      = [];

        foreach ($mapping['relationToSourceKeyColumns'] as $columnName => $refColumnName) {
            $params[] = isset($sourceClass->fieldNames[$refColumnName])
                ? $identifier[$sourceClass->fieldNames[$refColumnName]]
                : $identifier[$sourceClass->getFieldForColumn($refColumnName)];
        }

        return $params;
    }

    /**
     * Gets the SQL statement used for deleting a row from the collection.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection
     *
     * @return string[]|string[][] ordered tuple containing the SQL to be executed and an array
     *                             of types for bound parameters
     */
    protected function getDeleteRowSQL(PersistentCollection $collection)
    {
        $mapping     = $collection->getMapping();
        $class       = $this->em->getClassMetadata($mapping['sourceEntity']);
        $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);
        $columns     = [];
        $types       = [];

        foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) {
            $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform);
            $types[]   = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $class, $this->em);
        }

        foreach ($mapping['joinTable']['inverseJoinColumns'] as $joinColumn) {
            $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
            $types[]   = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em);
        }

        return [
            'DELETE FROM ' . $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform)
            . ' WHERE ' . implode(' = ? AND ', $columns) . ' = ?',
            $types,
        ];
    }

    /**
     * Gets the SQL parameters for the corresponding SQL statement to delete the given
     * element from the given collection.
     *
     * Internal note: Order of the parameters must be the same as the order of the columns in getDeleteRowSql.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @param mixed                              $element
     *
     * @return array
     */
    protected function getDeleteRowSQLParameters(PersistentCollection $collection, $element)
    {
        return $this->collectJoinTableColumnParameters($collection, $element);
    }

    /**
     * Gets the SQL statement used for inserting a row in the collection.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection
     *
     * @return string[]|string[][] ordered tuple containing the SQL to be executed and an array
     *                             of types for bound parameters
     */
    protected function getInsertRowSQL(PersistentCollection $collection)
    {
        $columns     = [];
        $types       = [];
        $mapping     = $collection->getMapping();
        $class       = $this->em->getClassMetadata($mapping['sourceEntity']);
        $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);

        foreach ($mapping['joinTable']['joinColumns'] as $joinColumn) {
            $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
            $types[]   = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $class, $this->em);
        }

        foreach ($mapping['joinTable']['inverseJoinColumns'] as $joinColumn) {
            $columns[] = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
            $types[]   = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em);
        }

        return [
            'INSERT INTO ' . $this->quoteStrategy->getJoinTableName($mapping, $class, $this->platform)
            . ' (' . implode(', ', $columns) . ')'
            . ' VALUES'
            . ' (' . implode(', ', array_fill(0, count($columns), '?')) . ')',
            $types,
        ];
    }

    /**
     * Gets the SQL parameters for the corresponding SQL statement to insert the given
     * element of the given collection into the database.
     *
     * Internal note: Order of the parameters must be the same as the order of the columns in getInsertRowSql.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @param mixed                              $element
     *
     * @return array
     */
    protected function getInsertRowSQLParameters(PersistentCollection $collection, $element)
    {
        return $this->collectJoinTableColumnParameters($collection, $element);
    }

    /**
     * Collects the parameters for inserting/deleting on the join table in the order
     * of the join table columns as specified in ManyToManyMapping#joinTableColumns.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @param object                             $element
     *
     * @return array
     */
    private function collectJoinTableColumnParameters(PersistentCollection $collection, $element)
    {
        $params      = [];
        $mapping     = $collection->getMapping();
        $isComposite = count($mapping['joinTableColumns']) > 2;

        $identifier1 = $this->uow->getEntityIdentifier($collection->getOwner());
        $identifier2 = $this->uow->getEntityIdentifier($element);

        $class1 = $class2 = null;
        if ($isComposite) {
            $class1 = $this->em->getClassMetadata(get_class($collection->getOwner()));
            $class2 = $collection->getTypeClass();
        }

        foreach ($mapping['joinTableColumns'] as $joinTableColumn) {
            $isRelationToSource = isset($mapping['relationToSourceKeyColumns'][$joinTableColumn]);

            if ( ! $isComposite) {
                $params[] = $isRelationToSource ? array_pop($identifier1) : array_pop($identifier2);

                continue;
            }

            if ($isRelationToSource) {
                $params[] = $identifier1[$class1->getFieldForColumn($mapping['relationToSourceKeyColumns'][$joinTableColumn])];

                continue;
            }

            $params[] = $identifier2[$class2->getFieldForColumn($mapping['relationToTargetKeyColumns'][$joinTableColumn])];
        }

        return $params;
    }

    /**
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @param string                             $key
     * @param boolean                            $addFilters Whether the filter SQL should be included or not.
     *
     * @return array ordered vector:
     *                - quoted join table name
     *                - where clauses to be added for filtering
     *                - parameters to be bound for filtering
     *                - types of the parameters to be bound for filtering
     */
    private function getJoinTableRestrictionsWithKey(PersistentCollection $collection, $key, $addFilters)
    {
        $filterMapping = $collection->getMapping();
        $mapping       = $filterMapping;
        $indexBy       = $mapping['indexBy'];
        $id            = $this->uow->getEntityIdentifier($collection->getOwner());
        $sourceClass   = $this->em->getClassMetadata($mapping['sourceEntity']);
        $targetClass   = $this->em->getClassMetadata($mapping['targetEntity']);

        if (! $mapping['isOwningSide']) {
            $associationSourceClass = $this->em->getClassMetadata($mapping['targetEntity']);
            $mapping                = $associationSourceClass->associationMappings[$mapping['mappedBy']];
            $joinColumns            = $mapping['joinTable']['joinColumns'];
            $sourceRelationMode     = 'relationToTargetKeyColumns';
            $targetRelationMode     = 'relationToSourceKeyColumns';
        } else {
            $associationSourceClass = $this->em->getClassMetadata($mapping['sourceEntity']);
            $joinColumns            = $mapping['joinTable']['inverseJoinColumns'];
            $sourceRelationMode     = 'relationToSourceKeyColumns';
            $targetRelationMode     = 'relationToTargetKeyColumns';
        }

        $quotedJoinTable = $this->quoteStrategy->getJoinTableName($mapping, $associationSourceClass, $this->platform). ' t';
        $whereClauses    = [];
        $params          = [];
        $types           = [];

        $joinNeeded = ! in_array($indexBy, $targetClass->identifier);

        if ($joinNeeded) { // extra join needed if indexBy is not a @id
            $joinConditions = [];

            foreach ($joinColumns as $joinTableColumn) {
                $joinConditions[] = 't.' . $joinTableColumn['name'] . ' = tr.' . $joinTableColumn['referencedColumnName'];
            }

            $tableName        = $this->quoteStrategy->getTableName($targetClass, $this->platform);
            $quotedJoinTable .= ' JOIN ' . $tableName . ' tr ON ' . implode(' AND ', $joinConditions);
            $columnName       = $targetClass->getColumnName($indexBy);

            $whereClauses[] = 'tr.' . $columnName . ' = ?';
            $params[]       = $key;
            $types[]        = PersisterHelper::getTypeOfColumn($columnName, $targetClass, $this->em);
        }

        foreach ($mapping['joinTableColumns'] as $joinTableColumn) {
            if (isset($mapping[$sourceRelationMode][$joinTableColumn])) {
                $column         = $mapping[$sourceRelationMode][$joinTableColumn];
                $whereClauses[] = 't.' . $joinTableColumn . ' = ?';
                $params[]       = $sourceClass->containsForeignIdentifier
                    ? $id[$sourceClass->getFieldForColumn($column)]
                    : $id[$sourceClass->fieldNames[$column]];
                $types[]        = PersisterHelper::getTypeOfColumn($column, $sourceClass, $this->em);
            } elseif ( ! $joinNeeded) {
                $column = $mapping[$targetRelationMode][$joinTableColumn];

                $whereClauses[] = 't.' . $joinTableColumn . ' = ?';
                $params[]       = $key;
                $types[]        = PersisterHelper::getTypeOfColumn($column, $targetClass, $this->em);
            }
        }

        if ($addFilters) {
            list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($filterMapping);

            if ($filterSql) {
                $quotedJoinTable .= ' ' . $joinTargetEntitySQL;
                $whereClauses[] = $filterSql;
            }
        }

        return [$quotedJoinTable, $whereClauses, $params, $types];
    }

    /**
     * @param \Doctrine\ORM\PersistentCollection $collection
     * @param object                             $element
     * @param boolean                            $addFilters Whether the filter SQL should be included or not.
     *
     * @return array ordered vector:
     *                - quoted join table name
     *                - where clauses to be added for filtering
     *                - parameters to be bound for filtering
     *                - types of the parameters to be bound for filtering
     */
    private function getJoinTableRestrictions(PersistentCollection $collection, $element, $addFilters)
    {
        $filterMapping  = $collection->getMapping();
        $mapping        = $filterMapping;

        if ( ! $mapping['isOwningSide']) {
            $sourceClass = $this->em->getClassMetadata($mapping['targetEntity']);
            $targetClass = $this->em->getClassMetadata($mapping['sourceEntity']);
            $sourceId = $this->uow->getEntityIdentifier($element);
            $targetId = $this->uow->getEntityIdentifier($collection->getOwner());

            $mapping = $sourceClass->associationMappings[$mapping['mappedBy']];
        } else {
            $sourceClass = $this->em->getClassMetadata($mapping['sourceEntity']);
            $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);
            $sourceId = $this->uow->getEntityIdentifier($collection->getOwner());
            $targetId = $this->uow->getEntityIdentifier($element);
        }

        $quotedJoinTable = $this->quoteStrategy->getJoinTableName($mapping, $sourceClass, $this->platform);
        $whereClauses    = [];
        $params          = [];
        $types           = [];

        foreach ($mapping['joinTableColumns'] as $joinTableColumn) {
            $whereClauses[] = ($addFilters ? 't.' : '') . $joinTableColumn . ' = ?';

            if (isset($mapping['relationToTargetKeyColumns'][$joinTableColumn])) {
                $targetColumn = $mapping['relationToTargetKeyColumns'][$joinTableColumn];
                $params[]     = $targetId[$targetClass->getFieldForColumn($targetColumn)];
                $types[]      = PersisterHelper::getTypeOfColumn($targetColumn, $targetClass, $this->em);

                continue;
            }

            // relationToSourceKeyColumns
            $targetColumn = $mapping['relationToSourceKeyColumns'][$joinTableColumn];
            $params[]     = $sourceId[$sourceClass->getFieldForColumn($targetColumn)];
            $types[]      = PersisterHelper::getTypeOfColumn($targetColumn, $sourceClass, $this->em);
        }

        if ($addFilters) {
            $quotedJoinTable .= ' t';

            list($joinTargetEntitySQL, $filterSql) = $this->getFilterSql($filterMapping);

            if ($filterSql) {
                $quotedJoinTable .= ' ' . $joinTargetEntitySQL;
                $whereClauses[] = $filterSql;
            }
        }

        return [$quotedJoinTable, $whereClauses, $params, $types];
    }

    /**
     * Expands Criteria Parameters by walking the expressions and grabbing all
     * parameters and types from it.
     *
     * @param \Doctrine\Common\Collections\Criteria $criteria
     *
     * @return array
     */
    private function expandCriteriaParameters(Criteria $criteria)
    {
        $expression = $criteria->getWhereExpression();

        if ($expression === null) {
            return [];
        }

        $valueVisitor = new SqlValueVisitor();

        $valueVisitor->dispatch($expression);

        list(, $types) = $valueVisitor->getParamsAndTypes();

        return $types;
    }

    /**
     * @param Criteria $criteria
     * @param ClassMetadata $targetClass
     * @return string
     */
    private function getOrderingSql(Criteria $criteria, ClassMetadata $targetClass)
    {
        $orderings = $criteria->getOrderings();
        if ($orderings) {
            $orderBy = [];
            foreach ($orderings as $name => $direction) {
                $field = $this->quoteStrategy->getColumnName(
                    $name,
                    $targetClass,
                    $this->platform
                );
                $orderBy[] = $field . ' ' . $direction;
            }

            return ' ORDER BY ' . implode(', ', $orderBy);
        }
        return '';
    }

    /**
     * @param Criteria $criteria
     * @return string
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getLimitSql(Criteria $criteria)
    {
        $limit  = $criteria->getMaxResults();
        $offset = $criteria->getFirstResult();
        if ($limit !== null || $offset !== null) {
            return $this->platform->modifyLimitQuery('', $limit, $offset);
        }
        return '';
    }
}
