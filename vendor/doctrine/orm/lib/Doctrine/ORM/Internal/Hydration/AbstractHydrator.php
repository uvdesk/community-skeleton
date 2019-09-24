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

namespace Doctrine\ORM\Internal\Hydration;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use PDO;
use function array_map;
use function in_array;

/**
 * Base class for all hydrators. A hydrator is a class that provides some form
 * of transformation of an SQL result set into another structure.
 *
 * @since  2.0
 * @author Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @author Roman Borschel <roman@code-factory.org>
 * @author Guilherme Blanco <guilhermeblanoc@hotmail.com>
 */
abstract class AbstractHydrator
{
    /**
     * The ResultSetMapping.
     *
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    protected $_rsm;

    /**
     * The EntityManager instance.
     *
     * @var EntityManagerInterface
     */
    protected $_em;

    /**
     * The dbms Platform instance.
     *
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected $_platform;

    /**
     * The UnitOfWork of the associated EntityManager.
     *
     * @var \Doctrine\ORM\UnitOfWork
     */
    protected $_uow;

    /**
     * Local ClassMetadata cache to avoid going to the EntityManager all the time.
     *
     * @var array
     */
    protected $_metadataCache = [];

    /**
     * The cache used during row-by-row hydration.
     *
     * @var array
     */
    protected $_cache = [];

    /**
     * The statement that provides the data to hydrate.
     *
     * @var \Doctrine\DBAL\Driver\Statement
     */
    protected $_stmt;

    /**
     * The query hints.
     *
     * @var array
     */
    protected $_hints;

    /**
     * Initializes a new instance of a class derived from <tt>AbstractHydrator</tt>.
     *
     * @param EntityManagerInterface $em The EntityManager to use.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->_em       = $em;
        $this->_platform = $em->getConnection()->getDatabasePlatform();
        $this->_uow      = $em->getUnitOfWork();
    }

    /**
     * Initiates a row-by-row hydration.
     *
     * @param object $stmt
     * @param object $resultSetMapping
     * @param array  $hints
     *
     * @return IterableResult
     */
    public function iterate($stmt, $resultSetMapping, array $hints = [])
    {
        $this->_stmt  = $stmt;
        $this->_rsm   = $resultSetMapping;
        $this->_hints = $hints;

        $evm = $this->_em->getEventManager();

        $evm->addEventListener([Events::onClear], $this);

        $this->prepare();

        return new IterableResult($this);
    }

    /**
     * Hydrates all rows returned by the passed statement instance at once.
     *
     * @param object $stmt
     * @param object $resultSetMapping
     * @param array  $hints
     *
     * @return array
     */
    public function hydrateAll($stmt, $resultSetMapping, array $hints = [])
    {
        $this->_stmt  = $stmt;
        $this->_rsm   = $resultSetMapping;
        $this->_hints = $hints;

        $this->_em->getEventManager()->addEventListener([Events::onClear], $this);

        $this->prepare();

        $result = $this->hydrateAllData();

        $this->cleanup();

        return $result;
    }

    /**
     * Hydrates a single row returned by the current statement instance during
     * row-by-row hydration with {@link iterate()}.
     *
     * @return mixed
     */
    public function hydrateRow()
    {
        $row = $this->_stmt->fetch(PDO::FETCH_ASSOC);

        if ( ! $row) {
            $this->cleanup();

            return false;
        }

        $result = [];

        $this->hydrateRowData($row, $result);

        return $result;
    }

    /**
     * When executed in a hydrate() loop we have to clear internal state to
     * decrease memory consumption.
     *
     * @param mixed $eventArgs
     *
     * @return void
     */
    public function onClear($eventArgs)
    {
    }

    /**
     * Executes one-time preparation tasks, once each time hydration is started
     * through {@link hydrateAll} or {@link iterate()}.
     *
     * @return void
     */
    protected function prepare()
    {
    }

    /**
     * Executes one-time cleanup tasks at the end of a hydration that was initiated
     * through {@link hydrateAll} or {@link iterate()}.
     *
     * @return void
     */
    protected function cleanup()
    {
        $this->_stmt->closeCursor();

        $this->_stmt          = null;
        $this->_rsm           = null;
        $this->_cache         = [];
        $this->_metadataCache = [];

        $this
            ->_em
            ->getEventManager()
            ->removeEventListener([Events::onClear], $this);
    }

    /**
     * Hydrates a single row from the current statement instance.
     *
     * Template method.
     *
     * @param array $data   The row data.
     * @param array $result The result to fill.
     *
     * @return void
     *
     * @throws HydrationException
     */
    protected function hydrateRowData(array $data, array &$result)
    {
        throw new HydrationException("hydrateRowData() not implemented by this hydrator.");
    }

    /**
     * Hydrates all rows from the current statement instance at once.
     *
     * @return array
     */
    abstract protected function hydrateAllData();

    /**
     * Processes a row of the result set.
     *
     * Used for identity-based hydration (HYDRATE_OBJECT and HYDRATE_ARRAY).
     * Puts the elements of a result row into a new array, grouped by the dql alias
     * they belong to. The column names in the result set are mapped to their
     * field names during this procedure as well as any necessary conversions on
     * the values applied. Scalar values are kept in a specific key 'scalars'.
     *
     * @param array  $data               SQL Result Row.
     * @param array &$id                 Dql-Alias => ID-Hash.
     * @param array &$nonemptyComponents Does this DQL-Alias has at least one non NULL value?
     *
     * @return array  An array with all the fields (name => value) of the data row,
     *                grouped by their component alias.
     */
    protected function gatherRowData(array $data, array &$id, array &$nonemptyComponents)
    {
        $rowData = ['data' => []];

        foreach ($data as $key => $value) {
            if (($cacheKeyInfo = $this->hydrateColumnInfo($key)) === null) {
                continue;
            }

            $fieldName = $cacheKeyInfo['fieldName'];

            switch (true) {
                case (isset($cacheKeyInfo['isNewObjectParameter'])):
                    $argIndex = $cacheKeyInfo['argIndex'];
                    $objIndex = $cacheKeyInfo['objIndex'];
                    $type     = $cacheKeyInfo['type'];
                    $value    = $type->convertToPHPValue($value, $this->_platform);

                    $rowData['newObjects'][$objIndex]['class']           = $cacheKeyInfo['class'];
                    $rowData['newObjects'][$objIndex]['args'][$argIndex] = $value;
                    break;

                case (isset($cacheKeyInfo['isScalar'])):
                    $type  = $cacheKeyInfo['type'];
                    $value = $type->convertToPHPValue($value, $this->_platform);

                    $rowData['scalars'][$fieldName] = $value;
                    break;

                //case (isset($cacheKeyInfo['isMetaColumn'])):
                default:
                    $dqlAlias = $cacheKeyInfo['dqlAlias'];
                    $type     = $cacheKeyInfo['type'];

                    // If there are field name collisions in the child class, then we need
                    // to only hydrate if we are looking at the correct discriminator value
                    if (isset($cacheKeyInfo['discriminatorColumn'], $data[$cacheKeyInfo['discriminatorColumn']])
                        && ! in_array((string) $data[$cacheKeyInfo['discriminatorColumn']], $cacheKeyInfo['discriminatorValues'], true)
                    ) {
                        break;
                    }

                    // in an inheritance hierarchy the same field could be defined several times.
                    // We overwrite this value so long we don't have a non-null value, that value we keep.
                    // Per definition it cannot be that a field is defined several times and has several values.
                    if (isset($rowData['data'][$dqlAlias][$fieldName])) {
                        break;
                    }

                    $rowData['data'][$dqlAlias][$fieldName] = $type
                        ? $type->convertToPHPValue($value, $this->_platform)
                        : $value;

                    if ($cacheKeyInfo['isIdentifier'] && $value !== null) {
                        $id[$dqlAlias] .= '|' . $value;
                        $nonemptyComponents[$dqlAlias] = true;
                    }
                    break;
            }
        }

        return $rowData;
    }

    /**
     * Processes a row of the result set.
     *
     * Used for HYDRATE_SCALAR. This is a variant of _gatherRowData() that
     * simply converts column names to field names and properly converts the
     * values according to their types. The resulting row has the same number
     * of elements as before.
     *
     * @param array $data
     *
     * @return array The processed row.
     */
    protected function gatherScalarRowData(&$data)
    {
        $rowData = [];

        foreach ($data as $key => $value) {
            if (($cacheKeyInfo = $this->hydrateColumnInfo($key)) === null) {
                continue;
            }

            $fieldName = $cacheKeyInfo['fieldName'];

            // WARNING: BC break! We know this is the desired behavior to type convert values, but this
            // erroneous behavior exists since 2.0 and we're forced to keep compatibility.
            if ( ! isset($cacheKeyInfo['isScalar'])) {
                $dqlAlias  = $cacheKeyInfo['dqlAlias'];
                $type      = $cacheKeyInfo['type'];
                $fieldName = $dqlAlias . '_' . $fieldName;
                $value     = $type
                    ? $type->convertToPHPValue($value, $this->_platform)
                    : $value;
            }

            $rowData[$fieldName] = $value;
        }

        return $rowData;
    }

    /**
     * Retrieve column information from ResultSetMapping.
     *
     * @param string $key Column name
     *
     * @return array|null
     */
    protected function hydrateColumnInfo($key)
    {
        if (isset($this->_cache[$key])) {
            return $this->_cache[$key];
        }

        switch (true) {
            // NOTE: Most of the times it's a field mapping, so keep it first!!!
            case (isset($this->_rsm->fieldMappings[$key])):
                $classMetadata = $this->getClassMetadata($this->_rsm->declaringClasses[$key]);
                $fieldName     = $this->_rsm->fieldMappings[$key];
                $fieldMapping  = $classMetadata->fieldMappings[$fieldName];
                $ownerMap      = $this->_rsm->columnOwnerMap[$key];
                $columnInfo    = [
                    'isIdentifier' => \in_array($fieldName, $classMetadata->identifier, true),
                    'fieldName'    => $fieldName,
                    'type'         => Type::getType($fieldMapping['type']),
                    'dqlAlias'     => $ownerMap,
                ];

                // the current discriminator value must be saved in order to disambiguate fields hydration,
                // should there be field name collisions
                if ($classMetadata->parentClasses && isset($this->_rsm->discriminatorColumns[$ownerMap])) {
                    return $this->_cache[$key] = \array_merge(
                        $columnInfo,
                        [
                            'discriminatorColumn' => $this->_rsm->discriminatorColumns[$ownerMap],
                            'discriminatorValue'  => $classMetadata->discriminatorValue,
                            'discriminatorValues' => $this->getDiscriminatorValues($classMetadata),
                        ]
                    );
                }

                return $this->_cache[$key] = $columnInfo;

            case (isset($this->_rsm->newObjectMappings[$key])):
                // WARNING: A NEW object is also a scalar, so it must be declared before!
                $mapping = $this->_rsm->newObjectMappings[$key];

                return $this->_cache[$key] = [
                    'isScalar'             => true,
                    'isNewObjectParameter' => true,
                    'fieldName'            => $this->_rsm->scalarMappings[$key],
                    'type'                 => Type::getType($this->_rsm->typeMappings[$key]),
                    'argIndex'             => $mapping['argIndex'],
                    'objIndex'             => $mapping['objIndex'],
                    'class'                => new \ReflectionClass($mapping['className']),
                ];

            case (isset($this->_rsm->scalarMappings[$key])):
                return $this->_cache[$key] = [
                    'isScalar'  => true,
                    'fieldName' => $this->_rsm->scalarMappings[$key],
                    'type'      => Type::getType($this->_rsm->typeMappings[$key]),
                ];

            case (isset($this->_rsm->metaMappings[$key])):
                // Meta column (has meaning in relational schema only, i.e. foreign keys or discriminator columns).
                $fieldName = $this->_rsm->metaMappings[$key];
                $dqlAlias  = $this->_rsm->columnOwnerMap[$key];
                $type      = isset($this->_rsm->typeMappings[$key])
                    ? Type::getType($this->_rsm->typeMappings[$key])
                    : null;

                // Cache metadata fetch
                $this->getClassMetadata($this->_rsm->aliasMap[$dqlAlias]);

                return $this->_cache[$key] = [
                    'isIdentifier' => isset($this->_rsm->isIdentifierColumn[$dqlAlias][$key]),
                    'isMetaColumn' => true,
                    'fieldName'    => $fieldName,
                    'type'         => $type,
                    'dqlAlias'     => $dqlAlias,
                ];
        }

        // this column is a left over, maybe from a LIMIT query hack for example in Oracle or DB2
        // maybe from an additional column that has not been defined in a NativeQuery ResultSetMapping.
        return null;
    }

    /**
     * @return string[]
     */
    private function getDiscriminatorValues(ClassMetadata $classMetadata) : array
    {
        $values = array_map(
            function (string $subClass) : string {
                return (string) $this->getClassMetadata($subClass)->discriminatorValue;
            },
            $classMetadata->subClasses
        );

        $values[] = (string) $classMetadata->discriminatorValue;

        return $values;
    }

    /**
     * Retrieve ClassMetadata associated to entity class name.
     *
     * @param string $className
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected function getClassMetadata($className)
    {
        if ( ! isset($this->_metadataCache[$className])) {
            $this->_metadataCache[$className] = $this->_em->getClassMetadata($className);
        }

        return $this->_metadataCache[$className];
    }

    /**
     * Register entity as managed in UnitOfWork.
     *
     * @param ClassMetadata $class
     * @param object        $entity
     * @param array         $data
     *
     * @return void
     *
     * @todo The "$id" generation is the same of UnitOfWork#createEntity. Remove this duplication somehow
     */
    protected function registerManaged(ClassMetadata $class, $entity, array $data)
    {
        if ($class->isIdentifierComposite) {
            $id = [];

            foreach ($class->identifier as $fieldName) {
                $id[$fieldName] = isset($class->associationMappings[$fieldName])
                    ? $data[$class->associationMappings[$fieldName]['joinColumns'][0]['name']]
                    : $data[$fieldName];
            }
        } else {
            $fieldName = $class->identifier[0];
            $id        = [
                $fieldName => isset($class->associationMappings[$fieldName])
                    ? $data[$class->associationMappings[$fieldName]['joinColumns'][0]['name']]
                    : $data[$fieldName]
            ];
        }

        $this->_em->getUnitOfWork()->registerManaged($entity, $id, $data);
    }
}
