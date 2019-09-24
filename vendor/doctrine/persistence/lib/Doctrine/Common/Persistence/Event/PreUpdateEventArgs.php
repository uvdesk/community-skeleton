<?php

namespace Doctrine\Common\Persistence\Event;

use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use function get_class;
use function sprintf;

/**
 * Class that holds event arguments for a preUpdate event.
 */
class PreUpdateEventArgs extends LifecycleEventArgs
{
    /** @var mixed[][] */
    private $entityChangeSet;

    /**
     * @param object    $entity
     * @param mixed[][] $changeSet
     */
    public function __construct($entity, ObjectManager $objectManager, array &$changeSet)
    {
        parent::__construct($entity, $objectManager);

        $this->entityChangeSet = &$changeSet;
    }

    /**
     * Retrieves the entity changeset.
     *
     * @return mixed[][]
     */
    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }

    /**
     * Checks if field has a changeset.
     *
     * @param string $field
     *
     * @return bool
     */
    public function hasChangedField($field)
    {
        return isset($this->entityChangeSet[$field]);
    }

    /**
     * Gets the old value of the changeset of the changed field.
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getOldValue($field)
    {
        $this->assertValidField($field);

        return $this->entityChangeSet[$field][0];
    }

    /**
     * Gets the new value of the changeset of the changed field.
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getNewValue($field)
    {
        $this->assertValidField($field);

        return $this->entityChangeSet[$field][1];
    }

    /**
     * Sets the new value of this field.
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return void
     */
    public function setNewValue($field, $value)
    {
        $this->assertValidField($field);

        $this->entityChangeSet[$field][1] = $value;
    }

    /**
     * Asserts the field exists in changeset.
     *
     * @param string $field
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    private function assertValidField($field)
    {
        if (! isset($this->entityChangeSet[$field])) {
            throw new InvalidArgumentException(sprintf(
                'Field "%s" is not a valid field of the entity "%s" in PreUpdateEventArgs.',
                $field,
                get_class($this->getObject())
            ));
        }
    }
}
