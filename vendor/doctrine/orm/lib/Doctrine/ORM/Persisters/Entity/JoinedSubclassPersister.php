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

namespace Doctrine\ORM\Persisters\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;

use Doctrine\DBAL\LockMode;
use Doctrine\DBAL\Types\Type;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Utility\PersisterHelper;

/**
 * The joined subclass persister maps a single entity instance to several tables in the
 * database as it is defined by the <tt>Class Table Inheritance</tt> strategy.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Alexander <iam.asm89@gmail.com>
 * @since 2.0
 * @see http://martinfowler.com/eaaCatalog/classTableInheritance.html
 */
class JoinedSubclassPersister extends AbstractEntityInheritancePersister
{
    /**
     * Map that maps column names to the table names that own them.
     * This is mainly a temporary cache, used during a single request.
     *
     * @var array
     */
    private $owningTableMap = [];

    /**
     * Map of table to quoted table names.
     *
     * @var array
     */
    private $quotedTableMap = [];

    /**
     * {@inheritdoc}
     */
    protected function getDiscriminatorColumnTableName()
    {
        $class = ($this->class->name !== $this->class->rootEntityName)
            ? $this->em->getClassMetadata($this->class->rootEntityName)
            : $this->class;

        return $class->getTableName();
    }

    /**
     * This function finds the ClassMetadata instance in an inheritance hierarchy
     * that is responsible for enabling versioning.
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    private function getVersionedClassMetadata()
    {
        if (isset($this->class->fieldMappings[$this->class->versionField]['inherited'])) {
            $definingClassName = $this->class->fieldMappings[$this->class->versionField]['inherited'];

            return $this->em->getClassMetadata($definingClassName);
        }

        return $this->class;
    }

    /**
     * Gets the name of the table that owns the column the given field is mapped to.
     *
     * @param string $fieldName
     *
     * @return string
     *
     * @override
     */
    public function getOwningTable($fieldName)
    {
        if (isset($this->owningTableMap[$fieldName])) {
            return $this->owningTableMap[$fieldName];
        }

        switch (true) {
            case isset($this->class->associationMappings[$fieldName]['inherited']):
                $cm = $this->em->getClassMetadata($this->class->associationMappings[$fieldName]['inherited']);
                break;

            case isset($this->class->fieldMappings[$fieldName]['inherited']):
                $cm = $this->em->getClassMetadata($this->class->fieldMappings[$fieldName]['inherited']);
                break;

            default:
                $cm = $this->class;
                break;
        }

        $tableName          = $cm->getTableName();
        $quotedTableName    = $this->quoteStrategy->getTableName($cm, $this->platform);

        $this->owningTableMap[$fieldName] = $tableName;
        $this->quotedTableMap[$tableName] = $quotedTableName;

        return $tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function executeInserts()
    {
        if ( ! $this->queuedInserts) {
            return [];
        }

        $postInsertIds  = [];
        $idGenerator    = $this->class->idGenerator;
        $isPostInsertId = $idGenerator->isPostInsertGenerator();
        $rootClass      = ($this->class->name !== $this->class->rootEntityName)
            ? $this->em->getClassMetadata($this->class->rootEntityName)
            : $this->class;

        // Prepare statement for the root table
        $rootPersister = $this->em->getUnitOfWork()->getEntityPersister($rootClass->name);
        $rootTableName = $rootClass->getTableName();
        $rootTableStmt = $this->conn->prepare($rootPersister->getInsertSQL());

        // Prepare statements for sub tables.
        $subTableStmts = [];

        if ($rootClass !== $this->class) {
            $subTableStmts[$this->class->getTableName()] = $this->conn->prepare($this->getInsertSQL());
        }

        foreach ($this->class->parentClasses as $parentClassName) {
            $parentClass = $this->em->getClassMetadata($parentClassName);
            $parentTableName = $parentClass->getTableName();

            if ($parentClass !== $rootClass) {
                $parentPersister = $this->em->getUnitOfWork()->getEntityPersister($parentClassName);
                $subTableStmts[$parentTableName] = $this->conn->prepare($parentPersister->getInsertSQL());
            }
        }

        // Execute all inserts. For each entity:
        // 1) Insert on root table
        // 2) Insert on sub tables
        foreach ($this->queuedInserts as $entity) {
            $insertData = $this->prepareInsertData($entity);

            // Execute insert on root table
            $paramIndex = 1;

            foreach ($insertData[$rootTableName] as $columnName => $value) {
                $rootTableStmt->bindValue($paramIndex++, $value, $this->columnTypes[$columnName]);
            }

            $rootTableStmt->execute();

            if ($isPostInsertId) {
                $generatedId = $idGenerator->generate($this->em, $entity);
                $id = [
                    $this->class->identifier[0] => $generatedId
                ];
                $postInsertIds[] = [
                    'generatedId' => $generatedId,
                    'entity' => $entity,
                ];
            } else {
                $id = $this->em->getUnitOfWork()->getEntityIdentifier($entity);
            }

            if ($this->class->isVersioned) {
                $this->assignDefaultVersionValue($entity, $id);
            }

            // Execute inserts on subtables.
            // The order doesn't matter because all child tables link to the root table via FK.
            foreach ($subTableStmts as $tableName => $stmt) {
                /** @var \Doctrine\DBAL\Statement $stmt */
                $paramIndex = 1;
                $data       = $insertData[$tableName] ?? [];

                foreach ((array) $id as $idName => $idVal) {
                    $type = isset($this->columnTypes[$idName]) ? $this->columnTypes[$idName] : Type::STRING;

                    $stmt->bindValue($paramIndex++, $idVal, $type);
                }

                foreach ($data as $columnName => $value) {
                    if (!is_array($id) || !isset($id[$columnName])) {
                        $stmt->bindValue($paramIndex++, $value, $this->columnTypes[$columnName]);
                    }
                }

                $stmt->execute();
            }
        }

        $rootTableStmt->closeCursor();

        foreach ($subTableStmts as $stmt) {
            $stmt->closeCursor();
        }

        $this->queuedInserts = [];

        return $postInsertIds;
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $updateData = $this->prepareUpdateData($entity);

        if ( ! $updateData) {
            return;
        }

        if (($isVersioned = $this->class->isVersioned) === false) {
            return;
        }

        $versionedClass  = $this->getVersionedClassMetadata();
        $versionedTable  = $versionedClass->getTableName();

        foreach ($updateData as $tableName => $data) {
            $tableName = $this->quotedTableMap[$tableName];
            $versioned = $isVersioned && $versionedTable === $tableName;

            $this->updateTable($entity, $tableName, $data, $versioned);
        }

        // Make sure the table with the version column is updated even if no columns on that
        // table were affected.
        if ($isVersioned) {
            if ( ! isset($updateData[$versionedTable])) {
                $tableName = $this->quoteStrategy->getTableName($versionedClass, $this->platform);

                $this->updateTable($entity, $tableName, [], true);
            }

            $identifiers = $this->em->getUnitOfWork()->getEntityIdentifier($entity);

            $this->assignDefaultVersionValue($entity, $identifiers);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $identifier = $this->em->getUnitOfWork()->getEntityIdentifier($entity);
        $id         = array_combine($this->class->getIdentifierColumnNames(), $identifier);

        $this->deleteJoinTableRecords($identifier);

        // If the database platform supports FKs, just
        // delete the row from the root table. Cascades do the rest.
        if ($this->platform->supportsForeignKeyConstraints()) {
            $rootClass  = $this->em->getClassMetadata($this->class->rootEntityName);
            $rootTable  = $this->quoteStrategy->getTableName($rootClass, $this->platform);

            return (bool) $this->conn->delete($rootTable, $id);
        }

        // Delete from all tables individually, starting from this class' table up to the root table.
        $rootTable = $this->quoteStrategy->getTableName($this->class, $this->platform);

        $affectedRows = $this->conn->delete($rootTable, $id);

        foreach ($this->class->parentClasses as $parentClass) {
            $parentMetadata = $this->em->getClassMetadata($parentClass);
            $parentTable    = $this->quoteStrategy->getTableName($parentMetadata, $this->platform);

            $this->conn->delete($parentTable, $id);
        }

        return (bool) $affectedRows;
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectSQL($criteria, $assoc = null, $lockMode = null, $limit = null, $offset = null, array $orderBy = null)
    {
        $this->switchPersisterContext($offset, $limit);

        $baseTableAlias = $this->getSQLTableAlias($this->class->name);
        $joinSql        = $this->getJoinSql($baseTableAlias);

        if ($assoc != null && $assoc['type'] == ClassMetadata::MANY_TO_MANY) {
            $joinSql .= $this->getSelectManyToManyJoinSQL($assoc);
        }

        $conditionSql = ($criteria instanceof Criteria)
            ? $this->getSelectConditionCriteriaSQL($criteria)
            : $this->getSelectConditionSQL($criteria, $assoc);

        // If the current class in the root entity, add the filters
        if ($filterSql = $this->generateFilterConditionSQL($this->em->getClassMetadata($this->class->rootEntityName), $this->getSQLTableAlias($this->class->rootEntityName))) {
            $conditionSql .= $conditionSql
                ? ' AND ' . $filterSql
                : $filterSql;
        }

        $orderBySql = '';

        if ($assoc !== null && isset($assoc['orderBy'])) {
            $orderBy = $assoc['orderBy'];
        }

        if ($orderBy) {
            $orderBySql = $this->getOrderBySQL($orderBy, $baseTableAlias);
        }

        $lockSql = '';

        switch ($lockMode) {
            case LockMode::PESSIMISTIC_READ:

                $lockSql = ' ' . $this->platform->getReadLockSQL();

                break;

            case LockMode::PESSIMISTIC_WRITE:

                $lockSql = ' ' . $this->platform->getWriteLockSQL();

                break;
        }

        $tableName  = $this->quoteStrategy->getTableName($this->class, $this->platform);
        $from       = ' FROM ' . $tableName . ' ' . $baseTableAlias;
        $where      = $conditionSql != '' ? ' WHERE ' . $conditionSql : '';
        $lock       = $this->platform->appendLockHint($from, $lockMode);
        $columnList = $this->getSelectColumnsSQL();
        $query      = 'SELECT '  . $columnList
                    . $lock
                    . $joinSql
                    . $where
                    . $orderBySql;

        return $this->platform->modifyLimitQuery($query, $limit, $offset) . $lockSql;
    }

    /**
     * {@inheritDoc}
     */
    public function getCountSQL($criteria = [])
    {
        $tableName      = $this->quoteStrategy->getTableName($this->class, $this->platform);
        $baseTableAlias = $this->getSQLTableAlias($this->class->name);
        $joinSql        = $this->getJoinSql($baseTableAlias);

        $conditionSql = ($criteria instanceof Criteria)
            ? $this->getSelectConditionCriteriaSQL($criteria)
            : $this->getSelectConditionSQL($criteria);

        $filterSql = $this->generateFilterConditionSQL($this->em->getClassMetadata($this->class->rootEntityName), $this->getSQLTableAlias($this->class->rootEntityName));

        if ('' !== $filterSql) {
            $conditionSql = $conditionSql
                ? $conditionSql . ' AND ' . $filterSql
                : $filterSql;
        }

        $sql = 'SELECT COUNT(*) '
            . 'FROM ' . $tableName . ' ' . $baseTableAlias
            . $joinSql
            . (empty($conditionSql) ? '' : ' WHERE ' . $conditionSql);

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    protected function getLockTablesSql($lockMode)
    {
        $joinSql            = '';
        $identifierColumns  = $this->class->getIdentifierColumnNames();
        $baseTableAlias     = $this->getSQLTableAlias($this->class->name);

        // INNER JOIN parent tables
        foreach ($this->class->parentClasses as $parentClassName) {
            $conditions     = [];
            $tableAlias     = $this->getSQLTableAlias($parentClassName);
            $parentClass    = $this->em->getClassMetadata($parentClassName);
            $joinSql       .= ' INNER JOIN ' . $this->quoteStrategy->getTableName($parentClass, $this->platform) . ' ' . $tableAlias . ' ON ';

            foreach ($identifierColumns as $idColumn) {
                $conditions[] = $baseTableAlias . '.' . $idColumn . ' = ' . $tableAlias . '.' . $idColumn;
            }

            $joinSql .= implode(' AND ', $conditions);
        }

        return parent::getLockTablesSql($lockMode) . $joinSql;
    }

    /**
     * Ensure this method is never called. This persister overrides getSelectEntitiesSQL directly.
     *
     * @return string
     */
    protected function getSelectColumnsSQL()
    {
        // Create the column list fragment only once
        if ($this->currentPersisterContext->selectColumnListSql !== null) {
            return $this->currentPersisterContext->selectColumnListSql;
        }

        $columnList         = [];
        $discrColumn        = $this->class->discriminatorColumn['name'];
        $discrColumnType    = $this->class->discriminatorColumn['type'];
        $baseTableAlias     = $this->getSQLTableAlias($this->class->name);
        $resultColumnName   = $this->platform->getSQLResultCasing($discrColumn);

        $this->currentPersisterContext->rsm->addEntityResult($this->class->name, 'r');
        $this->currentPersisterContext->rsm->setDiscriminatorColumn('r', $resultColumnName);
        $this->currentPersisterContext->rsm->addMetaResult('r', $resultColumnName, $discrColumn, false, $discrColumnType);

        // Add regular columns
        foreach ($this->class->fieldMappings as $fieldName => $mapping) {
            $class = isset($mapping['inherited'])
                ? $this->em->getClassMetadata($mapping['inherited'])
                : $this->class;

            $columnList[] = $this->getSelectColumnSQL($fieldName, $class);
        }

        // Add foreign key columns
        foreach ($this->class->associationMappings as $mapping) {
            if ( ! $mapping['isOwningSide'] || ! ($mapping['type'] & ClassMetadata::TO_ONE)) {
                continue;
            }

            $tableAlias = isset($mapping['inherited'])
                ? $this->getSQLTableAlias($mapping['inherited'])
                : $baseTableAlias;

            $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);

            foreach ($mapping['joinColumns'] as $joinColumn) {
                $columnList[] = $this->getSelectJoinColumnSQL(
                    $tableAlias,
                    $joinColumn['name'],
                    $this->quoteStrategy->getJoinColumnName($joinColumn, $this->class, $this->platform),
                    PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em)
                );
            }
        }

        // Add discriminator column (DO NOT ALIAS, see AbstractEntityInheritancePersister#processSQLResult).
        $tableAlias = ($this->class->rootEntityName == $this->class->name)
            ? $baseTableAlias
            : $this->getSQLTableAlias($this->class->rootEntityName);

        $columnList[] = $tableAlias . '.' . $discrColumn;

        // sub tables
        foreach ($this->class->subClasses as $subClassName) {
            $subClass   = $this->em->getClassMetadata($subClassName);
            $tableAlias = $this->getSQLTableAlias($subClassName);

            // Add subclass columns
            foreach ($subClass->fieldMappings as $fieldName => $mapping) {
                if (isset($mapping['inherited'])) {
                    continue;
                }

                $columnList[] = $this->getSelectColumnSQL($fieldName, $subClass);
            }

            // Add join columns (foreign keys)
            foreach ($subClass->associationMappings as $mapping) {
                if ( ! $mapping['isOwningSide']
                        || ! ($mapping['type'] & ClassMetadata::TO_ONE)
                        || isset($mapping['inherited'])) {
                    continue;
                }

                $targetClass = $this->em->getClassMetadata($mapping['targetEntity']);

                foreach ($mapping['joinColumns'] as $joinColumn) {
                    $columnList[] = $this->getSelectJoinColumnSQL(
                        $tableAlias,
                        $joinColumn['name'],
                        $this->quoteStrategy->getJoinColumnName($joinColumn, $subClass, $this->platform),
                        PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em)
                    );
                }
            }
        }

        $this->currentPersisterContext->selectColumnListSql = implode(', ', $columnList);

        return $this->currentPersisterContext->selectColumnListSql;
    }

    /**
     * {@inheritdoc}
     */
    protected function getInsertColumnList()
    {
        // Identifier columns must always come first in the column list of subclasses.
        $columns = $this->class->parentClasses
            ? $this->class->getIdentifierColumnNames()
            : [];

        foreach ($this->class->reflFields as $name => $field) {
            if (isset($this->class->fieldMappings[$name]['inherited'])
                    && ! isset($this->class->fieldMappings[$name]['id'])
                    || isset($this->class->associationMappings[$name]['inherited'])
                    || ($this->class->isVersioned && $this->class->versionField == $name)
                    || isset($this->class->embeddedClasses[$name])) {
                continue;
            }

            if (isset($this->class->associationMappings[$name])) {
                $assoc = $this->class->associationMappings[$name];
                if ($assoc['type'] & ClassMetadata::TO_ONE && $assoc['isOwningSide']) {
                    foreach ($assoc['targetToSourceKeyColumns'] as $sourceCol) {
                        $columns[] = $sourceCol;
                    }
                }
            } else if ($this->class->name != $this->class->rootEntityName ||
                    ! $this->class->isIdGeneratorIdentity() || $this->class->identifier[0] != $name) {
                $columns[]                  = $this->quoteStrategy->getColumnName($name, $this->class, $this->platform);
                $this->columnTypes[$name]   = $this->class->fieldMappings[$name]['type'];
            }
        }

        // Add discriminator column if it is the topmost class.
        if ($this->class->name == $this->class->rootEntityName) {
            $columns[] = $this->class->discriminatorColumn['name'];
        }

        return $columns;
    }

    /**
     * {@inheritdoc}
     */
    protected function assignDefaultVersionValue($entity, array $id)
    {
        $value = $this->fetchVersionValue($this->getVersionedClassMetadata(), $id);
        $this->class->setFieldValue($entity, $this->class->versionField, $value);
    }

    /**
     * @param string $baseTableAlias
     *
     * @return string
     */
    private function getJoinSql($baseTableAlias)
    {
        $joinSql          = '';
        $identifierColumn = $this->class->getIdentifierColumnNames();

        // INNER JOIN parent tables
        foreach ($this->class->parentClasses as $parentClassName) {
            $conditions   = [];
            $parentClass  = $this->em->getClassMetadata($parentClassName);
            $tableAlias   = $this->getSQLTableAlias($parentClassName);
            $joinSql     .= ' INNER JOIN ' . $this->quoteStrategy->getTableName($parentClass, $this->platform) . ' ' . $tableAlias . ' ON ';


            foreach ($identifierColumn as $idColumn) {
                $conditions[] = $baseTableAlias . '.' . $idColumn . ' = ' . $tableAlias . '.' . $idColumn;
            }

            $joinSql .= implode(' AND ', $conditions);
        }

        // OUTER JOIN sub tables
        foreach ($this->class->subClasses as $subClassName) {
            $conditions  = [];
            $subClass    = $this->em->getClassMetadata($subClassName);
            $tableAlias  = $this->getSQLTableAlias($subClassName);
            $joinSql    .= ' LEFT JOIN ' . $this->quoteStrategy->getTableName($subClass, $this->platform) . ' ' . $tableAlias . ' ON ';

            foreach ($identifierColumn as $idColumn) {
                $conditions[] = $baseTableAlias . '.' . $idColumn . ' = ' . $tableAlias . '.' . $idColumn;
            }

            $joinSql .= implode(' AND ', $conditions);
        }

        return $joinSql;
    }
}
