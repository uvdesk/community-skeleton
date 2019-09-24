<?php

namespace Doctrine\Common\Persistence;

/**
 * Base class to simplify ObjectManager decorators
 */
abstract class ObjectManagerDecorator implements ObjectManager
{
    /** @var ObjectManager */
    protected $wrapped;

    /**
     * {@inheritdoc}
     */
    public function find($className, $id)
    {
        return $this->wrapped->find($className, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($object)
    {
        $this->wrapped->persist($object);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object)
    {
        $this->wrapped->remove($object);
    }

    /**
     * {@inheritdoc}
     */
    public function merge($object)
    {
        return $this->wrapped->merge($object);
    }

    /**
     * {@inheritdoc}
     */
    public function clear($objectName = null)
    {
        $this->wrapped->clear($objectName);
    }

    /**
     * {@inheritdoc}
     */
    public function detach($object)
    {
        $this->wrapped->detach($object);
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($object)
    {
        $this->wrapped->refresh($object);
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->wrapped->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository($className)
    {
        return $this->wrapped->getRepository($className);
    }

    /**
     * {@inheritdoc}
     */
    public function getClassMetadata($className)
    {
        return $this->wrapped->getClassMetadata($className);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory()
    {
        return $this->wrapped->getMetadataFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function initializeObject($obj)
    {
        $this->wrapped->initializeObject($obj);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($object)
    {
        return $this->wrapped->contains($object);
    }
}
