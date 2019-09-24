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

namespace Doctrine\ORM\Cache\Logging;

use Doctrine\ORM\Cache\CollectionCacheKey;
use Doctrine\ORM\Cache\EntityCacheKey;
use Doctrine\ORM\Cache\QueryCacheKey;

/**
 * Cache logger chain
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class CacheLoggerChain implements CacheLogger
{
    /**
     * @var array<\Doctrine\ORM\Cache\Logging\CacheLogger>
     */
    private $loggers = [];

    /**
     * @param string                                  $name
     * @param \Doctrine\ORM\Cache\Logging\CacheLogger $logger
     */
    public function setLogger($name, CacheLogger $logger)
    {
        $this->loggers[$name] = $logger;
    }

    /**
     * @param string $name
     *
     * @return \Doctrine\ORM\Cache\Logging\CacheLogger|null
     */
    public function getLogger($name)
    {
        return isset($this->loggers[$name]) ? $this->loggers[$name] : null;
    }

    /**
     * @return array<\Doctrine\ORM\Cache\Logging\CacheLogger>
     */
    public function getLoggers()
    {
        return $this->loggers;
    }

    /**
     * {@inheritdoc}
     */
    public function collectionCacheHit($regionName, CollectionCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->collectionCacheHit($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collectionCacheMiss($regionName, CollectionCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->collectionCacheMiss($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collectionCachePut($regionName, CollectionCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->collectionCachePut($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function entityCacheHit($regionName, EntityCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->entityCacheHit($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function entityCacheMiss($regionName, EntityCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->entityCacheMiss($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function entityCachePut($regionName, EntityCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->entityCachePut($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function queryCacheHit($regionName, QueryCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->queryCacheHit($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function queryCacheMiss($regionName, QueryCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->queryCacheMiss($regionName, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function queryCachePut($regionName, QueryCacheKey $key)
    {
        foreach ($this->loggers as $logger) {
            $logger->queryCachePut($regionName, $key);
        }
    }
}
