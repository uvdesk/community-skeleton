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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\Common\PropertyChangedListener;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Cache\Persister\CachedPersister;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\ListenersInvoker;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Internal\HydrationCompleteHandler;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Reflection\ReflectionPropertiesGetter;
use Doctrine\ORM\Persisters\Collection\ManyToManyPersister;
use Doctrine\ORM\Persisters\Collection\OneToManyPersister;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
use Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister;
use Doctrine\ORM\Persisters\Entity\SingleTablePersister;
use Doctrine\ORM\Proxy\Proxy;
use Doctrine\ORM\Utility\IdentifierFlattener;
use InvalidArgumentException;
use Throwable;
use UnexpectedValueException;

/**
 * The UnitOfWork is responsible for tracking changes to objects during an
 * "object-level" transaction and for writing out changes to the database
 * in the correct order.
 *
 * Internal note: This class contains highly performance-sensitive code.
 *
 * @since       2.0
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 * @author      Rob Caiger <rob@clocal.co.uk>
 */
class UnitOfWork implements PropertyChangedListener
{
    /**
     * An entity is in MANAGED state when its persistence is managed by an EntityManager.
     */
    const STATE_MANAGED = 1;

    /**
     * An entity is new if it has just been instantiated (i.e. using the "new" operator)
     * and is not (yet) managed by an EntityManager.
     */
    const STATE_NEW = 2;

    /**
     * A detached entity is an instance with persistent state and identity that is not
     * (or no longer) associated with an EntityManager (and a UnitOfWork).
     */
    const STATE_DETACHED = 3;

    /**
     * A removed entity instance is an instance with a persistent identity,
     * associated with an EntityManager, whose persistent state will be deleted
     * on commit.
     */
    const STATE_REMOVED = 4;

    /**
     * Hint used to collect all primary keys of associated entities during hydration
     * and execute it in a dedicated query afterwards
     * @see https://doctrine-orm.readthedocs.org/en/latest/reference/dql-doctrine-query-language.html?highlight=eager#temporarily-change-fetch-mode-in-dql
     */
    const HINT_DEFEREAGERLOAD = 'deferEagerLoad';

    /**
     * The identity map that holds references to all managed entities that have
     * an identity. The entities are grouped by their class name.
     * Since all classes in a hierarchy must share the same identifier set,
     * we always take the root class name of the hierarchy.
     *
     * @var array
     */
    private $identityMap = [];

    /**
     * Map of all identifiers of managed entities.
     * Keys are object ids (spl_object_hash).
     *
     * @var array
     */
    private $entityIdentifiers = [];

    /**
     * Map of the original entity data of managed entities.
     * Keys are object ids (spl_object_hash). This is used for calculating changesets
     * at commit time.
     *
     * Internal note: Note that PHPs "copy-on-write" behavior helps a lot with memory usage.
     *                A value will only really be copied if the value in the entity is modified
     *                by the user.
     *
     * @var array
     */
    private $originalEntityData = [];

    /**
     * Map of entity changes. Keys are object ids (spl_object_hash).
     * Filled at the beginning of a commit of the UnitOfWork and cleaned at the end.
     *
     * @var array
     */
    private $entityChangeSets = [];

    /**
     * The (cached) states of any known entities.
     * Keys are object ids (spl_object_hash).
     *
     * @var array
     */
    private $entityStates = [];

    /**
     * Map of entities that are scheduled for dirty checking at commit time.
     * This is only used for entities with a change tracking policy of DEFERRED_EXPLICIT.
     * Keys are object ids (spl_object_hash).
     *
     * @var array
     */
    private $scheduledForSynchronization = [];

    /**
     * A list of all pending entity insertions.
     *
     * @var array
     */
    private $entityInsertions = [];

    /**
     * A list of all pending entity updates.
     *
     * @var array
     */
    private $entityUpdates = [];

    /**
     * Any pending extra updates that have been scheduled by persisters.
     *
     * @var array
     */
    private $extraUpdates = [];

    /**
     * A list of all pending entity deletions.
     *
     * @var array
     */
    private $entityDeletions = [];

    /**
     * New entities that were discovered through relationships that were not
     * marked as cascade-persist. During flush, this array is populated and
     * then pruned of any entities that were discovered through a valid
     * cascade-persist path. (Leftovers cause an error.)
     *
     * Keys are OIDs, payload is a two-item array describing the association
     * and the entity.
     *
     * @var object[][]|array[][] indexed by respective object spl_object_hash()
     */
    private $nonCascadedNewDetectedEntities = [];

    /**
     * All pending collection deletions.
     *
     * @var array
     */
    private $collectionDeletions = [];

    /**
     * All pending collection updates.
     *
     * @var array
     */
    private $collectionUpdates = [];

    /**
     * List of collections visited during changeset calculation on a commit-phase of a UnitOfWork.
     * At the end of the UnitOfWork all these collections will make new snapshots
     * of their data.
     *
     * @var array
     */
    private $visitedCollections = [];

    /**
     * The EntityManager that "owns" this UnitOfWork instance.
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * The entity persister instances used to persist entity instances.
     *
     * @var array
     */
    private $persisters = [];

    /**
     * The collection persister instances used to persist collections.
     *
     * @var array
     */
    private $collectionPersisters = [];

    /**
     * The EventManager used for dispatching events.
     *
     * @var \Doctrine\Common\EventManager
     */
    private $evm;

    /**
     * The ListenersInvoker used for dispatching events.
     *
     * @var \Doctrine\ORM\Event\ListenersInvoker
     */
    private $listenersInvoker;

    /**
     * The IdentifierFlattener used for manipulating identifiers
     *
     * @var \Doctrine\ORM\Utility\IdentifierFlattener
     */
    private $identifierFlattener;

    /**
     * Orphaned entities that are scheduled for removal.
     *
     * @var array
     */
    private $orphanRemovals = [];

    /**
     * Read-Only objects are never evaluated
     *
     * @var array
     */
    private $readOnlyObjects = [];

    /**
     * Map of Entity Class-Names and corresponding IDs that should eager loaded when requested.
     *
     * @var array
     */
    private $eagerLoadingEntities = [];

    /**
     * @var boolean
     */
    protected $hasCache = false;

    /**
     * Helper for handling completion of hydration
     *
     * @var HydrationCompleteHandler
     */
    private $hydrationCompleteHandler;

    /**
     * @var ReflectionPropertiesGetter
     */
    private $reflectionPropertiesGetter;

    /**
     * Initializes a new UnitOfWork instance, bound to the given EntityManager.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em                         = $em;
        $this->evm                        = $em->getEventManager();
        $this->listenersInvoker           = new ListenersInvoker($em);
        $this->hasCache                   = $em->getConfiguration()->isSecondLevelCacheEnabled();
        $this->identifierFlattener        = new IdentifierFlattener($this, $em->getMetadataFactory());
        $this->hydrationCompleteHandler   = new HydrationCompleteHandler($this->listenersInvoker, $em);
        $this->reflectionPropertiesGetter = new ReflectionPropertiesGetter(new RuntimeReflectionService());
    }

    /**
     * Commits the UnitOfWork, executing all operations that have been postponed
     * up to this point. The state of all managed entities will be synchronized with
     * the database.
     *
     * The operations are executed in the following order:
     *
     * 1) All entity insertions
     * 2) All entity updates
     * 3) All collection deletions
     * 4) All collection updates
     * 5) All entity deletions
     *
     * @param null|object|array $entity
     *
     * @return void
     *
     * @throws \Exception
     */
    public function commit($entity = null)
    {
        // Raise preFlush
        if ($this->evm->hasListeners(Events::preFlush)) {
            $this->evm->dispatchEvent(Events::preFlush, new PreFlushEventArgs($this->em));
        }

        // Compute changes done since last commit.
        if (null === $entity) {
            $this->computeChangeSets();
        } elseif (is_object($entity)) {
            $this->computeSingleEntityChangeSet($entity);
        } elseif (is_array($entity)) {
            foreach ($entity as $object) {
                $this->computeSingleEntityChangeSet($object);
            }
        }

        if ( ! ($this->entityInsertions ||
                $this->entityDeletions ||
                $this->entityUpdates ||
                $this->collectionUpdates ||
                $this->collectionDeletions ||
                $this->orphanRemovals)) {
            $this->dispatchOnFlushEvent();
            $this->dispatchPostFlushEvent();

            return; // Nothing to do.
        }

        $this->assertThatThereAreNoUnintentionallyNonPersistedAssociations();

        if ($this->orphanRemovals) {
            foreach ($this->orphanRemovals as $orphan) {
                $this->remove($orphan);
            }
        }

        $this->dispatchOnFlushEvent();

        // Now we need a commit order to maintain referential integrity
        $commitOrder = $this->getCommitOrder();

        $conn = $this->em->getConnection();
        $conn->beginTransaction();

        try {
            // Collection deletions (deletions of complete collections)
            foreach ($this->collectionDeletions as $collectionToDelete) {
                $this->getCollectionPersister($collectionToDelete->getMapping())->delete($collectionToDelete);
            }

            if ($this->entityInsertions) {
                foreach ($commitOrder as $class) {
                    $this->executeInserts($class);
                }
            }

            if ($this->entityUpdates) {
                foreach ($commitOrder as $class) {
                    $this->executeUpdates($class);
                }
            }

            // Extra updates that were requested by persisters.
            if ($this->extraUpdates) {
                $this->executeExtraUpdates();
            }

            // Collection updates (deleteRows, updateRows, insertRows)
            foreach ($this->collectionUpdates as $collectionToUpdate) {
                $this->getCollectionPersister($collectionToUpdate->getMapping())->update($collectionToUpdate);
            }

            // Entity deletions come last and need to be in reverse commit order
            if ($this->entityDeletions) {
                for ($count = count($commitOrder), $i = $count - 1; $i >= 0 && $this->entityDeletions; --$i) {
                    $this->executeDeletions($commitOrder[$i]);
                }
            }

            $conn->commit();
        } catch (Throwable $e) {
            $this->em->close();
            $conn->rollBack();

            $this->afterTransactionRolledBack();

            throw $e;
        }

        $this->afterTransactionComplete();

        // Take new snapshots from visited collections
        foreach ($this->visitedCollections as $coll) {
            $coll->takeSnapshot();
        }

        $this->dispatchPostFlushEvent();

        $this->postCommitCleanup($entity);
    }

    /**
     * @param null|object|object[] $entity
     */
    private function postCommitCleanup($entity) : void
    {
        $this->entityInsertions =
        $this->entityUpdates =
        $this->entityDeletions =
        $this->extraUpdates =
        $this->collectionUpdates =
        $this->nonCascadedNewDetectedEntities =
        $this->collectionDeletions =
        $this->visitedCollections =
        $this->orphanRemovals = [];

        if (null === $entity) {
            $this->entityChangeSets = $this->scheduledForSynchronization = [];

            return;
        }

        $entities = \is_object($entity)
            ? [$entity]
            : $entity;

        foreach ($entities as $object) {
            $oid = \spl_object_hash($object);

            $this->clearEntityChangeSet($oid);

            unset($this->scheduledForSynchronization[$this->em->getClassMetadata(\get_class($object))->rootEntityName][$oid]);
        }
    }

    /**
     * Computes the changesets of all entities scheduled for insertion.
     *
     * @return void
     */
    private function computeScheduleInsertsChangeSets()
    {
        foreach ($this->entityInsertions as $entity) {
            $class = $this->em->getClassMetadata(get_class($entity));

            $this->computeChangeSet($class, $entity);
        }
    }

    /**
     * Only flushes the given entity according to a ruleset that keeps the UoW consistent.
     *
     * 1. All entities scheduled for insertion, (orphan) removals and changes in collections are processed as well!
     * 2. Read Only entities are skipped.
     * 3. Proxies are skipped.
     * 4. Only if entity is properly managed.
     *
     * @param object $entity
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function computeSingleEntityChangeSet($entity)
    {
        $state = $this->getEntityState($entity);

        if ($state !== self::STATE_MANAGED && $state !== self::STATE_REMOVED) {
            throw new \InvalidArgumentException("Entity has to be managed or scheduled for removal for single computation " . self::objToStr($entity));
        }

        $class = $this->em->getClassMetadata(get_class($entity));

        if ($state === self::STATE_MANAGED && $class->isChangeTrackingDeferredImplicit()) {
            $this->persist($entity);
        }

        // Compute changes for INSERTed entities first. This must always happen even in this case.
        $this->computeScheduleInsertsChangeSets();

        if ($class->isReadOnly) {
            return;
        }

        // Ignore uninitialized proxy objects
        if ($entity instanceof Proxy && ! $entity->__isInitialized__) {
            return;
        }

        // Only MANAGED entities that are NOT SCHEDULED FOR INSERTION OR DELETION are processed here.
        $oid = spl_object_hash($entity);

        if ( ! isset($this->entityInsertions[$oid]) && ! isset($this->entityDeletions[$oid]) && isset($this->entityStates[$oid])) {
            $this->computeChangeSet($class, $entity);
        }
    }

    /**
     * Executes any extra updates that have been scheduled.
     */
    private function executeExtraUpdates()
    {
        foreach ($this->extraUpdates as $oid => $update) {
            list ($entity, $changeset) = $update;

            $this->entityChangeSets[$oid] = $changeset;
            $this->getEntityPersister(get_class($entity))->update($entity);
        }

        $this->extraUpdates = [];
    }

    /**
     * Gets the changeset for an entity.
     *
     * @param object $entity
     *
     * @return array
     */
    public function & getEntityChangeSet($entity)
    {
        $oid  = spl_object_hash($entity);
        $data = [];

        if (!isset($this->entityChangeSets[$oid])) {
            return $data;
        }

        return $this->entityChangeSets[$oid];
    }

    /**
     * Computes the changes that happened to a single entity.
     *
     * Modifies/populates the following properties:
     *
     * {@link _originalEntityData}
     * If the entity is NEW or MANAGED but not yet fully persisted (only has an id)
     * then it was not fetched from the database and therefore we have no original
     * entity data yet. All of the current entity data is stored as the original entity data.
     *
     * {@link _entityChangeSets}
     * The changes detected on all properties of the entity are stored there.
     * A change is a tuple array where the first entry is the old value and the second
     * entry is the new value of the property. Changesets are used by persisters
     * to INSERT/UPDATE the persistent entity state.
     *
     * {@link _entityUpdates}
     * If the entity is already fully MANAGED (has been fetched from the database before)
     * and any changes to its properties are detected, then a reference to the entity is stored
     * there to mark it for an update.
     *
     * {@link _collectionDeletions}
     * If a PersistentCollection has been de-referenced in a fully MANAGED entity,
     * then this collection is marked for deletion.
     *
     * @ignore
     *
     * @internal Don't call from the outside.
     *
     * @param ClassMetadata $class  The class descriptor of the entity.
     * @param object        $entity The entity for which to compute the changes.
     *
     * @return void
     */
    public function computeChangeSet(ClassMetadata $class, $entity)
    {
        $oid = spl_object_hash($entity);

        if (isset($this->readOnlyObjects[$oid])) {
            return;
        }

        if ( ! $class->isInheritanceTypeNone()) {
            $class = $this->em->getClassMetadata(get_class($entity));
        }

        $invoke = $this->listenersInvoker->getSubscribedSystems($class, Events::preFlush) & ~ListenersInvoker::INVOKE_MANAGER;

        if ($invoke !== ListenersInvoker::INVOKE_NONE) {
            $this->listenersInvoker->invoke($class, Events::preFlush, $entity, new PreFlushEventArgs($this->em), $invoke);
        }

        $actualData = [];

        foreach ($class->reflFields as $name => $refProp) {
            $value = $refProp->getValue($entity);

            if ($class->isCollectionValuedAssociation($name) && $value !== null) {
                if ($value instanceof PersistentCollection) {
                    if ($value->getOwner() === $entity) {
                        continue;
                    }

                    $value = new ArrayCollection($value->getValues());
                }

                // If $value is not a Collection then use an ArrayCollection.
                if ( ! $value instanceof Collection) {
                    $value = new ArrayCollection($value);
                }

                $assoc = $class->associationMappings[$name];

                // Inject PersistentCollection
                $value = new PersistentCollection(
                    $this->em, $this->em->getClassMetadata($assoc['targetEntity']), $value
                );
                $value->setOwner($entity, $assoc);
                $value->setDirty( ! $value->isEmpty());

                $class->reflFields[$name]->setValue($entity, $value);

                $actualData[$name] = $value;

                continue;
            }

            if (( ! $class->isIdentifier($name) || ! $class->isIdGeneratorIdentity()) && ($name !== $class->versionField)) {
                $actualData[$name] = $value;
            }
        }

        if ( ! isset($this->originalEntityData[$oid])) {
            // Entity is either NEW or MANAGED but not yet fully persisted (only has an id).
            // These result in an INSERT.
            $this->originalEntityData[$oid] = $actualData;
            $changeSet = [];

            foreach ($actualData as $propName => $actualValue) {
                if ( ! isset($class->associationMappings[$propName])) {
                    $changeSet[$propName] = [null, $actualValue];

                    continue;
                }

                $assoc = $class->associationMappings[$propName];

                if ($assoc['isOwningSide'] && $assoc['type'] & ClassMetadata::TO_ONE) {
                    $changeSet[$propName] = [null, $actualValue];
                }
            }

            $this->entityChangeSets[$oid] = $changeSet;
        } else {
            // Entity is "fully" MANAGED: it was already fully persisted before
            // and we have a copy of the original data
            $originalData           = $this->originalEntityData[$oid];
            $isChangeTrackingNotify = $class->isChangeTrackingNotify();
            $changeSet              = ($isChangeTrackingNotify && isset($this->entityChangeSets[$oid]))
                ? $this->entityChangeSets[$oid]
                : [];

            foreach ($actualData as $propName => $actualValue) {
                // skip field, its a partially omitted one!
                if ( ! (isset($originalData[$propName]) || array_key_exists($propName, $originalData))) {
                    continue;
                }

                $orgValue = $originalData[$propName];

                // skip if value haven't changed
                if ($orgValue === $actualValue) {
                    continue;
                }

                // if regular field
                if ( ! isset($class->associationMappings[$propName])) {
                    if ($isChangeTrackingNotify) {
                        continue;
                    }

                    $changeSet[$propName] = [$orgValue, $actualValue];

                    continue;
                }

                $assoc = $class->associationMappings[$propName];

                // Persistent collection was exchanged with the "originally"
                // created one. This can only mean it was cloned and replaced
                // on another entity.
                if ($actualValue instanceof PersistentCollection) {
                    $owner = $actualValue->getOwner();
                    if ($owner === null) { // cloned
                        $actualValue->setOwner($entity, $assoc);
                    } else if ($owner !== $entity) { // no clone, we have to fix
                        if (!$actualValue->isInitialized()) {
                            $actualValue->initialize(); // we have to do this otherwise the cols share state
                        }
                        $newValue = clone $actualValue;
                        $newValue->setOwner($entity, $assoc);
                        $class->reflFields[$propName]->setValue($entity, $newValue);
                    }
                }

                if ($orgValue instanceof PersistentCollection) {
                    // A PersistentCollection was de-referenced, so delete it.
                    $coid = spl_object_hash($orgValue);

                    if (isset($this->collectionDeletions[$coid])) {
                        continue;
                    }

                    $this->collectionDeletions[$coid] = $orgValue;
                    $changeSet[$propName] = $orgValue; // Signal changeset, to-many assocs will be ignored.

                    continue;
                }

                if ($assoc['type'] & ClassMetadata::TO_ONE) {
                    if ($assoc['isOwningSide']) {
                        $changeSet[$propName] = [$orgValue, $actualValue];
                    }

                    if ($orgValue !== null && $assoc['orphanRemoval']) {
                        $this->scheduleOrphanRemoval($orgValue);
                    }
                }
            }

            if ($changeSet) {
                $this->entityChangeSets[$oid]   = $changeSet;
                $this->originalEntityData[$oid] = $actualData;
                $this->entityUpdates[$oid]      = $entity;
            }
        }

        // Look for changes in associations of the entity
        foreach ($class->associationMappings as $field => $assoc) {
            if (($val = $class->reflFields[$field]->getValue($entity)) === null) {
                continue;
            }

            $this->computeAssociationChanges($assoc, $val);

            if ( ! isset($this->entityChangeSets[$oid]) &&
                $assoc['isOwningSide'] &&
                $assoc['type'] == ClassMetadata::MANY_TO_MANY &&
                $val instanceof PersistentCollection &&
                $val->isDirty()) {

                $this->entityChangeSets[$oid]   = [];
                $this->originalEntityData[$oid] = $actualData;
                $this->entityUpdates[$oid]      = $entity;
            }
        }
    }

    /**
     * Computes all the changes that have been done to entities and collections
     * since the last commit and stores these changes in the _entityChangeSet map
     * temporarily for access by the persisters, until the UoW commit is finished.
     *
     * @return void
     */
    public function computeChangeSets()
    {
        // Compute changes for INSERTed entities first. This must always happen.
        $this->computeScheduleInsertsChangeSets();

        // Compute changes for other MANAGED entities. Change tracking policies take effect here.
        foreach ($this->identityMap as $className => $entities) {
            $class = $this->em->getClassMetadata($className);

            // Skip class if instances are read-only
            if ($class->isReadOnly) {
                continue;
            }

            // If change tracking is explicit or happens through notification, then only compute
            // changes on entities of that type that are explicitly marked for synchronization.
            switch (true) {
                case ($class->isChangeTrackingDeferredImplicit()):
                    $entitiesToProcess = $entities;
                    break;

                case (isset($this->scheduledForSynchronization[$className])):
                    $entitiesToProcess = $this->scheduledForSynchronization[$className];
                    break;

                default:
                    $entitiesToProcess = [];

            }

            foreach ($entitiesToProcess as $entity) {
                // Ignore uninitialized proxy objects
                if ($entity instanceof Proxy && ! $entity->__isInitialized__) {
                    continue;
                }

                // Only MANAGED entities that are NOT SCHEDULED FOR INSERTION OR DELETION are processed here.
                $oid = spl_object_hash($entity);

                if ( ! isset($this->entityInsertions[$oid]) && ! isset($this->entityDeletions[$oid]) && isset($this->entityStates[$oid])) {
                    $this->computeChangeSet($class, $entity);
                }
            }
        }
    }

    /**
     * Computes the changes of an association.
     *
     * @param array $assoc The association mapping.
     * @param mixed $value The value of the association.
     *
     * @throws ORMInvalidArgumentException
     * @throws ORMException
     *
     * @return void
     */
    private function computeAssociationChanges($assoc, $value)
    {
        if ($value instanceof Proxy && ! $value->__isInitialized__) {
            return;
        }

        if ($value instanceof PersistentCollection && $value->isDirty()) {
            $coid = spl_object_hash($value);

            $this->collectionUpdates[$coid] = $value;
            $this->visitedCollections[$coid] = $value;
        }

        // Look through the entities, and in any of their associations,
        // for transient (new) entities, recursively. ("Persistence by reachability")
        // Unwrap. Uninitialized collections will simply be empty.
        $unwrappedValue = ($assoc['type'] & ClassMetadata::TO_ONE) ? [$value] : $value->unwrap();
        $targetClass    = $this->em->getClassMetadata($assoc['targetEntity']);

        foreach ($unwrappedValue as $key => $entry) {
            if (! ($entry instanceof $targetClass->name)) {
                throw ORMInvalidArgumentException::invalidAssociation($targetClass, $assoc, $entry);
            }

            $state = $this->getEntityState($entry, self::STATE_NEW);

            if ( ! ($entry instanceof $assoc['targetEntity'])) {
                throw ORMException::unexpectedAssociationValue($assoc['sourceEntity'], $assoc['fieldName'], get_class($entry), $assoc['targetEntity']);
            }

            switch ($state) {
                case self::STATE_NEW:
                    if ( ! $assoc['isCascadePersist']) {
                        /*
                         * For now just record the details, because this may
                         * not be an issue if we later discover another pathway
                         * through the object-graph where cascade-persistence
                         * is enabled for this object.
                         */
                        $this->nonCascadedNewDetectedEntities[\spl_object_hash($entry)] = [$assoc, $entry];

                        break;
                    }

                    $this->persistNew($targetClass, $entry);
                    $this->computeChangeSet($targetClass, $entry);

                    break;

                case self::STATE_REMOVED:
                    // Consume the $value as array (it's either an array or an ArrayAccess)
                    // and remove the element from Collection.
                    if ($assoc['type'] & ClassMetadata::TO_MANY) {
                        unset($value[$key]);
                    }
                    break;

                case self::STATE_DETACHED:
                    // Can actually not happen right now as we assume STATE_NEW,
                    // so the exception will be raised from the DBAL layer (constraint violation).
                    throw ORMInvalidArgumentException::detachedEntityFoundThroughRelationship($assoc, $entry);
                    break;

                default:
                    // MANAGED associated entities are already taken into account
                    // during changeset calculation anyway, since they are in the identity map.
            }
        }
    }

    /**
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     * @param object                              $entity
     *
     * @return void
     */
    private function persistNew($class, $entity)
    {
        $oid    = spl_object_hash($entity);
        $invoke = $this->listenersInvoker->getSubscribedSystems($class, Events::prePersist);

        if ($invoke !== ListenersInvoker::INVOKE_NONE) {
            $this->listenersInvoker->invoke($class, Events::prePersist, $entity, new LifecycleEventArgs($entity, $this->em), $invoke);
        }

        $idGen = $class->idGenerator;

        if ( ! $idGen->isPostInsertGenerator()) {
            $idValue = $idGen->generate($this->em, $entity);

            if ( ! $idGen instanceof \Doctrine\ORM\Id\AssignedGenerator) {
                $idValue = [$class->getSingleIdentifierFieldName() => $this->convertSingleFieldIdentifierToPHPValue($class, $idValue)];

                $class->setIdentifierValues($entity, $idValue);
            }

            // Some identifiers may be foreign keys to new entities.
            // In this case, we don't have the value yet and should treat it as if we have a post-insert generator
            if (! $this->hasMissingIdsWhichAreForeignKeys($class, $idValue)) {
                $this->entityIdentifiers[$oid] = $idValue;
            }
        }

        $this->entityStates[$oid] = self::STATE_MANAGED;

        $this->scheduleForInsert($entity);
    }

    /**
     * @param mixed[] $idValue
     */
    private function hasMissingIdsWhichAreForeignKeys(ClassMetadata $class, array $idValue) : bool
    {
        foreach ($idValue as $idField => $idFieldValue) {
            if ($idFieldValue === null && isset($class->associationMappings[$idField])) {
                return true;
            }
        }

        return false;
    }

    /**
     * INTERNAL:
     * Computes the changeset of an individual entity, independently of the
     * computeChangeSets() routine that is used at the beginning of a UnitOfWork#commit().
     *
     * The passed entity must be a managed entity. If the entity already has a change set
     * because this method is invoked during a commit cycle then the change sets are added.
     * whereby changes detected in this method prevail.
     *
     * @ignore
     *
     * @param ClassMetadata $class  The class descriptor of the entity.
     * @param object        $entity The entity for which to (re)calculate the change set.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException If the passed entity is not MANAGED.
     */
    public function recomputeSingleEntityChangeSet(ClassMetadata $class, $entity)
    {
        $oid = spl_object_hash($entity);

        if ( ! isset($this->entityStates[$oid]) || $this->entityStates[$oid] != self::STATE_MANAGED) {
            throw ORMInvalidArgumentException::entityNotManaged($entity);
        }

        // skip if change tracking is "NOTIFY"
        if ($class->isChangeTrackingNotify()) {
            return;
        }

        if ( ! $class->isInheritanceTypeNone()) {
            $class = $this->em->getClassMetadata(get_class($entity));
        }

        $actualData = [];

        foreach ($class->reflFields as $name => $refProp) {
            if (( ! $class->isIdentifier($name) || ! $class->isIdGeneratorIdentity())
                && ($name !== $class->versionField)
                && ! $class->isCollectionValuedAssociation($name)) {
                $actualData[$name] = $refProp->getValue($entity);
            }
        }

        if ( ! isset($this->originalEntityData[$oid])) {
            throw new \RuntimeException('Cannot call recomputeSingleEntityChangeSet before computeChangeSet on an entity.');
        }

        $originalData = $this->originalEntityData[$oid];
        $changeSet = [];

        foreach ($actualData as $propName => $actualValue) {
            $orgValue = $originalData[$propName] ?? null;

            if ($orgValue !== $actualValue) {
                $changeSet[$propName] = [$orgValue, $actualValue];
            }
        }

        if ($changeSet) {
            if (isset($this->entityChangeSets[$oid])) {
                $this->entityChangeSets[$oid] = array_merge($this->entityChangeSets[$oid], $changeSet);
            } else if ( ! isset($this->entityInsertions[$oid])) {
                $this->entityChangeSets[$oid] = $changeSet;
                $this->entityUpdates[$oid]    = $entity;
            }
            $this->originalEntityData[$oid] = $actualData;
        }
    }

    /**
     * Executes all entity insertions for entities of the specified type.
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     *
     * @return void
     */
    private function executeInserts($class)
    {
        $entities   = [];
        $className  = $class->name;
        $persister  = $this->getEntityPersister($className);
        $invoke     = $this->listenersInvoker->getSubscribedSystems($class, Events::postPersist);

        $insertionsForClass = [];

        foreach ($this->entityInsertions as $oid => $entity) {

            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            $insertionsForClass[$oid] = $entity;

            $persister->addInsert($entity);

            unset($this->entityInsertions[$oid]);

            if ($invoke !== ListenersInvoker::INVOKE_NONE) {
                $entities[] = $entity;
            }
        }

        $postInsertIds = $persister->executeInserts();

        if ($postInsertIds) {
            // Persister returned post-insert IDs
            foreach ($postInsertIds as $postInsertId) {
                $idField = $class->getSingleIdentifierFieldName();
                $idValue = $this->convertSingleFieldIdentifierToPHPValue($class, $postInsertId['generatedId']);

                $entity  = $postInsertId['entity'];
                $oid     = spl_object_hash($entity);

                $class->reflFields[$idField]->setValue($entity, $idValue);

                $this->entityIdentifiers[$oid] = [$idField => $idValue];
                $this->entityStates[$oid] = self::STATE_MANAGED;
                $this->originalEntityData[$oid][$idField] = $idValue;

                $this->addToIdentityMap($entity);
            }
        } else {
            foreach ($insertionsForClass as $oid => $entity) {
                if (! isset($this->entityIdentifiers[$oid])) {
                    //entity was not added to identity map because some identifiers are foreign keys to new entities.
                    //add it now
                    $this->addToEntityIdentifiersAndEntityMap($class, $oid, $entity);
                }
            }
        }

        foreach ($entities as $entity) {
            $this->listenersInvoker->invoke($class, Events::postPersist, $entity, new LifecycleEventArgs($entity, $this->em), $invoke);
        }
    }

    /**
     * @param object $entity
     */
    private function addToEntityIdentifiersAndEntityMap(ClassMetadata $class, string $oid, $entity): void
    {
        $identifier = [];

        foreach ($class->getIdentifierFieldNames() as $idField) {
            $value = $class->getFieldValue($entity, $idField);

            if (isset($class->associationMappings[$idField])) {
                // NOTE: Single Columns as associated identifiers only allowed - this constraint it is enforced.
                $value = $this->getSingleIdentifierValue($value);
            }

            $identifier[$idField] = $this->originalEntityData[$oid][$idField] = $value;
        }

        $this->entityStates[$oid]      = self::STATE_MANAGED;
        $this->entityIdentifiers[$oid] = $identifier;

        $this->addToIdentityMap($entity);
    }

    /**
     * Executes all entity updates for entities of the specified type.
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     *
     * @return void
     */
    private function executeUpdates($class)
    {
        $className          = $class->name;
        $persister          = $this->getEntityPersister($className);
        $preUpdateInvoke    = $this->listenersInvoker->getSubscribedSystems($class, Events::preUpdate);
        $postUpdateInvoke   = $this->listenersInvoker->getSubscribedSystems($class, Events::postUpdate);

        foreach ($this->entityUpdates as $oid => $entity) {
            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            if ($preUpdateInvoke != ListenersInvoker::INVOKE_NONE) {
                $this->listenersInvoker->invoke($class, Events::preUpdate, $entity, new PreUpdateEventArgs($entity, $this->em, $this->getEntityChangeSet($entity)), $preUpdateInvoke);

                $this->recomputeSingleEntityChangeSet($class, $entity);
            }

            if ( ! empty($this->entityChangeSets[$oid])) {
                $persister->update($entity);
            }

            unset($this->entityUpdates[$oid]);

            if ($postUpdateInvoke != ListenersInvoker::INVOKE_NONE) {
                $this->listenersInvoker->invoke($class, Events::postUpdate, $entity, new LifecycleEventArgs($entity, $this->em), $postUpdateInvoke);
            }
        }
    }

    /**
     * Executes all entity deletions for entities of the specified type.
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     *
     * @return void
     */
    private function executeDeletions($class)
    {
        $className  = $class->name;
        $persister  = $this->getEntityPersister($className);
        $invoke     = $this->listenersInvoker->getSubscribedSystems($class, Events::postRemove);

        foreach ($this->entityDeletions as $oid => $entity) {
            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            $persister->delete($entity);

            unset(
                $this->entityDeletions[$oid],
                $this->entityIdentifiers[$oid],
                $this->originalEntityData[$oid],
                $this->entityStates[$oid]
            );

            // Entity with this $oid after deletion treated as NEW, even if the $oid
            // is obtained by a new entity because the old one went out of scope.
            //$this->entityStates[$oid] = self::STATE_NEW;
            if ( ! $class->isIdentifierNatural()) {
                $class->reflFields[$class->identifier[0]]->setValue($entity, null);
            }

            if ($invoke !== ListenersInvoker::INVOKE_NONE) {
                $this->listenersInvoker->invoke($class, Events::postRemove, $entity, new LifecycleEventArgs($entity, $this->em), $invoke);
            }
        }
    }

    /**
     * Gets the commit order.
     *
     * @param array|null $entityChangeSet
     *
     * @return array
     */
    private function getCommitOrder(array $entityChangeSet = null)
    {
        if ($entityChangeSet === null) {
            $entityChangeSet = array_merge($this->entityInsertions, $this->entityUpdates, $this->entityDeletions);
        }

        $calc = $this->getCommitOrderCalculator();

        // See if there are any new classes in the changeset, that are not in the
        // commit order graph yet (don't have a node).
        // We have to inspect changeSet to be able to correctly build dependencies.
        // It is not possible to use IdentityMap here because post inserted ids
        // are not yet available.
        $newNodes = [];

        foreach ($entityChangeSet as $entity) {
            $class = $this->em->getClassMetadata(get_class($entity));

            if ($calc->hasNode($class->name)) {
                continue;
            }

            $calc->addNode($class->name, $class);

            $newNodes[] = $class;
        }

        // Calculate dependencies for new nodes
        while ($class = array_pop($newNodes)) {
            foreach ($class->associationMappings as $assoc) {
                if ( ! ($assoc['isOwningSide'] && $assoc['type'] & ClassMetadata::TO_ONE)) {
                    continue;
                }

                $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);

                if ( ! $calc->hasNode($targetClass->name)) {
                    $calc->addNode($targetClass->name, $targetClass);

                    $newNodes[] = $targetClass;
                }

                $joinColumns = reset($assoc['joinColumns']);

                $calc->addDependency($targetClass->name, $class->name, (int)empty($joinColumns['nullable']));

                // If the target class has mapped subclasses, these share the same dependency.
                if ( ! $targetClass->subClasses) {
                    continue;
                }

                foreach ($targetClass->subClasses as $subClassName) {
                    $targetSubClass = $this->em->getClassMetadata($subClassName);

                    if ( ! $calc->hasNode($subClassName)) {
                        $calc->addNode($targetSubClass->name, $targetSubClass);

                        $newNodes[] = $targetSubClass;
                    }

                    $calc->addDependency($targetSubClass->name, $class->name, 1);
                }
            }
        }

        return $calc->sort();
    }

    /**
     * Schedules an entity for insertion into the database.
     * If the entity already has an identifier, it will be added to the identity map.
     *
     * @param object $entity The entity to schedule for insertion.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function scheduleForInsert($entity)
    {
        $oid = spl_object_hash($entity);

        if (isset($this->entityUpdates[$oid])) {
            throw new InvalidArgumentException("Dirty entity can not be scheduled for insertion.");
        }

        if (isset($this->entityDeletions[$oid])) {
            throw ORMInvalidArgumentException::scheduleInsertForRemovedEntity($entity);
        }
        if (isset($this->originalEntityData[$oid]) && ! isset($this->entityInsertions[$oid])) {
            throw ORMInvalidArgumentException::scheduleInsertForManagedEntity($entity);
        }

        if (isset($this->entityInsertions[$oid])) {
            throw ORMInvalidArgumentException::scheduleInsertTwice($entity);
        }

        $this->entityInsertions[$oid] = $entity;

        if (isset($this->entityIdentifiers[$oid])) {
            $this->addToIdentityMap($entity);
        }

        if ($entity instanceof NotifyPropertyChanged) {
            $entity->addPropertyChangedListener($this);
        }
    }

    /**
     * Checks whether an entity is scheduled for insertion.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isScheduledForInsert($entity)
    {
        return isset($this->entityInsertions[spl_object_hash($entity)]);
    }

    /**
     * Schedules an entity for being updated.
     *
     * @param object $entity The entity to schedule for being updated.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function scheduleForUpdate($entity)
    {
        $oid = spl_object_hash($entity);

        if ( ! isset($this->entityIdentifiers[$oid])) {
            throw ORMInvalidArgumentException::entityHasNoIdentity($entity, "scheduling for update");
        }

        if (isset($this->entityDeletions[$oid])) {
            throw ORMInvalidArgumentException::entityIsRemoved($entity, "schedule for update");
        }

        if ( ! isset($this->entityUpdates[$oid]) && ! isset($this->entityInsertions[$oid])) {
            $this->entityUpdates[$oid] = $entity;
        }
    }

    /**
     * INTERNAL:
     * Schedules an extra update that will be executed immediately after the
     * regular entity updates within the currently running commit cycle.
     *
     * Extra updates for entities are stored as (entity, changeset) tuples.
     *
     * @ignore
     *
     * @param object $entity    The entity for which to schedule an extra update.
     * @param array  $changeset The changeset of the entity (what to update).
     *
     * @return void
     */
    public function scheduleExtraUpdate($entity, array $changeset)
    {
        $oid         = spl_object_hash($entity);
        $extraUpdate = [$entity, $changeset];

        if (isset($this->extraUpdates[$oid])) {
            list(, $changeset2) = $this->extraUpdates[$oid];

            $extraUpdate = [$entity, $changeset + $changeset2];
        }

        $this->extraUpdates[$oid] = $extraUpdate;
    }

    /**
     * Checks whether an entity is registered as dirty in the unit of work.
     * Note: Is not very useful currently as dirty entities are only registered
     * at commit time.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isScheduledForUpdate($entity)
    {
        return isset($this->entityUpdates[spl_object_hash($entity)]);
    }

    /**
     * Checks whether an entity is registered to be checked in the unit of work.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isScheduledForDirtyCheck($entity)
    {
        $rootEntityName = $this->em->getClassMetadata(get_class($entity))->rootEntityName;

        return isset($this->scheduledForSynchronization[$rootEntityName][spl_object_hash($entity)]);
    }

    /**
     * INTERNAL:
     * Schedules an entity for deletion.
     *
     * @param object $entity
     *
     * @return void
     */
    public function scheduleForDelete($entity)
    {
        $oid = spl_object_hash($entity);

        if (isset($this->entityInsertions[$oid])) {
            if ($this->isInIdentityMap($entity)) {
                $this->removeFromIdentityMap($entity);
            }

            unset($this->entityInsertions[$oid], $this->entityStates[$oid]);

            return; // entity has not been persisted yet, so nothing more to do.
        }

        if ( ! $this->isInIdentityMap($entity)) {
            return;
        }

        $this->removeFromIdentityMap($entity);

        unset($this->entityUpdates[$oid]);

        if ( ! isset($this->entityDeletions[$oid])) {
            $this->entityDeletions[$oid] = $entity;
            $this->entityStates[$oid]    = self::STATE_REMOVED;
        }
    }

    /**
     * Checks whether an entity is registered as removed/deleted with the unit
     * of work.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isScheduledForDelete($entity)
    {
        return isset($this->entityDeletions[spl_object_hash($entity)]);
    }

    /**
     * Checks whether an entity is scheduled for insertion, update or deletion.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isEntityScheduled($entity)
    {
        $oid = spl_object_hash($entity);

        return isset($this->entityInsertions[$oid])
            || isset($this->entityUpdates[$oid])
            || isset($this->entityDeletions[$oid]);
    }

    /**
     * INTERNAL:
     * Registers an entity in the identity map.
     * Note that entities in a hierarchy are registered with the class name of
     * the root entity.
     *
     * @ignore
     *
     * @param object $entity The entity to register.
     *
     * @return boolean TRUE if the registration was successful, FALSE if the identity of
     *                 the entity in question is already managed.
     *
     * @throws ORMInvalidArgumentException
     */
    public function addToIdentityMap($entity)
    {
        $classMetadata = $this->em->getClassMetadata(get_class($entity));
        $identifier    = $this->entityIdentifiers[spl_object_hash($entity)];

        if (empty($identifier) || in_array(null, $identifier, true)) {
            throw ORMInvalidArgumentException::entityWithoutIdentity($classMetadata->name, $entity);
        }

        $idHash    = implode(' ', $identifier);
        $className = $classMetadata->rootEntityName;

        if (isset($this->identityMap[$className][$idHash])) {
            return false;
        }

        $this->identityMap[$className][$idHash] = $entity;

        return true;
    }

    /**
     * Gets the state of an entity with regard to the current unit of work.
     *
     * @param object   $entity
     * @param int|null $assume The state to assume if the state is not yet known (not MANAGED or REMOVED).
     *                         This parameter can be set to improve performance of entity state detection
     *                         by potentially avoiding a database lookup if the distinction between NEW and DETACHED
     *                         is either known or does not matter for the caller of the method.
     *
     * @return int The entity state.
     */
    public function getEntityState($entity, $assume = null)
    {
        $oid = spl_object_hash($entity);

        if (isset($this->entityStates[$oid])) {
            return $this->entityStates[$oid];
        }

        if ($assume !== null) {
            return $assume;
        }

        // State can only be NEW or DETACHED, because MANAGED/REMOVED states are known.
        // Note that you can not remember the NEW or DETACHED state in _entityStates since
        // the UoW does not hold references to such objects and the object hash can be reused.
        // More generally because the state may "change" between NEW/DETACHED without the UoW being aware of it.
        $class = $this->em->getClassMetadata(get_class($entity));
        $id    = $class->getIdentifierValues($entity);

        if ( ! $id) {
            return self::STATE_NEW;
        }

        if ($class->containsForeignIdentifier) {
            $id = $this->identifierFlattener->flattenIdentifier($class, $id);
        }

        switch (true) {
            case ($class->isIdentifierNatural()):
                // Check for a version field, if available, to avoid a db lookup.
                if ($class->isVersioned) {
                    return ($class->getFieldValue($entity, $class->versionField))
                        ? self::STATE_DETACHED
                        : self::STATE_NEW;
                }

                // Last try before db lookup: check the identity map.
                if ($this->tryGetById($id, $class->rootEntityName)) {
                    return self::STATE_DETACHED;
                }

                // db lookup
                if ($this->getEntityPersister($class->name)->exists($entity)) {
                    return self::STATE_DETACHED;
                }

                return self::STATE_NEW;

            case ( ! $class->idGenerator->isPostInsertGenerator()):
                // if we have a pre insert generator we can't be sure that having an id
                // really means that the entity exists. We have to verify this through
                // the last resort: a db lookup

                // Last try before db lookup: check the identity map.
                if ($this->tryGetById($id, $class->rootEntityName)) {
                    return self::STATE_DETACHED;
                }

                // db lookup
                if ($this->getEntityPersister($class->name)->exists($entity)) {
                    return self::STATE_DETACHED;
                }

                return self::STATE_NEW;

            default:
                return self::STATE_DETACHED;
        }
    }

    /**
     * INTERNAL:
     * Removes an entity from the identity map. This effectively detaches the
     * entity from the persistence management of Doctrine.
     *
     * @ignore
     *
     * @param object $entity
     *
     * @return boolean
     *
     * @throws ORMInvalidArgumentException
     */
    public function removeFromIdentityMap($entity)
    {
        $oid           = spl_object_hash($entity);
        $classMetadata = $this->em->getClassMetadata(get_class($entity));
        $idHash        = implode(' ', $this->entityIdentifiers[$oid]);

        if ($idHash === '') {
            throw ORMInvalidArgumentException::entityHasNoIdentity($entity, "remove from identity map");
        }

        $className = $classMetadata->rootEntityName;

        if (isset($this->identityMap[$className][$idHash])) {
            unset($this->identityMap[$className][$idHash]);
            unset($this->readOnlyObjects[$oid]);

            //$this->entityStates[$oid] = self::STATE_DETACHED;

            return true;
        }

        return false;
    }

    /**
     * INTERNAL:
     * Gets an entity in the identity map by its identifier hash.
     *
     * @ignore
     *
     * @param string $idHash
     * @param string $rootClassName
     *
     * @return object
     */
    public function getByIdHash($idHash, $rootClassName)
    {
        return $this->identityMap[$rootClassName][$idHash];
    }

    /**
     * INTERNAL:
     * Tries to get an entity by its identifier hash. If no entity is found for
     * the given hash, FALSE is returned.
     *
     * @ignore
     *
     * @param mixed  $idHash        (must be possible to cast it to string)
     * @param string $rootClassName
     *
     * @return object|bool The found entity or FALSE.
     */
    public function tryGetByIdHash($idHash, $rootClassName)
    {
        $stringIdHash = (string) $idHash;

        return isset($this->identityMap[$rootClassName][$stringIdHash])
            ? $this->identityMap[$rootClassName][$stringIdHash]
            : false;
    }

    /**
     * Checks whether an entity is registered in the identity map of this UnitOfWork.
     *
     * @param object $entity
     *
     * @return boolean
     */
    public function isInIdentityMap($entity)
    {
        $oid = spl_object_hash($entity);

        if (empty($this->entityIdentifiers[$oid])) {
            return false;
        }

        $classMetadata = $this->em->getClassMetadata(get_class($entity));
        $idHash        = implode(' ', $this->entityIdentifiers[$oid]);

        return isset($this->identityMap[$classMetadata->rootEntityName][$idHash]);
    }

    /**
     * INTERNAL:
     * Checks whether an identifier hash exists in the identity map.
     *
     * @ignore
     *
     * @param string $idHash
     * @param string $rootClassName
     *
     * @return boolean
     */
    public function containsIdHash($idHash, $rootClassName)
    {
        return isset($this->identityMap[$rootClassName][$idHash]);
    }

    /**
     * Persists an entity as part of the current unit of work.
     *
     * @param object $entity The entity to persist.
     *
     * @return void
     */
    public function persist($entity)
    {
        $visited = [];

        $this->doPersist($entity, $visited);
    }

    /**
     * Persists an entity as part of the current unit of work.
     *
     * This method is internally called during persist() cascades as it tracks
     * the already visited entities to prevent infinite recursions.
     *
     * @param object $entity  The entity to persist.
     * @param array  $visited The already visited entities.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     * @throws UnexpectedValueException
     */
    private function doPersist($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            return; // Prevent infinite recursion
        }

        $visited[$oid] = $entity; // Mark visited

        $class = $this->em->getClassMetadata(get_class($entity));

        // We assume NEW, so DETACHED entities result in an exception on flush (constraint violation).
        // If we would detect DETACHED here we would throw an exception anyway with the same
        // consequences (not recoverable/programming error), so just assuming NEW here
        // lets us avoid some database lookups for entities with natural identifiers.
        $entityState = $this->getEntityState($entity, self::STATE_NEW);

        switch ($entityState) {
            case self::STATE_MANAGED:
                // Nothing to do, except if policy is "deferred explicit"
                if ($class->isChangeTrackingDeferredExplicit()) {
                    $this->scheduleForDirtyCheck($entity);
                }
                break;

            case self::STATE_NEW:
                $this->persistNew($class, $entity);
                break;

            case self::STATE_REMOVED:
                // Entity becomes managed again
                unset($this->entityDeletions[$oid]);
                $this->addToIdentityMap($entity);

                $this->entityStates[$oid] = self::STATE_MANAGED;
                break;

            case self::STATE_DETACHED:
                // Can actually not happen right now since we assume STATE_NEW.
                throw ORMInvalidArgumentException::detachedEntityCannot($entity, "persisted");

            default:
                throw new UnexpectedValueException("Unexpected entity state: $entityState." . self::objToStr($entity));
        }

        $this->cascadePersist($entity, $visited);
    }

    /**
     * Deletes an entity as part of the current unit of work.
     *
     * @param object $entity The entity to remove.
     *
     * @return void
     */
    public function remove($entity)
    {
        $visited = [];

        $this->doRemove($entity, $visited);
    }

    /**
     * Deletes an entity as part of the current unit of work.
     *
     * This method is internally called during delete() cascades as it tracks
     * the already visited entities to prevent infinite recursions.
     *
     * @param object $entity  The entity to delete.
     * @param array  $visited The map of the already visited entities.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException If the instance is a detached entity.
     * @throws UnexpectedValueException
     */
    private function doRemove($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            return; // Prevent infinite recursion
        }

        $visited[$oid] = $entity; // mark visited

        // Cascade first, because scheduleForDelete() removes the entity from the identity map, which
        // can cause problems when a lazy proxy has to be initialized for the cascade operation.
        $this->cascadeRemove($entity, $visited);

        $class       = $this->em->getClassMetadata(get_class($entity));
        $entityState = $this->getEntityState($entity);

        switch ($entityState) {
            case self::STATE_NEW:
            case self::STATE_REMOVED:
                // nothing to do
                break;

            case self::STATE_MANAGED:
                $invoke = $this->listenersInvoker->getSubscribedSystems($class, Events::preRemove);

                if ($invoke !== ListenersInvoker::INVOKE_NONE) {
                    $this->listenersInvoker->invoke($class, Events::preRemove, $entity, new LifecycleEventArgs($entity, $this->em), $invoke);
                }

                $this->scheduleForDelete($entity);
                break;

            case self::STATE_DETACHED:
                throw ORMInvalidArgumentException::detachedEntityCannot($entity, "removed");
            default:
                throw new UnexpectedValueException("Unexpected entity state: $entityState." . self::objToStr($entity));
        }

    }

    /**
     * Merges the state of the given detached entity into this UnitOfWork.
     *
     * @param object $entity
     *
     * @return object The managed copy of the entity.
     *
     * @throws OptimisticLockException If the entity uses optimistic locking through a version
     *         attribute and the version check against the managed copy fails.
     *
     * @todo Require active transaction!? OptimisticLockException may result in undefined state!?
     */
    public function merge($entity)
    {
        $visited = [];

        return $this->doMerge($entity, $visited);
    }

    /**
     * Executes a merge operation on an entity.
     *
     * @param object      $entity
     * @param array       $visited
     * @param object|null $prevManagedCopy
     * @param array|null  $assoc
     *
     * @return object The managed copy of the entity.
     *
     * @throws OptimisticLockException If the entity uses optimistic locking through a version
     *         attribute and the version check against the managed copy fails.
     * @throws ORMInvalidArgumentException If the entity instance is NEW.
     * @throws EntityNotFoundException if an assigned identifier is used in the entity, but none is provided
     */
    private function doMerge($entity, array &$visited, $prevManagedCopy = null, array $assoc = [])
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            $managedCopy = $visited[$oid];

            if ($prevManagedCopy !== null) {
                $this->updateAssociationWithMergedEntity($entity, $assoc, $prevManagedCopy, $managedCopy);
            }

            return $managedCopy;
        }

        $class = $this->em->getClassMetadata(get_class($entity));

        // First we assume DETACHED, although it can still be NEW but we can avoid
        // an extra db-roundtrip this way. If it is not MANAGED but has an identity,
        // we need to fetch it from the db anyway in order to merge.
        // MANAGED entities are ignored by the merge operation.
        $managedCopy = $entity;

        if ($this->getEntityState($entity, self::STATE_DETACHED) !== self::STATE_MANAGED) {
            // Try to look the entity up in the identity map.
            $id = $class->getIdentifierValues($entity);

            // If there is no ID, it is actually NEW.
            if ( ! $id) {
                $managedCopy = $this->newInstance($class);

                $this->mergeEntityStateIntoManagedCopy($entity, $managedCopy);
                $this->persistNew($class, $managedCopy);
            } else {
                $flatId = ($class->containsForeignIdentifier)
                    ? $this->identifierFlattener->flattenIdentifier($class, $id)
                    : $id;

                $managedCopy = $this->tryGetById($flatId, $class->rootEntityName);

                if ($managedCopy) {
                    // We have the entity in-memory already, just make sure its not removed.
                    if ($this->getEntityState($managedCopy) == self::STATE_REMOVED) {
                        throw ORMInvalidArgumentException::entityIsRemoved($managedCopy, "merge");
                    }
                } else {
                    // We need to fetch the managed copy in order to merge.
                    $managedCopy = $this->em->find($class->name, $flatId);
                }

                if ($managedCopy === null) {
                    // If the identifier is ASSIGNED, it is NEW, otherwise an error
                    // since the managed entity was not found.
                    if ( ! $class->isIdentifierNatural()) {
                        throw EntityNotFoundException::fromClassNameAndIdentifier(
                            $class->getName(),
                            $this->identifierFlattener->flattenIdentifier($class, $id)
                        );
                    }

                    $managedCopy = $this->newInstance($class);
                    $class->setIdentifierValues($managedCopy, $id);

                    $this->mergeEntityStateIntoManagedCopy($entity, $managedCopy);
                    $this->persistNew($class, $managedCopy);
                } else {
                    $this->ensureVersionMatch($class, $entity, $managedCopy);
                    $this->mergeEntityStateIntoManagedCopy($entity, $managedCopy);
                }
            }

            $visited[$oid] = $managedCopy; // mark visited

            if ($class->isChangeTrackingDeferredExplicit()) {
                $this->scheduleForDirtyCheck($entity);
            }
        }

        if ($prevManagedCopy !== null) {
            $this->updateAssociationWithMergedEntity($entity, $assoc, $prevManagedCopy, $managedCopy);
        }

        // Mark the managed copy visited as well
        $visited[spl_object_hash($managedCopy)] = $managedCopy;

        $this->cascadeMerge($entity, $managedCopy, $visited);

        return $managedCopy;
    }

    /**
     * @param ClassMetadata $class
     * @param object        $entity
     * @param object        $managedCopy
     *
     * @return void
     *
     * @throws OptimisticLockException
     */
    private function ensureVersionMatch(ClassMetadata $class, $entity, $managedCopy)
    {
        if (! ($class->isVersioned && $this->isLoaded($managedCopy) && $this->isLoaded($entity))) {
            return;
        }

        $reflField          = $class->reflFields[$class->versionField];
        $managedCopyVersion = $reflField->getValue($managedCopy);
        $entityVersion      = $reflField->getValue($entity);

        // Throw exception if versions don't match.
        if ($managedCopyVersion == $entityVersion) {
            return;
        }

        throw OptimisticLockException::lockFailedVersionMismatch($entity, $entityVersion, $managedCopyVersion);
    }

    /**
     * Tests if an entity is loaded - must either be a loaded proxy or not a proxy
     *
     * @param object $entity
     *
     * @return bool
     */
    private function isLoaded($entity)
    {
        return !($entity instanceof Proxy) || $entity->__isInitialized();
    }

    /**
     * Sets/adds associated managed copies into the previous entity's association field
     *
     * @param object $entity
     * @param array  $association
     * @param object $previousManagedCopy
     * @param object $managedCopy
     *
     * @return void
     */
    private function updateAssociationWithMergedEntity($entity, array $association, $previousManagedCopy, $managedCopy)
    {
        $assocField = $association['fieldName'];
        $prevClass  = $this->em->getClassMetadata(get_class($previousManagedCopy));

        if ($association['type'] & ClassMetadata::TO_ONE) {
            $prevClass->reflFields[$assocField]->setValue($previousManagedCopy, $managedCopy);

            return;
        }

        $value   = $prevClass->reflFields[$assocField]->getValue($previousManagedCopy);
        $value[] = $managedCopy;

        if ($association['type'] == ClassMetadata::ONE_TO_MANY) {
            $class = $this->em->getClassMetadata(get_class($entity));

            $class->reflFields[$association['mappedBy']]->setValue($managedCopy, $previousManagedCopy);
        }
    }

    /**
     * Detaches an entity from the persistence management. It's persistence will
     * no longer be managed by Doctrine.
     *
     * @param object $entity The entity to detach.
     *
     * @return void
     */
    public function detach($entity)
    {
        $visited = [];

        $this->doDetach($entity, $visited);
    }

    /**
     * Executes a detach operation on the given entity.
     *
     * @param object  $entity
     * @param array   $visited
     * @param boolean $noCascade if true, don't cascade detach operation.
     *
     * @return void
     */
    private function doDetach($entity, array &$visited, $noCascade = false)
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            return; // Prevent infinite recursion
        }

        $visited[$oid] = $entity; // mark visited

        switch ($this->getEntityState($entity, self::STATE_DETACHED)) {
            case self::STATE_MANAGED:
                if ($this->isInIdentityMap($entity)) {
                    $this->removeFromIdentityMap($entity);
                }

                unset(
                    $this->entityInsertions[$oid],
                    $this->entityUpdates[$oid],
                    $this->entityDeletions[$oid],
                    $this->entityIdentifiers[$oid],
                    $this->entityStates[$oid],
                    $this->originalEntityData[$oid]
                );
                break;
            case self::STATE_NEW:
            case self::STATE_DETACHED:
                return;
        }

        if ( ! $noCascade) {
            $this->cascadeDetach($entity, $visited);
        }
    }

    /**
     * Refreshes the state of the given entity from the database, overwriting
     * any local, unpersisted changes.
     *
     * @param object $entity The entity to refresh.
     *
     * @return void
     *
     * @throws InvalidArgumentException If the entity is not MANAGED.
     */
    public function refresh($entity)
    {
        $visited = [];

        $this->doRefresh($entity, $visited);
    }

    /**
     * Executes a refresh operation on an entity.
     *
     * @param object $entity  The entity to refresh.
     * @param array  $visited The already visited entities during cascades.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException If the entity is not MANAGED.
     */
    private function doRefresh($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            return; // Prevent infinite recursion
        }

        $visited[$oid] = $entity; // mark visited

        $class = $this->em->getClassMetadata(get_class($entity));

        if ($this->getEntityState($entity) !== self::STATE_MANAGED) {
            throw ORMInvalidArgumentException::entityNotManaged($entity);
        }

        $this->getEntityPersister($class->name)->refresh(
            array_combine($class->getIdentifierFieldNames(), $this->entityIdentifiers[$oid]),
            $entity
        );

        $this->cascadeRefresh($entity, $visited);
    }

    /**
     * Cascades a refresh operation to associated entities.
     *
     * @param object $entity
     * @param array  $visited
     *
     * @return void
     */
    private function cascadeRefresh($entity, array &$visited)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        $associationMappings = array_filter(
            $class->associationMappings,
            function ($assoc) { return $assoc['isCascadeRefresh']; }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof PersistentCollection):
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                    // break; is commented intentionally!

                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    foreach ($relatedEntities as $relatedEntity) {
                        $this->doRefresh($relatedEntity, $visited);
                    }
                    break;

                case ($relatedEntities !== null):
                    $this->doRefresh($relatedEntities, $visited);
                    break;

                default:
                    // Do nothing
            }
        }
    }

    /**
     * Cascades a detach operation to associated entities.
     *
     * @param object $entity
     * @param array  $visited
     *
     * @return void
     */
    private function cascadeDetach($entity, array &$visited)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        $associationMappings = array_filter(
            $class->associationMappings,
            function ($assoc) { return $assoc['isCascadeDetach']; }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof PersistentCollection):
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                    // break; is commented intentionally!

                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    foreach ($relatedEntities as $relatedEntity) {
                        $this->doDetach($relatedEntity, $visited);
                    }
                    break;

                case ($relatedEntities !== null):
                    $this->doDetach($relatedEntities, $visited);
                    break;

                default:
                    // Do nothing
            }
        }
    }

    /**
     * Cascades a merge operation to associated entities.
     *
     * @param object $entity
     * @param object $managedCopy
     * @param array  $visited
     *
     * @return void
     */
    private function cascadeMerge($entity, $managedCopy, array &$visited)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        $associationMappings = array_filter(
            $class->associationMappings,
            function ($assoc) { return $assoc['isCascadeMerge']; }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            if ($relatedEntities instanceof Collection) {
                if ($relatedEntities === $class->reflFields[$assoc['fieldName']]->getValue($managedCopy)) {
                    continue;
                }

                if ($relatedEntities instanceof PersistentCollection) {
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                }

                foreach ($relatedEntities as $relatedEntity) {
                    $this->doMerge($relatedEntity, $visited, $managedCopy, $assoc);
                }
            } else if ($relatedEntities !== null) {
                $this->doMerge($relatedEntities, $visited, $managedCopy, $assoc);
            }
        }
    }

    /**
     * Cascades the save operation to associated entities.
     *
     * @param object $entity
     * @param array  $visited
     *
     * @return void
     */
    private function cascadePersist($entity, array &$visited)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        $associationMappings = array_filter(
            $class->associationMappings,
            function ($assoc) { return $assoc['isCascadePersist']; }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof PersistentCollection):
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                    // break; is commented intentionally!

                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    if (($assoc['type'] & ClassMetadata::TO_MANY) <= 0) {
                        throw ORMInvalidArgumentException::invalidAssociation(
                            $this->em->getClassMetadata($assoc['targetEntity']),
                            $assoc,
                            $relatedEntities
                        );
                    }

                    foreach ($relatedEntities as $relatedEntity) {
                        $this->doPersist($relatedEntity, $visited);
                    }

                    break;

                case ($relatedEntities !== null):
                    if (! $relatedEntities instanceof $assoc['targetEntity']) {
                        throw ORMInvalidArgumentException::invalidAssociation(
                            $this->em->getClassMetadata($assoc['targetEntity']),
                            $assoc,
                            $relatedEntities
                        );
                    }

                    $this->doPersist($relatedEntities, $visited);
                    break;

                default:
                    // Do nothing
            }
        }
    }

    /**
     * Cascades the delete operation to associated entities.
     *
     * @param object $entity
     * @param array  $visited
     *
     * @return void
     */
    private function cascadeRemove($entity, array &$visited)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        $associationMappings = array_filter(
            $class->associationMappings,
            function ($assoc) { return $assoc['isCascadeRemove']; }
        );

        $entitiesToCascade = [];

        foreach ($associationMappings as $assoc) {
            if ($entity instanceof Proxy && !$entity->__isInitialized__) {
                $entity->__load();
            }

            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    // If its a PersistentCollection initialization is intended! No unwrap!
                    foreach ($relatedEntities as $relatedEntity) {
                        $entitiesToCascade[] = $relatedEntity;
                    }
                    break;

                case ($relatedEntities !== null):
                    $entitiesToCascade[] = $relatedEntities;
                    break;

                default:
                    // Do nothing
            }
        }

        foreach ($entitiesToCascade as $relatedEntity) {
            $this->doRemove($relatedEntity, $visited);
        }
    }

    /**
     * Acquire a lock on the given entity.
     *
     * @param object $entity
     * @param int    $lockMode
     * @param int    $lockVersion
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws OptimisticLockException
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        if ($entity === null) {
            throw new \InvalidArgumentException("No entity passed to UnitOfWork#lock().");
        }

        if ($this->getEntityState($entity, self::STATE_DETACHED) != self::STATE_MANAGED) {
            throw ORMInvalidArgumentException::entityNotManaged($entity);
        }

        $class = $this->em->getClassMetadata(get_class($entity));

        switch (true) {
            case LockMode::OPTIMISTIC === $lockMode:
                if ( ! $class->isVersioned) {
                    throw OptimisticLockException::notVersioned($class->name);
                }

                if ($lockVersion === null) {
                    return;
                }

                if ($entity instanceof Proxy && !$entity->__isInitialized__) {
                    $entity->__load();
                }

                $entityVersion = $class->reflFields[$class->versionField]->getValue($entity);

                if ($entityVersion != $lockVersion) {
                    throw OptimisticLockException::lockFailedVersionMismatch($entity, $lockVersion, $entityVersion);
                }

                break;

            case LockMode::NONE === $lockMode:
            case LockMode::PESSIMISTIC_READ === $lockMode:
            case LockMode::PESSIMISTIC_WRITE === $lockMode:
                if (!$this->em->getConnection()->isTransactionActive()) {
                    throw TransactionRequiredException::transactionRequired();
                }

                $oid = spl_object_hash($entity);

                $this->getEntityPersister($class->name)->lock(
                    array_combine($class->getIdentifierFieldNames(), $this->entityIdentifiers[$oid]),
                    $lockMode
                );
                break;

            default:
                // Do nothing
        }
    }

    /**
     * Gets the CommitOrderCalculator used by the UnitOfWork to order commits.
     *
     * @return \Doctrine\ORM\Internal\CommitOrderCalculator
     */
    public function getCommitOrderCalculator()
    {
        return new Internal\CommitOrderCalculator();
    }

    /**
     * Clears the UnitOfWork.
     *
     * @param string|null $entityName if given, only entities of this type will get detached.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException if an invalid entity name is given
     */
    public function clear($entityName = null)
    {
        if ($entityName === null) {
            $this->identityMap =
            $this->entityIdentifiers =
            $this->originalEntityData =
            $this->entityChangeSets =
            $this->entityStates =
            $this->scheduledForSynchronization =
            $this->entityInsertions =
            $this->entityUpdates =
            $this->entityDeletions =
            $this->nonCascadedNewDetectedEntities =
            $this->collectionDeletions =
            $this->collectionUpdates =
            $this->extraUpdates =
            $this->readOnlyObjects =
            $this->visitedCollections =
            $this->orphanRemovals = [];
        } else {
            $this->clearIdentityMapForEntityName($entityName);
            $this->clearEntityInsertionsForEntityName($entityName);
        }

        if ($this->evm->hasListeners(Events::onClear)) {
            $this->evm->dispatchEvent(Events::onClear, new Event\OnClearEventArgs($this->em, $entityName));
        }
    }

    /**
     * INTERNAL:
     * Schedules an orphaned entity for removal. The remove() operation will be
     * invoked on that entity at the beginning of the next commit of this
     * UnitOfWork.
     *
     * @ignore
     *
     * @param object $entity
     *
     * @return void
     */
    public function scheduleOrphanRemoval($entity)
    {
        $this->orphanRemovals[spl_object_hash($entity)] = $entity;
    }

    /**
     * INTERNAL:
     * Cancels a previously scheduled orphan removal.
     *
     * @ignore
     *
     * @param object $entity
     *
     * @return void
     */
    public function cancelOrphanRemoval($entity)
    {
        unset($this->orphanRemovals[spl_object_hash($entity)]);
    }

    /**
     * INTERNAL:
     * Schedules a complete collection for removal when this UnitOfWork commits.
     *
     * @param PersistentCollection $coll
     *
     * @return void
     */
    public function scheduleCollectionDeletion(PersistentCollection $coll)
    {
        $coid = spl_object_hash($coll);

        // TODO: if $coll is already scheduled for recreation ... what to do?
        // Just remove $coll from the scheduled recreations?
        unset($this->collectionUpdates[$coid]);

        $this->collectionDeletions[$coid] = $coll;
    }

    /**
     * @param PersistentCollection $coll
     *
     * @return bool
     */
    public function isCollectionScheduledForDeletion(PersistentCollection $coll)
    {
        return isset($this->collectionDeletions[spl_object_hash($coll)]);
    }

    /**
     * @param ClassMetadata $class
     *
     * @return \Doctrine\Common\Persistence\ObjectManagerAware|object
     */
    private function newInstance($class)
    {
        $entity = $class->newInstance();

        if ($entity instanceof \Doctrine\Common\Persistence\ObjectManagerAware) {
            $entity->injectObjectManager($this->em, $class);
        }

        return $entity;
    }

    /**
     * INTERNAL:
     * Creates an entity. Used for reconstitution of persistent entities.
     *
     * Internal note: Highly performance-sensitive method.
     *
     * @ignore
     *
     * @param string $className The name of the entity class.
     * @param array  $data      The data for the entity.
     * @param array  $hints     Any hints to account for during reconstitution/lookup of the entity.
     *
     * @return object The managed entity instance.
     *
     * @todo Rename: getOrCreateEntity
     */
    public function createEntity($className, array $data, &$hints = [])
    {
        $class = $this->em->getClassMetadata($className);

        $id = $this->identifierFlattener->flattenIdentifier($class, $data);
        $idHash = implode(' ', $id);

        if (isset($this->identityMap[$class->rootEntityName][$idHash])) {
            $entity = $this->identityMap[$class->rootEntityName][$idHash];
            $oid = spl_object_hash($entity);

            if (
                isset($hints[Query::HINT_REFRESH])
                && isset($hints[Query::HINT_REFRESH_ENTITY])
                && ($unmanagedProxy = $hints[Query::HINT_REFRESH_ENTITY]) !== $entity
                && $unmanagedProxy instanceof Proxy
                && $this->isIdentifierEquals($unmanagedProxy, $entity)
            ) {
                // DDC-1238 - we have a managed instance, but it isn't the provided one.
                // Therefore we clear its identifier. Also, we must re-fetch metadata since the
                // refreshed object may be anything

                foreach ($class->identifier as $fieldName) {
                    $class->reflFields[$fieldName]->setValue($unmanagedProxy, null);
                }

                return $unmanagedProxy;
            }

            if ($entity instanceof Proxy && ! $entity->__isInitialized()) {
                $entity->__setInitialized(true);

                if ($entity instanceof NotifyPropertyChanged) {
                    $entity->addPropertyChangedListener($this);
                }
            } else {
                if ( ! isset($hints[Query::HINT_REFRESH])
                    || (isset($hints[Query::HINT_REFRESH_ENTITY]) && $hints[Query::HINT_REFRESH_ENTITY] !== $entity)) {
                    return $entity;
                }
            }

            // inject ObjectManager upon refresh.
            if ($entity instanceof ObjectManagerAware) {
                $entity->injectObjectManager($this->em, $class);
            }

            $this->originalEntityData[$oid] = $data;
        } else {
            $entity = $this->newInstance($class);
            $oid    = spl_object_hash($entity);

            $this->entityIdentifiers[$oid]  = $id;
            $this->entityStates[$oid]       = self::STATE_MANAGED;
            $this->originalEntityData[$oid] = $data;

            $this->identityMap[$class->rootEntityName][$idHash] = $entity;

            if ($entity instanceof NotifyPropertyChanged) {
                $entity->addPropertyChangedListener($this);
            }
        }

        foreach ($data as $field => $value) {
            if (isset($class->fieldMappings[$field])) {
                $class->reflFields[$field]->setValue($entity, $value);
            }
        }

        // Loading the entity right here, if its in the eager loading map get rid of it there.
        unset($this->eagerLoadingEntities[$class->rootEntityName][$idHash]);

        if (isset($this->eagerLoadingEntities[$class->rootEntityName]) && ! $this->eagerLoadingEntities[$class->rootEntityName]) {
            unset($this->eagerLoadingEntities[$class->rootEntityName]);
        }

        // Properly initialize any unfetched associations, if partial objects are not allowed.
        if (isset($hints[Query::HINT_FORCE_PARTIAL_LOAD])) {
            return $entity;
        }

        foreach ($class->associationMappings as $field => $assoc) {
            // Check if the association is not among the fetch-joined associations already.
            if (isset($hints['fetchAlias']) && isset($hints['fetched'][$hints['fetchAlias']][$field])) {
                continue;
            }

            $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);

            switch (true) {
                case ($assoc['type'] & ClassMetadata::TO_ONE):
                    if ( ! $assoc['isOwningSide']) {

                        // use the given entity association
                        if (isset($data[$field]) && is_object($data[$field]) && isset($this->entityStates[spl_object_hash($data[$field])])) {

                            $this->originalEntityData[$oid][$field] = $data[$field];

                            $class->reflFields[$field]->setValue($entity, $data[$field]);
                            $targetClass->reflFields[$assoc['mappedBy']]->setValue($data[$field], $entity);

                            continue 2;
                        }

                        // Inverse side of x-to-one can never be lazy
                        $class->reflFields[$field]->setValue($entity, $this->getEntityPersister($assoc['targetEntity'])->loadOneToOneEntity($assoc, $entity));

                        continue 2;
                    }

                    // use the entity association
                    if (isset($data[$field]) && is_object($data[$field]) && isset($this->entityStates[spl_object_hash($data[$field])])) {
                        $class->reflFields[$field]->setValue($entity, $data[$field]);
                        $this->originalEntityData[$oid][$field] = $data[$field];

                        break;
                    }

                    $associatedId = [];

                    // TODO: Is this even computed right in all cases of composite keys?
                    foreach ($assoc['targetToSourceKeyColumns'] as $targetColumn => $srcColumn) {
                        $joinColumnValue = $data[$srcColumn] ?? null;

                        if ($joinColumnValue !== null) {
                            if ($targetClass->containsForeignIdentifier) {
                                $associatedId[$targetClass->getFieldForColumn($targetColumn)] = $joinColumnValue;
                            } else {
                                $associatedId[$targetClass->fieldNames[$targetColumn]] = $joinColumnValue;
                            }
                        } elseif ($targetClass->containsForeignIdentifier
                            && in_array($targetClass->getFieldForColumn($targetColumn), $targetClass->identifier, true)
                        ) {
                            // the missing key is part of target's entity primary key
                            $associatedId = [];
                            break;
                        }
                    }

                    if ( ! $associatedId) {
                        // Foreign key is NULL
                        $class->reflFields[$field]->setValue($entity, null);
                        $this->originalEntityData[$oid][$field] = null;

                        break;
                    }

                    if ( ! isset($hints['fetchMode'][$class->name][$field])) {
                        $hints['fetchMode'][$class->name][$field] = $assoc['fetch'];
                    }

                    // Foreign key is set
                    // Check identity map first
                    // FIXME: Can break easily with composite keys if join column values are in
                    //        wrong order. The correct order is the one in ClassMetadata#identifier.
                    $relatedIdHash = implode(' ', $associatedId);

                    switch (true) {
                        case (isset($this->identityMap[$targetClass->rootEntityName][$relatedIdHash])):
                            $newValue = $this->identityMap[$targetClass->rootEntityName][$relatedIdHash];

                            // If this is an uninitialized proxy, we are deferring eager loads,
                            // this association is marked as eager fetch, and its an uninitialized proxy (wtf!)
                            // then we can append this entity for eager loading!
                            if ($hints['fetchMode'][$class->name][$field] == ClassMetadata::FETCH_EAGER &&
                                isset($hints[self::HINT_DEFEREAGERLOAD]) &&
                                !$targetClass->isIdentifierComposite &&
                                $newValue instanceof Proxy &&
                                $newValue->__isInitialized__ === false) {

                                $this->eagerLoadingEntities[$targetClass->rootEntityName][$relatedIdHash] = current($associatedId);
                            }

                            break;

                        case ($targetClass->subClasses):
                            // If it might be a subtype, it can not be lazy. There isn't even
                            // a way to solve this with deferred eager loading, which means putting
                            // an entity with subclasses at a *-to-one location is really bad! (performance-wise)
                            $newValue = $this->getEntityPersister($assoc['targetEntity'])->loadOneToOneEntity($assoc, $entity, $associatedId);
                            break;

                        default:
                            switch (true) {
                                // We are negating the condition here. Other cases will assume it is valid!
                                case ($hints['fetchMode'][$class->name][$field] !== ClassMetadata::FETCH_EAGER):
                                    $newValue = $this->em->getProxyFactory()->getProxy($assoc['targetEntity'], $associatedId);
                                    break;

                                // Deferred eager load only works for single identifier classes
                                case (isset($hints[self::HINT_DEFEREAGERLOAD]) && ! $targetClass->isIdentifierComposite):
                                    // TODO: Is there a faster approach?
                                    $this->eagerLoadingEntities[$targetClass->rootEntityName][$relatedIdHash] = current($associatedId);

                                    $newValue = $this->em->getProxyFactory()->getProxy($assoc['targetEntity'], $associatedId);
                                    break;

                                default:
                                    // TODO: This is very imperformant, ignore it?
                                    $newValue = $this->em->find($assoc['targetEntity'], $associatedId);
                                    break;
                            }

                            // PERF: Inlined & optimized code from UnitOfWork#registerManaged()
                            $newValueOid = spl_object_hash($newValue);
                            $this->entityIdentifiers[$newValueOid] = $associatedId;
                            $this->identityMap[$targetClass->rootEntityName][$relatedIdHash] = $newValue;

                            if (
                                $newValue instanceof NotifyPropertyChanged &&
                                ( ! $newValue instanceof Proxy || $newValue->__isInitialized())
                            ) {
                                $newValue->addPropertyChangedListener($this);
                            }
                            $this->entityStates[$newValueOid] = self::STATE_MANAGED;
                            // make sure that when an proxy is then finally loaded, $this->originalEntityData is set also!
                            break;
                    }

                    $this->originalEntityData[$oid][$field] = $newValue;
                    $class->reflFields[$field]->setValue($entity, $newValue);

                    if ($assoc['inversedBy'] && $assoc['type'] & ClassMetadata::ONE_TO_ONE) {
                        $inverseAssoc = $targetClass->associationMappings[$assoc['inversedBy']];
                        $targetClass->reflFields[$inverseAssoc['fieldName']]->setValue($newValue, $entity);
                    }

                    break;

                default:
                    // Ignore if its a cached collection
                    if (isset($hints[Query::HINT_CACHE_ENABLED]) && $class->getFieldValue($entity, $field) instanceof PersistentCollection) {
                        break;
                    }

                    // use the given collection
                    if (isset($data[$field]) && $data[$field] instanceof PersistentCollection) {

                        $data[$field]->setOwner($entity, $assoc);

                        $class->reflFields[$field]->setValue($entity, $data[$field]);
                        $this->originalEntityData[$oid][$field] = $data[$field];

                        break;
                    }

                    // Inject collection
                    $pColl = new PersistentCollection($this->em, $targetClass, new ArrayCollection);
                    $pColl->setOwner($entity, $assoc);
                    $pColl->setInitialized(false);

                    $reflField = $class->reflFields[$field];
                    $reflField->setValue($entity, $pColl);

                    if ($assoc['fetch'] == ClassMetadata::FETCH_EAGER) {
                        $this->loadCollection($pColl);
                        $pColl->takeSnapshot();
                    }

                    $this->originalEntityData[$oid][$field] = $pColl;
                    break;
            }
        }

        // defer invoking of postLoad event to hydration complete step
        $this->hydrationCompleteHandler->deferPostLoadInvoking($class, $entity);

        return $entity;
    }

    /**
     * @return void
     */
    public function triggerEagerLoads()
    {
        if ( ! $this->eagerLoadingEntities) {
            return;
        }

        // avoid infinite recursion
        $eagerLoadingEntities       = $this->eagerLoadingEntities;
        $this->eagerLoadingEntities = [];

        foreach ($eagerLoadingEntities as $entityName => $ids) {
            if ( ! $ids) {
                continue;
            }

            $class = $this->em->getClassMetadata($entityName);

            $this->getEntityPersister($entityName)->loadAll(
                array_combine($class->identifier, [array_values($ids)])
            );
        }
    }

    /**
     * Initializes (loads) an uninitialized persistent collection of an entity.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection The collection to initialize.
     *
     * @return void
     *
     * @todo Maybe later move to EntityManager#initialize($proxyOrCollection). See DDC-733.
     */
    public function loadCollection(PersistentCollection $collection)
    {
        $assoc     = $collection->getMapping();
        $persister = $this->getEntityPersister($assoc['targetEntity']);

        switch ($assoc['type']) {
            case ClassMetadata::ONE_TO_MANY:
                $persister->loadOneToManyCollection($assoc, $collection->getOwner(), $collection);
                break;

            case ClassMetadata::MANY_TO_MANY:
                $persister->loadManyToManyCollection($assoc, $collection->getOwner(), $collection);
                break;
        }

        $collection->setInitialized(true);
    }

    /**
     * Gets the identity map of the UnitOfWork.
     *
     * @return array
     */
    public function getIdentityMap()
    {
        return $this->identityMap;
    }

    /**
     * Gets the original data of an entity. The original data is the data that was
     * present at the time the entity was reconstituted from the database.
     *
     * @param object $entity
     *
     * @return array
     */
    public function getOriginalEntityData($entity)
    {
        $oid = spl_object_hash($entity);

        return isset($this->originalEntityData[$oid])
            ? $this->originalEntityData[$oid]
            : [];
    }

    /**
     * @ignore
     *
     * @param object $entity
     * @param array  $data
     *
     * @return void
     */
    public function setOriginalEntityData($entity, array $data)
    {
        $this->originalEntityData[spl_object_hash($entity)] = $data;
    }

    /**
     * INTERNAL:
     * Sets a property value of the original data array of an entity.
     *
     * @ignore
     *
     * @param string $oid
     * @param string $property
     * @param mixed  $value
     *
     * @return void
     */
    public function setOriginalEntityProperty($oid, $property, $value)
    {
        $this->originalEntityData[$oid][$property] = $value;
    }

    /**
     * Gets the identifier of an entity.
     * The returned value is always an array of identifier values. If the entity
     * has a composite identifier then the identifier values are in the same
     * order as the identifier field names as returned by ClassMetadata#getIdentifierFieldNames().
     *
     * @param object $entity
     *
     * @return array The identifier values.
     */
    public function getEntityIdentifier($entity)
    {
        return $this->entityIdentifiers[spl_object_hash($entity)];
    }

    /**
     * Processes an entity instance to extract their identifier values.
     *
     * @param object $entity The entity instance.
     *
     * @return mixed A scalar value.
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function getSingleIdentifierValue($entity)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        if ($class->isIdentifierComposite) {
            throw ORMInvalidArgumentException::invalidCompositeIdentifier();
        }

        $values = $this->isInIdentityMap($entity)
            ? $this->getEntityIdentifier($entity)
            : $class->getIdentifierValues($entity);

        return isset($values[$class->identifier[0]]) ? $values[$class->identifier[0]] : null;
    }

    /**
     * Tries to find an entity with the given identifier in the identity map of
     * this UnitOfWork.
     *
     * @param mixed  $id            The entity identifier to look for.
     * @param string $rootClassName The name of the root class of the mapped entity hierarchy.
     *
     * @return object|bool Returns the entity with the specified identifier if it exists in
     *                     this UnitOfWork, FALSE otherwise.
     */
    public function tryGetById($id, $rootClassName)
    {
        $idHash = implode(' ', (array) $id);

        return isset($this->identityMap[$rootClassName][$idHash])
            ? $this->identityMap[$rootClassName][$idHash]
            : false;
    }

    /**
     * Schedules an entity for dirty-checking at commit-time.
     *
     * @param object $entity The entity to schedule for dirty-checking.
     *
     * @return void
     *
     * @todo Rename: scheduleForSynchronization
     */
    public function scheduleForDirtyCheck($entity)
    {
        $rootClassName = $this->em->getClassMetadata(get_class($entity))->rootEntityName;

        $this->scheduledForSynchronization[$rootClassName][spl_object_hash($entity)] = $entity;
    }

    /**
     * Checks whether the UnitOfWork has any pending insertions.
     *
     * @return boolean TRUE if this UnitOfWork has pending insertions, FALSE otherwise.
     */
    public function hasPendingInsertions()
    {
        return ! empty($this->entityInsertions);
    }

    /**
     * Calculates the size of the UnitOfWork. The size of the UnitOfWork is the
     * number of entities in the identity map.
     *
     * @return integer
     */
    public function size()
    {
        $countArray = array_map('count', $this->identityMap);

        return array_sum($countArray);
    }

    /**
     * Gets the EntityPersister for an Entity.
     *
     * @param string $entityName The name of the Entity.
     *
     * @return \Doctrine\ORM\Persisters\Entity\EntityPersister
     */
    public function getEntityPersister($entityName)
    {
        if (isset($this->persisters[$entityName])) {
            return $this->persisters[$entityName];
        }

        $class = $this->em->getClassMetadata($entityName);

        switch (true) {
            case ($class->isInheritanceTypeNone()):
                $persister = new BasicEntityPersister($this->em, $class);
                break;

            case ($class->isInheritanceTypeSingleTable()):
                $persister = new SingleTablePersister($this->em, $class);
                break;

            case ($class->isInheritanceTypeJoined()):
                $persister = new JoinedSubclassPersister($this->em, $class);
                break;

            default:
                throw new \RuntimeException('No persister found for entity.');
        }

        if ($this->hasCache && $class->cache !== null) {
            $persister = $this->em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedEntityPersister($this->em, $persister, $class);
        }

        $this->persisters[$entityName] = $persister;

        return $this->persisters[$entityName];
    }

    /**
     * Gets a collection persister for a collection-valued association.
     *
     * @param array $association
     *
     * @return \Doctrine\ORM\Persisters\Collection\CollectionPersister
     */
    public function getCollectionPersister(array $association)
    {
        $role = isset($association['cache'])
            ? $association['sourceEntity'] . '::' . $association['fieldName']
            : $association['type'];

        if (isset($this->collectionPersisters[$role])) {
            return $this->collectionPersisters[$role];
        }

        $persister = ClassMetadata::ONE_TO_MANY === $association['type']
            ? new OneToManyPersister($this->em)
            : new ManyToManyPersister($this->em);

        if ($this->hasCache && isset($association['cache'])) {
            $persister = $this->em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedCollectionPersister($this->em, $persister, $association);
        }

        $this->collectionPersisters[$role] = $persister;

        return $this->collectionPersisters[$role];
    }

    /**
     * INTERNAL:
     * Registers an entity as managed.
     *
     * @param object $entity The entity.
     * @param array  $id     The identifier values.
     * @param array  $data   The original entity data.
     *
     * @return void
     */
    public function registerManaged($entity, array $id, array $data)
    {
        $oid = spl_object_hash($entity);

        $this->entityIdentifiers[$oid]  = $id;
        $this->entityStates[$oid]       = self::STATE_MANAGED;
        $this->originalEntityData[$oid] = $data;

        $this->addToIdentityMap($entity);

        if ($entity instanceof NotifyPropertyChanged && ( ! $entity instanceof Proxy || $entity->__isInitialized())) {
            $entity->addPropertyChangedListener($this);
        }
    }

    /**
     * INTERNAL:
     * Clears the property changeset of the entity with the given OID.
     *
     * @param string $oid The entity's OID.
     *
     * @return void
     */
    public function clearEntityChangeSet($oid)
    {
        unset($this->entityChangeSets[$oid]);
    }

    /* PropertyChangedListener implementation */

    /**
     * Notifies this UnitOfWork of a property change in an entity.
     *
     * @param object $entity       The entity that owns the property.
     * @param string $propertyName The name of the property that changed.
     * @param mixed  $oldValue     The old value of the property.
     * @param mixed  $newValue     The new value of the property.
     *
     * @return void
     */
    public function propertyChanged($entity, $propertyName, $oldValue, $newValue)
    {
        $oid   = spl_object_hash($entity);
        $class = $this->em->getClassMetadata(get_class($entity));

        $isAssocField = isset($class->associationMappings[$propertyName]);

        if ( ! $isAssocField && ! isset($class->fieldMappings[$propertyName])) {
            return; // ignore non-persistent fields
        }

        // Update changeset and mark entity for synchronization
        $this->entityChangeSets[$oid][$propertyName] = [$oldValue, $newValue];

        if ( ! isset($this->scheduledForSynchronization[$class->rootEntityName][$oid])) {
            $this->scheduleForDirtyCheck($entity);
        }
    }

    /**
     * Gets the currently scheduled entity insertions in this UnitOfWork.
     *
     * @return array
     */
    public function getScheduledEntityInsertions()
    {
        return $this->entityInsertions;
    }

    /**
     * Gets the currently scheduled entity updates in this UnitOfWork.
     *
     * @return array
     */
    public function getScheduledEntityUpdates()
    {
        return $this->entityUpdates;
    }

    /**
     * Gets the currently scheduled entity deletions in this UnitOfWork.
     *
     * @return array
     */
    public function getScheduledEntityDeletions()
    {
        return $this->entityDeletions;
    }

    /**
     * Gets the currently scheduled complete collection deletions
     *
     * @return array
     */
    public function getScheduledCollectionDeletions()
    {
        return $this->collectionDeletions;
    }

    /**
     * Gets the currently scheduled collection inserts, updates and deletes.
     *
     * @return array
     */
    public function getScheduledCollectionUpdates()
    {
        return $this->collectionUpdates;
    }

    /**
     * Helper method to initialize a lazy loading proxy or persistent collection.
     *
     * @param object $obj
     *
     * @return void
     */
    public function initializeObject($obj)
    {
        if ($obj instanceof Proxy) {
            $obj->__load();

            return;
        }

        if ($obj instanceof PersistentCollection) {
            $obj->initialize();
        }
    }

    /**
     * Helper method to show an object as string.
     *
     * @param object $obj
     *
     * @return string
     */
    private static function objToStr($obj)
    {
        return method_exists($obj, '__toString') ? (string) $obj : get_class($obj).'@'.spl_object_hash($obj);
    }

    /**
     * Marks an entity as read-only so that it will not be considered for updates during UnitOfWork#commit().
     *
     * This operation cannot be undone as some parts of the UnitOfWork now keep gathering information
     * on this object that might be necessary to perform a correct update.
     *
     * @param object $object
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function markReadOnly($object)
    {
        if ( ! is_object($object) || ! $this->isInIdentityMap($object)) {
            throw ORMInvalidArgumentException::readOnlyRequiresManagedEntity($object);
        }

        $this->readOnlyObjects[spl_object_hash($object)] = true;
    }

    /**
     * Is this entity read only?
     *
     * @param object $object
     *
     * @return bool
     *
     * @throws ORMInvalidArgumentException
     */
    public function isReadOnly($object)
    {
        if ( ! is_object($object)) {
            throw ORMInvalidArgumentException::readOnlyRequiresManagedEntity($object);
        }

        return isset($this->readOnlyObjects[spl_object_hash($object)]);
    }

    /**
     * Perform whatever processing is encapsulated here after completion of the transaction.
     */
    private function afterTransactionComplete()
    {
        $this->performCallbackOnCachedPersister(function (CachedPersister $persister) {
            $persister->afterTransactionComplete();
        });
    }

    /**
     * Perform whatever processing is encapsulated here after completion of the rolled-back.
     */
    private function afterTransactionRolledBack()
    {
        $this->performCallbackOnCachedPersister(function (CachedPersister $persister) {
            $persister->afterTransactionRolledBack();
        });
    }

    /**
     * Performs an action after the transaction.
     *
     * @param callable $callback
     */
    private function performCallbackOnCachedPersister(callable $callback)
    {
        if ( ! $this->hasCache) {
            return;
        }

        foreach (array_merge($this->persisters, $this->collectionPersisters) as $persister) {
            if ($persister instanceof CachedPersister) {
                $callback($persister);
            }
        }
    }

    private function dispatchOnFlushEvent()
    {
        if ($this->evm->hasListeners(Events::onFlush)) {
            $this->evm->dispatchEvent(Events::onFlush, new OnFlushEventArgs($this->em));
        }
    }

    private function dispatchPostFlushEvent()
    {
        if ($this->evm->hasListeners(Events::postFlush)) {
            $this->evm->dispatchEvent(Events::postFlush, new PostFlushEventArgs($this->em));
        }
    }

    /**
     * Verifies if two given entities actually are the same based on identifier comparison
     *
     * @param object $entity1
     * @param object $entity2
     *
     * @return bool
     */
    private function isIdentifierEquals($entity1, $entity2)
    {
        if ($entity1 === $entity2) {
            return true;
        }

        $class = $this->em->getClassMetadata(get_class($entity1));

        if ($class !== $this->em->getClassMetadata(get_class($entity2))) {
            return false;
        }

        $oid1 = spl_object_hash($entity1);
        $oid2 = spl_object_hash($entity2);

        $id1 = isset($this->entityIdentifiers[$oid1])
            ? $this->entityIdentifiers[$oid1]
            : $this->identifierFlattener->flattenIdentifier($class, $class->getIdentifierValues($entity1));
        $id2 = isset($this->entityIdentifiers[$oid2])
            ? $this->entityIdentifiers[$oid2]
            : $this->identifierFlattener->flattenIdentifier($class, $class->getIdentifierValues($entity2));

        return $id1 === $id2 || implode(' ', $id1) === implode(' ', $id2);
    }

    /**
     * @throws ORMInvalidArgumentException
     */
    private function assertThatThereAreNoUnintentionallyNonPersistedAssociations() : void
    {
        $entitiesNeedingCascadePersist = \array_diff_key($this->nonCascadedNewDetectedEntities, $this->entityInsertions);

        $this->nonCascadedNewDetectedEntities = [];

        if ($entitiesNeedingCascadePersist) {
            throw ORMInvalidArgumentException::newEntitiesFoundThroughRelationships(
                \array_values($entitiesNeedingCascadePersist)
            );
        }
    }

    /**
     * @param object $entity
     * @param object $managedCopy
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    private function mergeEntityStateIntoManagedCopy($entity, $managedCopy)
    {
        if (! $this->isLoaded($entity)) {
            return;
        }

        if (! $this->isLoaded($managedCopy)) {
            $managedCopy->__load();
        }

        $class = $this->em->getClassMetadata(get_class($entity));

        foreach ($this->reflectionPropertiesGetter->getProperties($class->name) as $prop) {
            $name = $prop->name;

            $prop->setAccessible(true);

            if ( ! isset($class->associationMappings[$name])) {
                if ( ! $class->isIdentifier($name)) {
                    $prop->setValue($managedCopy, $prop->getValue($entity));
                }
            } else {
                $assoc2 = $class->associationMappings[$name];

                if ($assoc2['type'] & ClassMetadata::TO_ONE) {
                    $other = $prop->getValue($entity);
                    if ($other === null) {
                        $prop->setValue($managedCopy, null);
                    } else {
                        if ($other instanceof Proxy && !$other->__isInitialized()) {
                            // do not merge fields marked lazy that have not been fetched.
                            continue;
                        }

                        if ( ! $assoc2['isCascadeMerge']) {
                            if ($this->getEntityState($other) === self::STATE_DETACHED) {
                                $targetClass = $this->em->getClassMetadata($assoc2['targetEntity']);
                                $relatedId   = $targetClass->getIdentifierValues($other);

                                if ($targetClass->subClasses) {
                                    $other = $this->em->find($targetClass->name, $relatedId);
                                } else {
                                    $other = $this->em->getProxyFactory()->getProxy(
                                        $assoc2['targetEntity'],
                                        $relatedId
                                    );
                                    $this->registerManaged($other, $relatedId, []);
                                }
                            }

                            $prop->setValue($managedCopy, $other);
                        }
                    }
                } else {
                    $mergeCol = $prop->getValue($entity);

                    if ($mergeCol instanceof PersistentCollection && ! $mergeCol->isInitialized()) {
                        // do not merge fields marked lazy that have not been fetched.
                        // keep the lazy persistent collection of the managed copy.
                        continue;
                    }

                    $managedCol = $prop->getValue($managedCopy);

                    if ( ! $managedCol) {
                        $managedCol = new PersistentCollection(
                            $this->em,
                            $this->em->getClassMetadata($assoc2['targetEntity']),
                            new ArrayCollection
                        );
                        $managedCol->setOwner($managedCopy, $assoc2);
                        $prop->setValue($managedCopy, $managedCol);
                    }

                    if ($assoc2['isCascadeMerge']) {
                        $managedCol->initialize();

                        // clear and set dirty a managed collection if its not also the same collection to merge from.
                        if ( ! $managedCol->isEmpty() && $managedCol !== $mergeCol) {
                            $managedCol->unwrap()->clear();
                            $managedCol->setDirty(true);

                            if ($assoc2['isOwningSide']
                                && $assoc2['type'] == ClassMetadata::MANY_TO_MANY
                                && $class->isChangeTrackingNotify()
                            ) {
                                $this->scheduleForDirtyCheck($managedCopy);
                            }
                        }
                    }
                }
            }

            if ($class->isChangeTrackingNotify()) {
                // Just treat all properties as changed, there is no other choice.
                $this->propertyChanged($managedCopy, $name, null, $prop->getValue($managedCopy));
            }
        }
    }

    /**
     * This method called by hydrators, and indicates that hydrator totally completed current hydration cycle.
     * Unit of work able to fire deferred events, related to loading events here.
     *
     * @internal should be called internally from object hydrators
     */
    public function hydrationComplete()
    {
        $this->hydrationCompleteHandler->hydrationComplete();
    }

    /**
     * @param string $entityName
     */
    private function clearIdentityMapForEntityName($entityName)
    {
        if (! isset($this->identityMap[$entityName])) {
            return;
        }

        $visited = [];

        foreach ($this->identityMap[$entityName] as $entity) {
            $this->doDetach($entity, $visited, false);
        }
    }

    /**
     * @param string $entityName
     */
    private function clearEntityInsertionsForEntityName($entityName)
    {
        foreach ($this->entityInsertions as $hash => $entity) {
            // note: performance optimization - `instanceof` is much faster than a function call
            if ($entity instanceof $entityName && get_class($entity) === $entityName) {
                unset($this->entityInsertions[$hash]);
            }
        }
    }

    /**
     * @param ClassMetadata $class
     * @param mixed         $identifierValue
     *
     * @return mixed the identifier after type conversion
     *
     * @throws \Doctrine\ORM\Mapping\MappingException if the entity has more than a single identifier
     */
    private function convertSingleFieldIdentifierToPHPValue(ClassMetadata $class, $identifierValue)
    {
        return $this->em->getConnection()->convertToPHPValue(
            $identifierValue,
            $class->getTypeOfField($class->getSingleIdentifierFieldName())
        );
    }
}
