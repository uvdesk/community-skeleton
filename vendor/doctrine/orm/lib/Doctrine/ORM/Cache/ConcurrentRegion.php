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
 * Defines contract for concurrently managed data region.
 * It should be able to lock an specific cache entry in an atomic operation.
 *
 * When a entry is locked another process should not be able to read or write the entry.
 * All evict operation should not consider locks, even though an entry is locked evict should be able to delete the entry and its lock.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface ConcurrentRegion extends Region
{
    /**
     * Attempts to read lock the mapping for the given key.
     *
     * @param \Doctrine\ORM\Cache\CacheKey $key The key of the item to lock.
     *
     * @return \Doctrine\ORM\Cache\Lock A lock instance or NULL if the lock already exists.
     *
     * @throws \Doctrine\ORM\Cache\LockException Indicates a problem accessing the region.
     */
    public function lock(CacheKey $key);

    /**
     * Attempts to read unlock the mapping for the given key.
     *
     * @param \Doctrine\ORM\Cache\CacheKey $key  The key of the item to unlock.
     * @param \Doctrine\ORM\Cache\Lock     $lock The lock previously obtained from {@link readLock}
     *
     * @return void
     *
     * @throws \Doctrine\ORM\Cache\LockException Indicates a problem accessing the region.
     */
    public function unlock(CacheKey $key, Lock $lock);
}
