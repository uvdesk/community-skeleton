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
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class TimestampQueryCacheValidator implements QueryCacheValidator
{
    /**
     * @var TimestampRegion
     */
    private $timestampRegion;

    /**
     * @param TimestampRegion $timestampRegion
     */
    public function __construct(TimestampRegion $timestampRegion)
    {
        $this->timestampRegion = $timestampRegion;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(QueryCacheKey $key, QueryCacheEntry $entry)
    {
        if ($this->regionUpdated($key, $entry)) {
            return false;
        }

        if ($key->lifetime == 0) {
            return true;
        }

        return ($entry->time + $key->lifetime) > microtime(true);
    }

    /**
     * @param QueryCacheKey   $key
     * @param QueryCacheEntry $entry
     *
     * @return bool
     */
    private function regionUpdated(QueryCacheKey $key, QueryCacheEntry $entry)
    {
        if ($key->timestampKey === null) {
            return false;
        }

        $timestamp = $this->timestampRegion->get($key->timestampKey);

        return $timestamp && $timestamp->time > $entry->time;
    }
}
