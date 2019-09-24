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
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;

/**
 * "DATE_ADD" "(" ArithmeticPrimary "," ArithmeticPrimary "," StringPrimary ")"
 *
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 */
class DateAddFunction extends FunctionNode
{
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    /**
     * @override
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        switch (strtolower($this->unit->value)) {
            case 'second':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddSecondsExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'minute':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddMinutesExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'hour':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddHourExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'day':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddDaysExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'week':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddWeeksExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'month':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddMonthExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'year':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddYearsExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );

            default:
                throw QueryException::semanticalError(
                    'DATE_ADD() only supports units of type second, minute, hour, day, week, month and year.'
                );
        }
    }

    /**
     * @override
     * @inheritdoc
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->intervalExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->unit = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
