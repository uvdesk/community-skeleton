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

namespace Doctrine\ORM\Tools\Pagination;

use Doctrine\DBAL\Platforms\DB2Platform;
use Doctrine\DBAL\Platforms\OraclePlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Platforms\SQLAnywherePlatform;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\AST\PartialObjectExpression;
use Doctrine\ORM\Query\AST\SelectExpression;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\AST\SelectStatement;

/**
 * Wraps the query in order to select root entity IDs for pagination.
 *
 * Given a DQL like `SELECT u FROM User u` it will generate an SQL query like:
 * SELECT DISTINCT <id> FROM (<original SQL>) LIMIT x OFFSET y
 *
 * Works with composite keys but cannot deal with queries that have multiple
 * root entities (e.g. `SELECT f, b from Foo, Bar`)
 *
 * @author Sander Marechal <s.marechal@jejik.com>
 */
class LimitSubqueryOutputWalker extends SqlWalker
{
    private const ORDER_BY_PATH_EXPRESSION = '/(?<![a-z0-9_])%s\.%s(?![a-z0-9_])/i';

    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    private $platform;

    /**
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    private $rsm;

    /**
     * @var array
     */
    private $queryComponents;

    /**
     * @var int
     */
    private $firstResult;

    /**
     * @var int
     */
    private $maxResults;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * The quote strategy.
     *
     * @var \Doctrine\ORM\Mapping\QuoteStrategy
     */
    private $quoteStrategy;

    /**
     * @var array
     */
    private $orderByPathExpressions = [];

    /**
     * @var bool We don't want to add path expressions from sub-selects into the select clause of the containing query.
     *           This state flag simply keeps track on whether we are walking on a subquery or not
     */
    private $inSubSelect = false;

    /**
     * Constructor.
     *
     * Stores various parameters that are otherwise unavailable
     * because Doctrine\ORM\Query\SqlWalker keeps everything private without
     * accessors.
     *
     * @param \Doctrine\ORM\Query              $query
     * @param \Doctrine\ORM\Query\ParserResult $parserResult
     * @param array                            $queryComponents
     */
    public function __construct($query, $parserResult, array $queryComponents)
    {
        $this->platform = $query->getEntityManager()->getConnection()->getDatabasePlatform();
        $this->rsm = $parserResult->getResultSetMapping();
        $this->queryComponents = $queryComponents;

        // Reset limit and offset
        $this->firstResult = $query->getFirstResult();
        $this->maxResults = $query->getMaxResults();
        $query->setFirstResult(null)->setMaxResults(null);

        $this->em               = $query->getEntityManager();
        $this->quoteStrategy    = $this->em->getConfiguration()->getQuoteStrategy();

        parent::__construct($query, $parserResult, $queryComponents);
    }

    /**
     * Check if the platform supports the ROW_NUMBER window function.
     *
     * @return bool
     */
    private function platformSupportsRowNumber()
    {
        return $this->platform instanceof PostgreSqlPlatform
            || $this->platform instanceof SQLServerPlatform
            || $this->platform instanceof OraclePlatform
            || $this->platform instanceof SQLAnywherePlatform
            || $this->platform instanceof DB2Platform
            || (method_exists($this->platform, 'supportsRowNumberFunction')
                && $this->platform->supportsRowNumberFunction());
    }

    /**
     * Rebuilds a select statement's order by clause for use in a
     * ROW_NUMBER() OVER() expression.
     *
     * @param SelectStatement $AST
     */
    private function rebuildOrderByForRowNumber(SelectStatement $AST)
    {
        $orderByClause = $AST->orderByClause;
        $selectAliasToExpressionMap = [];
        // Get any aliases that are available for select expressions.
        foreach ($AST->selectClause->selectExpressions as $selectExpression) {
            $selectAliasToExpressionMap[$selectExpression->fieldIdentificationVariable] = $selectExpression->expression;
        }

        // Rebuild string orderby expressions to use the select expression they're referencing
        foreach ($orderByClause->orderByItems as $orderByItem) {
            if (is_string($orderByItem->expression) && isset($selectAliasToExpressionMap[$orderByItem->expression])) {
                $orderByItem->expression = $selectAliasToExpressionMap[$orderByItem->expression];
            }
        }
        $func = new RowNumberOverFunction('dctrn_rownum');
        $func->orderByClause = $AST->orderByClause;
        $AST->selectClause->selectExpressions[] = new SelectExpression($func, 'dctrn_rownum', true);

        // No need for an order by clause, we'll order by rownum in the outer query.
        $AST->orderByClause = null;
    }

    /**
     * Walks down a SelectStatement AST node, wrapping it in a SELECT DISTINCT.
     *
     * @param SelectStatement $AST
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function walkSelectStatement(SelectStatement $AST)
    {
        if ($this->platformSupportsRowNumber()) {
            return $this->walkSelectStatementWithRowNumber($AST);
        }
        return $this->walkSelectStatementWithoutRowNumber($AST);
    }

    /**
     * Walks down a SelectStatement AST node, wrapping it in a SELECT DISTINCT.
     * This method is for use with platforms which support ROW_NUMBER.
     *
     * @param SelectStatement $AST
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function walkSelectStatementWithRowNumber(SelectStatement $AST)
    {
        $hasOrderBy = false;
        $outerOrderBy = ' ORDER BY dctrn_minrownum ASC';
        $orderGroupBy = '';
        if ($AST->orderByClause instanceof OrderByClause) {
            $hasOrderBy = true;
            $this->rebuildOrderByForRowNumber($AST);
        }

        $innerSql = $this->getInnerSQL($AST);

        $sqlIdentifier = $this->getSQLIdentifier($AST);

        if ($hasOrderBy) {
            $orderGroupBy = ' GROUP BY ' . implode(', ', $sqlIdentifier);
            $sqlIdentifier[] = 'MIN(' . $this->walkResultVariable('dctrn_rownum') . ') AS dctrn_minrownum';
        }

        // Build the counter query
        $sql = sprintf(
            'SELECT DISTINCT %s FROM (%s) dctrn_result',
            implode(', ', $sqlIdentifier),
            $innerSql
        );

        if ($hasOrderBy) {
            $sql .= $orderGroupBy . $outerOrderBy;
        }

        // Apply the limit and offset.
        $sql = $this->platform->modifyLimitQuery(
            $sql,
            $this->maxResults,
            $this->firstResult
        );

        // Add the columns to the ResultSetMapping. It's not really nice but
        // it works. Preferably I'd clear the RSM or simply create a new one
        // but that is not possible from inside the output walker, so we dirty
        // up the one we have.
        foreach ($sqlIdentifier as $property => $alias) {
            $this->rsm->addScalarResult($alias, $property);
        }

        return $sql;
    }

    /**
     * Walks down a SelectStatement AST node, wrapping it in a SELECT DISTINCT.
     * This method is for platforms which DO NOT support ROW_NUMBER.
     *
     * @param SelectStatement $AST
     * @param bool $addMissingItemsFromOrderByToSelect
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function walkSelectStatementWithoutRowNumber(SelectStatement $AST, $addMissingItemsFromOrderByToSelect = true)
    {
        // We don't want to call this recursively!
        if ($AST->orderByClause instanceof OrderByClause && $addMissingItemsFromOrderByToSelect) {
            // In the case of ordering a query by columns from joined tables, we
            // must add those columns to the select clause of the query BEFORE
            // the SQL is generated.
            $this->addMissingItemsFromOrderByToSelect($AST);
        }

        // Remove order by clause from the inner query
        // It will be re-appended in the outer select generated by this method
        $orderByClause = $AST->orderByClause;
        $AST->orderByClause = null;

        $innerSql = $this->getInnerSQL($AST);

        $sqlIdentifier = $this->getSQLIdentifier($AST);

        // Build the counter query
        $sql = sprintf('SELECT DISTINCT %s FROM (%s) dctrn_result',
            implode(', ', $sqlIdentifier), $innerSql);

        // http://www.doctrine-project.org/jira/browse/DDC-1958
        $sql = $this->preserveSqlOrdering($sqlIdentifier, $innerSql, $sql, $orderByClause);

        // Apply the limit and offset.
        $sql = $this->platform->modifyLimitQuery(
            $sql, $this->maxResults, $this->firstResult
        );

        // Add the columns to the ResultSetMapping. It's not really nice but
        // it works. Preferably I'd clear the RSM or simply create a new one
        // but that is not possible from inside the output walker, so we dirty
        // up the one we have.
        foreach ($sqlIdentifier as $property => $alias) {
            $this->rsm->addScalarResult($alias, $property);
        }

        // Restore orderByClause
        $AST->orderByClause = $orderByClause;

        return $sql;
    }

    /**
     * Finds all PathExpressions in an AST's OrderByClause, and ensures that
     * the referenced fields are present in the SelectClause of the passed AST.
     *
     * @param SelectStatement $AST
     */
    private function addMissingItemsFromOrderByToSelect(SelectStatement $AST)
    {
        $this->orderByPathExpressions = [];

        // We need to do this in another walker because otherwise we'll end up
        // polluting the state of this one.
        $walker = clone $this;

        // This will populate $orderByPathExpressions via
        // LimitSubqueryOutputWalker::walkPathExpression, which will be called
        // as the select statement is walked. We'll end up with an array of all
        // path expressions referenced in the query.
        $walker->walkSelectStatementWithoutRowNumber($AST, false);
        $orderByPathExpressions = $walker->getOrderByPathExpressions();

        // Get a map of referenced identifiers to field names.
        $selects = [];
        foreach ($orderByPathExpressions as $pathExpression) {
            $idVar = $pathExpression->identificationVariable;
            $field = $pathExpression->field;
            if (!isset($selects[$idVar])) {
                $selects[$idVar] = [];
            }
            $selects[$idVar][$field] = true;
        }

        // Loop the select clause of the AST and exclude items from $select
        // that are already being selected in the query.
        foreach ($AST->selectClause->selectExpressions as $selectExpression) {
            if ($selectExpression instanceof SelectExpression) {
                $idVar = $selectExpression->expression;
                if (!is_string($idVar)) {
                    continue;
                }
                $field = $selectExpression->fieldIdentificationVariable;
                if ($field === null) {
                    // No need to add this select, as we're already fetching the whole object.
                    unset($selects[$idVar]);
                } else {
                    unset($selects[$idVar][$field]);
                }
            }
        }

        // Add select items which were not excluded to the AST's select clause.
        foreach ($selects as $idVar => $fields) {
            $AST->selectClause->selectExpressions[] = new SelectExpression(new PartialObjectExpression($idVar, array_keys($fields)), null, true);
        }
    }

    /**
     * Generates new SQL for statements with an order by clause
     *
     * @param array              $sqlIdentifier
     * @param string             $innerSql
     * @param string             $sql
     * @param OrderByClause|null $orderByClause
     *
     * @return string
     */
    private function preserveSqlOrdering(
        array $sqlIdentifier,
        string $innerSql,
        string $sql,
        ?OrderByClause $orderByClause
    ) : string {
        // If the sql statement has an order by clause, we need to wrap it in a new select distinct statement
        if (! $orderByClause) {
            return $sql;
        }

        // now only select distinct identifier
        return \sprintf(
            'SELECT DISTINCT %s FROM (%s) dctrn_result',
            \implode(', ', $sqlIdentifier),
            $this->recreateInnerSql($orderByClause, $sqlIdentifier, $innerSql)
        );
    }

    /**
     * Generates a new SQL statement for the inner query to keep the correct sorting
     *
     * @param OrderByClause $orderByClause
     * @param array         $identifiers
     * @param string        $innerSql
     *
     * @return string
     */
    private function recreateInnerSql(
        OrderByClause $orderByClause,
        array $identifiers,
        string $innerSql
    ) : string {
        [$searchPatterns, $replacements] = $this->generateSqlAliasReplacements();

        $orderByItems = [];

        foreach ($orderByClause->orderByItems as $orderByItem) {
            // Walk order by item to get string representation of it and
            // replace path expressions in the order by clause with their column alias
            $orderByItemString = \preg_replace(
                $searchPatterns,
                $replacements,
                $this->walkOrderByItem($orderByItem)
            );

            $orderByItems[] = $orderByItemString;
            $identifier     = \substr($orderByItemString, 0, \strrpos($orderByItemString, ' '));

            if (! \in_array($identifier, $identifiers, true)) {
                $identifiers[] = $identifier;
            }
        }

        return $sql = \sprintf(
            'SELECT DISTINCT %s FROM (%s) dctrn_result_inner ORDER BY %s',
            \implode(', ', $identifiers),
            $innerSql,
            \implode(', ', $orderByItems)
        );
    }

    /**
     * @return string[][]
     */
    private function generateSqlAliasReplacements() : array
    {
        $aliasMap = $searchPatterns = $replacements = $metadataList = [];

        // Generate DQL alias -> SQL table alias mapping
        foreach (\array_keys($this->rsm->aliasMap) as $dqlAlias) {
            $metadataList[$dqlAlias] = $class = $this->queryComponents[$dqlAlias]['metadata'];
            $aliasMap[$dqlAlias] = $this->getSQLTableAlias($class->getTableName(), $dqlAlias);
        }

        // Generate search patterns for each field's path expression in the order by clause
        foreach ($this->rsm->fieldMappings as $fieldAlias => $fieldName) {
            $dqlAliasForFieldAlias = $this->rsm->columnOwnerMap[$fieldAlias];
            $class = $metadataList[$dqlAliasForFieldAlias];

            // If the field is from a joined child table, we won't be ordering on it.
            if (! isset($class->fieldMappings[$fieldName])) {
                continue;
            }

            $fieldMapping = $class->fieldMappings[$fieldName];

            // Get the proper column name as will appear in the select list
            $columnName = $this->quoteStrategy->getColumnName(
                $fieldName,
                $metadataList[$dqlAliasForFieldAlias],
                $this->em->getConnection()->getDatabasePlatform()
            );

            // Get the SQL table alias for the entity and field
            $sqlTableAliasForFieldAlias = $aliasMap[$dqlAliasForFieldAlias];

            if (isset($fieldMapping['declared']) && $fieldMapping['declared'] !== $class->name) {
                // Field was declared in a parent class, so we need to get the proper SQL table alias
                // for the joined parent table.
                $otherClassMetadata = $this->em->getClassMetadata($fieldMapping['declared']);

                if (! $otherClassMetadata->isMappedSuperclass) {
                    $sqlTableAliasForFieldAlias = $this->getSQLTableAlias($otherClassMetadata->getTableName(), $dqlAliasForFieldAlias);
                }
            }

            // Compose search and replace patterns
            $searchPatterns[] = \sprintf(self::ORDER_BY_PATH_EXPRESSION, $sqlTableAliasForFieldAlias, $columnName);
            $replacements[]   = $fieldAlias;
        }

        return [$searchPatterns, $replacements];
    }

    /**
     * getter for $orderByPathExpressions
     *
     * @return array
     */
    public function getOrderByPathExpressions()
    {
        return $this->orderByPathExpressions;
    }

    /**
     * @param SelectStatement $AST
     *
     * @return string
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    private function getInnerSQL(SelectStatement $AST)
    {
        // Set every select expression as visible(hidden = false) to
        // make $AST have scalar mappings properly - this is relevant for referencing selected
        // fields from outside the subquery, for example in the ORDER BY segment
        $hiddens = [];

        foreach ($AST->selectClause->selectExpressions as $idx => $expr) {
            $hiddens[$idx] = $expr->hiddenAliasResultVariable;
            $expr->hiddenAliasResultVariable = false;
        }

        $innerSql = parent::walkSelectStatement($AST);

        // Restore hiddens
        foreach ($AST->selectClause->selectExpressions as $idx => $expr) {
            $expr->hiddenAliasResultVariable = $hiddens[$idx];
        }

        return $innerSql;
    }

    /**
     * @param SelectStatement $AST
     *
     * @return array
     */
    private function getSQLIdentifier(SelectStatement $AST)
    {
        // Find out the SQL alias of the identifier column of the root entity.
        // It may be possible to make this work with multiple root entities but that
        // would probably require issuing multiple queries or doing a UNION SELECT.
        // So for now, it's not supported.

        // Get the root entity and alias from the AST fromClause.
        $from = $AST->fromClause->identificationVariableDeclarations;
        if (count($from) !== 1) {
            throw new \RuntimeException('Cannot count query which selects two FROM components, cannot make distinction');
        }

        $fromRoot       = reset($from);
        $rootAlias      = $fromRoot->rangeVariableDeclaration->aliasIdentificationVariable;
        $rootClass      = $this->queryComponents[$rootAlias]['metadata'];
        $rootIdentifier = $rootClass->identifier;

        // For every identifier, find out the SQL alias by combing through the ResultSetMapping
        $sqlIdentifier = [];
        foreach ($rootIdentifier as $property) {
            if (isset($rootClass->fieldMappings[$property])) {
                foreach (array_keys($this->rsm->fieldMappings, $property) as $alias) {
                    if ($this->rsm->columnOwnerMap[$alias] == $rootAlias) {
                        $sqlIdentifier[$property] = $alias;
                    }
                }
            }

            if (isset($rootClass->associationMappings[$property])) {
                $joinColumn = $rootClass->associationMappings[$property]['joinColumns'][0]['name'];

                foreach (array_keys($this->rsm->metaMappings, $joinColumn) as $alias) {
                    if ($this->rsm->columnOwnerMap[$alias] == $rootAlias) {
                        $sqlIdentifier[$property] = $alias;
                    }
                }
            }
        }

        if (count($sqlIdentifier) === 0) {
            throw new \RuntimeException('The Paginator does not support Queries which only yield ScalarResults.');
        }

        if (count($rootIdentifier) != count($sqlIdentifier)) {
            throw new \RuntimeException(sprintf(
                'Not all identifier properties can be found in the ResultSetMapping: %s',
                implode(', ', array_diff($rootIdentifier, array_keys($sqlIdentifier)))
            ));
        }

        return $sqlIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    public function walkPathExpression($pathExpr)
    {
        if (!$this->inSubSelect && !$this->platformSupportsRowNumber() && !in_array($pathExpr, $this->orderByPathExpressions)) {
            $this->orderByPathExpressions[] = $pathExpr;
        }

        return parent::walkPathExpression($pathExpr);
    }

    /**
     * {@inheritdoc}
     */
    public function walkSubSelect($subselect)
    {
        $this->inSubSelect = true;

        $sql = parent::walkSubselect($subselect);

        $this->inSubSelect = false;

        return $sql;
    }
}
