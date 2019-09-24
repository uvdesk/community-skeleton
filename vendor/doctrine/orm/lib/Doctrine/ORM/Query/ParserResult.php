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
 * Encapsulates the resulting components from a DQL query parsing process that
 * can be serialized.
 *
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Janne Vanhala <jpvanhal@cc.hut.fi>
 * @author		Roman Borschel <roman@code-factory.org>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @link        http://www.doctrine-project.org
 * @since       2.0
 */
class ParserResult
{
    /**
     * The SQL executor used for executing the SQL.
     *
     * @var \Doctrine\ORM\Query\Exec\AbstractSqlExecutor
     */
    private $_sqlExecutor;

    /**
     * The ResultSetMapping that describes how to map the SQL result set.
     *
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    private $_resultSetMapping;

    /**
     * The mappings of DQL parameter names/positions to SQL parameter positions.
     *
     * @var array
     */
    private $_parameterMappings = [];

    /**
     * Initializes a new instance of the <tt>ParserResult</tt> class.
     * The new instance is initialized with an empty <tt>ResultSetMapping</tt>.
     */
    public function __construct()
    {
        $this->_resultSetMapping = new ResultSetMapping;
    }

    /**
     * Gets the ResultSetMapping for the parsed query.
     *
     * @return ResultSetMapping|null The result set mapping of the parsed query or NULL
     *                               if the query is not a SELECT query.
     */
    public function getResultSetMapping()
    {
        return $this->_resultSetMapping;
    }

    /**
     * Sets the ResultSetMapping of the parsed query.
     *
     * @param ResultSetMapping $rsm
     *
     * @return void
     */
    public function setResultSetMapping(ResultSetMapping $rsm)
    {
        $this->_resultSetMapping = $rsm;
    }

    /**
     * Sets the SQL executor that should be used for this ParserResult.
     *
     * @param \Doctrine\ORM\Query\Exec\AbstractSqlExecutor $executor
     *
     * @return void
     */
    public function setSqlExecutor($executor)
    {
        $this->_sqlExecutor = $executor;
    }

    /**
     * Gets the SQL executor used by this ParserResult.
     *
     * @return \Doctrine\ORM\Query\Exec\AbstractSqlExecutor
     */
    public function getSqlExecutor()
    {
        return $this->_sqlExecutor;
    }

    /**
     * Adds a DQL to SQL parameter mapping. One DQL parameter name/position can map to
     * several SQL parameter positions.
     *
     * @param string|integer $dqlPosition
     * @param integer        $sqlPosition
     *
     * @return void
     */
    public function addParameterMapping($dqlPosition, $sqlPosition)
    {
        $this->_parameterMappings[$dqlPosition][] = $sqlPosition;
    }

    /**
     * Gets all DQL to SQL parameter mappings.
     *
     * @return array The parameter mappings.
     */
    public function getParameterMappings()
    {
        return $this->_parameterMappings;
    }

    /**
     * Gets the SQL parameter positions for a DQL parameter name/position.
     *
     * @param string|integer $dqlPosition The name or position of the DQL parameter.
     *
     * @return array The positions of the corresponding SQL parameters.
     */
    public function getSqlParameterPositions($dqlPosition)
    {
        return $this->_parameterMappings[$dqlPosition];
    }
}
