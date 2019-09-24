<?php

namespace Doctrine\Common\Persistence;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * Makes a Persistent Objects aware of its own object-manager.
 *
 * Using this interface the managing object manager and class metadata instances
 * are injected into the persistent object after construction. This allows
 * you to implement ActiveRecord functionality on top of the persistence-ignorance
 * that Doctrine propagates.
 *
 * Word of Warning: This is a very powerful hook to change how you can work with your domain models.
 * Using this hook will break the Single Responsibility Principle inside your Domain Objects
 * and increase the coupling of database and objects.
 *
 * Every ObjectManager has to implement this functionality itself.
 */
interface ObjectManagerAware
{
    /**
     * Injects responsible ObjectManager and the ClassMetadata into this persistent object.
     *
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata);
}
