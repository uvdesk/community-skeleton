<?php

namespace Doctrine\DBAL\Cache;

use Doctrine\DBAL\DBALException;

class CacheException extends DBALException
{
    /**
     * @return \Doctrine\DBAL\Cache\CacheException
     */
    public static function noCacheKey()
    {
        return new self('No cache key was set.');
    }

    /**
     * @return \Doctrine\DBAL\Cache\CacheException
     */
    public static function noResultDriverConfigured()
    {
        return new self('Trying to cache a query but no result driver is configured.');
    }
}
