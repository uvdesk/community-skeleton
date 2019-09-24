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

namespace Doctrine\ORM\Query;

use Doctrine\DBAL\LockMode;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Utility\HierarchyDiscriminatorResolver;
use Doctrine\ORM\Utility\PersisterHelper;

/**
 * The SqlWalker is a TreeWalker that walks over a DQL AST and constructs
 * the corresponding SQL.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Alexander <iam.asm89@gmail.com>
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @since  2.0
 */
class SqlWalker implements TreeWalker
{
    /**
     * @var string
     */
    const HINT_DISTINCT = 'doctrine.distinct';

    /**
     * @var ResultSetMapping
     */
    private $rsm;

    /**
     * Counter for generating unique column aliases.
     *
     * @var integer
     */
    private $aliasCounter = 0;

    /**
     * Counter for generating unique table aliases.
     *
     * @var integer
     */
    private $tableAliasCounter = 0;

    /**
     * Counter for generating unique scalar result.
     *
     * @var integer
     */
    private $scalarResultCounter = 1;

    /**
     * Counter for generating unique parameter indexes.
     *
     * @var integer
     */
    private $sqlParamIndex = 0;

    /**
     * Counter for generating indexes.
     *
     * @var integer
     */
    private $newObjectCounter = 0;

    /**
     * @var ParserResult
     */
    private $parserResult;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $conn;

    /**
     * @var \Doctrine\ORM\AbstractQuery
     */
    private $query;

    /**
     * @var array
     */
    private $tableAliasMap = [];

    /**
     * Map from result variable names to their SQL column alias names.
     *
     * @var array
     */
    private $scalarResultAliasMap = [];

    /**
     * Map from Table-Alias + Column-Name to OrderBy-Direction.
     *
     * @var array
     */
    private $orderedColumnsMap = [];

    /**
     * Map from DQL-Alias + Field-Name to SQL Column Alias.
     *
     * @var array
     */
    private $scalarFields = [];

    /**
     * Map of all components/classes that appear in the DQL query.
     *
     * @var array
     */
    private $queryComponents;

    /**
     * A list of classes that appear in non-scalar SelectExpressions.
     *
     * @var array
     */
    private $selectedClasses = [];

    /**
     * The DQL alias of the root class of the currently traversed query.
     *
     * @var array
     */
    private $rootAliases = [];

    /**
     * Flag that indicates whether to generate SQL table aliases in the SQL.
     * These should only be generated for SELECT queries, not for UPDATE/DELETE.
     *
     * @var boolean
     */
    private $useSqlTableAliases = true;

    /**
     * The database platform abstraction.
     *
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    private $platform;

    /**
     * The quote strategy.
     *
     * @var \Doctrine\ORM\Mapping\QuoteStrategy
     */
    private $quoteStrategy;

    /**
     * {@inheritDoc}
     */
    public function __construct($query, $parserResult, array $queryComponents)
    {
        $this->query            = $query;
        $this->parserResult     = $parserResult;
        $this->queryComponents  = $queryComponents;
        $this->rsm              = $parserResult->getResultSetMapping();
        $this->em               = $query->getEntityManager();
        $this->conn             = $this->em->getConnection();
        $this->platform         = $this->conn->getDatabasePlatform();
        $this->quoteStrategy    = $this->em->getConfiguration()->getQuoteStrategy();
    }

    /**
     * Gets the Query instance used by the walker.
     *
     * @return Query.
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets the Connection used by the walker.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Gets the EntityManager used by the walker.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Gets the information about a single query component.
     *
     * @param string $dqlAlias The DQL alias.
     *
     * @return array
     */
    public function getQueryComponent($dqlAlias)
    {
        return $this->queryComponents[$dqlAlias];
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryComponents()
    {
        return $this->queryComponents;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueryComponent($dqlAlias, array $queryComponent)
    {
        $requiredKeys = ['metadata', 'parent', 'relation', 'map', 'nestingLevel', 'token'];

        if (array_diff($requiredKeys, array_keys($queryComponent))) {
            throw QueryException::invalidQueryComponent($dqlAlias);
        }

        $this->queryComponents[$dqlAlias] = $queryComponent;
    }

    /**
     * {@inheritdoc}
     */
    public function getExecutor($AST)
    {
        switch (true) {
            case ($AST instanceof AST\DeleteStatement):
                $primaryClass = $this->em->getClassMetadata($AST->deleteClause->abstractSchemaName);

                return ($primaryClass->isInheritanceTypeJoined())
                    ? new Exec\MultiTableDeleteExecutor($AST, $this)
                    : new Exec\SingleTableDeleteUpdateExecutor($AST, $this);

            case ($AST instanceof AST\UpdateStatement):
                $primaryClass = $this->em->getClassMetadata($AST->updateClause->abstractSchemaName);

                return ($primaryClass->isInheritanceTypeJoined())
                    ? new Exec\MultiTableUpdateExecutor($AST, $this)
                    : new Exec\SingleTableDeleteUpdateExecutor($AST, $this);

            default:
                return new Exec\SingleSelectExecutor($AST, $this);
        }
    }

    /**
     * Generates a unique, short SQL table alias.
     *
     * @param string $tableName Table name
     * @param string $dqlAlias  The DQL alias.
     *
     * @return string Generated table alias.
     */
    public function getSQLTableAlias($tableName, $dqlAlias = '')
    {
        $tableName .= ($dqlAlias) ? '@[' . $dqlAlias . ']' : '';

        if ( ! isset($this->tableAliasMap[$tableName])) {
            $this->tableAliasMap[$tableName] = (preg_match('/[a-z]/i', $tableName[0]) ? strtolower($tableName[0]) : 't')
                . $this->tableAliasCounter++ . '_';
        }

        return $this->tableAliasMap[$tableName];
    }

    /**
     * Forces the SqlWalker to use a specific alias for a table name, rather than
     * generating an alias on its own.
     *
     * @param string $tableName
     * @param string $alias
     * @param string $dqlAlias
     *
     * @return string
     */
    public function setSQLTableAlias($tableName, $alias, $dqlAlias = '')
    {
        $tableName .= ($dqlAlias) ? '@[' . $dqlAlias . ']' : '';

        $this->tableAliasMap[$tableName] = $alias;

        return $alias;
    }

    /**
     * Gets an SQL column alias for a column name.
     *
     * @param string $columnName
     *
     * @return string
     */
    public function getSQLColumnAlias($columnName)
    {
        return $this->quoteStrategy->getColumnAlias($columnName, $this->aliasCounter++, $this->platform);
    }

    /**
     * Generates the SQL JOINs that are necessary for Class Table Inheritance
     * for the given class.
     *
     * @param ClassMetadata $class    The class for which to generate the joins.
     * @param string        $dqlAlias The DQL alias of the class.
     *
     * @return string The SQL.
     */
    private function _generateClassTableInheritanceJoins($class, $dqlAlias)
    {
        $sql = '';

        $baseTableAlias = $this->getSQLTableAlias($class->getTableName(), $dqlAlias);

        // INNER JOIN parent class tables
        foreach ($class->parentClasses as $parentClassName) {
            $parentClass = $this->em->getClassMetadata($parentClassName);
            $tableAlias  = $this->getSQLTableAlias($parentClass->getTableName(), $dqlAlias);

            // If this is a joined association we must use left joins to preserve the correct result.
            $sql .= isset($this->queryComponents[$dqlAlias]['relation']) ? ' LEFT ' : ' INNER ';
            $sql .= 'JOIN ' . $this->quoteStrategy->getTableName($parentClass, $this->platform) . ' ' . $tableAlias . ' ON ';

            $sqlParts = [];

            foreach ($this->quoteStrategy->getIdentifierColumnNames($class, $this->platform) as $columnName) {
                $sqlParts[] = $baseTableAlias . '.' . $columnName . ' = ' . $tableAlias . '.' . $columnName;
            }

            // Add filters on the root class
            if ($filterSql = $this->generateFilterConditionSQL($parentClass, $tableAlias)) {
                $sqlParts[] = $filterSql;
            }

            $sql .= implode(' AND ', $sqlParts);
        }

        // Ignore subclassing inclusion if partial objects is disallowed
        if ($this->query->getHint(Query::HINT_FORCE_PARTIAL_LOAD)) {
            return $sql;
        }

        // LEFT JOIN child class tables
        foreach ($class->subClasses as $subClassName) {
            $subClass   = $this->em->getClassMetadata($subClassName);
            $tableAlias = $this->getSQLTableAlias($subClass->getTableName(), $dqlAlias);

            $sql .= ' LEFT JOIN ' . $this->quoteStrategy->getTableName($subClass, $this->platform) . ' ' . $tableAlias . ' ON ';

            $sqlParts = [];

            foreach ($this->quoteStrategy->getIdentifierColumnNames($subClass, $this->platform) as $columnName) {
                $sqlParts[] = $baseTableAlias . '.' . $columnName . ' = ' . $tableAlias . '.' . $columnName;
            }

            $sql .= implode(' AND ', $sqlParts);
        }

        return $sql;
    }

    /**
     * @return string
     */
    private function _generateOrderedCollectionOrderByItems()
    {
        $orderedColumns = [];

        foreach ($this->selectedClasses as $selectedClass) {
            $dqlAlias  = $selectedClass['dqlAlias'];
            $qComp     = $this->queryComponents[$dqlAlias];

            if ( ! isset($qComp['relation']['orderBy'])) {
                continue;
            }

            $persister = $this->em->getUnitOfWork()->getEntityPersister($qComp['metadata']->name);

            foreach ($qComp['relation']['orderBy'] as $fieldName => $orientation) {
                $columnName = $this->quoteStrategy->getColumnName($fieldName, $qComp['metadata'], $this->platform);
                $tableName  = ($qComp['metadata']->isInheritanceTypeJoined())
                    ? $persister->getOwningTable($fieldName)
                    : $qComp['metadata']->getTableName();

                $orderedColumn = $this->getSQLTableAlias($tableName, $dqlAlias) . '.' . $columnName;

                // OrderByClause should replace an ordered relation. see - DDC-2475
                if (isset($this->orderedColumnsMap[$orderedColumn])) {
                    continue;
                }

                $this->orderedColumnsMap[$orderedColumn] = $orientation;
                $orderedColumns[] = $orderedColumn . ' ' . $orientation;
            }
        }

        return implode(', ', $orderedColumns);
    }

    /**
     * Generates a discriminator column SQL condition for the class with the given DQL alias.
     *
     * @param array $dqlAliases List of root DQL aliases to inspect for discriminator restrictions.
     *
     * @return string
     */
    private function _generateDiscriminatorColumnConditionSQL(array $dqlAliases)
    {
        $sqlParts = [];

        foreach ($dqlAliases as $dqlAlias) {
            $class = $this->queryComponents[$dqlAlias]['metadata'];

            if ( ! $class->isInheritanceTypeSingleTable()) continue;

            $conn   = $this->em->getConnection();
            $values = [];

            if ($class->discriminatorValue !== null) { // discriminators can be 0
                $values[] = $conn->quote($class->discriminatorValue);
            }

            foreach ($class->subClasses as $subclassName) {
                $values[] = $conn->quote($this->em->getClassMetadata($subclassName)->discriminatorValue);
            }

            $sqlTableAlias = ($this->useSqlTableAliases)
                ? $this->getSQLTableAlias($class->getTableName(), $dqlAlias) . '.'
                : '';

            $sqlParts[] = $sqlTableAlias . $class->discriminatorColumn['name'] . ' IN (' . implode(', ', $values) . ')';
        }

        $sql = implode(' AND ', $sqlParts);

        return (count($sqlParts) > 1) ? '(' . $sql . ')' : $sql;
    }

    /**
     * Generates the filter SQL for a given entity and table alias.
     *
     * @param ClassMetadata $targetEntity     Metadata of the target entity.
     * @param string        $targetTableAlias The table alias of the joined/selected table.
     *
     * @return string The SQL query part to add to a query.
     */
    private function generateFilterConditionSQL(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$this->em->hasFilters()) {
            return '';
        }

        switch($targetEntity->inheritanceType) {
            case ClassMetadata::INHERITANCE_TYPE_NONE:
                break;
            case ClassMetadata::INHERITANCE_TYPE_JOINED:
                // The classes in the inheritance will be added to the query one by one,
                // but only the root node is getting filtered
                if ($targetEntity->name !== $targetEntity->rootEntityName) {
                    return '';
                }
                break;
            case ClassMetadata::INHERITANCE_TYPE_SINGLE_TABLE:
                // With STI the table will only be queried once, make sure that the filters
                // are added to the root entity
                $targetEntity = $this->em->getClassMetadata($targetEntity->rootEntityName);
                break;
            default:
                //@todo: throw exception?
                return '';
        }

        $filterClauses = [];
        foreach ($this->em->getFilters()->getEnabledFilters() as $filter) {
            if ('' !== $filterExpr = $filter->addFilterConstraint($targetEntity, $targetTableAlias)) {
                $filterClauses[] = '(' . $filterExpr . ')';
            }
        }

        return implode(' AND ', $filterClauses);
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectStatement(AST\SelectStatement $AST)
    {
        $limit    = $this->query->getMaxResults();
        $offset   = $this->query->getFirstResult();
        $lockMode = $this->query->getHint(Query::HINT_LOCK_MODE);
        $sql      = $this->walkSelectClause($AST->selectClause)
            . $this->walkFromClause($AST->fromClause)
            . $this->walkWhereClause($AST->whereClause);

        if ($AST->groupByClause) {
            $sql .= $this->walkGroupByClause($AST->groupByClause);
        }

        if ($AST->havingClause) {
            $sql .= $this->walkHavingClause($AST->havingClause);
        }

        if ($AST->orderByClause) {
            $sql .= $this->walkOrderByClause($AST->orderByClause);
        }

        if ( ! $AST->orderByClause && ($orderBySql = $this->_generateOrderedCollectionOrderByItems())) {
            $sql .= ' ORDER BY ' . $orderBySql;
        }

        if ($limit !== null || $offset !== null) {
            $sql = $this->platform->modifyLimitQuery($sql, $limit, $offset);
        }

        if ($lockMode === null || $lockMode === false || $lockMode === LockMode::NONE) {
            return $sql;
        }

        if ($lockMode === LockMode::PESSIMISTIC_READ) {
            return $sql . ' ' . $this->platform->getReadLockSQL();
        }

        if ($lockMode === LockMode::PESSIMISTIC_WRITE) {
            return $sql . ' ' . $this->platform->getWriteLockSQL();
        }

        if ($lockMode !== LockMode::OPTIMISTIC) {
            throw QueryException::invalidLockMode();
        }

        foreach ($this->selectedClasses as $selectedClass) {
            if ( ! $selectedClass['class']->isVersioned) {
                throw OptimisticLockException::lockFailed($selectedClass['class']->name);
            }
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateStatement(AST\UpdateStatement $AST)
    {
        $this->useSqlTableAliases = false;
        $this->rsm->isSelect      = false;

        return $this->walkUpdateClause($AST->updateClause)
            . $this->walkWhereClause($AST->whereClause);
    }

    /**
     * {@inheritdoc}
     */
    public function walkDeleteStatement(AST\DeleteStatement $AST)
    {
        $this->useSqlTableAliases = false;
        $this->rsm->isSelect      = false;

        return $this->walkDeleteClause($AST->deleteClause)
            . $this->walkWhereClause($AST->whereClause);
    }

    /**
     * Walks down an IdentificationVariable AST node, thereby generating the appropriate SQL.
     * This one differs of ->walkIdentificationVariable() because it generates the entity identifiers.
     *
     * @param string $identVariable
     *
     * @return string
     */
    public function walkEntityIdentificationVariable($identVariable)
    {
        $class      = $this->queryComponents[$identVariable]['metadata'];
        $tableAlias = $this->getSQLTableAlias($class->getTableName(), $identVariable);
        $sqlParts   = [];

        foreach ($this->quoteStrategy->getIdentifierColumnNames($class, $this->platform) as $columnName) {
            $sqlParts[] = $tableAlias . '.' . $columnName;
        }

        return implode(', ', $sqlParts);
    }

    /**
     * Walks down an IdentificationVariable (no AST node associated), thereby generating the SQL.
     *
     * @param string $identificationVariable
     * @param string $fieldName
     *
     * @return string The SQL.
     */
    public function walkIdentificationVariable($identificationVariable, $fieldName = null)
    {
        $class = $this->queryComponents[$identificationVariable]['metadata'];

        if (
            $fieldName !== null && $class->isInheritanceTypeJoined() &&
            isset($class->fieldMappings[$fieldName]['inherited'])
        ) {
            $class = $this->em->getClassMetadata($class->fieldMappings[$fieldName]['inherited']);
        }

        return $this->getSQLTableAlias($class->getTableName(), $identificationVariable);
    }

    /**
     * {@inheritdoc}
     */
    public function walkPathExpression($pathExpr)
    {
        $sql = '';

        /* @var $pathExpr Query\AST\PathExpression */
        switch ($pathExpr->type) {
            case AST\PathExpression::TYPE_STATE_FIELD:
                $fieldName = $pathExpr->field;
                $dqlAlias = $pathExpr->identificationVariable;
                $class = $this->queryComponents[$dqlAlias]['metadata'];

                if ($this->useSqlTableAliases) {
                    $sql .= $this->walkIdentificationVariable($dqlAlias, $fieldName) . '.';
                }

                $sql .= $this->quoteStrategy->getColumnName($fieldName, $class, $this->platform);
                break;

            case AST\PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION:
                // 1- the owning side:
                //    Just use the foreign key, i.e. u.group_id
                $fieldName = $pathExpr->field;
                $dqlAlias = $pathExpr->identificationVariable;
                $class = $this->queryComponents[$dqlAlias]['metadata'];

                if (isset($class->associationMappings[$fieldName]['inherited'])) {
                    $class = $this->em->getClassMetadata($class->associationMappings[$fieldName]['inherited']);
                }

                $assoc = $class->associationMappings[$fieldName];

                if ( ! $assoc['isOwningSide']) {
                    throw QueryException::associationPathInverseSideNotSupported($pathExpr);
                }

                // COMPOSITE KEYS NOT (YET?) SUPPORTED
                if (count($assoc['sourceToTargetKeyColumns']) > 1) {
                    throw QueryException::associationPathCompositeKeyNotSupported();
                }

                if ($this->useSqlTableAliases) {
                    $sql .= $this->getSQLTableAlias($class->getTableName(), $dqlAlias) . '.';
                }

                $sql .= reset($assoc['targetToSourceKeyColumns']);
                break;

            default:
                throw QueryException::invalidPathExpression($pathExpr);
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectClause($selectClause)
    {
        $sql = 'SELECT ' . (($selectClause->isDistinct) ? 'DISTINCT ' : '');
        $sqlSelectExpressions = array_filter(array_map([$this, 'walkSelectExpression'], $selectClause->selectExpressions));

        if ($this->query->getHint(Query::HINT_INTERNAL_ITERATION) == true && $selectClause->isDistinct) {
            $this->query->setHint(self::HINT_DISTINCT, true);
        }

        $addMetaColumns = ! $this->query->getHint(Query::HINT_FORCE_PARTIAL_LOAD) &&
            $this->query->getHydrationMode() == Query::HYDRATE_OBJECT
            ||
            $this->query->getHydrationMode() != Query::HYDRATE_OBJECT &&
            $this->query->getHint(Query::HINT_INCLUDE_META_COLUMNS);

        foreach ($this->selectedClasses as $selectedClass) {
            $class       = $selectedClass['class'];
            $dqlAlias    = $selectedClass['dqlAlias'];
            $resultAlias = $selectedClass['resultAlias'];

            // Register as entity or joined entity result
            if ($this->queryComponents[$dqlAlias]['relation'] === null) {
                $this->rsm->addEntityResult($class->name, $dqlAlias, $resultAlias);
            } else {
                $this->rsm->addJoinedEntityResult(
                    $class->name,
                    $dqlAlias,
                    $this->queryComponents[$dqlAlias]['parent'],
                    $this->queryComponents[$dqlAlias]['relation']['fieldName']
                );
            }

            if ($class->isInheritanceTypeSingleTable() || $class->isInheritanceTypeJoined()) {
                // Add discriminator columns to SQL
                $rootClass   = $this->em->getClassMetadata($class->rootEntityName);
                $tblAlias    = $this->getSQLTableAlias($rootClass->getTableName(), $dqlAlias);
                $discrColumn = $rootClass->discriminatorColumn;
                $columnAlias = $this->getSQLColumnAlias($discrColumn['name']);

                $sqlSelectExpressions[] = $tblAlias . '.' . $discrColumn['name'] . ' AS ' . $columnAlias;

                $this->rsm->setDiscriminatorColumn($dqlAlias, $columnAlias);
                $this->rsm->addMetaResult($dqlAlias, $columnAlias, $discrColumn['fieldName'], false, $discrColumn['type']);
            }

            // Add foreign key columns to SQL, if necessary
            if ( ! $addMetaColumns && ! $class->containsForeignIdentifier) {
                continue;
            }

            // Add foreign key columns of class and also parent classes
            foreach ($class->associationMappings as $assoc) {
                if ( ! ($assoc['isOwningSide'] && $assoc['type'] & ClassMetadata::TO_ONE)
                    || ( ! $addMetaColumns && !isset($assoc['id']))) {
                    continue;
                }

                $targetClass   = $this->em->getClassMetadata($assoc['targetEntity']);
                $isIdentifier  = (isset($assoc['id']) && $assoc['id'] === true);
                $owningClass   = (isset($assoc['inherited'])) ? $this->em->getClassMetadata($assoc['inherited']) : $class;
                $sqlTableAlias = $this->getSQLTableAlias($owningClass->getTableName(), $dqlAlias);

                foreach ($assoc['joinColumns'] as $joinColumn) {
                    $columnName  = $joinColumn['name'];
                    $columnAlias = $this->getSQLColumnAlias($columnName);
                    $columnType  = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em);

                    $quotedColumnName       = $this->quoteStrategy->getJoinColumnName($joinColumn, $class, $this->platform);
                    $sqlSelectExpressions[] = $sqlTableAlias . '.' . $quotedColumnName . ' AS ' . $columnAlias;

                    $this->rsm->addMetaResult($dqlAlias, $columnAlias, $columnName, $isIdentifier, $columnType);
                }
            }

            // Add foreign key columns to SQL, if necessary
            if ( ! $addMetaColumns) {
                continue;
            }

            // Add foreign key columns of subclasses
            foreach ($class->subClasses as $subClassName) {
                $subClass      = $this->em->getClassMetadata($subClassName);
                $sqlTableAlias = $this->getSQLTableAlias($subClass->getTableName(), $dqlAlias);

                foreach ($subClass->associationMappings as $assoc) {
                    // Skip if association is inherited
                    if (isset($assoc['inherited'])) continue;

                    if ($assoc['isOwningSide'] && $assoc['type'] & ClassMetadata::TO_ONE) {
                        $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);

                        foreach ($assoc['joinColumns'] as $joinColumn) {
                            $columnName  = $joinColumn['name'];
                            $columnAlias = $this->getSQLColumnAlias($columnName);
                            $columnType  = PersisterHelper::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $this->em);

                            $quotedColumnName       = $this->quoteStrategy->getJoinColumnName($joinColumn, $subClass, $this->platform);
                            $sqlSelectExpressions[] = $sqlTableAlias . '.' . $quotedColumnName . ' AS ' . $columnAlias;

                            $this->rsm->addMetaResult($dqlAlias, $columnAlias, $columnName, $subClass->isIdentifier($columnName), $columnType);
                        }
                    }
                }
            }
        }

        $sql .= implode(', ', $sqlSelectExpressions);

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkFromClause($fromClause)
    {
        $identificationVarDecls = $fromClause->identificationVariableDeclarations;
        $sqlParts = [];

        foreach ($identificationVarDecls as $identificationVariableDecl) {
            $sqlParts[] = $this->walkIdentificationVariableDeclaration($identificationVariableDecl);
        }

        return ' FROM ' . implode(', ', $sqlParts);
    }

    /**
     * Walks down a IdentificationVariableDeclaration AST node, thereby generating the appropriate SQL.
     *
     * @param AST\IdentificationVariableDeclaration $identificationVariableDecl
     *
     * @return string
     */
    public function walkIdentificationVariableDeclaration($identificationVariableDecl)
    {
        $sql = $this->walkRangeVariableDeclaration($identificationVariableDecl->rangeVariableDeclaration);

        if ($identificationVariableDecl->indexBy) {
            $this->walkIndexBy($identificationVariableDecl->indexBy);
        }

        foreach ($identificationVariableDecl->joins as $join) {
            $sql .= $this->walkJoin($join);
        }

        return $sql;
    }

    /**
     * Walks down a IndexBy AST node.
     *
     * @param AST\IndexBy $indexBy
     *
     * @return void
     */
    public function walkIndexBy($indexBy)
    {
        $pathExpression = $indexBy->simpleStateFieldPathExpression;
        $alias          = $pathExpression->identificationVariable;
        $field          = $pathExpression->field;

        if (isset($this->scalarFields[$alias][$field])) {
            $this->rsm->addIndexByScalar($this->scalarFields[$alias][$field]);

            return;
        }

        $this->rsm->addIndexBy($alias, $field);
    }

    /**
     * Walks down a RangeVariableDeclaration AST node, thereby generating the appropriate SQL.
     *
     * @param AST\RangeVariableDeclaration $rangeVariableDeclaration
     *
     * @return string
     */
    public function walkRangeVariableDeclaration($rangeVariableDeclaration)
    {
        return $this->generateRangeVariableDeclarationSQL($rangeVariableDeclaration, false);
    }

    /**
     * Generate appropriate SQL for RangeVariableDeclaration AST node
     *
     * @param AST\RangeVariableDeclaration $rangeVariableDeclaration
     * @param bool $buildNestedJoins
     *
     * @return string
     */
    private function generateRangeVariableDeclarationSQL($rangeVariableDeclaration, bool $buildNestedJoins) : string
    {
        $class    = $this->em->getClassMetadata($rangeVariableDeclaration->abstractSchemaName);
        $dqlAlias = $rangeVariableDeclaration->aliasIdentificationVariable;

        if ($rangeVariableDeclaration->isRoot) {
            $this->rootAliases[] = $dqlAlias;
        }

        $sql = $this->platform->appendLockHint(
            $this->quoteStrategy->getTableName($class, $this->platform) . ' ' .
            $this->getSQLTableAlias($class->getTableName(), $dqlAlias),
            $this->query->getHint(Query::HINT_LOCK_MODE)
        );

        if ( ! $class->isInheritanceTypeJoined()) {
            return $sql;
        }

        $classTableInheritanceJoins = $this->_generateClassTableInheritanceJoins($class, $dqlAlias);

        if ( ! $buildNestedJoins) {
            return $sql . $classTableInheritanceJoins;
        }

        return $classTableInheritanceJoins === '' ? $sql : '(' . $sql . $classTableInheritanceJoins . ')';
    }

    /**
     * Walks down a JoinAssociationDeclaration AST node, thereby generating the appropriate SQL.
     *
     * @param AST\JoinAssociationDeclaration $joinAssociationDeclaration
     * @param int                            $joinType
     * @param AST\ConditionalExpression      $condExpr
     *
     * @return string
     *
     * @throws QueryException
     */
    public function walkJoinAssociationDeclaration($joinAssociationDeclaration, $joinType = AST\Join::JOIN_TYPE_INNER, $condExpr = null)
    {
        $sql = '';

        $associationPathExpression = $joinAssociationDeclaration->joinAssociationPathExpression;
        $joinedDqlAlias            = $joinAssociationDeclaration->aliasIdentificationVariable;
        $indexBy                   = $joinAssociationDeclaration->indexBy;

        $relation        = $this->queryComponents[$joinedDqlAlias]['relation'];
        $targetClass     = $this->em->getClassMetadata($relation['targetEntity']);
        $sourceClass     = $this->em->getClassMetadata($relation['sourceEntity']);
        $targetTableName = $this->quoteStrategy->getTableName($targetClass, $this->platform);

        $targetTableAlias = $this->getSQLTableAlias($targetClass->getTableName(), $joinedDqlAlias);
        $sourceTableAlias = $this->getSQLTableAlias($sourceClass->getTableName(), $associationPathExpression->identificationVariable);

        // Ensure we got the owning side, since it has all mapping info
        $assoc = ( ! $relation['isOwningSide']) ? $targetClass->associationMappings[$relation['mappedBy']] : $relation;

        if ($this->query->getHint(Query::HINT_INTERNAL_ITERATION) == true && (!$this->query->getHint(self::HINT_DISTINCT) || isset($this->selectedClasses[$joinedDqlAlias]))) {
            if ($relation['type'] == ClassMetadata::ONE_TO_MANY || $relation['type'] == ClassMetadata::MANY_TO_MANY) {
                throw QueryException::iterateWithFetchJoinNotAllowed($assoc);
            }
        }

        $targetTableJoin = null;

        // This condition is not checking ClassMetadata::MANY_TO_ONE, because by definition it cannot
        // be the owning side and previously we ensured that $assoc is always the owning side of the associations.
        // The owning side is necessary at this point because only it contains the JoinColumn information.
        switch (true) {
            case ($assoc['type'] & ClassMetadata::TO_ONE):
                $conditions = [];

                foreach ($assoc['joinColumns'] as $joinColumn) {
                    $quotedSourceColumn = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
                    $quotedTargetColumn = $this->quoteStrategy->getReferencedJoinColumnName($joinColumn, $targetClass, $this->platform);

                    if ($relation['isOwningSide']) {
                        $conditions[] = $sourceTableAlias . '.' . $quotedSourceColumn . ' = ' . $targetTableAlias . '.' . $quotedTargetColumn;

                        continue;
                    }

                    $conditions[] = $sourceTableAlias . '.' . $quotedTargetColumn . ' = ' . $targetTableAlias . '.' . $quotedSourceColumn;
                }

                // Apply remaining inheritance restrictions
                $discrSql = $this->_generateDiscriminatorColumnConditionSQL([$joinedDqlAlias]);

                if ($discrSql) {
                    $conditions[] = $discrSql;
                }

                // Apply the filters
                $filterExpr = $this->generateFilterConditionSQL($targetClass, $targetTableAlias);

                if ($filterExpr) {
                    $conditions[] = $filterExpr;
                }

                $targetTableJoin = [
                    'table' => $targetTableName . ' ' . $targetTableAlias,
                    'condition' => implode(' AND ', $conditions),
                ];
                break;

            case ($assoc['type'] == ClassMetadata::MANY_TO_MANY):
                // Join relation table
                $joinTable      = $assoc['joinTable'];
                $joinTableAlias = $this->getSQLTableAlias($joinTable['name'], $joinedDqlAlias);
                $joinTableName  = $this->quoteStrategy->getJoinTableName($assoc, $sourceClass, $this->platform);

                $conditions      = [];
                $relationColumns = ($relation['isOwningSide'])
                    ? $assoc['joinTable']['joinColumns']
                    : $assoc['joinTable']['inverseJoinColumns'];

                foreach ($relationColumns as $joinColumn) {
                    $quotedSourceColumn = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
                    $quotedTargetColumn = $this->quoteStrategy->getReferencedJoinColumnName($joinColumn, $targetClass, $this->platform);

                    $conditions[] = $sourceTableAlias . '.' . $quotedTargetColumn . ' = ' . $joinTableAlias . '.' . $quotedSourceColumn;
                }

                $sql .= $joinTableName . ' ' . $joinTableAlias . ' ON ' . implode(' AND ', $conditions);

                // Join target table
                $sql .= ($joinType == AST\Join::JOIN_TYPE_LEFT || $joinType == AST\Join::JOIN_TYPE_LEFTOUTER) ? ' LEFT JOIN ' : ' INNER JOIN ';

                $conditions      = [];
                $relationColumns = ($relation['isOwningSide'])
                    ? $assoc['joinTable']['inverseJoinColumns']
                    : $assoc['joinTable']['joinColumns'];

                foreach ($relationColumns as $joinColumn) {
                    $quotedSourceColumn = $this->quoteStrategy->getJoinColumnName($joinColumn, $targetClass, $this->platform);
                    $quotedTargetColumn = $this->quoteStrategy->getReferencedJoinColumnName($joinColumn, $targetClass, $this->platform);

                    $conditions[] = $targetTableAlias . '.' . $quotedTargetColumn . ' = ' . $joinTableAlias . '.' . $quotedSourceColumn;
                }

                // Apply remaining inheritance restrictions
                $discrSql = $this->_generateDiscriminatorColumnConditionSQL([$joinedDqlAlias]);

                if ($discrSql) {
                    $conditions[] = $discrSql;
                }

                // Apply the filters
                $filterExpr = $this->generateFilterConditionSQL($targetClass, $targetTableAlias);

                if ($filterExpr) {
                    $conditions[] = $filterExpr;
                }

                $targetTableJoin = [
                    'table' => $targetTableName . ' ' . $targetTableAlias,
                    'condition' => implode(' AND ', $conditions),
                ];
                break;

            default:
                throw new \BadMethodCallException('Type of association must be one of *_TO_ONE or MANY_TO_MANY');
        }

        // Handle WITH clause
        $withCondition = (null === $condExpr) ? '' : ('(' . $this->walkConditionalExpression($condExpr) . ')');

        if ($targetClass->isInheritanceTypeJoined()) {
            $ctiJoins = $this->_generateClassTableInheritanceJoins($targetClass, $joinedDqlAlias);
            // If we have WITH condition, we need to build nested joins for target class table and cti joins
            if ($withCondition) {
                $sql .= '(' . $targetTableJoin['table'] . $ctiJoins . ') ON ' . $targetTableJoin['condition'];
            } else {
                $sql .= $targetTableJoin['table'] . ' ON ' . $targetTableJoin['condition'] . $ctiJoins;
            }
        } else {
            $sql .= $targetTableJoin['table'] . ' ON ' . $targetTableJoin['condition'];
        }

        if ($withCondition) {
            $sql .= ' AND ' . $withCondition;
        }

        // Apply the indexes
        if ($indexBy) {
            // For Many-To-One or One-To-One associations this obviously makes no sense, but is ignored silently.
            $this->walkIndexBy($indexBy);
        } else if (isset($relation['indexBy'])) {
            $this->rsm->addIndexBy($joinedDqlAlias, $relation['indexBy']);
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkFunction($function)
    {
        return $function->getSql($this);
    }

    /**
     * {@inheritdoc}
     */
    public function walkOrderByClause($orderByClause)
    {
        $orderByItems = array_map([$this, 'walkOrderByItem'], $orderByClause->orderByItems);

        if (($collectionOrderByItems = $this->_generateOrderedCollectionOrderByItems()) !== '') {
            $orderByItems = array_merge($orderByItems, (array) $collectionOrderByItems);
        }

        return ' ORDER BY ' . implode(', ', $orderByItems);
    }

    /**
     * {@inheritdoc}
     */
    public function walkOrderByItem($orderByItem)
    {
        $type = strtoupper($orderByItem->type);
        $expr = $orderByItem->expression;
        $sql  = ($expr instanceof AST\Node)
            ? $expr->dispatch($this)
            : $this->walkResultVariable($this->queryComponents[$expr]['token']['value']);

        $this->orderedColumnsMap[$sql] = $type;

        if ($expr instanceof AST\Subselect) {
            return '(' . $sql . ') ' . $type;
        }

        return $sql . ' ' . $type;
    }

    /**
     * {@inheritdoc}
     */
    public function walkHavingClause($havingClause)
    {
        return ' HAVING ' . $this->walkConditionalExpression($havingClause->conditionalExpression);
    }

    /**
     * {@inheritdoc}
     */
    public function walkJoin($join)
    {
        $joinType        = $join->joinType;
        $joinDeclaration = $join->joinAssociationDeclaration;

        $sql = ($joinType == AST\Join::JOIN_TYPE_LEFT || $joinType == AST\Join::JOIN_TYPE_LEFTOUTER)
            ? ' LEFT JOIN '
            : ' INNER JOIN ';

        switch (true) {
            case ($joinDeclaration instanceof AST\RangeVariableDeclaration):
                $class      = $this->em->getClassMetadata($joinDeclaration->abstractSchemaName);
                $dqlAlias   = $joinDeclaration->aliasIdentificationVariable;
                $tableAlias = $this->getSQLTableAlias($class->table['name'], $dqlAlias);
                $conditions = [];

                if ($join->conditionalExpression) {
                    $conditions[] = '(' . $this->walkConditionalExpression($join->conditionalExpression) . ')';
                }

                $isUnconditionalJoin = empty($conditions);
                $condExprConjunction = ($class->isInheritanceTypeJoined() && $joinType != AST\Join::JOIN_TYPE_LEFT && $joinType != AST\Join::JOIN_TYPE_LEFTOUTER && $isUnconditionalJoin)
                    ? ' AND '
                    : ' ON ';

                $sql .= $this->generateRangeVariableDeclarationSQL($joinDeclaration, !$isUnconditionalJoin);

                // Apply remaining inheritance restrictions
                $discrSql = $this->_generateDiscriminatorColumnConditionSQL([$dqlAlias]);

                if ($discrSql) {
                    $conditions[] = $discrSql;
                }

                // Apply the filters
                $filterExpr = $this->generateFilterConditionSQL($class, $tableAlias);

                if ($filterExpr) {
                    $conditions[] = $filterExpr;
                }

                if ($conditions) {
                    $sql .= $condExprConjunction . implode(' AND ', $conditions);
                }

                break;

            case ($joinDeclaration instanceof AST\JoinAssociationDeclaration):
                $sql .= $this->walkJoinAssociationDeclaration($joinDeclaration, $joinType, $join->conditionalExpression);
                break;
        }

        return $sql;
    }

    /**
     * Walks down a CoalesceExpression AST node and generates the corresponding SQL.
     *
     * @param AST\CoalesceExpression $coalesceExpression
     *
     * @return string The SQL.
     */
    public function walkCoalesceExpression($coalesceExpression)
    {
        $sql = 'COALESCE(';

        $scalarExpressions = [];

        foreach ($coalesceExpression->scalarExpressions as $scalarExpression) {
            $scalarExpressions[] = $this->walkSimpleArithmeticExpression($scalarExpression);
        }

        $sql .= implode(', ', $scalarExpressions) . ')';

        return $sql;
    }

    /**
     * Walks down a NullIfExpression AST node and generates the corresponding SQL.
     *
     * @param AST\NullIfExpression $nullIfExpression
     *
     * @return string The SQL.
     */
    public function walkNullIfExpression($nullIfExpression)
    {
        $firstExpression = is_string($nullIfExpression->firstExpression)
            ? $this->conn->quote($nullIfExpression->firstExpression)
            : $this->walkSimpleArithmeticExpression($nullIfExpression->firstExpression);

        $secondExpression = is_string($nullIfExpression->secondExpression)
            ? $this->conn->quote($nullIfExpression->secondExpression)
            : $this->walkSimpleArithmeticExpression($nullIfExpression->secondExpression);

        return 'NULLIF(' . $firstExpression . ', ' . $secondExpression . ')';
    }

    /**
     * Walks down a GeneralCaseExpression AST node and generates the corresponding SQL.
     *
     * @param AST\GeneralCaseExpression $generalCaseExpression
     *
     * @return string The SQL.
     */
    public function walkGeneralCaseExpression(AST\GeneralCaseExpression $generalCaseExpression)
    {
        $sql = 'CASE';

        foreach ($generalCaseExpression->whenClauses as $whenClause) {
            $sql .= ' WHEN ' . $this->walkConditionalExpression($whenClause->caseConditionExpression);
            $sql .= ' THEN ' . $this->walkSimpleArithmeticExpression($whenClause->thenScalarExpression);
        }

        $sql .= ' ELSE ' . $this->walkSimpleArithmeticExpression($generalCaseExpression->elseScalarExpression) . ' END';

        return $sql;
    }

    /**
     * Walks down a SimpleCaseExpression AST node and generates the corresponding SQL.
     *
     * @param AST\SimpleCaseExpression $simpleCaseExpression
     *
     * @return string The SQL.
     */
    public function walkSimpleCaseExpression($simpleCaseExpression)
    {
        $sql = 'CASE ' . $this->walkStateFieldPathExpression($simpleCaseExpression->caseOperand);

        foreach ($simpleCaseExpression->simpleWhenClauses as $simpleWhenClause) {
            $sql .= ' WHEN ' . $this->walkSimpleArithmeticExpression($simpleWhenClause->caseScalarExpression);
            $sql .= ' THEN ' . $this->walkSimpleArithmeticExpression($simpleWhenClause->thenScalarExpression);
        }

        $sql .= ' ELSE ' . $this->walkSimpleArithmeticExpression($simpleCaseExpression->elseScalarExpression) . ' END';

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectExpression($selectExpression)
    {
        $sql    = '';
        $expr   = $selectExpression->expression;
        $hidden = $selectExpression->hiddenAliasResultVariable;

        switch (true) {
            case ($expr instanceof AST\PathExpression):
                if ($expr->type !== AST\PathExpression::TYPE_STATE_FIELD) {
                    throw QueryException::invalidPathExpression($expr);
                }

                $fieldName = $expr->field;
                $dqlAlias  = $expr->identificationVariable;
                $qComp     = $this->queryComponents[$dqlAlias];
                $class     = $qComp['metadata'];

                $resultAlias = $selectExpression->fieldIdentificationVariable ?: $fieldName;
                $tableName   = ($class->isInheritanceTypeJoined())
                    ? $this->em->getUnitOfWork()->getEntityPersister($class->name)->getOwningTable($fieldName)
                    : $class->getTableName();

                $sqlTableAlias = $this->getSQLTableAlias($tableName, $dqlAlias);
                $fieldMapping  = $class->fieldMappings[$fieldName];
                $columnName    = $this->quoteStrategy->getColumnName($fieldName, $class, $this->platform);
                $columnAlias   = $this->getSQLColumnAlias($fieldMapping['columnName']);
                $col           = $sqlTableAlias . '.' . $columnName;

                if (isset($fieldMapping['requireSQLConversion'])) {
                    $type = Type::getType($fieldMapping['type']);
                    $col  = $type->convertToPHPValueSQL($col, $this->conn->getDatabasePlatform());
                }

                $sql .= $col . ' AS ' . $columnAlias;

                $this->scalarResultAliasMap[$resultAlias] = $columnAlias;

                if ( ! $hidden) {
                    $this->rsm->addScalarResult($columnAlias, $resultAlias, $fieldMapping['type']);
                    $this->scalarFields[$dqlAlias][$fieldName] = $columnAlias;
                }

                break;

            case ($expr instanceof AST\AggregateExpression):
            case ($expr instanceof AST\Functions\FunctionNode):
            case ($expr instanceof AST\SimpleArithmeticExpression):
            case ($expr instanceof AST\ArithmeticTerm):
            case ($expr instanceof AST\ArithmeticFactor):
            case ($expr instanceof AST\ParenthesisExpression):
            case ($expr instanceof AST\Literal):
            case ($expr instanceof AST\NullIfExpression):
            case ($expr instanceof AST\CoalesceExpression):
            case ($expr instanceof AST\GeneralCaseExpression):
            case ($expr instanceof AST\SimpleCaseExpression):
                $columnAlias = $this->getSQLColumnAlias('sclr');
                $resultAlias = $selectExpression->fieldIdentificationVariable ?: $this->scalarResultCounter++;

                $sql .= $expr->dispatch($this) . ' AS ' . $columnAlias;

                $this->scalarResultAliasMap[$resultAlias] = $columnAlias;

                if ( ! $hidden) {
                    // We cannot resolve field type here; assume 'string'.
                    $this->rsm->addScalarResult($columnAlias, $resultAlias, 'string');
                }
                break;

            case ($expr instanceof AST\Subselect):
                $columnAlias = $this->getSQLColumnAlias('sclr');
                $resultAlias = $selectExpression->fieldIdentificationVariable ?: $this->scalarResultCounter++;

                $sql .= '(' . $this->walkSubselect($expr) . ') AS ' . $columnAlias;

                $this->scalarResultAliasMap[$resultAlias] = $columnAlias;

                if ( ! $hidden) {
                    // We cannot resolve field type here; assume 'string'.
                    $this->rsm->addScalarResult($columnAlias, $resultAlias, 'string');
                }
                break;

            case ($expr instanceof AST\NewObjectExpression):
                $sql .= $this->walkNewObject($expr,$selectExpression->fieldIdentificationVariable);
                break;

            default:
                // IdentificationVariable or PartialObjectExpression
                if ($expr instanceof AST\PartialObjectExpression) {
                    $dqlAlias = $expr->identificationVariable;
                    $partialFieldSet = $expr->partialFieldSet;
                } else {
                    $dqlAlias = $expr;
                    $partialFieldSet = [];
                }

                $queryComp   = $this->queryComponents[$dqlAlias];
                $class       = $queryComp['metadata'];
                $resultAlias = $selectExpression->fieldIdentificationVariable ?: null;

                if ( ! isset($this->selectedClasses[$dqlAlias])) {
                    $this->selectedClasses[$dqlAlias] = [
                        'class'       => $class,
                        'dqlAlias'    => $dqlAlias,
                        'resultAlias' => $resultAlias
                    ];
                }

                $sqlParts = [];

                // Select all fields from the queried class
                foreach ($class->fieldMappings as $fieldName => $mapping) {
                    if ($partialFieldSet && ! in_array($fieldName, $partialFieldSet)) {
                        continue;
                    }

                    $tableName = (isset($mapping['inherited']))
                        ? $this->em->getClassMetadata($mapping['inherited'])->getTableName()
                        : $class->getTableName();

                    $sqlTableAlias    = $this->getSQLTableAlias($tableName, $dqlAlias);
                    $columnAlias      = $this->getSQLColumnAlias($mapping['columnName']);
                    $quotedColumnName = $this->quoteStrategy->getColumnName($fieldName, $class, $this->platform);

                    $col = $sqlTableAlias . '.' . $quotedColumnName;

                    if (isset($mapping['requireSQLConversion'])) {
                        $type = Type::getType($mapping['type']);
                        $col = $type->convertToPHPValueSQL($col, $this->platform);
                    }

                    $sqlParts[] = $col . ' AS '. $columnAlias;

                    $this->scalarResultAliasMap[$resultAlias][] = $columnAlias;

                    $this->rsm->addFieldResult($dqlAlias, $columnAlias, $fieldName, $class->name);
                }

                // Add any additional fields of subclasses (excluding inherited fields)
                // 1) on Single Table Inheritance: always, since its marginal overhead
                // 2) on Class Table Inheritance only if partial objects are disallowed,
                //    since it requires outer joining subtables.
                if ($class->isInheritanceTypeSingleTable() || ! $this->query->getHint(Query::HINT_FORCE_PARTIAL_LOAD)) {
                    foreach ($class->subClasses as $subClassName) {
                        $subClass      = $this->em->getClassMetadata($subClassName);
                        $sqlTableAlias = $this->getSQLTableAlias($subClass->getTableName(), $dqlAlias);

                        foreach ($subClass->fieldMappings as $fieldName => $mapping) {
                            if (isset($mapping['inherited']) || ($partialFieldSet && !in_array($fieldName, $partialFieldSet))) {
                                continue;
                            }

                            $columnAlias      = $this->getSQLColumnAlias($mapping['columnName']);
                            $quotedColumnName = $this->quoteStrategy->getColumnName($fieldName, $subClass, $this->platform);

                            $col = $sqlTableAlias . '.' . $quotedColumnName;

                            if (isset($mapping['requireSQLConversion'])) {
                                $type = Type::getType($mapping['type']);
                                $col = $type->convertToPHPValueSQL($col, $this->platform);
                            }

                            $sqlParts[] = $col . ' AS ' . $columnAlias;

                            $this->scalarResultAliasMap[$resultAlias][] = $columnAlias;

                            $this->rsm->addFieldResult($dqlAlias, $columnAlias, $fieldName, $subClassName);
                        }
                    }
                }

                $sql .= implode(', ', $sqlParts);
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkQuantifiedExpression($qExpr)
    {
        return ' ' . strtoupper($qExpr->type) . '(' . $this->walkSubselect($qExpr->subselect) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function walkSubselect($subselect)
    {
        $useAliasesBefore  = $this->useSqlTableAliases;
        $rootAliasesBefore = $this->rootAliases;

        $this->rootAliases = []; // reset the rootAliases for the subselect
        $this->useSqlTableAliases = true;

        $sql  = $this->walkSimpleSelectClause($subselect->simpleSelectClause);
        $sql .= $this->walkSubselectFromClause($subselect->subselectFromClause);
        $sql .= $this->walkWhereClause($subselect->whereClause);

        $sql .= $subselect->groupByClause ? $this->walkGroupByClause($subselect->groupByClause) : '';
        $sql .= $subselect->havingClause ? $this->walkHavingClause($subselect->havingClause) : '';
        $sql .= $subselect->orderByClause ? $this->walkOrderByClause($subselect->orderByClause) : '';

        $this->rootAliases        = $rootAliasesBefore; // put the main aliases back
        $this->useSqlTableAliases = $useAliasesBefore;

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkSubselectFromClause($subselectFromClause)
    {
        $identificationVarDecls = $subselectFromClause->identificationVariableDeclarations;
        $sqlParts               = [];

        foreach ($identificationVarDecls as $subselectIdVarDecl) {
            $sqlParts[] = $this->walkIdentificationVariableDeclaration($subselectIdVarDecl);
        }

        return ' FROM ' . implode(', ', $sqlParts);
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleSelectClause($simpleSelectClause)
    {
        return 'SELECT' . ($simpleSelectClause->isDistinct ? ' DISTINCT' : '')
            . $this->walkSimpleSelectExpression($simpleSelectClause->simpleSelectExpression);
    }

    /**
     * @param \Doctrine\ORM\Query\AST\ParenthesisExpression $parenthesisExpression
     *
     * @return string.
     */
    public function walkParenthesisExpression(AST\ParenthesisExpression $parenthesisExpression)
    {
        return sprintf('(%s)', $parenthesisExpression->expression->dispatch($this));
    }

    /**
     * @param AST\NewObjectExpression   $newObjectExpression
     * @param null|string               $newObjectResultAlias
     * @return string The SQL.
     */
    public function walkNewObject($newObjectExpression, $newObjectResultAlias=null)
    {
        $sqlSelectExpressions = [];
        $objIndex             = $newObjectResultAlias?:$this->newObjectCounter++;

        foreach ($newObjectExpression->args as $argIndex => $e) {
            $resultAlias = $this->scalarResultCounter++;
            $columnAlias = $this->getSQLColumnAlias('sclr');
            $fieldType   = 'string';

            switch (true) {
                case ($e instanceof AST\NewObjectExpression):
                    $sqlSelectExpressions[] = $e->dispatch($this);
                    break;

                case ($e instanceof AST\Subselect):
                    $sqlSelectExpressions[] = '(' . $e->dispatch($this) . ') AS ' . $columnAlias;
                    break;

                case ($e instanceof AST\PathExpression):
                    $dqlAlias  = $e->identificationVariable;
                    $qComp     = $this->queryComponents[$dqlAlias];
                    $class     = $qComp['metadata'];
                    $fieldType = $class->fieldMappings[$e->field]['type'];

                    $sqlSelectExpressions[] = trim($e->dispatch($this)) . ' AS ' . $columnAlias;
                    break;

                case ($e instanceof AST\Literal):
                    switch ($e->type) {
                        case AST\Literal::BOOLEAN:
                            $fieldType = 'boolean';
                            break;

                        case AST\Literal::NUMERIC:
                            $fieldType = is_float($e->value) ? 'float' : 'integer';
                            break;
                    }

                    $sqlSelectExpressions[] = trim($e->dispatch($this)) . ' AS ' . $columnAlias;
                    break;

                default:
                    $sqlSelectExpressions[] = trim($e->dispatch($this)) . ' AS ' . $columnAlias;
                    break;
            }

            $this->scalarResultAliasMap[$resultAlias] = $columnAlias;
            $this->rsm->addScalarResult($columnAlias, $resultAlias, $fieldType);

            $this->rsm->newObjectMappings[$columnAlias] = [
                'className' => $newObjectExpression->className,
                'objIndex'  => $objIndex,
                'argIndex'  => $argIndex
            ];
        }

        return implode(', ', $sqlSelectExpressions);
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleSelectExpression($simpleSelectExpression)
    {
        $expr = $simpleSelectExpression->expression;
        $sql  = ' ';

        switch (true) {
            case ($expr instanceof AST\PathExpression):
                $sql .= $this->walkPathExpression($expr);
                break;

            case ($expr instanceof AST\Subselect):
                $alias = $simpleSelectExpression->fieldIdentificationVariable ?: $this->scalarResultCounter++;

                $columnAlias = 'sclr' . $this->aliasCounter++;
                $this->scalarResultAliasMap[$alias] = $columnAlias;

                $sql .= '(' . $this->walkSubselect($expr) . ') AS ' . $columnAlias;
                break;

            case ($expr instanceof AST\Functions\FunctionNode):
            case ($expr instanceof AST\SimpleArithmeticExpression):
            case ($expr instanceof AST\ArithmeticTerm):
            case ($expr instanceof AST\ArithmeticFactor):
            case ($expr instanceof AST\Literal):
            case ($expr instanceof AST\NullIfExpression):
            case ($expr instanceof AST\CoalesceExpression):
            case ($expr instanceof AST\GeneralCaseExpression):
            case ($expr instanceof AST\SimpleCaseExpression):
                $alias = $simpleSelectExpression->fieldIdentificationVariable ?: $this->scalarResultCounter++;

                $columnAlias = $this->getSQLColumnAlias('sclr');
                $this->scalarResultAliasMap[$alias] = $columnAlias;

                $sql .= $expr->dispatch($this) . ' AS ' . $columnAlias;
                break;

            case ($expr instanceof AST\ParenthesisExpression):
                $sql .= $this->walkParenthesisExpression($expr);
                break;

            default: // IdentificationVariable
                $sql .= $this->walkEntityIdentificationVariable($expr);
                break;
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkAggregateExpression($aggExpression)
    {
        return $aggExpression->functionName . '(' . ($aggExpression->isDistinct ? 'DISTINCT ' : '')
            . $this->walkSimpleArithmeticExpression($aggExpression->pathExpression) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function walkGroupByClause($groupByClause)
    {
        $sqlParts = [];

        foreach ($groupByClause->groupByItems as $groupByItem) {
            $sqlParts[] = $this->walkGroupByItem($groupByItem);
        }

        return ' GROUP BY ' . implode(', ', $sqlParts);
    }

    /**
     * {@inheritdoc}
     */
    public function walkGroupByItem($groupByItem)
    {
        // StateFieldPathExpression
        if ( ! is_string($groupByItem)) {
            return $this->walkPathExpression($groupByItem);
        }

        // ResultVariable
        if (isset($this->queryComponents[$groupByItem]['resultVariable'])) {
            $resultVariable = $this->queryComponents[$groupByItem]['resultVariable'];

            if ($resultVariable instanceof AST\PathExpression) {
                return $this->walkPathExpression($resultVariable);
            }

            if (isset($resultVariable->pathExpression)) {
                return $this->walkPathExpression($resultVariable->pathExpression);
            }

            return $this->walkResultVariable($groupByItem);
        }

        // IdentificationVariable
        $sqlParts = [];

        foreach ($this->queryComponents[$groupByItem]['metadata']->fieldNames as $field) {
            $item       = new AST\PathExpression(AST\PathExpression::TYPE_STATE_FIELD, $groupByItem, $field);
            $item->type = AST\PathExpression::TYPE_STATE_FIELD;

            $sqlParts[] = $this->walkPathExpression($item);
        }

        foreach ($this->queryComponents[$groupByItem]['metadata']->associationMappings as $mapping) {
            if ($mapping['isOwningSide'] && $mapping['type'] & ClassMetadataInfo::TO_ONE) {
                $item       = new AST\PathExpression(AST\PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION, $groupByItem, $mapping['fieldName']);
                $item->type = AST\PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION;

                $sqlParts[] = $this->walkPathExpression($item);
            }
        }

        return implode(', ', $sqlParts);
    }

    /**
     * {@inheritdoc}
     */
    public function walkDeleteClause(AST\DeleteClause $deleteClause)
    {
        $class     = $this->em->getClassMetadata($deleteClause->abstractSchemaName);
        $tableName = $class->getTableName();
        $sql       = 'DELETE FROM ' . $this->quoteStrategy->getTableName($class, $this->platform);

        $this->setSQLTableAlias($tableName, $tableName, $deleteClause->aliasIdentificationVariable);
        $this->rootAliases[] = $deleteClause->aliasIdentificationVariable;

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateClause($updateClause)
    {
        $class     = $this->em->getClassMetadata($updateClause->abstractSchemaName);
        $tableName = $class->getTableName();
        $sql       = 'UPDATE ' . $this->quoteStrategy->getTableName($class, $this->platform);

        $this->setSQLTableAlias($tableName, $tableName, $updateClause->aliasIdentificationVariable);
        $this->rootAliases[] = $updateClause->aliasIdentificationVariable;

        $sql .= ' SET ' . implode(', ', array_map([$this, 'walkUpdateItem'], $updateClause->updateItems));

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateItem($updateItem)
    {
        $useTableAliasesBefore = $this->useSqlTableAliases;
        $this->useSqlTableAliases = false;

        $sql      = $this->walkPathExpression($updateItem->pathExpression) . ' = ';
        $newValue = $updateItem->newValue;

        switch (true) {
            case ($newValue instanceof AST\Node):
                $sql .= $newValue->dispatch($this);
                break;

            case ($newValue === null):
                $sql .= 'NULL';
                break;

            default:
                $sql .= $this->conn->quote($newValue);
                break;
        }

        $this->useSqlTableAliases = $useTableAliasesBefore;

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkWhereClause($whereClause)
    {
        $condSql  = null !== $whereClause ? $this->walkConditionalExpression($whereClause->conditionalExpression) : '';
        $discrSql = $this->_generateDiscriminatorColumnConditionSQL($this->rootAliases);

        if ($this->em->hasFilters()) {
            $filterClauses = [];
            foreach ($this->rootAliases as $dqlAlias) {
                $class = $this->queryComponents[$dqlAlias]['metadata'];
                $tableAlias = $this->getSQLTableAlias($class->table['name'], $dqlAlias);

                if ($filterExpr = $this->generateFilterConditionSQL($class, $tableAlias)) {
                    $filterClauses[] = $filterExpr;
                }
            }

            if (count($filterClauses)) {
                if ($condSql) {
                    $condSql = '(' . $condSql . ') AND ';
                }

                $condSql .= implode(' AND ', $filterClauses);
            }
        }

        if ($condSql) {
            return ' WHERE ' . (( ! $discrSql) ? $condSql : '(' . $condSql . ') AND ' . $discrSql);
        }

        if ($discrSql) {
            return ' WHERE ' . $discrSql;
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalExpression($condExpr)
    {
        // Phase 2 AST optimization: Skip processing of ConditionalExpression
        // if only one ConditionalTerm is defined
        if ( ! ($condExpr instanceof AST\ConditionalExpression)) {
            return $this->walkConditionalTerm($condExpr);
        }

        return implode(' OR ', array_map([$this, 'walkConditionalTerm'], $condExpr->conditionalTerms));
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalTerm($condTerm)
    {
        // Phase 2 AST optimization: Skip processing of ConditionalTerm
        // if only one ConditionalFactor is defined
        if ( ! ($condTerm instanceof AST\ConditionalTerm)) {
            return $this->walkConditionalFactor($condTerm);
        }

        return implode(' AND ', array_map([$this, 'walkConditionalFactor'], $condTerm->conditionalFactors));
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalFactor($factor)
    {
        // Phase 2 AST optimization: Skip processing of ConditionalFactor
        // if only one ConditionalPrimary is defined
        return ( ! ($factor instanceof AST\ConditionalFactor))
            ? $this->walkConditionalPrimary($factor)
            : ($factor->not ? 'NOT ' : '') . $this->walkConditionalPrimary($factor->conditionalPrimary);
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalPrimary($primary)
    {
        if ($primary->isSimpleConditionalExpression()) {
            return $primary->simpleConditionalExpression->dispatch($this);
        }

        if ($primary->isConditionalExpression()) {
            $condExpr = $primary->conditionalExpression;

            return '(' . $this->walkConditionalExpression($condExpr) . ')';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function walkExistsExpression($existsExpr)
    {
        $sql = ($existsExpr->not) ? 'NOT ' : '';

        $sql .= 'EXISTS (' . $this->walkSubselect($existsExpr->subselect) . ')';

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkCollectionMemberExpression($collMemberExpr)
    {
        $sql = $collMemberExpr->not ? 'NOT ' : '';
        $sql .= 'EXISTS (SELECT 1 FROM ';

        $entityExpr   = $collMemberExpr->entityExpression;
        $collPathExpr = $collMemberExpr->collectionValuedPathExpression;

        $fieldName = $collPathExpr->field;
        $dqlAlias  = $collPathExpr->identificationVariable;

        $class = $this->queryComponents[$dqlAlias]['metadata'];

        switch (true) {
            // InputParameter
            case ($entityExpr instanceof AST\InputParameter):
                $dqlParamKey = $entityExpr->name;
                $entitySql   = '?';
                break;

            // SingleValuedAssociationPathExpression | IdentificationVariable
            case ($entityExpr instanceof AST\PathExpression):
                $entitySql = $this->walkPathExpression($entityExpr);
                break;

            default:
                throw new \BadMethodCallException("Not implemented");
        }

        $assoc = $class->associationMappings[$fieldName];

        if ($assoc['type'] == ClassMetadata::ONE_TO_MANY) {
            $targetClass      = $this->em->getClassMetadata($assoc['targetEntity']);
            $targetTableAlias = $this->getSQLTableAlias($targetClass->getTableName());
            $sourceTableAlias = $this->getSQLTableAlias($class->getTableName(), $dqlAlias);

            $sql .= $this->quoteStrategy->getTableName($targetClass, $this->platform) . ' ' . $targetTableAlias . ' WHERE ';

            $owningAssoc = $targetClass->associationMappings[$assoc['mappedBy']];
            $sqlParts    = [];

            foreach ($owningAssoc['targetToSourceKeyColumns'] as $targetColumn => $sourceColumn) {
                $targetColumn = $this->quoteStrategy->getColumnName($class->fieldNames[$targetColumn], $class, $this->platform);

                $sqlParts[] = $sourceTableAlias . '.' . $targetColumn . ' = ' . $targetTableAlias . '.' . $sourceColumn;
            }

            foreach ($this->quoteStrategy->getIdentifierColumnNames($targetClass, $this->platform) as $targetColumnName) {
                if (isset($dqlParamKey)) {
                    $this->parserResult->addParameterMapping($dqlParamKey, $this->sqlParamIndex++);
                }

                $sqlParts[] = $targetTableAlias . '.'  . $targetColumnName . ' = ' . $entitySql;
            }

            $sql .= implode(' AND ', $sqlParts);
        } else { // many-to-many
            $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);

            $owningAssoc = $assoc['isOwningSide'] ? $assoc : $targetClass->associationMappings[$assoc['mappedBy']];
            $joinTable = $owningAssoc['joinTable'];

            // SQL table aliases
            $joinTableAlias   = $this->getSQLTableAlias($joinTable['name']);
            $targetTableAlias = $this->getSQLTableAlias($targetClass->getTableName());
            $sourceTableAlias = $this->getSQLTableAlias($class->getTableName(), $dqlAlias);

            // join to target table
            $sql .= $this->quoteStrategy->getJoinTableName($owningAssoc, $targetClass, $this->platform) . ' ' . $joinTableAlias
                . ' INNER JOIN ' . $this->quoteStrategy->getTableName($targetClass, $this->platform) . ' ' . $targetTableAlias . ' ON ';

            // join conditions
            $joinColumns  = $assoc['isOwningSide'] ? $joinTable['inverseJoinColumns'] : $joinTable['joinColumns'];
            $joinSqlParts = [];

            foreach ($joinColumns as $joinColumn) {
                $targetColumn = $this->quoteStrategy->getColumnName($targetClass->fieldNames[$joinColumn['referencedColumnName']], $targetClass, $this->platform);

                $joinSqlParts[] = $joinTableAlias . '.' . $joinColumn['name'] . ' = ' . $targetTableAlias . '.' . $targetColumn;
            }

            $sql .= implode(' AND ', $joinSqlParts);
            $sql .= ' WHERE ';

            $joinColumns = $assoc['isOwningSide'] ? $joinTable['joinColumns'] : $joinTable['inverseJoinColumns'];
            $sqlParts    = [];

            foreach ($joinColumns as $joinColumn) {
                $targetColumn = $this->quoteStrategy->getColumnName($class->fieldNames[$joinColumn['referencedColumnName']], $class, $this->platform);

                $sqlParts[] = $joinTableAlias . '.' . $joinColumn['name'] . ' = ' . $sourceTableAlias . '.' . $targetColumn;
            }

            foreach ($this->quoteStrategy->getIdentifierColumnNames($targetClass, $this->platform) as $targetColumnName) {
                if (isset($dqlParamKey)) {
                    $this->parserResult->addParameterMapping($dqlParamKey, $this->sqlParamIndex++);
                }

                $sqlParts[] = $targetTableAlias . '.' . $targetColumnName . ' IN (' . $entitySql . ')';
            }

            $sql .= implode(' AND ', $sqlParts);
        }

        return $sql . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function walkEmptyCollectionComparisonExpression($emptyCollCompExpr)
    {
        $sizeFunc = new AST\Functions\SizeFunction('size');
        $sizeFunc->collectionPathExpression = $emptyCollCompExpr->expression;

        return $sizeFunc->getSql($this) . ($emptyCollCompExpr->not ? ' > 0' : ' = 0');
    }

    /**
     * {@inheritdoc}
     */
    public function walkNullComparisonExpression($nullCompExpr)
    {
        $expression = $nullCompExpr->expression;
        $comparison = ' IS' . ($nullCompExpr->not ? ' NOT' : '') . ' NULL';

        // Handle ResultVariable
        if (is_string($expression) && isset($this->queryComponents[$expression]['resultVariable'])) {
            return $this->walkResultVariable($expression) . $comparison;
        }

        // Handle InputParameter mapping inclusion to ParserResult
        if ($expression instanceof AST\InputParameter) {
            return $this->walkInputParameter($expression) . $comparison;
        }

        return $expression->dispatch($this) . $comparison;
    }

    /**
     * {@inheritdoc}
     */
    public function walkInExpression($inExpr)
    {
        $sql = $this->walkArithmeticExpression($inExpr->expression) . ($inExpr->not ? ' NOT' : '') . ' IN (';

        $sql .= ($inExpr->subselect)
            ? $this->walkSubselect($inExpr->subselect)
            : implode(', ', array_map([$this, 'walkInParameter'], $inExpr->literals));

        $sql .= ')';

        return $sql;
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function walkInstanceOfExpression($instanceOfExpr)
    {
        $sql = '';

        $dqlAlias = $instanceOfExpr->identificationVariable;
        $discrClass = $class = $this->queryComponents[$dqlAlias]['metadata'];

        if ($class->discriminatorColumn) {
            $discrClass = $this->em->getClassMetadata($class->rootEntityName);
        }

        if ($this->useSqlTableAliases) {
            $sql .= $this->getSQLTableAlias($discrClass->getTableName(), $dqlAlias) . '.';
        }

        $sql .= $class->discriminatorColumn['name'] . ($instanceOfExpr->not ? ' NOT IN ' : ' IN ');
        $sql .= $this->getChildDiscriminatorsFromClassMetadata($discrClass, $instanceOfExpr);

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkInParameter($inParam)
    {
        return $inParam instanceof AST\InputParameter
            ? $this->walkInputParameter($inParam)
            : $this->walkLiteral($inParam);
    }

    /**
     * {@inheritdoc}
     */
    public function walkLiteral($literal)
    {
        switch ($literal->type) {
            case AST\Literal::STRING:
                return $this->conn->quote($literal->value);

            case AST\Literal::BOOLEAN:
                return $this->conn->getDatabasePlatform()->convertBooleans('true' === strtolower($literal->value));

            case AST\Literal::NUMERIC:
                return $literal->value;

            default:
                throw QueryException::invalidLiteral($literal);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function walkBetweenExpression($betweenExpr)
    {
        $sql = $this->walkArithmeticExpression($betweenExpr->expression);

        if ($betweenExpr->not) {
            $sql .= ' NOT';
        }

        $sql .= ' BETWEEN ' . $this->walkArithmeticExpression($betweenExpr->leftBetweenExpression)
            . ' AND ' . $this->walkArithmeticExpression($betweenExpr->rightBetweenExpression);

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkLikeExpression($likeExpr)
    {
        $stringExpr = $likeExpr->stringExpression;
        $leftExpr   = (is_string($stringExpr) && isset($this->queryComponents[$stringExpr]['resultVariable']))
            ? $this->walkResultVariable($stringExpr)
            : $stringExpr->dispatch($this);

        $sql = $leftExpr . ($likeExpr->not ? ' NOT' : '') . ' LIKE ';

        if ($likeExpr->stringPattern instanceof AST\InputParameter) {
            $sql .= $this->walkInputParameter($likeExpr->stringPattern);
        } elseif ($likeExpr->stringPattern instanceof AST\Functions\FunctionNode) {
            $sql .= $this->walkFunction($likeExpr->stringPattern);
        } elseif ($likeExpr->stringPattern instanceof AST\PathExpression) {
            $sql .= $this->walkPathExpression($likeExpr->stringPattern);
        } else {
            $sql .= $this->walkLiteral($likeExpr->stringPattern);
        }

        if ($likeExpr->escapeChar) {
            $sql .= ' ESCAPE ' . $this->walkLiteral($likeExpr->escapeChar);
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkStateFieldPathExpression($stateFieldPathExpression)
    {
        return $this->walkPathExpression($stateFieldPathExpression);
    }

    /**
     * {@inheritdoc}
     */
    public function walkComparisonExpression($compExpr)
    {
        $leftExpr  = $compExpr->leftExpression;
        $rightExpr = $compExpr->rightExpression;
        $sql       = '';

        $sql .= ($leftExpr instanceof AST\Node)
            ? $leftExpr->dispatch($this)
            : (is_numeric($leftExpr) ? $leftExpr : $this->conn->quote($leftExpr));

        $sql .= ' ' . $compExpr->operator . ' ';

        $sql .= ($rightExpr instanceof AST\Node)
            ? $rightExpr->dispatch($this)
            : (is_numeric($rightExpr) ? $rightExpr : $this->conn->quote($rightExpr));

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function walkInputParameter($inputParam)
    {
        $this->parserResult->addParameterMapping($inputParam->name, $this->sqlParamIndex++);

        $parameter = $this->query->getParameter($inputParam->name);

        if ($parameter && Type::hasType($type = $parameter->getType())) {
            return Type::getType($type)->convertToDatabaseValueSQL('?', $this->platform);
        }

        return '?';
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticExpression($arithmeticExpr)
    {
        return ($arithmeticExpr->isSimpleArithmeticExpression())
            ? $this->walkSimpleArithmeticExpression($arithmeticExpr->simpleArithmeticExpression)
            : '(' . $this->walkSubselect($arithmeticExpr->subselect) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleArithmeticExpression($simpleArithmeticExpr)
    {
        if ( ! ($simpleArithmeticExpr instanceof AST\SimpleArithmeticExpression)) {
            return $this->walkArithmeticTerm($simpleArithmeticExpr);
        }

        return implode(' ', array_map([$this, 'walkArithmeticTerm'], $simpleArithmeticExpr->arithmeticTerms));
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticTerm($term)
    {
        if (is_string($term)) {
            return (isset($this->queryComponents[$term]))
                ? $this->walkResultVariable($this->queryComponents[$term]['token']['value'])
                : $term;
        }

        // Phase 2 AST optimization: Skip processing of ArithmeticTerm
        // if only one ArithmeticFactor is defined
        if ( ! ($term instanceof AST\ArithmeticTerm)) {
            return $this->walkArithmeticFactor($term);
        }

        return implode(' ', array_map([$this, 'walkArithmeticFactor'], $term->arithmeticFactors));
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticFactor($factor)
    {
        if (is_string($factor)) {
            return (isset($this->queryComponents[$factor]))
                ? $this->walkResultVariable($this->queryComponents[$factor]['token']['value'])
                : $factor;
        }

        // Phase 2 AST optimization: Skip processing of ArithmeticFactor
        // if only one ArithmeticPrimary is defined
        if ( ! ($factor instanceof AST\ArithmeticFactor)) {
            return $this->walkArithmeticPrimary($factor);
        }

        $sign = $factor->isNegativeSigned() ? '-' : ($factor->isPositiveSigned() ? '+' : '');

        return $sign . $this->walkArithmeticPrimary($factor->arithmeticPrimary);
    }

    /**
     * Walks down an ArithmeticPrimary that represents an AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $primary
     *
     * @return string The SQL.
     */
    public function walkArithmeticPrimary($primary)
    {
        if ($primary instanceof AST\SimpleArithmeticExpression) {
            return '(' . $this->walkSimpleArithmeticExpression($primary) . ')';
        }

        if ($primary instanceof AST\Node) {
            return $primary->dispatch($this);
        }

        return $this->walkEntityIdentificationVariable($primary);
    }

    /**
     * {@inheritdoc}
     */
    public function walkStringPrimary($stringPrimary)
    {
        return (is_string($stringPrimary))
            ? $this->conn->quote($stringPrimary)
            : $stringPrimary->dispatch($this);
    }

    /**
     * {@inheritdoc}
     */
    public function walkResultVariable($resultVariable)
    {
        $resultAlias = $this->scalarResultAliasMap[$resultVariable];

        if (is_array($resultAlias)) {
            return implode(', ', $resultAlias);
        }

        return $resultAlias;
    }

    /**
     * @param ClassMetadataInfo $rootClass
     * @param AST\InstanceOfExpression $instanceOfExpr
     * @return string The list in parentheses of valid child discriminators from the given class
     * @throws QueryException
     */
    private function getChildDiscriminatorsFromClassMetadata(ClassMetadataInfo $rootClass, AST\InstanceOfExpression $instanceOfExpr): string
    {
        $sqlParameterList = [];
        $discriminators = [];
        foreach ($instanceOfExpr->value as $parameter) {
            if ($parameter instanceof AST\InputParameter) {
                $this->rsm->discriminatorParameters[$parameter->name] = $parameter->name;
                $sqlParameterList[] = $this->walkInParameter($parameter);
                continue;
            }

            $metadata = $this->em->getClassMetadata($parameter);

            if ($metadata->getName() !== $rootClass->name && ! $metadata->getReflectionClass()->isSubclassOf($rootClass->name)) {
                throw QueryException::instanceOfUnrelatedClass($parameter, $rootClass->name);
            }

            $discriminators += HierarchyDiscriminatorResolver::resolveDiscriminatorsForClass($metadata, $this->em);
        }

        foreach (array_keys($discriminators) as $dis) {
            $sqlParameterList[] = $this->conn->quote($dis);
        }

        return '(' . implode(', ', $sqlParameterList) . ')';
    }
}
