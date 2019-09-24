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

use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\QueryException;

/**
 * "DATE_ADD(date1, interval, unit)"
 *
 * 
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 */
class DateSubFunction extends DateAddFunction
{
    /**
     * @override
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        switch (strtolower($this->unit->value)) {
            case 'second':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubSecondsExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'minute':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubMinutesExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'hour':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubHourExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'day':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubDaysExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'week':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubWeeksExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'month':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubMonthExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );
            case 'year':
                return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubYearsExpression(
                    $this->firstDateExpression->dispatch($sqlWalker),
                    $this->intervalExpression->dispatch($sqlWalker)
                );

            default:
                throw QueryException::semanticalError(
                    'DATE_SUB() only supports units of type second, minute, hour, day, week, month and year.'
                );
        }
    }
}
