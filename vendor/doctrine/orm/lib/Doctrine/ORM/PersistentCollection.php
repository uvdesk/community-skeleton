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

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * A PersistentCollection represents a collection of elements that have persistent state.
 *
 * Collections of entities represent only the associations (links) to those entities.
 * That means, if the collection is part of a many-many mapping and you remove
 * entities from the collection, only the links in the relation table are removed (on flush).
 * Similarly, if you remove entities from a collection that is part of a one-many
 * mapping this will only result in the nulling out of the foreign keys on flush.
 *
 * @since     2.0
 * @author    Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @author    Roman Borschel <roman@code-factory.org>
 * @author    Giorgio Sironi <piccoloprincipeazzurro@gmail.com>
 * @author    Stefano Rodriguez <stefano.rodriguez@fubles.com>
 */
final class PersistentCollection extends AbstractLazyCollection implements Selectable
{
    /**
     * A snapshot of the collection at the moment it was fetched from the database.
     * This is used to create a diff of the collection at commit time.
     *
     * @var array
     */
    private $snapshot = [];

    /**
     * The entity that owns this collection.
     *
     * @var object
     */
    private $owner;

    /**
     * The association mapping the collection belongs to.
     * This is currently either a OneToManyMapping or a ManyToManyMapping.
     *
     * @var array
     */
    private $association;

    /**
     * The EntityManager that manages the persistence of the collection.
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * The name of the field on the target entities that points to the owner
     * of the collection. This is only set if the association is bi-directional.
     *
     * @var string
     */
    private $backRefFieldName;

    /**
     * The class descriptor of the collection's entity type.
     *
     * @var ClassMetadata
     */
    private $typeClass;

    /**
     * Whether the collection is dirty and needs to be synchronized with the database
     * when the UnitOfWork that manages its persistent state commits.
     *
     * @var boolean
     */
    private $isDirty = false;

    /**
     * Creates a new persistent collection.
     *
     * @param EntityManagerInterface $em         The EntityManager the collection will be associated with.
     * @param ClassMetadata          $class      The class descriptor of the entity type of this collection.
     * @param Collection             $collection The collection elements.
     */
    public function __construct(EntityManagerInterface $em, $class, Collection $collection)
    {
        $this->collection  = $collection;
        $this->em          = $em;
        $this->typeClass   = $class;
        $this->initialized = true;
    }

    /**
     * INTERNAL:
     * Sets the collection's owning entity together with the AssociationMapping that
     * describes the association between the owner and the elements of the collection.
     *
     * @param object $entity
     * @param array  $assoc
     *
     * @return void
     */
    public function setOwner($entity, array $assoc)
    {
        $this->owner            = $entity;
        $this->association      = $assoc;
        $this->backRefFieldName = $assoc['inversedBy'] ?: $assoc['mappedBy'];
    }

    /**
     * INTERNAL:
     * Gets the collection owner.
     *
     * @return object
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return Mapping\ClassMetadata
     */
    public function getTypeClass()
    {
        return $this->typeClass;
    }

    /**
     * INTERNAL:
     * Adds an element to a collection during hydration. This will automatically
     * complete bidirectional associations in the case of a one-to-many association.
     *
     * @param mixed $element The element to add.
     *
     * @return void
     */
    public function hydrateAdd($element)
    {
        $this->collection->add($element);

        // If _backRefFieldName is set and its a one-to-many association,
        // we need to set the back reference.
        if ($this->backRefFieldName && $this->association['type'] === ClassMetadata::ONE_TO_MANY) {
            // Set back reference to owner
            $this->typeClass->reflFields[$this->backRefFieldName]->setValue(
                $element, $this->owner
            );

            $this->em->getUnitOfWork()->setOriginalEntityProperty(
                spl_object_hash($element), $this->backRefFieldName, $this->owner
            );
        }
    }

    /**
     * INTERNAL:
     * Sets a keyed element in the collection during hydration.
     *
     * @param mixed $key     The key to set.
     * @param mixed $element The element to set.
     *
     * @return void
     */
    public function hydrateSet($key, $element)
    {
        $this->collection->set($key, $element);

        // If _backRefFieldName is set, then the association is bidirectional
        // and we need to set the back reference.
        if ($this->backRefFieldName && $this->association['type'] === ClassMetadata::ONE_TO_MANY) {
            // Set back reference to owner
            $this->typeClass->reflFields[$this->backRefFieldName]->setValue(
                $element, $this->owner
            );
        }
    }

    /**
     * Initializes the collection by loading its contents from the database
     * if the collection is not yet initialized.
     *
     * @return void
     */
    public function initialize()
    {
        if ($this->initialized || ! $this->association) {
            return;
        }

        $this->doInitialize();

        $this->initialized = true;
    }

    /**
     * INTERNAL:
     * Tells this collection to take a snapshot of its current state.
     *
     * @return void
     */
    public function takeSnapshot()
    {
        $this->snapshot = $this->collection->toArray();
        $this->isDirty  = false;
    }

    /**
     * INTERNAL:
     * Returns the last snapshot of the elements in the collection.
     *
     * @return array The last snapshot of the elements.
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * INTERNAL:
     * getDeleteDiff
     *
     * @return array
     */
    public function getDeleteDiff()
    {
        return array_udiff_assoc(
            $this->snapshot,
            $this->collection->toArray(),
            function($a, $b) { return $a === $b ? 0 : 1; }
        );
    }

    /**
     * INTERNAL:
     * getInsertDiff
     *
     * @return array
     */
    public function getInsertDiff()
    {
        return array_udiff_assoc(
            $this->collection->toArray(),
            $this->snapshot,
            function($a, $b) { return $a === $b ? 0 : 1; }
        );
    }

    /**
     * INTERNAL: Gets the association mapping of the collection.
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->association;
    }

    /**
     * Marks this collection as changed/dirty.
     *
     * @return void
     */
    private function changed()
    {
        if ($this->isDirty) {
            return;
        }

        $this->isDirty = true;

        if ($this->association !== null &&
            $this->association['isOwningSide'] &&
            $this->association['type'] === ClassMetadata::MANY_TO_MANY &&
            $this->owner &&
            $this->em->getClassMetadata(get_class($this->owner))->isChangeTrackingNotify()) {
            $this->em->getUnitOfWork()->scheduleForDirtyCheck($this->owner);
        }
    }

    /**
     * Gets a boolean flag indicating whether this collection is dirty which means
     * its state needs to be synchronized with the database.
     *
     * @return boolean TRUE if the collection is dirty, FALSE otherwise.
     */
    public function isDirty()
    {
        return $this->isDirty;
    }

    /**
     * Sets a boolean flag, indicating whether this collection is dirty.
     *
     * @param boolean $dirty Whether the collection should be marked dirty or not.
     *
     * @return void
     */
    public function setDirty($dirty)
    {
        $this->isDirty = $dirty;
    }

    /**
     * Sets the initialized flag of the collection, forcing it into that state.
     *
     * @param boolean $bool
     *
     * @return void
     */
    public function setInitialized($bool)
    {
        $this->initialized = $bool;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        // TODO: If the keys are persistent as well (not yet implemented)
        //       and the collection is not initialized and orphanRemoval is
        //       not used we can issue a straight SQL delete/update on the
        //       association (table). Without initializing the collection.
        $removed = parent::remove($key);

        if ( ! $removed) {
            return $removed;
        }

        $this->changed();

        if ($this->association !== null &&
            $this->association['type'] & ClassMetadata::TO_MANY &&
            $this->owner &&
            $this->association['orphanRemoval']) {
            $this->em->getUnitOfWork()->scheduleOrphanRemoval($removed);
        }

        return $removed;
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($element)
    {
        if ( ! $this->initialized && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY) {
            if ($this->collection->contains($element)) {
                return $this->collection->removeElement($element);
            }

            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return $persister->removeElement($this, $element);
        }

        $removed = parent::removeElement($element);

        if ( ! $removed) {
            return $removed;
        }

        $this->changed();

        if ($this->association !== null &&
            $this->association['type'] & ClassMetadata::TO_MANY &&
            $this->owner &&
            $this->association['orphanRemoval']) {
            $this->em->getUnitOfWork()->scheduleOrphanRemoval($element);
        }

        return $removed;
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        if (! $this->initialized && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY
            && isset($this->association['indexBy'])) {
            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return $this->collection->containsKey($key) || $persister->containsKey($this, $key);
        }

        return parent::containsKey($key);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($element)
    {
        if ( ! $this->initialized && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY) {
            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return $this->collection->contains($element) || $persister->contains($this, $element);
        }

        return parent::contains($element);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        if ( ! $this->initialized
            && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY
            && isset($this->association['indexBy'])
        ) {
            if (!$this->typeClass->isIdentifierComposite && $this->typeClass->isIdentifier($this->association['indexBy'])) {
                return $this->em->find($this->typeClass->name, $key);
            }

            return $this->em->getUnitOfWork()->getCollectionPersister($this->association)->get($this, $key);
        }

        return parent::get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        if ( ! $this->initialized && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY) {
            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return $persister->count($this) + ($this->isDirty ? $this->collection->count() : 0);
        }

        return parent::count();
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        parent::set($key, $value);

        $this->changed();

        if (is_object($value) && $this->em) {
            $this->em->getUnitOfWork()->cancelOrphanRemoval($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->collection->add($value);

        $this->changed();

        if (is_object($value) && $this->em) {
            $this->em->getUnitOfWork()->cancelOrphanRemoval($value);
        }

        return true;
    }

    /* ArrayAccess implementation */

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ( ! isset($offset)) {
            $this->add($value);
            return;
        }

        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->collection->isEmpty() && $this->count() === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        if ($this->initialized && $this->isEmpty()) {
            $this->collection->clear();

            return;
        }

        $uow = $this->em->getUnitOfWork();

        if ($this->association['type'] & ClassMetadata::TO_MANY &&
            $this->association['orphanRemoval'] &&
            $this->owner) {
            // we need to initialize here, as orphan removal acts like implicit cascadeRemove,
            // hence for event listeners we need the objects in memory.
            $this->initialize();

            foreach ($this->collection as $element) {
                $uow->scheduleOrphanRemoval($element);
            }
        }

        $this->collection->clear();

        $this->initialized = true; // direct call, {@link initialize()} is too expensive

        if ($this->association['isOwningSide'] && $this->owner) {
            $this->changed();

            $uow->scheduleCollectionDeletion($this);

            $this->takeSnapshot();
        }
    }

    /**
     * Called by PHP when this collection is serialized. Ensures that only the
     * elements are properly serialized.
     *
     * Internal note: Tried to implement Serializable first but that did not work well
     *                with circular references. This solution seems simpler and works well.
     *
     * @return array
     */
    public function __sleep()
    {
        return ['collection', 'initialized'];
    }

    /**
     * Extracts a slice of $length elements starting at position $offset from the Collection.
     *
     * If $length is null it returns all elements from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the elements contained in the collection slice is called on.
     *
     * @param int      $offset
     * @param int|null $length
     *
     * @return array
     */
    public function slice($offset, $length = null)
    {
        if ( ! $this->initialized && ! $this->isDirty && $this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY) {
            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return $persister->slice($this, $offset, $length);
        }

        return parent::slice($offset, $length);
    }

    /**
     * Cleans up internal state of cloned persistent collection.
     *
     * The following problems have to be prevented:
     * 1. Added entities are added to old PC
     * 2. New collection is not dirty, if reused on other entity nothing
     * changes.
     * 3. Snapshot leads to invalid diffs being generated.
     * 4. Lazy loading grabs entities from old owner object.
     * 5. New collection is connected to old owner and leads to duplicate keys.
     *
     * @return void
     */
    public function __clone()
    {
        if (is_object($this->collection)) {
            $this->collection = clone $this->collection;
        }

        $this->initialize();

        $this->owner    = null;
        $this->snapshot = [];

        $this->changed();
    }

    /**
     * Selects all elements from a selectable that match the expression and
     * return a new collection containing these elements.
     *
     * @param \Doctrine\Common\Collections\Criteria $criteria
     *
     * @return Collection
     *
     * @throws \RuntimeException
     */
    public function matching(Criteria $criteria)
    {
        if ($this->isDirty) {
            $this->initialize();
        }

        if ($this->initialized) {
            return $this->collection->matching($criteria);
        }

        if ($this->association['type'] === ClassMetadata::MANY_TO_MANY) {
            $persister = $this->em->getUnitOfWork()->getCollectionPersister($this->association);

            return new ArrayCollection($persister->loadCriteria($this, $criteria));
        }

        $builder         = Criteria::expr();
        $ownerExpression = $builder->eq($this->backRefFieldName, $this->owner);
        $expression      = $criteria->getWhereExpression();
        $expression      = $expression ? $builder->andX($expression, $ownerExpression) : $ownerExpression;

        $criteria = clone $criteria;
        $criteria->where($expression);

        $persister = $this->em->getUnitOfWork()->getEntityPersister($this->association['targetEntity']);

        return ($this->association['fetch'] === ClassMetadata::FETCH_EXTRA_LAZY)
            ? new LazyCriteriaCollection($persister, $criteria)
            : new ArrayCollection($persister->loadCriteria($criteria));
    }

    /**
     * Retrieves the wrapped Collection instance.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function unwrap()
    {
        return $this->collection;
    }

    /**
     * {@inheritdoc}
     */
    protected function doInitialize()
    {
        // Has NEW objects added through add(). Remember them.
        $newlyAddedDirtyObjects = [];

        if ($this->isDirty) {
            $newlyAddedDirtyObjects = $this->collection->toArray();
        }

        $this->collection->clear();
        $this->em->getUnitOfWork()->loadCollection($this);
        $this->takeSnapshot();

        if ($newlyAddedDirtyObjects) {
            $this->restoreNewObjectsInDirtyCollection($newlyAddedDirtyObjects);
        }
    }

    /**
     * @param object[] $newObjects
     *
     * Note: the only reason why this entire looping/complexity is performed via `spl_object_hash`
     *       is because we want to prevent using `array_udiff()`, which is likely to cause very
     *       high overhead (complexity of O(n^2)). `array_diff_key()` performs the operation in
     *       core, which is faster than using a callback for comparisons
     */
    private function restoreNewObjectsInDirtyCollection(array $newObjects) : void
    {
        $loadedObjects               = $this->collection->toArray();
        $newObjectsByOid             = \array_combine(\array_map('spl_object_hash', $newObjects), $newObjects);
        $loadedObjectsByOid          = \array_combine(\array_map('spl_object_hash', $loadedObjects), $loadedObjects);
        $newObjectsThatWereNotLoaded = \array_diff_key($newObjectsByOid, $loadedObjectsByOid);

        if ($newObjectsThatWereNotLoaded) {
            // Reattach NEW objects added through add(), if any.
            \array_walk($newObjectsThatWereNotLoaded, [$this->collection, 'add']);

            $this->isDirty = true;
        }
    }
}
