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

/**
 * An adapter implementation of the TreeWalker interface. The methods in this class
 * are empty. ﻿This class exists as convenience for creating tree walkers.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 */
abstract class TreeWalkerAdapter implements TreeWalker
{
    /**
     * The original Query.
     *
     * @var \Doctrine\ORM\AbstractQuery
     */
    private $_query;

    /**
     * The ParserResult of the original query that was produced by the Parser.
     *
     * @var \Doctrine\ORM\Query\ParserResult
     */
    private $_parserResult;

    /**
     * The query components of the original query (the "symbol table") that was produced by the Parser.
     *
     * @var array
     */
    private $_queryComponents;

    /**
     * {@inheritdoc}
     */
    public function __construct($query, $parserResult, array $queryComponents)
    {
        $this->_query = $query;
        $this->_parserResult = $parserResult;
        $this->_queryComponents = $queryComponents;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryComponents()
    {
        return $this->_queryComponents;
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

        $this->_queryComponents[$dqlAlias] = $queryComponent;
    }

    /**
     * @return array
     */
    protected function _getQueryComponents()
    {
        return $this->_queryComponents;
    }

    /**
     * Retrieves the Query Instance responsible for the current walkers execution.
     *
     * @return \Doctrine\ORM\AbstractQuery
     */
    protected function _getQuery()
    {
        return $this->_query;
    }

    /**
     * Retrieves the ParserResult.
     *
     * @return \Doctrine\ORM\Query\ParserResult
     */
    protected function _getParserResult()
    {
        return $this->_parserResult;
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectStatement(AST\SelectStatement $AST)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectClause($selectClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkFromClause($fromClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkFunction($function)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkOrderByClause($orderByClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkOrderByItem($orderByItem)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkHavingClause($havingClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkJoin($join)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSelectExpression($selectExpression)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkQuantifiedExpression($qExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSubselect($subselect)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSubselectFromClause($subselectFromClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleSelectClause($simpleSelectClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleSelectExpression($simpleSelectExpression)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkAggregateExpression($aggExpression)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkGroupByClause($groupByClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkGroupByItem($groupByItem)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateStatement(AST\UpdateStatement $AST)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkDeleteStatement(AST\DeleteStatement $AST)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkDeleteClause(AST\DeleteClause $deleteClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateClause($updateClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkUpdateItem($updateItem)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkWhereClause($whereClause)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalExpression($condExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalTerm($condTerm)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalFactor($factor)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkConditionalPrimary($primary)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkExistsExpression($existsExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkCollectionMemberExpression($collMemberExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkEmptyCollectionComparisonExpression($emptyCollCompExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkNullComparisonExpression($nullCompExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkInExpression($inExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkInstanceOfExpression($instanceOfExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkLiteral($literal)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkBetweenExpression($betweenExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkLikeExpression($likeExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkStateFieldPathExpression($stateFieldPathExpression)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkComparisonExpression($compExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkInputParameter($inputParam)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticExpression($arithmeticExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticTerm($term)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkStringPrimary($stringPrimary)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkArithmeticFactor($factor)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkSimpleArithmeticExpression($simpleArithmeticExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkPathExpression($pathExpr)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function walkResultVariable($resultVariable)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getExecutor($AST)
    {
    }
}
