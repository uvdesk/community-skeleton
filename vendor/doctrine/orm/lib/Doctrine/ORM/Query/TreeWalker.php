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
 * Interface for walkers of DQL ASTs (abstract syntax trees).
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 */
interface TreeWalker
{
    /**
     * Initializes TreeWalker with important information about the ASTs to be walked.
     *
     * @param \Doctrine\ORM\AbstractQuery      $query           The parsed Query.
     * @param \Doctrine\ORM\Query\ParserResult $parserResult    The result of the parsing process.
     * @param array                            $queryComponents The query components (symbol table).
     */
    public function __construct($query, $parserResult, array $queryComponents);

    /**
     * Returns internal queryComponents array.
     *
     * @return array
     */
    public function getQueryComponents();

    /**
     * Sets or overrides a query component for a given dql alias.
     *
     * @param string $dqlAlias       The DQL alias.
     * @param array  $queryComponent
     *
     * @return void
     */
    public function setQueryComponent($dqlAlias, array $queryComponent);

    /**
     * Walks down a SelectStatement AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SelectStatement $AST
     *
     * @return string The SQL.
     */
    function walkSelectStatement(AST\SelectStatement $AST);

    /**
     * Walks down a SelectClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SelectClause $selectClause
     *
     * @return string The SQL.
     */
    function walkSelectClause($selectClause);

    /**
     * Walks down a FromClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\FromClause $fromClause
     *
     * @return string The SQL.
     */
    function walkFromClause($fromClause);

    /**
     * Walks down a FunctionNode AST node, thereby generating the appropriate SQL.
     *
     * @param AST\Functions\FunctionNode $function
     *
     * @return string The SQL.
     */
    function walkFunction($function);

    /**
     * Walks down an OrderByClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\OrderByClause $orderByClause
     *
     * @return string The SQL.
     */
    function walkOrderByClause($orderByClause);

    /**
     * Walks down an OrderByItem AST node, thereby generating the appropriate SQL.
     *
     * @param AST\OrderByItem $orderByItem
     *
     * @return string The SQL.
     */
    function walkOrderByItem($orderByItem);

    /**
     * Walks down a HavingClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\HavingClause $havingClause
     *
     * @return string The SQL.
     */
    function walkHavingClause($havingClause);

    /**
     * Walks down a Join AST node and creates the corresponding SQL.
     *
     * @param AST\Join $join
     *
     * @return string The SQL.
     */
    function walkJoin($join);

    /**
     * Walks down a SelectExpression AST node and generates the corresponding SQL.
     *
     * @param AST\SelectExpression $selectExpression
     *
     * @return string The SQL.
     */
    function walkSelectExpression($selectExpression);

    /**
     * Walks down a QuantifiedExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\QuantifiedExpression $qExpr
     *
     * @return string The SQL.
     */
    function walkQuantifiedExpression($qExpr);

    /**
     * Walks down a Subselect AST node, thereby generating the appropriate SQL.
     *
     * @param AST\Subselect $subselect
     *
     * @return string The SQL.
     */
    function walkSubselect($subselect);

    /**
     * Walks down a SubselectFromClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SubselectFromClause $subselectFromClause
     *
     * @return string The SQL.
     */
    function walkSubselectFromClause($subselectFromClause);

    /**
     * Walks down a SimpleSelectClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SimpleSelectClause $simpleSelectClause
     *
     * @return string The SQL.
     */
    function walkSimpleSelectClause($simpleSelectClause);

    /**
     * Walks down a SimpleSelectExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SimpleSelectExpression $simpleSelectExpression
     *
     * @return string The SQL.
     */
    function walkSimpleSelectExpression($simpleSelectExpression);

    /**
     * Walks down an AggregateExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\AggregateExpression $aggExpression
     *
     * @return string The SQL.
     */
    function walkAggregateExpression($aggExpression);

    /**
     * Walks down a GroupByClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\GroupByClause $groupByClause
     *
     * @return string The SQL.
     */
    function walkGroupByClause($groupByClause);

    /**
     * Walks down a GroupByItem AST node, thereby generating the appropriate SQL.
     *
     * @param AST\PathExpression|string $groupByItem
     *
     * @return string The SQL.
     */
    function walkGroupByItem($groupByItem);

    /**
     * Walks down an UpdateStatement AST node, thereby generating the appropriate SQL.
     *
     * @param AST\UpdateStatement $AST
     *
     * @return string The SQL.
     */
    function walkUpdateStatement(AST\UpdateStatement $AST);

    /**
     * Walks down a DeleteStatement AST node, thereby generating the appropriate SQL.
     *
     * @param AST\DeleteStatement $AST
     *
     * @return string The SQL.
     */
    function walkDeleteStatement(AST\DeleteStatement $AST);

    /**
     * Walks down a DeleteClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\DeleteClause $deleteClause
     *
     * @return string The SQL.
     */
    function walkDeleteClause(AST\DeleteClause $deleteClause);

    /**
     * Walks down an UpdateClause AST node, thereby generating the appropriate SQL.
     *
     * @param AST\UpdateClause $updateClause
     *
     * @return string The SQL.
     */
    function walkUpdateClause($updateClause);

    /**
     * Walks down an UpdateItem AST node, thereby generating the appropriate SQL.
     *
     * @param AST\UpdateItem $updateItem
     *
     * @return string The SQL.
     */
    function walkUpdateItem($updateItem);

    /**
     * Walks down a WhereClause AST node, thereby generating the appropriate SQL.
     * WhereClause or not, the appropriate discriminator sql is added.
     *
     * @param AST\WhereClause $whereClause
     *
     * @return string The SQL.
     */
    function walkWhereClause($whereClause);

    /**
     * Walk down a ConditionalExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ConditionalExpression $condExpr
     *
     * @return string The SQL.
     */
    function walkConditionalExpression($condExpr);

    /**
     * Walks down a ConditionalTerm AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ConditionalTerm $condTerm
     *
     * @return string The SQL.
     */
    function walkConditionalTerm($condTerm);

    /**
     * Walks down a ConditionalFactor AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ConditionalFactor $factor
     *
     * @return string The SQL.
     */
    function walkConditionalFactor($factor);

    /**
     * Walks down a ConditionalPrimary AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ConditionalPrimary $primary
     *
     * @return string The SQL.
     */
    function walkConditionalPrimary($primary);

    /**
     * Walks down an ExistsExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ExistsExpression $existsExpr
     *
     * @return string The SQL.
     */
    function walkExistsExpression($existsExpr);

    /**
     * Walks down a CollectionMemberExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\CollectionMemberExpression $collMemberExpr
     *
     * @return string The SQL.
     */
    function walkCollectionMemberExpression($collMemberExpr);

    /**
     * Walks down an EmptyCollectionComparisonExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\EmptyCollectionComparisonExpression $emptyCollCompExpr
     *
     * @return string The SQL.
     */
    function walkEmptyCollectionComparisonExpression($emptyCollCompExpr);

    /**
     * Walks down a NullComparisonExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\NullComparisonExpression $nullCompExpr
     *
     * @return string The SQL.
     */
    function walkNullComparisonExpression($nullCompExpr);

    /**
     * Walks down an InExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\InExpression $inExpr
     *
     * @return string The SQL.
     */
    function walkInExpression($inExpr);

    /**
     * Walks down an InstanceOfExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\InstanceOfExpression $instanceOfExpr
     *
     * @return string The SQL.
     */
    function walkInstanceOfExpression($instanceOfExpr);

    /**
     * Walks down a literal that represents an AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $literal
     *
     * @return string The SQL.
     */
    function walkLiteral($literal);

    /**
     * Walks down a BetweenExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\BetweenExpression $betweenExpr
     *
     * @return string The SQL.
     */
    function walkBetweenExpression($betweenExpr);

    /**
     * Walks down a LikeExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\LikeExpression $likeExpr
     *
     * @return string The SQL.
     */
    function walkLikeExpression($likeExpr);

    /**
     * Walks down a StateFieldPathExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\PathExpression $stateFieldPathExpression
     *
     * @return string The SQL.
     */
    function walkStateFieldPathExpression($stateFieldPathExpression);

    /**
     * Walks down a ComparisonExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ComparisonExpression $compExpr
     *
     * @return string The SQL.
     */
    function walkComparisonExpression($compExpr);

    /**
     * Walks down an InputParameter AST node, thereby generating the appropriate SQL.
     *
     * @param AST\InputParameter $inputParam
     *
     * @return string The SQL.
     */
    function walkInputParameter($inputParam);

    /**
     * Walks down an ArithmeticExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\ArithmeticExpression $arithmeticExpr
     *
     * @return string The SQL.
     */
    function walkArithmeticExpression($arithmeticExpr);

    /**
     * Walks down an ArithmeticTerm AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $term
     *
     * @return string The SQL.
     */
    function walkArithmeticTerm($term);

    /**
     * Walks down a StringPrimary that represents an AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $stringPrimary
     *
     * @return string The SQL.
     */
    function walkStringPrimary($stringPrimary);

    /**
     * Walks down an ArithmeticFactor that represents an AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $factor
     *
     * @return string The SQL.
     */
    function walkArithmeticFactor($factor);

    /**
     * Walks down an SimpleArithmeticExpression AST node, thereby generating the appropriate SQL.
     *
     * @param AST\SimpleArithmeticExpression $simpleArithmeticExpr
     *
     * @return string The SQL.
     */
    function walkSimpleArithmeticExpression($simpleArithmeticExpr);

    /**
     * Walks down a PathExpression AST node, thereby generating the appropriate SQL.
     *
     * @param mixed $pathExpr
     *
     * @return string The SQL.
     */
    function walkPathExpression($pathExpr);

    /**
     * Walks down a ResultVariable that represents an AST node, thereby generating the appropriate SQL.
     *
     * @param string $resultVariable
     *
     * @return string The SQL.
     */
    function walkResultVariable($resultVariable);

    /**
     * Gets an executor that can be used to execute the result of this walker.
     *
     * @param AST\DeleteStatement|AST\UpdateStatement|AST\SelectStatement $AST
     *
     * @return Exec\AbstractSqlExecutor
     */
    function getExecutor($AST);
}
