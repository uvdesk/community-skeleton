<?php

namespace Doctrine\Common\Persistence\Event;

use Doctrine\Common\EventArgs;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Provides event arguments for the onClear event.
 */
class OnClearEventArgs extends EventArgs
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var string|null */
    private $entityClass;

    /**
     * @param ObjectManager $objectManager The object manager.
     * @param string|null   $entityClass   The optional entity class.
     */
    public function __construct($objectManager, $entityClass = null)
    {
        $this->objectManager = $objectManager;
        $this->entityClass   = $entityClass;
    }

    /**
     * Retrieves the associated ObjectManager.
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * Returns the name of the entity class that is cleared, or null if all are cleared.
     *
     * @return string|null
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Returns whether this event clears all entities.
     *
     * @return bool
     */
    public function clearsAllEntities()
    {
        return $this->entityClass === null;
    }
}
