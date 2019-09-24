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

use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Hydrator cache entry for entities
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface EntityHydrator
{
    /**
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata The entity metadata.
     * @param \Doctrine\ORM\Cache\EntityCacheKey  $key      The entity cache key.
     * @param object                              $entity   The entity.
     *
     * @return \Doctrine\ORM\Cache\EntityCacheEntry
     */
    public function buildCacheEntry(ClassMetadata $metadata, EntityCacheKey $key, $entity);

    /**
     * @param \Doctrine\ORM\Mapping\ClassMetadata  $metadata The entity metadata.
     * @param \Doctrine\ORM\Cache\EntityCacheKey   $key      The entity cache key.
     * @param \Doctrine\ORM\Cache\EntityCacheEntry $entry    The entity cache entry.
     * @param object                               $entity   The entity to load the cache into. If not specified, a new entity is created.
     */
    public function loadCacheEntry(ClassMetadata $metadata, EntityCacheKey $key, EntityCacheEntry $entry, $entity = null);
}
