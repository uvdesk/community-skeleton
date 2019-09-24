<?php

namespace Doctrine\Common\Persistence\Event;

use Doctrine\Common\EventArgs;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Lifecycle Events are triggered by the UnitOfWork during lifecycle transitions
 * of entities.
 */
class LifecycleEventArgs extends EventArgs
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var object */
    private $object;

    /**
     * @param object $object
     */
    public function __construct($object, ObjectManager $objectManager)
    {
        $this->object        = $object;
        $this->objectManager = $objectManager;
    }

    /**
     * Retrieves the associated entity.
     *
     * @deprecated
     *
     * @return object
     */
    public function getEntity()
    {
        return $this->object;
    }

    /**
     * Retrieves the associated object.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
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
}
