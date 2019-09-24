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

namespace Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;

/**
 * Id generator that uses a single-row database table and a hi/lo algorithm.
 *
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class TableGenerator extends AbstractIdGenerator
{
    /**
     * @var string
     */
    private $_tableName;

    /**
     * @var string
     */
    private $_sequenceName;

    /**
     * @var int
     */
    private $_allocationSize;

    /**
     * @var int|null
     */
    private $_nextValue;

    /**
     * @var int|null
     */
    private $_maxValue;

    /**
     * @param string $tableName
     * @param string $sequenceName
     * @param int    $allocationSize
     */
    public function __construct($tableName, $sequenceName = 'default', $allocationSize = 10)
    {
        $this->_tableName = $tableName;
        $this->_sequenceName = $sequenceName;
        $this->_allocationSize = $allocationSize;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(
        EntityManager $em, $entity)
    {
        if ($this->_maxValue === null || $this->_nextValue == $this->_maxValue) {
            // Allocate new values
            $conn = $em->getConnection();

            if ($conn->getTransactionNestingLevel() === 0) {
                // use select for update
                $sql          = $conn->getDatabasePlatform()->getTableHiLoCurrentValSql($this->_tableName, $this->_sequenceName);
                $currentLevel = $conn->fetchColumn($sql);

                if ($currentLevel != null) {
                    $this->_nextValue = $currentLevel;
                    $this->_maxValue = $this->_nextValue + $this->_allocationSize;

                    $updateSql = $conn->getDatabasePlatform()->getTableHiLoUpdateNextValSql(
                        $this->_tableName, $this->_sequenceName, $this->_allocationSize
                    );

                    if ($conn->executeUpdate($updateSql, [1 => $currentLevel, 2 => $currentLevel+1]) !== 1) {
                        // no affected rows, concurrency issue, throw exception
                    }
                } else {
                    // no current level returned, TableGenerator seems to be broken, throw exception
                }
            } else {
                // only table locks help here, implement this or throw exception?
                // or do we want to work with table locks exclusively?
            }
        }

        return $this->_nextValue++;
    }
}
