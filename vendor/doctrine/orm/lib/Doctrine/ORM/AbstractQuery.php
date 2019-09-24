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

namespace Doctrine\ORM;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping\MappingException as ORMMappingException;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Cache\QueryCacheKey;
use Doctrine\DBAL\Cache\QueryCacheProfile;

/**
 * Base contract for ORM queries. Base class for Query and NativeQuery.
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Konsta Vesterinen <kvesteri@cc.hut.fi>
 */
abstract class AbstractQuery
{
    /* Hydration mode constants */

    /**
     * Hydrates an object graph. This is the default behavior.
     */
    const HYDRATE_OBJECT = 1;

    /**
     * Hydrates an array graph.
     */
    const HYDRATE_ARRAY = 2;

    /**
     * Hydrates a flat, rectangular result set with scalar values.
     */
    const HYDRATE_SCALAR = 3;

    /**
     * Hydrates a single scalar value.
     */
    const HYDRATE_SINGLE_SCALAR = 4;

    /**
     * Very simple object hydrator (optimized for performance).
     */
    const HYDRATE_SIMPLEOBJECT = 5;

    /**
     * The parameter map of this query.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $parameters;

    /**
     * The user-specified ResultSetMapping to use.
     *
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    protected $_resultSetMapping;

    /**
     * The entity manager used by this query object.
     *
     * @var EntityManagerInterface
     */
    protected $_em;

    /**
     * The map of query hints.
     *
     * @var array
     */
    protected $_hints = [];

    /**
     * The hydration mode.
     *
     * @var string|int
     */
    protected $_hydrationMode = self::HYDRATE_OBJECT;

    /**
     * @var \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    protected $_queryCacheProfile;

    /**
     * Whether or not expire the result cache.
     *
     * @var boolean
     */
    protected $_expireResultCache = false;

    /**
     * @var \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    protected $_hydrationCacheProfile;

    /**
     * Whether to use second level cache, if available.
     *
     * @var boolean
     */
    protected $cacheable = false;

    /**
     * @var boolean
     */
    protected $hasCache = false;

    /**
     * Second level cache region name.
     *
     * @var string|null
     */
    protected $cacheRegion;

    /**
     * Second level query cache mode.
     *
     * @var integer|null
     */
    protected $cacheMode;

    /**
     * @var \Doctrine\ORM\Cache\Logging\CacheLogger|null
     */
    protected $cacheLogger;

    /**
     * @var integer
     */
    protected $lifetime = 0;

    /**
     * Initializes a new instance of a class derived from <tt>AbstractQuery</tt>.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->_em          = $em;
        $this->parameters   = new ArrayCollection();
        $this->_hints       = $em->getConfiguration()->getDefaultQueryHints();
        $this->hasCache     = $this->_em->getConfiguration()->isSecondLevelCacheEnabled();

        if ($this->hasCache) {
            $this->cacheLogger = $em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheLogger();
        }
    }

    /**
     * Enable/disable second level query (result) caching for this query.
     *
     * @param boolean $cacheable
     *
     * @return static This query instance.
     */
    public function setCacheable($cacheable)
    {
        $this->cacheable = (boolean) $cacheable;

        return $this;
    }

    /**
     * @return boolean TRUE if the query results are enable for second level cache, FALSE otherwise.
     */
    public function isCacheable()
    {
        return $this->cacheable;
    }

    /**
     * @param string $cacheRegion
     *
     * @return static This query instance.
     */
    public function setCacheRegion($cacheRegion)
    {
        $this->cacheRegion = (string) $cacheRegion;

        return $this;
    }

    /**
    * Obtain the name of the second level query cache region in which query results will be stored
    *
    * @return string|null The cache region name; NULL indicates the default region.
    */
    public function getCacheRegion()
    {
        return $this->cacheRegion;
    }

    /**
     * @return boolean TRUE if the query cache and second level cache are enabled, FALSE otherwise.
     */
    protected function isCacheEnabled()
    {
        return $this->cacheable && $this->hasCache;
    }

    /**
     * @return integer
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * Sets the life-time for this query into second level cache.
     *
     * @param integer $lifetime
     *
     * @return \Doctrine\ORM\AbstractQuery This query instance.
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = (integer) $lifetime;

        return $this;
    }

    /**
     * @return integer
     */
    public function getCacheMode()
    {
        return $this->cacheMode;
    }

    /**
     * @param integer $cacheMode
     *
     * @return \Doctrine\ORM\AbstractQuery This query instance.
     */
    public function setCacheMode($cacheMode)
    {
        $this->cacheMode = (integer) $cacheMode;

        return $this;
    }

    /**
     * Gets the SQL query that corresponds to this query object.
     * The returned SQL syntax depends on the connection driver that is used
     * by this query object at the time of this method call.
     *
     * @return string SQL query
     */
    abstract public function getSQL();

    /**
     * Retrieves the associated EntityManager of this Query instance.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * Frees the resources used by the query object.
     *
     * Resets Parameters, Parameter Types and Query Hints.
     *
     * @return void
     */
    public function free()
    {
        $this->parameters = new ArrayCollection();

        $this->_hints = $this->_em->getConfiguration()->getDefaultQueryHints();
    }

    /**
     * Get all defined parameters.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection The defined query parameters.
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Gets a query parameter.
     *
     * @param mixed $key The key (index or name) of the bound parameter.
     *
     * @return Query\Parameter|null The value of the bound parameter, or NULL if not available.
     */
    public function getParameter($key)
    {
        $filteredParameters = $this->parameters->filter(
            function (Query\Parameter $parameter) use ($key) : bool {
                $parameterName = $parameter->getName();

                return $key === $parameterName || (string) $key === (string) $parameterName;
            }
        );

        return ! $filteredParameters->isEmpty() ? $filteredParameters->first() : null;
    }

    /**
     * Sets a collection of query parameters.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection|array $parameters
     *
     * @return static This query instance.
     */
    public function setParameters($parameters)
    {
        // BC compatibility with 2.3-
        if (is_array($parameters)) {
            $parameterCollection = new ArrayCollection();

            foreach ($parameters as $key => $value) {
                $parameterCollection->add(new Parameter($key, $value));
            }

            $parameters = $parameterCollection;
        }

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Sets a query parameter.
     *
     * @param string|int  $key   The parameter position or name.
     * @param mixed       $value The parameter value.
     * @param string|null $type  The parameter type. If specified, the given value will be run through
     *                           the type conversion of this type. This is usually not needed for
     *                           strings and numeric types.
     *
     * @return static This query instance.
     */
    public function setParameter($key, $value, $type = null)
    {
        $existingParameter = $this->getParameter($key);

        if ($existingParameter !== null) {
            $existingParameter->setValue($value, $type);

            return $this;
        }

        $this->parameters->add(new Parameter($key, $value, $type));

        return $this;
    }

    /**
     * Processes an individual parameter value.
     *
     * @param mixed $value
     *
     * @return array|string
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function processParameterValue($value)
    {
        if (is_scalar($value)) {
            return $value;
        }

        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
            foreach ($value as $key => $paramValue) {
                $paramValue  = $this->processParameterValue($paramValue);
                $value[$key] = is_array($paramValue) ? reset($paramValue) : $paramValue;
            }

            return $value;
        }

        if ($value instanceof Mapping\ClassMetadata) {
            return $value->name;
        }

        if (! is_object($value)) {
            return $value;
        }

        try {
            $value = $this->_em->getUnitOfWork()->getSingleIdentifierValue($value);

            if ($value === null) {
                throw ORMInvalidArgumentException::invalidIdentifierBindingEntity();
            }
        } catch (MappingException | ORMMappingException $e) {
            // Silence any mapping exceptions. These can occur if the object in
            // question is not a mapped entity, in which case we just don't do
            // any preparation on the value.
        }

        return $value;
    }

    /**
     * Sets the ResultSetMapping that should be used for hydration.
     *
     * @param \Doctrine\ORM\Query\ResultSetMapping $rsm
     *
     * @return static This query instance.
     */
    public function setResultSetMapping(Query\ResultSetMapping $rsm)
    {
        $this->translateNamespaces($rsm);
        $this->_resultSetMapping = $rsm;

        return $this;
    }

    /**
     * Gets the ResultSetMapping used for hydration.
     *
     * @return \Doctrine\ORM\Query\ResultSetMapping
     */
    protected function getResultSetMapping()
    {
        return $this->_resultSetMapping;
    }

    /**
     * Allows to translate entity namespaces to full qualified names.
     *
     * @param Query\ResultSetMapping $rsm
     *
     * @return void
     */
    private function translateNamespaces(Query\ResultSetMapping $rsm)
    {
        $translate = function ($alias) {
            return $this->_em->getClassMetadata($alias)->getName();
        };

        $rsm->aliasMap = array_map($translate, $rsm->aliasMap);
        $rsm->declaringClasses = array_map($translate, $rsm->declaringClasses);
    }

    /**
     * Set a cache profile for hydration caching.
     *
     * If no result cache driver is set in the QueryCacheProfile, the default
     * result cache driver is used from the configuration.
     *
     * Important: Hydration caching does NOT register entities in the
     * UnitOfWork when retrieved from the cache. Never use result cached
     * entities for requests that also flush the EntityManager. If you want
     * some form of caching with UnitOfWork registration you should use
     * {@see AbstractQuery::setResultCacheProfile()}.
     *
     * @example
     * $lifetime = 100;
     * $resultKey = "abc";
     * $query->setHydrationCacheProfile(new QueryCacheProfile());
     * $query->setHydrationCacheProfile(new QueryCacheProfile($lifetime, $resultKey));
     *
     * @param \Doctrine\DBAL\Cache\QueryCacheProfile $profile
     *
     * @return static This query instance.
     */
    public function setHydrationCacheProfile(QueryCacheProfile $profile = null)
    {
        if ($profile !== null && ! $profile->getResultCacheDriver()) {
            $resultCacheDriver = $this->_em->getConfiguration()->getHydrationCacheImpl();
            $profile = $profile->setResultCacheDriver($resultCacheDriver);
        }

        $this->_hydrationCacheProfile = $profile;

        return $this;
    }

    /**
     * @return \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function getHydrationCacheProfile()
    {
        return $this->_hydrationCacheProfile;
    }

    /**
     * Set a cache profile for the result cache.
     *
     * If no result cache driver is set in the QueryCacheProfile, the default
     * result cache driver is used from the configuration.
     *
     * @param \Doctrine\DBAL\Cache\QueryCacheProfile $profile
     *
     * @return static This query instance.
     */
    public function setResultCacheProfile(QueryCacheProfile $profile = null)
    {
        if ($profile !== null && ! $profile->getResultCacheDriver()) {
            $resultCacheDriver = $this->_em->getConfiguration()->getResultCacheImpl();
            $profile = $profile->setResultCacheDriver($resultCacheDriver);
        }

        $this->_queryCacheProfile = $profile;

        return $this;
    }

    /**
     * Defines a cache driver to be used for caching result sets and implicitly enables caching.
     *
     * @param \Doctrine\Common\Cache\Cache|null $resultCacheDriver Cache driver
     *
     * @return static This query instance.
     *
     * @throws ORMException
     */
    public function setResultCacheDriver($resultCacheDriver = null)
    {
        if ($resultCacheDriver !== null && ! ($resultCacheDriver instanceof \Doctrine\Common\Cache\Cache)) {
            throw ORMException::invalidResultCacheDriver();
        }

        $this->_queryCacheProfile = $this->_queryCacheProfile
            ? $this->_queryCacheProfile->setResultCacheDriver($resultCacheDriver)
            : new QueryCacheProfile(0, null, $resultCacheDriver);

        return $this;
    }

    /**
     * Returns the cache driver used for caching result sets.
     *
     * @deprecated
     *
     * @return \Doctrine\Common\Cache\Cache Cache driver
     */
    public function getResultCacheDriver()
    {
        if ($this->_queryCacheProfile && $this->_queryCacheProfile->getResultCacheDriver()) {
            return $this->_queryCacheProfile->getResultCacheDriver();
        }

        return $this->_em->getConfiguration()->getResultCacheImpl();
    }

    /**
     * Set whether or not to cache the results of this query and if so, for
     * how long and which ID to use for the cache entry.
     *
     * @param boolean $bool
     * @param integer $lifetime
     * @param string  $resultCacheId
     *
     * @return static This query instance.
     */
    public function useResultCache($bool, $lifetime = null, $resultCacheId = null)
    {
        if ($bool) {
            $this->setResultCacheLifetime($lifetime);
            $this->setResultCacheId($resultCacheId);

            return $this;
        }

        $this->_queryCacheProfile = null;

        return $this;
    }

    /**
     * Defines how long the result cache will be active before expire.
     *
     * @param integer $lifetime How long the cache entry is valid.
     *
     * @return static This query instance.
     */
    public function setResultCacheLifetime($lifetime)
    {
        $lifetime = ($lifetime !== null) ? (int) $lifetime : 0;

        $this->_queryCacheProfile = $this->_queryCacheProfile
            ? $this->_queryCacheProfile->setLifetime($lifetime)
            : new QueryCacheProfile($lifetime, null, $this->_em->getConfiguration()->getResultCacheImpl());

        return $this;
    }

    /**
     * Retrieves the lifetime of resultset cache.
     *
     * @deprecated
     *
     * @return integer
     */
    public function getResultCacheLifetime()
    {
        return $this->_queryCacheProfile ? $this->_queryCacheProfile->getLifetime() : 0;
    }

    /**
     * Defines if the result cache is active or not.
     *
     * @param boolean $expire Whether or not to force resultset cache expiration.
     *
     * @return static This query instance.
     */
    public function expireResultCache($expire = true)
    {
        $this->_expireResultCache = $expire;

        return $this;
    }

    /**
     * Retrieves if the resultset cache is active or not.
     *
     * @return boolean
     */
    public function getExpireResultCache()
    {
        return $this->_expireResultCache;
    }

    /**
     * @return QueryCacheProfile
     */
    public function getQueryCacheProfile()
    {
        return $this->_queryCacheProfile;
    }

    /**
     * Change the default fetch mode of an association for this query.
     *
     * $fetchMode can be one of ClassMetadata::FETCH_EAGER or ClassMetadata::FETCH_LAZY
     *
     * @param string $class
     * @param string $assocName
     * @param int    $fetchMode
     *
     * @return static This query instance.
     */
    public function setFetchMode($class, $assocName, $fetchMode)
    {
        if ($fetchMode !== Mapping\ClassMetadata::FETCH_EAGER) {
            $fetchMode = Mapping\ClassMetadata::FETCH_LAZY;
        }

        $this->_hints['fetchMode'][$class][$assocName] = $fetchMode;

        return $this;
    }

    /**
     * Defines the processing mode to be used during hydration / result set transformation.
     *
     * @param string|int $hydrationMode Doctrine processing mode to be used during hydration process.
     *                                  One of the Query::HYDRATE_* constants.
     *
     * @return static This query instance.
     */
    public function setHydrationMode($hydrationMode)
    {
        $this->_hydrationMode = $hydrationMode;

        return $this;
    }

    /**
     * Gets the hydration mode currently used by the query.
     *
     * @return string|int
     */
    public function getHydrationMode()
    {
        return $this->_hydrationMode;
    }

    /**
     * Gets the list of results for the query.
     *
     * Alias for execute(null, $hydrationMode = HYDRATE_OBJECT).
     *
     * @param string|int $hydrationMode
     *
     * @return mixed
     */
    public function getResult($hydrationMode = self::HYDRATE_OBJECT)
    {
        return $this->execute(null, $hydrationMode);
    }

    /**
     * Gets the array of results for the query.
     *
     * Alias for execute(null, HYDRATE_ARRAY).
     *
     * @return array
     */
    public function getArrayResult()
    {
        return $this->execute(null, self::HYDRATE_ARRAY);
    }

    /**
     * Gets the scalar results for the query.
     *
     * Alias for execute(null, HYDRATE_SCALAR).
     *
     * @return array
     */
    public function getScalarResult()
    {
        return $this->execute(null, self::HYDRATE_SCALAR);
    }

    /**
     * Get exactly one result or null.
     *
     * @param string|int $hydrationMode
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function getOneOrNullResult($hydrationMode = null)
    {
        try {
            $result = $this->execute(null, $hydrationMode);
        } catch (NoResultException $e) {
            return null;
        }


        if ($this->_hydrationMode !== self::HYDRATE_SINGLE_SCALAR && ! $result) {
            return null;
        }

        if ( ! is_array($result)) {
            return $result;
        }

        if (count($result) > 1) {
            throw new NonUniqueResultException;
        }

        return array_shift($result);
    }

    /**
     * Gets the single result of the query.
     *
     * Enforces the presence as well as the uniqueness of the result.
     *
     * If the result is not unique, a NonUniqueResultException is thrown.
     * If there is no result, a NoResultException is thrown.
     *
     * @param string|int $hydrationMode
     *
     * @return mixed
     *
     * @throws NonUniqueResultException If the query result is not unique.
     * @throws NoResultException        If the query returned no result and hydration mode is not HYDRATE_SINGLE_SCALAR.
     */
    public function getSingleResult($hydrationMode = null)
    {
        $result = $this->execute(null, $hydrationMode);

        if ($this->_hydrationMode !== self::HYDRATE_SINGLE_SCALAR && ! $result) {
            throw new NoResultException;
        }

        if ( ! is_array($result)) {
            return $result;
        }

        if (count($result) > 1) {
            throw new NonUniqueResultException;
        }

        return array_shift($result);
    }

    /**
     * Gets the single scalar result of the query.
     *
     * Alias for getSingleResult(HYDRATE_SINGLE_SCALAR).
     *
     * @return mixed The scalar result, or NULL if the query returned no result.
     *
     * @throws NonUniqueResultException If the query result is not unique.
     */
    public function getSingleScalarResult()
    {
        return $this->getSingleResult(self::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Sets a query hint. If the hint name is not recognized, it is silently ignored.
     *
     * @param string $name  The name of the hint.
     * @param mixed  $value The value of the hint.
     *
     * @return static This query instance.
     */
    public function setHint($name, $value)
    {
        $this->_hints[$name] = $value;

        return $this;
    }

    /**
     * Gets the value of a query hint. If the hint name is not recognized, FALSE is returned.
     *
     * @param string $name The name of the hint.
     *
     * @return mixed The value of the hint or FALSE, if the hint name is not recognized.
     */
    public function getHint($name)
    {
        return isset($this->_hints[$name]) ? $this->_hints[$name] : false;
    }

    /**
     * Check if the query has a hint
     *
     * @param string $name The name of the hint
     *
     * @return bool False if the query does not have any hint
     */
    public function hasHint($name)
    {
        return isset($this->_hints[$name]);
    }

    /**
     * Return the key value map of query hints that are currently set.
     *
     * @return array
     */
    public function getHints()
    {
        return $this->_hints;
    }

    /**
     * Executes the query and returns an IterableResult that can be used to incrementally
     * iterate over the result.
     *
     * @param ArrayCollection|array|null $parameters    The query parameters.
     * @param string|int|null            $hydrationMode The hydration mode to use.
     *
     * @return \Doctrine\ORM\Internal\Hydration\IterableResult
     */
    public function iterate($parameters = null, $hydrationMode = null)
    {
        if ($hydrationMode !== null) {
            $this->setHydrationMode($hydrationMode);
        }

        if ( ! empty($parameters)) {
            $this->setParameters($parameters);
        }

        $rsm  = $this->getResultSetMapping();
        $stmt = $this->_doExecute();

        return $this->_em->newHydrator($this->_hydrationMode)->iterate($stmt, $rsm, $this->_hints);
    }

    /**
     * Executes the query.
     *
     * @param ArrayCollection|array|null $parameters Query parameters.
     * @param string|int|null            $hydrationMode Processing mode to be used during the hydration process.
     *
     * @return mixed
     */
    public function execute($parameters = null, $hydrationMode = null)
    {
        if ($this->cacheable && $this->isCacheEnabled()) {
            return $this->executeUsingQueryCache($parameters, $hydrationMode);
        }

        return $this->executeIgnoreQueryCache($parameters, $hydrationMode);
    }

    /**
     * Execute query ignoring second level cache.
     *
     * @param ArrayCollection|array|null $parameters
     * @param string|int|null            $hydrationMode
     *
     * @return mixed
     */
    private function executeIgnoreQueryCache($parameters = null, $hydrationMode = null)
    {
        if ($hydrationMode !== null) {
            $this->setHydrationMode($hydrationMode);
        }

        if ( ! empty($parameters)) {
            $this->setParameters($parameters);
        }

        $setCacheEntry = function() {};

        if ($this->_hydrationCacheProfile !== null) {
            list($cacheKey, $realCacheKey) = $this->getHydrationCacheId();

            $queryCacheProfile = $this->getHydrationCacheProfile();
            $cache             = $queryCacheProfile->getResultCacheDriver();
            $result            = $cache->fetch($cacheKey);

            if (isset($result[$realCacheKey])) {
                return $result[$realCacheKey];
            }

            if ( ! $result) {
                $result = [];
            }

            $setCacheEntry = function($data) use ($cache, $result, $cacheKey, $realCacheKey, $queryCacheProfile) {
                $result[$realCacheKey] = $data;

                $cache->save($cacheKey, $result, $queryCacheProfile->getLifetime());
            };
        }

        $stmt = $this->_doExecute();

        if (is_numeric($stmt)) {
            $setCacheEntry($stmt);

            return $stmt;
        }

        $rsm  = $this->getResultSetMapping();
        $data = $this->_em->newHydrator($this->_hydrationMode)->hydrateAll($stmt, $rsm, $this->_hints);

        $setCacheEntry($data);

        return $data;
    }

    /**
     * Load from second level cache or executes the query and put into cache.
     *
     * @param ArrayCollection|array|null $parameters
     * @param string|int|null            $hydrationMode
     *
     * @return mixed
     */
    private function executeUsingQueryCache($parameters = null, $hydrationMode = null)
    {
        $rsm        = $this->getResultSetMapping();
        $queryCache = $this->_em->getCache()->getQueryCache($this->cacheRegion);
        $queryKey   = new QueryCacheKey(
            $this->getHash(),
            $this->lifetime,
            $this->cacheMode ?: Cache::MODE_NORMAL,
            $this->getTimestampKey()
        );

        $result     = $queryCache->get($queryKey, $rsm, $this->_hints);

        if ($result !== null) {
            if ($this->cacheLogger) {
                $this->cacheLogger->queryCacheHit($queryCache->getRegion()->getName(), $queryKey);
            }

            return $result;
        }

        $result = $this->executeIgnoreQueryCache($parameters, $hydrationMode);
        $cached = $queryCache->put($queryKey, $rsm, $result, $this->_hints);

        if ($this->cacheLogger) {
            $this->cacheLogger->queryCacheMiss($queryCache->getRegion()->getName(), $queryKey);

            if ($cached) {
                $this->cacheLogger->queryCachePut($queryCache->getRegion()->getName(), $queryKey);
            }
        }

        return $result;
    }

    /**
     * @return \Doctrine\ORM\Cache\TimestampCacheKey|null
     */
    private function getTimestampKey()
    {
        $entityName = reset($this->_resultSetMapping->aliasMap);

        if (empty($entityName)) {
            return null;
        }

        $metadata = $this->_em->getClassMetadata($entityName);

        return new Cache\TimestampCacheKey($metadata->rootEntityName);
    }

    /**
     * Get the result cache id to use to store the result set cache entry.
     * Will return the configured id if it exists otherwise a hash will be
     * automatically generated for you.
     *
     * @return array ($key, $hash)
     */
    protected function getHydrationCacheId()
    {
        $parameters = [];

        foreach ($this->getParameters() as $parameter) {
            $parameters[$parameter->getName()] = $this->processParameterValue($parameter->getValue());
        }

        $sql                    = $this->getSQL();
        $queryCacheProfile      = $this->getHydrationCacheProfile();
        $hints                  = $this->getHints();
        $hints['hydrationMode'] = $this->getHydrationMode();

        ksort($hints);

        return $queryCacheProfile->generateCacheKeys($sql, $parameters, $hints);
    }

    /**
     * Set the result cache id to use to store the result set cache entry.
     * If this is not explicitly set by the developer then a hash is automatically
     * generated for you.
     *
     * @param string $id
     *
     * @return static This query instance.
     */
    public function setResultCacheId($id)
    {
        $this->_queryCacheProfile = $this->_queryCacheProfile
            ? $this->_queryCacheProfile->setCacheKey($id)
            : new QueryCacheProfile(0, $id, $this->_em->getConfiguration()->getResultCacheImpl());

        return $this;
    }

    /**
     * Get the result cache id to use to store the result set cache entry if set.
     *
     * @deprecated
     *
     * @return string
     */
    public function getResultCacheId()
    {
        return $this->_queryCacheProfile ? $this->_queryCacheProfile->getCacheKey() : null;
    }

    /**
     * Executes the query and returns a the resulting Statement object.
     *
     * @return \Doctrine\DBAL\Driver\Statement The executed database statement that holds the results.
     */
    abstract protected function _doExecute();

    /**
     * Cleanup Query resource when clone is called.
     *
     * @return void
     */
    public function __clone()
    {
        $this->parameters = new ArrayCollection();

        $this->_hints = [];
        $this->_hints = $this->_em->getConfiguration()->getDefaultQueryHints();
    }

    /**
     * Generates a string of currently query to use for the cache second level cache.
     *
     * @return string
     */
    protected function getHash()
    {
        $query  = $this->getSQL();
        $hints  = $this->getHints();
        $params = array_map(function(Parameter $parameter) {
            // Small optimization
            // Does not invoke processParameterValue for scalar values
            if (is_scalar($value = $parameter->getValue())) {
                return $value;
            }

            return $this->processParameterValue($value);
        }, $this->parameters->getValues());

        ksort($hints);

        return sha1($query . '-' . serialize($params) . '-' . serialize($hints));
    }
}
