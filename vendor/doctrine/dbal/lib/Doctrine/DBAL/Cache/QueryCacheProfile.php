<?php

namespace Doctrine\DBAL\Cache;

use Doctrine\Common\Cache\Cache;
use function hash;
use function serialize;
use function sha1;

/**
 * Query Cache Profile handles the data relevant for query caching.
 *
 * It is a value object, setter methods return NEW instances.
 */
class QueryCacheProfile
{
    /** @var Cache|null */
    private $resultCacheDriver;

    /** @var int */
    private $lifetime = 0;

    /** @var string|null */
    private $cacheKey;

    /**
     * @param int         $lifetime
     * @param string|null $cacheKey
     */
    public function __construct($lifetime = 0, $cacheKey = null, ?Cache $resultCache = null)
    {
        $this->lifetime          = $lifetime;
        $this->cacheKey          = $cacheKey;
        $this->resultCacheDriver = $resultCache;
    }

    /**
     * @return Cache|null
     */
    public function getResultCacheDriver()
    {
        return $this->resultCacheDriver;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @return string
     *
     * @throws CacheException
     */
    public function getCacheKey()
    {
        if ($this->cacheKey === null) {
            throw CacheException::noCacheKey();
        }

        return $this->cacheKey;
    }

    /**
     * Generates the real cache key from query, params, types and connection parameters.
     *
     * @param string         $query
     * @param mixed[]        $params
     * @param int[]|string[] $types
     * @param mixed[]        $connectionParams
     *
     * @return string[]
     */
    public function generateCacheKeys($query, $params, $types, array $connectionParams = [])
    {
        $realCacheKey = 'query=' . $query .
            '&params=' . serialize($params) .
            '&types=' . serialize($types) .
            '&connectionParams=' . hash('sha256', serialize($connectionParams));

        // should the key be automatically generated using the inputs or is the cache key set?
        if ($this->cacheKey === null) {
            $cacheKey = sha1($realCacheKey);
        } else {
            $cacheKey = $this->cacheKey;
        }

        return [$cacheKey, $realCacheKey];
    }

    /**
     * @return \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setResultCacheDriver(Cache $cache)
    {
        return new QueryCacheProfile($this->lifetime, $this->cacheKey, $cache);
    }

    /**
     * @param string|null $cacheKey
     *
     * @return \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setCacheKey($cacheKey)
    {
        return new QueryCacheProfile($this->lifetime, $cacheKey, $this->resultCacheDriver);
    }

    /**
     * @param int $lifetime
     *
     * @return \Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setLifetime($lifetime)
    {
        return new QueryCacheProfile($lifetime, $this->cacheKey, $this->resultCacheDriver);
    }
}
