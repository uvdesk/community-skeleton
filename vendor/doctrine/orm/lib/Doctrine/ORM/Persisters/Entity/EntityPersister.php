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

namespace Doctrine\ORM\Persisters\Entity;

use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Entity persister interface
 * Define the behavior that should be implemented by all entity persisters.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @since 2.5
 */
interface EntityPersister
{
    /**
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getClassMetadata();

    /**
     * Gets the ResultSetMapping used for hydration.
     *
     * @return \Doctrine\ORM\Query\ResultSetMapping
     */
    public function getResultSetMapping();

    /**
     * Get all queued inserts.
     *
     * @return array
    */
    public function getInserts();

     /**
     * @TODO - It should not be here.
     * But its necessary since JoinedSubclassPersister#executeInserts invoke the root persister.
     *
     * Gets the INSERT SQL used by the persister to persist a new entity.
     *
     * @return string
     */
    public function getInsertSQL();

    /**
     * Gets the SELECT SQL to select one or more entities by a set of field criteria.
     *
     * @param array|\Doctrine\Common\Collections\Criteria $criteria
     * @param array|null                                  $assoc
     * @param int|null                                    $lockMode
     * @param int|null                                    $limit
     * @param int|null                                    $offset
     * @param array|null                                  $orderBy
     *
     * @return string
     */
    public function getSelectSQL($criteria, $assoc = null, $lockMode = null, $limit = null, $offset = null, array $orderBy = null);

    /**
     * Get the COUNT SQL to count entities (optionally based on a criteria)
     *
     * @param array|\Doctrine\Common\Collections\Criteria $criteria
     *
     * @return string
     */
    public function getCountSQL($criteria = []);

    /**
     * Expands the parameters from the given criteria and use the correct binding types if found.
     *
     * @param $criteria
     *
     * @return array
     */
    public function expandParameters($criteria);

    /**
     * Expands Criteria Parameters by walking the expressions and grabbing all parameters and types from it.
     *
     * @param \Doctrine\Common\Collections\Criteria $criteria
     *
     * @return array
     */
    public function expandCriteriaParameters(Criteria $criteria);

    /**
     * Gets the SQL WHERE condition for matching a field with a given value.
     *
     * @param string      $field
     * @param mixed       $value
     * @param array|null  $assoc
     * @param string|null $comparison
     *
     * @return string
     */
    public function getSelectConditionStatementSQL($field, $value, $assoc = null, $comparison = null);

    /**
     * Adds an entity to the queued insertions.
     * The entity remains queued until {@link executeInserts} is invoked.
     *
     * @param object $entity The entity to queue for insertion.
     *
     * @return void
     */
    public function addInsert($entity);

    /**
     * Executes all queued entity insertions and returns any generated post-insert
     * identifiers that were created as a result of the insertions.
     *
     * If no inserts are queued, invoking this method is a NOOP.
     *
     * @return array An array of any generated post-insert IDs. This will be an empty array
     *               if the entity class does not use the IDENTITY generation strategy.
     */
    public function executeInserts();

    /**
     * Updates a managed entity. The entity is updated according to its current changeset
     * in the running UnitOfWork. If there is no changeset, nothing is updated.
     *
     * @param object $entity The entity to update.
     *
     * @return void
     */
    public function update($entity);

    /**
     * Deletes a managed entity.
     *
     * The entity to delete must be managed and have a persistent identifier.
     * The deletion happens instantaneously.
     *
     * Subclasses may override this method to customize the semantics of entity deletion.
     *
     * @param object $entity The entity to delete.
     *
     * @return bool TRUE if the entity got deleted in the database, FALSE otherwise.
     */
    public function delete($entity);

    /**
     * Count entities (optionally filtered by a criteria)
     *
     * @param  array|\Doctrine\Common\Collections\Criteria $criteria
     *
     * @return int
     */
    public function count($criteria = []);

    /**
     * Gets the name of the table that owns the column the given field is mapped to.
     *
     * The default implementation in BasicEntityPersister always returns the name
     * of the table the entity type of this persister is mapped to, since an entity
     * is always persisted to a single table with a BasicEntityPersister.
     *
     * @param string $fieldName The field name.
     *
     * @return string The table name.
     */
    public function getOwningTable($fieldName);

    /**
     * Loads an entity by a list of field criteria.
     *
     * @param array       $criteria The criteria by which to load the entity.
     * @param object|null $entity   The entity to load the data into. If not specified, a new entity is created.
     * @param array|null  $assoc    The association that connects the entity to load to another entity, if any.
     * @param array       $hints    Hints for entity creation.
     * @param int|null    $lockMode One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              for loading the entity.
     * @param int|null    $limit    Limit number of results.
     * @param array|null  $orderBy  Criteria to order by.
     *
     * @return object|null The loaded and managed entity instance or NULL if the entity can not be found.
     *
     * @todo Check identity map? loadById method? Try to guess whether $criteria is the id?
     */
    public function load(array $criteria, $entity = null, $assoc = null, array $hints = [], $lockMode = null, $limit = null, array $orderBy = null);

    /**
     * Loads an entity by identifier.
     *
     * @param array       $identifier The entity identifier.
     * @param object|null $entity     The entity to load the data into. If not specified, a new entity is created.
     *
     * @return object The loaded and managed entity instance or NULL if the entity can not be found.
     *
     * @todo Check parameters
     */
    public function loadById(array $identifier, $entity = null);

    /**
     * Loads an entity of this persister's mapped class as part of a single-valued
     * association from another entity.
     *
     * @param array  $assoc        The association to load.
     * @param object $sourceEntity The entity that owns the association (not necessarily the "owning side").
     * @param array  $identifier   The identifier of the entity to load. Must be provided if
     *                             the association to load represents the owning side, otherwise
     *                             the identifier is derived from the $sourceEntity.
     *
     * @return object The loaded and managed entity instance or NULL if the entity can not be found.
     *
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function loadOneToOneEntity(array $assoc, $sourceEntity, array $identifier = []);

    /**
     * Refreshes a managed entity.
     *
     * @param array    $id       The identifier of the entity as an associative array from
     *                           column or field names to values.
     * @param object   $entity   The entity to refresh.
     * @param int|null $lockMode One of the \Doctrine\DBAL\LockMode::* constants
     *                           or NULL if no specific lock mode should be used
     *                           for refreshing the managed entity.
     *
     * @return void
     */
    public function refresh(array $id, $entity, $lockMode = null);

    /**
     * Loads Entities matching the given Criteria object.
     *
     * @param \Doctrine\Common\Collections\Criteria $criteria
     *
     * @return array
     */
    public function loadCriteria(Criteria $criteria);

    /**
     * Loads a list of entities by a list of field criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     */
    public function loadAll(array $criteria = [], array $orderBy = null, $limit = null, $offset = null);

    /**
     * Gets (sliced or full) elements of the given collection.
     *
     * @param array    $assoc
     * @param object   $sourceEntity
     * @param int|null $offset
     * @param int|null $limit
     *
     * @return array
     */
    public function getManyToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null);

    /**
     * Loads a collection of entities of a many-to-many association.
     *
     * @param array                $assoc        The association mapping of the association being loaded.
     * @param object               $sourceEntity The entity that owns the collection.
     * @param PersistentCollection $collection         The collection to fill.
     *
     * @return array
     */
    public function loadManyToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection);

    /**
     * Loads a collection of entities in a one-to-many association.
     *
     * @param array                $assoc
     * @param object               $sourceEntity
     * @param PersistentCollection $collection   The collection to load/fill.
     *
     * @return array
     */
    public function loadOneToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection);

    /**
     * Locks all rows of this entity matching the given criteria with the specified pessimistic lock mode.
     *
     * @param array $criteria
     * @param int   $lockMode One of the Doctrine\DBAL\LockMode::* constants.
     *
     * @return void
     */
    public function lock(array $criteria, $lockMode);

    /**
     * Returns an array with (sliced or full list) of elements in the specified collection.
     *
     * @param array    $assoc
     * @param object   $sourceEntity
     * @param int|null $offset
     * @param int|null $limit
     *
     * @return array
     */
    public function getOneToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null);

    /**
     * Checks whether the given managed entity exists in the database.
     *
     * @param object        $entity
     * @param Criteria|null $extraConditions
     *
     * @return boolean TRUE if the entity exists in the database, FALSE otherwise.
     */
    public function exists($entity, Criteria $extraConditions = null);
}
