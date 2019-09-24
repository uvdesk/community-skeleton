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

namespace Doctrine\ORM\Persisters\Entity;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * A swappable persister context to use as a container for the current
 * generated query/resultSetMapping/type binding information.
 *
 * This class is a utility class to be used only by the persister API
 *
 * This object is highly mutable due to performance reasons. Same reasoning
 * behind its properties being public.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class CachedPersisterContext
{
    /**
     * Metadata object that describes the mapping of the mapped entity class.
     *
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    public $class;

    /**
     * ResultSetMapping that is used for all queries. Is generated lazily once per request.
     *
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    public $rsm;

    /**
     * The SELECT column list SQL fragment used for querying entities by this persister.
     * This SQL fragment is only generated once per request, if at all.
     *
     * @var string|null
     */
    public $selectColumnListSql;

    /**
     * The JOIN SQL fragment used to eagerly load all many-to-one and one-to-one
     * associations configured as FETCH_EAGER, as well as all inverse one-to-one associations.
     *
     * @var string
     */
    public $selectJoinSql;

    /**
     * Counter for creating unique SQL table and column aliases.
     *
     * @var integer
     */
    public $sqlAliasCounter = 0;

    /**
     * Map from class names (FQCN) to the corresponding generated SQL table aliases.
     *
     * @var array
     */
    public $sqlTableAliases = [];

    /**
     * Whether this persistent context is considering limit operations applied to the selection queries
     *
     * @var bool
     */
    public $handlesLimits;

    /**
     * @param ClassMetadata    $class
     * @param ResultSetMapping $rsm
     * @param bool             $handlesLimits
     */
    public function __construct(
        ClassMetadata $class,
        ResultSetMapping $rsm,
        $handlesLimits
    ) {
        $this->class         = $class;
        $this->rsm           = $rsm;
        $this->handlesLimits = (bool) $handlesLimits;
    }
}
