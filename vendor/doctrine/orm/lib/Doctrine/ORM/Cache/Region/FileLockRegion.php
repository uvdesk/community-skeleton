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

namespace Doctrine\ORM\Cache\Region;

use Doctrine\ORM\Cache\CollectionCacheEntry;
use Doctrine\ORM\Cache\Lock;
use Doctrine\ORM\Cache\Region;
use Doctrine\ORM\Cache\CacheKey;
use Doctrine\ORM\Cache\CacheEntry;
use Doctrine\ORM\Cache\ConcurrentRegion;

/**
 * Very naive concurrent region, based on file locks.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silvagmail.com>
 */
class FileLockRegion implements ConcurrentRegion
{
    const LOCK_EXTENSION = 'lock';

    /**
     * var \Doctrine\ORM\Cache\Region
     */
    private $region;

    /**
     * @var string
     */
    private $directory;

    /**
     * var integer
     */
    private $lockLifetime;

    /**
     * @param \Doctrine\ORM\Cache\Region $region
     * @param string                     $directory
     * @param string                     $lockLifetime
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Region $region, $directory, $lockLifetime)
    {
        if ( ! is_dir($directory) && ! @mkdir($directory, 0775, true)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" does not exist and could not be created.', $directory));
        }

        if ( ! is_writable($directory)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" is not writable.', $directory));
        }

        $this->region       = $region;
        $this->directory    = $directory;
        $this->lockLifetime = $lockLifetime;
    }

    /**
     * @param \Doctrine\ORM\Cache\CacheKey $key
     * @param \Doctrine\ORM\Cache\Lock     $lock
     *
     * @return boolean
     */
    private function isLocked(CacheKey $key, Lock $lock = null)
    {
        $filename = $this->getLockFileName($key);

        if ( ! is_file($filename)) {
            return false;
        }

        $time     = $this->getLockTime($filename);
        $content  = $this->getLockContent($filename);

        if ( ! $content || ! $time) {
            @unlink($filename);

            return false;
        }

        if ($lock && $content === $lock->value) {
            return false;
        }

        // outdated lock
        if (($time + $this->lockLifetime) <= time()) {
            @unlink($filename);

            return false;
        }

        return true;
    }

    /**
     * @param \Doctrine\ORM\Cache\CacheKey $key
     *
     * @return string
     */
    private function getLockFileName(CacheKey $key)
    {
        return $this->directory . DIRECTORY_SEPARATOR . $key->hash . '.' . self::LOCK_EXTENSION;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    private function getLockContent($filename)
    {
        return @file_get_contents($filename);
    }

    /**
     * @param string $filename
     *
     * @return integer
     */
    private function getLockTime($filename)
    {
        return @fileatime($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->region->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function contains(CacheKey $key)
    {
        if ($this->isLocked($key)) {
            return false;
        }

        return $this->region->contains($key);
    }

    /**
     * {@inheritdoc}
     */
    public function get(CacheKey $key)
    {
        if ($this->isLocked($key)) {
            return null;
        }

        return $this->region->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getMultiple(CollectionCacheEntry $collection)
    {
        if (array_filter(array_map([$this, 'isLocked'], $collection->identifiers))) {
            return null;
        }

        return $this->region->getMultiple($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function put(CacheKey $key, CacheEntry $entry, Lock $lock = null)
    {
        if ($this->isLocked($key, $lock)) {
            return false;
        }

        return $this->region->put($key, $entry);
    }

    /**
     * {@inheritdoc}
     */
    public function evict(CacheKey $key)
    {
        if ($this->isLocked($key)) {
            @unlink($this->getLockFileName($key));
        }

        return $this->region->evict($key);
    }

    /**
     * {@inheritdoc}
     */
    public function evictAll()
    {
        // The check below is necessary because on some platforms glob returns false
        // when nothing matched (even though no errors occurred)
        $filenames = glob(sprintf("%s/*.%s" , $this->directory, self::LOCK_EXTENSION));

        if ($filenames) {
            foreach ($filenames as $filename) {
                @unlink($filename);
            }
        }

        return $this->region->evictAll();
    }

    /**
     * {@inheritdoc}
     */
    public function lock(CacheKey $key)
    {
        if ($this->isLocked($key)) {
            return null;
        }

        $lock     = Lock::createLockRead();
        $filename = $this->getLockFileName($key);

        if ( ! @file_put_contents($filename, $lock->value, LOCK_EX)) {
            return null;
        }
        chmod($filename, 0664);

        return $lock;
    }

    /**
     * {@inheritdoc}
     */
    public function unlock(CacheKey $key, Lock $lock)
    {
        if ($this->isLocked($key, $lock)) {
            return false;
        }

        if ( ! @unlink($this->getLockFileName($key))) {
            return false;
        }

        return true;
    }
}
