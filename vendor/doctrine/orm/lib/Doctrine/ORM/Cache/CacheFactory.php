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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Persisters\Collection\CollectionPersister;
use Doctrine\ORM\Persisters\Entity\EntityPersister;

/**
 * Contract for building second level cache regions components.
 * 
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface CacheFactory
{
    /**
     * Build an entity persister for the given entity metadata.
     *
     * @param \Doctrine\ORM\EntityManagerInterface            $em        The entity manager.
     * @param \Doctrine\ORM\Persisters\Entity\EntityPersister $persister The entity persister that will be cached.
     * @param \Doctrine\ORM\Mapping\ClassMetadata             $metadata  The entity metadata.
     *
     * @return \Doctrine\ORM\Cache\Persister\Entity\CachedEntityPersister
     */
    public function buildCachedEntityPersister(EntityManagerInterface $em, EntityPersister $persister, ClassMetadata $metadata);

    /**
     * Build a collection persister for the given relation mapping.
     *
     * @param \Doctrine\ORM\EntityManagerInterface                    $em        The entity manager.
     * @param \Doctrine\ORM\Persisters\Collection\CollectionPersister $persister The collection persister that will be cached.
     * @param array                                                   $mapping   The association mapping.
     *
     * @return \Doctrine\ORM\Cache\Persister\Collection\CachedCollectionPersister
     */
    public function buildCachedCollectionPersister(EntityManagerInterface $em, CollectionPersister $persister, array $mapping);

    /**
     * Build a query cache based on the given region name
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em         The Entity manager.
     * @param string                               $regionName The region name.
     *
     * @return \Doctrine\ORM\Cache\QueryCache The built query cache.
     */
    public function buildQueryCache(EntityManagerInterface $em, $regionName = null);

    /**
     * Build an entity hydrator
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em       The Entity manager.
     * @param \Doctrine\ORM\Mapping\ClassMetadata  $metadata The entity metadata.
     *
     * @return \Doctrine\ORM\Cache\EntityHydrator The built entity hydrator.
     */
    public function buildEntityHydrator(EntityManagerInterface $em, ClassMetadata $metadata);

    /**
     * Build a collection hydrator
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em      The Entity manager.
     * @param array                                $mapping The association mapping.
     *
     * @return \Doctrine\ORM\Cache\CollectionHydrator The built collection hydrator.
     */
    public function buildCollectionHydrator(EntityManagerInterface $em, array $mapping);

    /**
     * Build a cache region
     *
     * @param array $cache The cache configuration.
     *
     * @return \Doctrine\ORM\Cache\Region The cache region.
     */
    public function getRegion(array $cache);

    /**
     * Build timestamp cache region
     *
     * @return \Doctrine\ORM\Cache\TimestampRegion The timestamp region.
     */
    public function getTimestampRegion();

    /**
     * Build \Doctrine\ORM\Cache
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return \Doctrine\ORM\Cache
     */
    public function createCache(EntityManagerInterface $entityManager);
}
