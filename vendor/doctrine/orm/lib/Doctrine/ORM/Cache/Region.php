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

namespace Doctrine\ORM\Cache;

/**
 * Defines a contract for accessing a particular named region.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface Region extends MultiGetRegion
{
    /**
     * Retrieve the name of this region.
     *
     * @return string The region name
     */
    public function getName();

    /**
     * Determine whether this region contains data for the given key.
     *
     * @param \Doctrine\ORM\Cache\CacheKey $key The cache key
     *
     * @return boolean TRUE if the underlying cache contains corresponding data; FALSE otherwise.
     */
    public function contains(CacheKey $key);

    /**
     * Get an item from the cache.
     *
     * @param \Doctrine\ORM\Cache\CacheKey $key The key of the item to be retrieved.
     *
     * @return \Doctrine\ORM\Cache\CacheEntry|null The cached entry or NULL
     *
     * @throws \Doctrine\ORM\Cache\CacheException Indicates a problem accessing the item or region.
     */
    public function get(CacheKey $key);

    /**
     * Put an item into the cache.
     *
     * @param \Doctrine\ORM\Cache\CacheKey   $key   The key under which to cache the item.
     * @param \Doctrine\ORM\Cache\CacheEntry $entry The entry to cache.
     * @param \Doctrine\ORM\Cache\Lock       $lock  The lock previously obtained.
     *
     * @throws \Doctrine\ORM\Cache\CacheException Indicates a problem accessing the region.
     */
    public function put(CacheKey $key, CacheEntry $entry, Lock $lock = null);

    /**
     * Remove an item from the cache.
     *
     * @param \Doctrine\ORM\Cache\CacheKey $key The key under which to cache the item.
     *
     * @throws \Doctrine\ORM\Cache\CacheException Indicates a problem accessing the region.
     */
    public function evict(CacheKey $key);

    /**
     * Remove all contents of this particular cache region.
     *
     * @throws \Doctrine\ORM\Cache\CacheException Indicates problem accessing the region.
     */
    public function evictAll();
}
