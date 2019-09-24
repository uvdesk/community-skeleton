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

namespace Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\QueryException;

/**
 * "IDENTITY" "(" SingleValuedAssociationPathExpression {"," string} ")"
 *
 *
 * @link    www.doctrine-project.org
 * @since   2.2
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 */
class IdentityFunction extends FunctionNode
{
    /**
     * @var \Doctrine\ORM\Query\AST\PathExpression
     */
    public $pathExpression;

    /**
     * @var string
     */
    public $fieldMapping;

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $platform       = $sqlWalker->getEntityManager()->getConnection()->getDatabasePlatform();
        $quoteStrategy  = $sqlWalker->getEntityManager()->getConfiguration()->getQuoteStrategy();
        $dqlAlias       = $this->pathExpression->identificationVariable;
        $assocField     = $this->pathExpression->field;
        $qComp          = $sqlWalker->getQueryComponent($dqlAlias);
        $class          = $qComp['metadata'];
        $assoc          = $class->associationMappings[$assocField];
        $targetEntity   = $sqlWalker->getEntityManager()->getClassMetadata($assoc['targetEntity']);
        $joinColumn     = reset($assoc['joinColumns']);

        if ($this->fieldMapping !== null) {
            if ( ! isset($targetEntity->fieldMappings[$this->fieldMapping])) {
                throw new QueryException(sprintf('Undefined reference field mapping "%s"', $this->fieldMapping));
            }

            $field      = $targetEntity->fieldMappings[$this->fieldMapping];
            $joinColumn = null;

            foreach ($assoc['joinColumns'] as $mapping) {

                if ($mapping['referencedColumnName'] === $field['columnName']) {
                    $joinColumn = $mapping;

                    break;
                }
            }

            if ($joinColumn === null) {
                throw new QueryException(sprintf('Unable to resolve the reference field mapping "%s"', $this->fieldMapping));
            }
        }

        // The table with the relation may be a subclass, so get the table name from the association definition
        $tableName = $sqlWalker->getEntityManager()->getClassMetadata($assoc['sourceEntity'])->getTableName();

        $tableAlias = $sqlWalker->getSQLTableAlias($tableName, $dqlAlias);
        $columnName  = $quoteStrategy->getJoinColumnName($joinColumn, $targetEntity, $platform);

        return $tableAlias . '.' . $columnName;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->pathExpression = $parser->SingleValuedAssociationPathExpression();

        if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $parser->match(Lexer::T_STRING);

            $this->fieldMapping = $parser->getLexer()->token['value'];
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
