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

namespace Doctrine\ORM\Query\Exec;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\AST;

/**
 * Executor that executes the SQL statements for DQL DELETE/UPDATE statements on classes
 * that are mapped to a single table.
 *
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @author      Roman Borschel <roman@code-factory.org>
 * @link        www.doctrine-project.org
 * @since       2.0
 * @todo This is exactly the same as SingleSelectExecutor. Unify in SingleStatementExecutor.
 */
class SingleTableDeleteUpdateExecutor extends AbstractSqlExecutor
{
    /**
     * @param \Doctrine\ORM\Query\AST\Node  $AST
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     */
    public function __construct(AST\Node $AST, $sqlWalker)
    {
        if ($AST instanceof AST\UpdateStatement) {
            $this->_sqlStatements = $sqlWalker->walkUpdateStatement($AST);
        } else if ($AST instanceof AST\DeleteStatement) {
            $this->_sqlStatements = $sqlWalker->walkDeleteStatement($AST);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Connection $conn, array $params, array $types)
    {
        return $conn->executeUpdate($this->_sqlStatements, $params, $types);
    }
}
