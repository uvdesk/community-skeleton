Events
======

Doctrine 2 features a lightweight event system that is part of the
Common package. Doctrine uses it to dispatch system events, mainly
:ref:`lifecycle events <reference-events-lifecycle-events>`.
You can also use it for your own custom events.

The Event System
----------------

The event system is controlled by the ``EventManager``. It is the
central point of Doctrine's event listener system. Listeners are
registered on the manager and events are dispatched through the
manager.

.. code-block:: php

    <?php
    $evm = new EventManager();

Now we can add some event listeners to the ``$evm``. Let's create a
``TestEvent`` class to play around with.

.. code-block:: php

    <?php
    class TestEvent
    {
        const preFoo = 'preFoo';
        const postFoo = 'postFoo';

        private $_evm;

        public $preFooInvoked = false;
        public $postFooInvoked = false;

        public function __construct($evm)
        {
            $evm->addEventListener(array(self::preFoo, self::postFoo), $this);
        }

        public function preFoo(EventArgs $e)
        {
            $this->preFooInvoked = true;
        }

        public function postFoo(EventArgs $e)
        {
            $this->postFooInvoked = true;
        }
    }

    // Create a new instance
    $test = new TestEvent($evm);

Events can be dispatched by using the ``dispatchEvent()`` method.

.. code-block:: php

    <?php
    $evm->dispatchEvent(TestEvent::preFoo);
    $evm->dispatchEvent(TestEvent::postFoo);

You can easily remove a listener with the ``removeEventListener()``
method.

.. code-block:: php

    <?php
    $evm->removeEventListener(array(self::preFoo, self::postFoo), $this);

The Doctrine 2 event system also has a simple concept of event
subscribers. We can define a simple ``TestEventSubscriber`` class
which implements the ``\Doctrine\Common\EventSubscriber`` interface
and implements a ``getSubscribedEvents()`` method which returns an
array of events it should be subscribed to.

.. code-block:: php

    <?php
    class TestEventSubscriber implements \Doctrine\Common\EventSubscriber
    {
        public $preFooInvoked = false;

        public function preFoo()
        {
            $this->preFooInvoked = true;
        }

        public function getSubscribedEvents()
        {
            return array(TestEvent::preFoo);
        }
    }

    $eventSubscriber = new TestEventSubscriber();
    $evm->addEventSubscriber($eventSubscriber);

.. note::

    The array to return in the ``getSubscribedEvents`` method is a simple array
    with the values being the event names. The subscriber must have a method
    that is named exactly like the event.

Now when you dispatch an event, any event subscribers will be
notified for that event.

.. code-block:: php

    <?php
    $evm->dispatchEvent(TestEvent::preFoo);

Now you can test the ``$eventSubscriber`` instance to see if the
``preFoo()`` method was invoked.

.. code-block:: php

    <?php
    if ($eventSubscriber->preFooInvoked) {
        echo 'pre foo invoked!';
    }

Naming convention
~~~~~~~~~~~~~~~~~

Events being used with the Doctrine 2 EventManager are best named
with camelcase and the value of the corresponding constant should
be the name of the constant itself, even with spelling. This has
several reasons:


-  It is easy to read.
-  Simplicity.
-  Each method within an EventSubscriber is named after the
   corresponding constant's value. If the constant's name and value differ
   it contradicts the intention of using the constant and makes your code
   harder to maintain.

An example for a correct notation can be found in the example
``TestEvent`` above.

.. _reference-events-lifecycle-events:

Lifecycle Events
----------------

The EntityManager and UnitOfWork trigger a bunch of events during
the life-time of their registered entities.


-  preRemove - The preRemove event occurs for a given entity before
   the respective EntityManager remove operation for that entity is
   executed.  It is not called for a DQL DELETE statement.
-  postRemove - The postRemove event occurs for an entity after the
   entity has been deleted. It will be invoked after the database
   delete operations. It is not called for a DQL DELETE statement.
-  prePersist - The prePersist event occurs for a given entity
   before the respective EntityManager persist operation for that
   entity is executed. It should be noted that this event is only triggered on
   *initial* persist of an entity (i.e. it does not trigger on future updates).
-  postPersist - The postPersist event occurs for an entity after
   the entity has been made persistent. It will be invoked after the
   database insert operations. Generated primary key values are
   available in the postPersist event.
-  preUpdate - The preUpdate event occurs before the database
   update operations to entity data. It is not called for a DQL UPDATE statement
   nor when the computed changeset is empty.
-  postUpdate - The postUpdate event occurs after the database
   update operations to entity data. It is not called for a DQL UPDATE statement.
-  postLoad - The postLoad event occurs for an entity after the
   entity has been loaded into the current EntityManager from the
   database or after the refresh operation has been applied to it.
-  loadClassMetadata - The loadClassMetadata event occurs after the
   mapping metadata for a class has been loaded from a mapping source
   (annotations/xml/yaml). This event is not a lifecycle callback.
-  onClassMetadataNotFound - Loading class metadata for a particular
   requested class name failed. Manipulating the given event args instance
   allows providing fallback metadata even when no actual metadata exists
   or could be found. This event is not a lifecycle callback.
-  preFlush - The preFlush event occurs at the very beginning of a flush
   operation.
-  onFlush - The onFlush event occurs after the change-sets of all
   managed entities are computed. This event is not a lifecycle
   callback.
-  postFlush - The postFlush event occurs at the end of a flush operation. This
   event is not a lifecycle callback.
-  onClear - The onClear event occurs when the EntityManager#clear() operation is
   invoked, after all references to entities have been removed from the unit of
   work. This event is not a lifecycle callback.

.. warning::

    Note that, when using ``Doctrine\ORM\AbstractQuery#iterate()``, ``postLoad``
    events will be executed immediately after objects are being hydrated, and therefore
    associations are not guaranteed to be initialized. It is not safe to combine
    usage of ``Doctrine\ORM\AbstractQuery#iterate()`` and ``postLoad`` event
    handlers.

.. warning::

    Note that the postRemove event or any events triggered after an entity removal
    can receive an uninitializable proxy in case you have configured an entity to
    cascade remove relations. In this case, you should load yourself the proxy in
    the associated pre event.

You can access the Event constants from the ``Events`` class in the
ORM package.

.. code-block:: php

    <?php
    use Doctrine\ORM\Events;
    echo Events::preUpdate;

These can be hooked into by two different types of event
listeners:

-  Lifecycle Callbacks are methods on the entity classes that are
   called when the event is triggered. As of v2.4 they receive some kind
   of ``EventArgs`` instance.
-  Lifecycle Event Listeners and Subscribers are classes with specific callback
   methods that receives some kind of ``EventArgs`` instance.

The EventArgs instance received by the listener gives access to the entity,
EntityManager and other relevant data.

.. note::

    All Lifecycle events that happen during the ``flush()`` of
    an EntityManager have very specific constraints on the allowed
    operations that can be executed. Please read the
    :ref:`reference-events-implementing-listeners` section very carefully
    to understand which operations are allowed in which lifecycle event.


Lifecycle Callbacks
-------------------

Lifecycle Callbacks are defined on an entity class. They allow you to
trigger callbacks whenever an instance of that entity class experiences
a relevant lifecycle event. More than one callback can be defined for each
lifecycle event. Lifecycle Callbacks are best used for simple operations
specific to a particular entity class's lifecycle.

.. code-block:: php

    <?php

    /** @Entity @HasLifecycleCallbacks */
    class User
    {
        // ...

        /**
         * @Column(type="string", length=255)
         */
        public $value;

        /** @Column(name="created_at", type="string", length=255) */
        private $createdAt;

        /** @PrePersist */
        public function doStuffOnPrePersist()
        {
            $this->createdAt = date('Y-m-d H:i:s');
        }

        /** @PrePersist */
        public function doOtherStuffOnPrePersist()
        {
            $this->value = 'changed from prePersist callback!';
        }

        /** @PostPersist */
        public function doStuffOnPostPersist()
        {
            $this->value = 'changed from postPersist callback!';
        }

        /** @PostLoad */
        public function doStuffOnPostLoad()
        {
            $this->value = 'changed from postLoad callback!';
        }

        /** @PreUpdate */
        public function doStuffOnPreUpdate()
        {
            $this->value = 'changed from preUpdate callback!';
        }
    }

Note that the methods set as lifecycle callbacks need to be public and,
when using these annotations, you have to apply the
``@HasLifecycleCallbacks`` marker annotation on the entity class.

If you want to register lifecycle callbacks from YAML or XML you
can do it with the following.

.. code-block:: yaml

    User:
      type: entity
      fields:
    # ...
        name:
          type: string(50)
      lifecycleCallbacks:
        prePersist: [ doStuffOnPrePersist, doOtherStuffOnPrePersist ]
        postPersist: [ doStuffOnPostPersist ]

In YAML the ``key`` of the lifecycleCallbacks entry is the event that you
are triggering on and the value is the method (or methods) to call. The allowed
event types are the ones listed in the previous Lifecycle Events section.

XML would look something like this:

.. code-block:: xml

    <?xml version="1.0" encoding="UTF-8"?>

    <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                              https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

        <entity name="User">

            <lifecycle-callbacks>
                <lifecycle-callback type="prePersist" method="doStuffOnPrePersist"/>
                <lifecycle-callback type="postPersist" method="doStuffOnPostPersist"/>
            </lifecycle-callbacks>

        </entity>

    </doctrine-mapping>

In XML the ``type`` of the lifecycle-callback entry is the event that you
are triggering on and the ``method`` is the method to call. The allowed event
types are the ones listed in the previous Lifecycle Events section.

When using YAML or XML you need to remember to create public methods to match the
callback names you defined. E.g. in these examples ``doStuffOnPrePersist()``,
``doOtherStuffOnPrePersist()`` and ``doStuffOnPostPersist()`` methods need to be
defined on your ``User`` model.

.. code-block:: php

    <?php
    // ...

    class User
    {
        // ...

        public function doStuffOnPrePersist()
        {
            // ...
        }

        public function doOtherStuffOnPrePersist()
        {
            // ...
        }

        public function doStuffOnPostPersist()
        {
            // ...
        }
    }


Lifecycle Callbacks Event Argument
-----------------------------------

.. versionadded:: 2.4

Since 2.4 the triggered event is given to the lifecycle-callback.

With the additional argument you have access to the
``EntityManager`` and ``UnitOfWork`` APIs inside these callback methods.

.. code-block:: php

    <?php
    // ...

    class User
    {
        public function preUpdate(PreUpdateEventArgs $event)
        {
            if ($event->hasChangedField('username')) {
                // Do something when the username is changed.
            }
        }
    }

Listening and subscribing to Lifecycle Events
---------------------------------------------

Lifecycle event listeners are much more powerful than the simple
lifecycle callbacks that are defined on the entity classes. They
sit at a level above the entities and allow you to implement re-usable
behaviors across different entity classes.

Note that they require much more detailed knowledge about the inner
workings of the EntityManager and UnitOfWork. Please read the
:ref:`reference-events-implementing-listeners` section carefully if you
are trying to write your own listener.

For event subscribers, there are no surprises. They declare the
lifecycle events in their ``getSubscribedEvents`` method and provide
public methods that expect the relevant arguments.

A lifecycle event listener looks like the following:

.. code-block:: php

    <?php
    use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

    class MyEventListener
    {
        public function preUpdate(LifecycleEventArgs $args)
        {
            $entity = $args->getObject();
            $entityManager = $args->getObjectManager();

            // perhaps you only want to act on some "Product" entity
            if ($entity instanceof Product) {
                // do something with the Product
            }
        }
    }

A lifecycle event subscriber may look like this:

.. code-block:: php

    <?php
    use Doctrine\ORM\Events;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

    class MyEventSubscriber implements EventSubscriber
    {
        public function getSubscribedEvents()
        {
            return array(
                Events::postUpdate,
            );
        }

        public function postUpdate(LifecycleEventArgs $args)
        {
            $entity = $args->getObject();
            $entityManager = $args->getObjectManager();

            // perhaps you only want to act on some "Product" entity
            if ($entity instanceof Product) {
                // do something with the Product
            }
        }

.. note::

    Lifecycle events are triggered for all entities. It is the responsibility
    of the listeners and subscribers to check if the entity is of a type
    it wants to handle.

To register an event listener or subscriber, you have to hook it into the
EventManager that is passed to the EntityManager factory:

.. code-block:: php

    <?php
    $eventManager = new EventManager();
    $eventManager->addEventListener(array(Events::preUpdate), new MyEventListener());
    $eventManager->addEventSubscriber(new MyEventSubscriber());

    $entityManager = EntityManager::create($dbOpts, $config, $eventManager);

You can also retrieve the event manager instance after the
EntityManager was created:

.. code-block:: php

    <?php
    $entityManager->getEventManager()->addEventListener(array(Events::preUpdate), new MyEventListener());
    $entityManager->getEventManager()->addEventSubscriber(new MyEventSubscriber());

.. _reference-events-implementing-listeners:

Implementing Event Listeners
----------------------------

This section explains what is and what is not allowed during
specific lifecycle events of the UnitOfWork. Although you get
passed the EntityManager in all of these events, you have to follow
these restrictions very carefully since operations in the wrong
event may produce lots of different errors, such as inconsistent
data and lost updates/persists/removes.

For the described events that are also lifecycle callback events
the restrictions apply as well, with the additional restriction
that (prior to version 2.4) you do not have access to the
EntityManager or UnitOfWork APIs inside these events.

prePersist
~~~~~~~~~~

There are two ways for the ``prePersist`` event to be triggered.
One is obviously when you call ``EntityManager#persist()``. The
event is also called for all cascaded associations.

There is another way for ``prePersist`` to be called, inside the
``flush()`` method when changes to associations are computed and
this association is marked as cascade persist. Any new entity found
during this operation is also persisted and ``prePersist`` called
on it. This is called "persistence by reachability".

In both cases you get passed a ``LifecycleEventArgs`` instance
which has access to the entity and the entity manager.

The following restrictions apply to ``prePersist``:


-  If you are using a PrePersist Identity Generator such as
   sequences the ID value will *NOT* be available within any
   PrePersist events.
-  Doctrine will not recognize changes made to relations in a prePersist
   event. This includes modifications to
   collections such as additions, removals or replacement.

preRemove
~~~~~~~~~

The ``preRemove`` event is called on every entity when its passed
to the ``EntityManager#remove()`` method. It is cascaded for all
associations that are marked as cascade delete.

There are no restrictions to what methods can be called inside the
``preRemove`` event, except when the remove method itself was
called during a flush operation.

preFlush
~~~~~~~~

``preFlush`` is called at ``EntityManager#flush()`` before
anything else. ``EntityManager#flush()`` can be called safely
inside its listeners.

.. code-block:: php

    <?php

    use Doctrine\ORM\Event\PreFlushEventArgs;

    class PreFlushExampleListener
    {
        public function preFlush(PreFlushEventArgs $args)
        {
            // ...
        }
    }

onFlush
~~~~~~~

OnFlush is a very powerful event. It is called inside
``EntityManager#flush()`` after the changes to all the managed
entities and their associations have been computed. This means, the
``onFlush`` event has access to the sets of:


-  Entities scheduled for insert
-  Entities scheduled for update
-  Entities scheduled for removal
-  Collections scheduled for update
-  Collections scheduled for removal

To make use of the onFlush event you have to be familiar with the
internal UnitOfWork API, which grants you access to the previously
mentioned sets. See this example:

.. code-block:: php

    <?php
    class FlushExampleListener
    {
        public function onFlush(OnFlushEventArgs $eventArgs)
        {
            $em = $eventArgs->getEntityManager();
            $uow = $em->getUnitOfWork();

            foreach ($uow->getScheduledEntityInsertions() as $entity) {

            }

            foreach ($uow->getScheduledEntityUpdates() as $entity) {

            }

            foreach ($uow->getScheduledEntityDeletions() as $entity) {

            }

            foreach ($uow->getScheduledCollectionDeletions() as $col) {

            }

            foreach ($uow->getScheduledCollectionUpdates() as $col) {

            }
        }
    }

The following restrictions apply to the onFlush event:


-  If you create and persist a new entity in ``onFlush``, then
   calling ``EntityManager#persist()`` is not enough.
   You have to execute an additional call to
   ``$unitOfWork->computeChangeSet($classMetadata, $entity)``.
-  Changing primitive fields or associations requires you to
   explicitly trigger a re-computation of the changeset of the
   affected entity. This can be done by calling
   ``$unitOfWork->recomputeSingleEntityChangeSet($classMetadata, $entity)``.

postFlush
~~~~~~~~~

``postFlush`` is called at the end of ``EntityManager#flush()``.
``EntityManager#flush()`` can **NOT** be called safely inside its listeners.

.. code-block:: php

    <?php

    use Doctrine\ORM\Event\PostFlushEventArgs;

    class PostFlushExampleListener
    {
        public function postFlush(PostFlushEventArgs $args)
        {
            // ...
        }
    }

preUpdate
~~~~~~~~~

PreUpdate is the most restrictive to use event, since it is called
right before an update statement is called for an entity inside the
``EntityManager#flush()`` method. Note that this event is not
triggered when the computed changeset is empty.

Changes to associations of the updated entity are never allowed in
this event, since Doctrine cannot guarantee to correctly handle
referential integrity at this point of the flush operation. This
event has a powerful feature however, it is executed with a
``PreUpdateEventArgs`` instance, which contains a reference to the
computed change-set of this entity.

This means you have access to all the fields that have changed for
this entity with their old and new value. The following methods are
available on the ``PreUpdateEventArgs``:


-  ``getEntity()`` to get access to the actual entity.
-  ``getEntityChangeSet()`` to get a copy of the changeset array.
   Changes to this returned array do not affect updating.
-  ``hasChangedField($fieldName)`` to check if the given field name
   of the current entity changed.
-  ``getOldValue($fieldName)`` and ``getNewValue($fieldName)`` to
   access the values of a field.
-  ``setNewValue($fieldName, $value)`` to change the value of a
   field to be updated.

A simple example for this event looks like:

.. code-block:: php

    <?php
    class NeverAliceOnlyBobListener
    {
        public function preUpdate(PreUpdateEventArgs $eventArgs)
        {
            if ($eventArgs->getEntity() instanceof User) {
                if ($eventArgs->hasChangedField('name') && $eventArgs->getNewValue('name') == 'Alice') {
                    $eventArgs->setNewValue('name', 'Bob');
                }
            }
        }
    }

You could also use this listener to implement validation of all the
fields that have changed. This is more efficient than using a
lifecycle callback when there are expensive validations to call:

.. code-block:: php

    <?php
    class ValidCreditCardListener
    {
        public function preUpdate(PreUpdateEventArgs $eventArgs)
        {
            if ($eventArgs->getEntity() instanceof Account) {
                if ($eventArgs->hasChangedField('creditCard')) {
                    $this->validateCreditCard($eventArgs->getNewValue('creditCard'));
                }
            }
        }

        private function validateCreditCard($no)
        {
            // throw an exception to interrupt flush event. Transaction will be rolled back.
        }
    }

Restrictions for this event:


-  Changes to associations of the passed entities are not
   recognized by the flush operation anymore.
-  Changes to fields of the passed entities are not recognized by
   the flush operation anymore, use the computed change-set passed to
   the event to modify primitive field values, e.g. use
   ``$eventArgs->setNewValue($field, $value);`` as in the Alice to Bob example above.
-  Any calls to ``EntityManager#persist()`` or
   ``EntityManager#remove()``, even in combination with the UnitOfWork
   API are strongly discouraged and don't work as expected outside the
   flush operation.

postUpdate, postRemove, postPersist
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The three post events are called inside ``EntityManager#flush()``.
Changes in here are not relevant to the persistence in the
database, but you can use these events to alter non-persistable items,
like non-mapped fields, logging or even associated classes that are
not directly mapped by Doctrine.

postLoad
~~~~~~~~

This event is called after an entity is constructed by the
EntityManager.

Entity listeners
----------------

.. versionadded:: 2.4

An entity listener is a lifecycle listener class used for an entity.

- The entity listener's mapping may be applied to an entity class or mapped superclass.
- An entity listener is defined by mapping the entity class with the corresponding mapping.

.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Entity;

        /** @Entity @EntityListeners({"UserListener"}) */
        class User
        {
            // ....
        }
    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Entity\User">
                <entity-listeners>
                    <entity-listener class="UserListener"/>
                </entity-listeners>
                <!-- .... -->
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Entity\User:
          type: entity
          entityListeners:
            UserListener:
          # ....

.. _reference-entity-listeners:

Entity listeners class
~~~~~~~~~~~~~~~~~~~~~~

An ``Entity Listener`` could be any class, by default it should be a class with a no-arg constructor.

- Different from :ref:`reference-events-implementing-listeners` an ``Entity Listener`` is invoked just to the specified entity
- An entity listener method receives two arguments, the entity instance and the lifecycle event.
- The callback method can be defined by naming convention or specifying a method mapping.
- When a listener mapping is not given the parser will use the naming convention to look for a matching method,
  e.g. it will look for a public ``preUpdate()`` method if you are listening to the ``preUpdate`` event.
- When a listener mapping is given the parser will not look for any methods using the naming convention.

.. code-block:: php

    <?php
    class UserListener
    {
        public function preUpdate(User $user, PreUpdateEventArgs $event)
        {
            // Do something on pre update.
        }
    }

To define a specific event listener method (one that does not follow the naming convention)
you need to map the listener method using the event type mapping:

.. configuration-block::

    .. code-block:: php

        <?php
        class UserListener
        {
            /** @PrePersist */
            public function prePersistHandler(User $user, LifecycleEventArgs $event) { // ... }

            /** @PostPersist */
            public function postPersistHandler(User $user, LifecycleEventArgs $event) { // ... }

            /** @PreUpdate */
            public function preUpdateHandler(User $user, PreUpdateEventArgs $event) { // ... }

            /** @PostUpdate */
            public function postUpdateHandler(User $user, LifecycleEventArgs $event) { // ... }

            /** @PostRemove */
            public function postRemoveHandler(User $user, LifecycleEventArgs $event) { // ... }

            /** @PreRemove */
            public function preRemoveHandler(User $user, LifecycleEventArgs $event) { // ... }

            /** @PreFlush */
            public function preFlushHandler(User $user, PreFlushEventArgs $event) { // ... }

            /** @PostLoad */
            public function postLoadHandler(User $user, LifecycleEventArgs $event) { // ... }
        }
    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Entity\User">
                 <entity-listeners>
                    <entity-listener class="UserListener">
                        <lifecycle-callback type="preFlush"      method="preFlushHandler"/>
                        <lifecycle-callback type="postLoad"      method="postLoadHandler"/>

                        <lifecycle-callback type="postPersist"   method="postPersistHandler"/>
                        <lifecycle-callback type="prePersist"    method="prePersistHandler"/>

                        <lifecycle-callback type="postUpdate"    method="postUpdateHandler"/>
                        <lifecycle-callback type="preUpdate"     method="preUpdateHandler"/>

                        <lifecycle-callback type="postRemove"    method="postRemoveHandler"/>
                        <lifecycle-callback type="preRemove"     method="preRemoveHandler"/>
                    </entity-listener>
                </entity-listeners>
                <!-- .... -->
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Entity\User:
          type: entity
          entityListeners:
            UserListener:
              preFlush: [preFlushHandler]
              postLoad: [postLoadHandler]

              postPersist: [postPersistHandler]
              prePersist: [prePersistHandler]

              postUpdate: [postUpdateHandler]
              preUpdate: [preUpdateHandler]

              postRemove: [postRemoveHandler]
              preRemove: [preRemoveHandler]
          # ....

.. note::

    The order of execution of multiple methods for the same event (e.g. multiple @PrePersist) is not guaranteed.


Entity listeners resolver
~~~~~~~~~~~~~~~~~~~~~~~~~~
Doctrine invokes the listener resolver to get the listener instance.

- A resolver allows you register a specific entity listener instance.
- You can also implement your own resolver by extending ``Doctrine\ORM\Mapping\DefaultEntityListenerResolver`` or implementing ``Doctrine\ORM\Mapping\EntityListenerResolver``

Specifying an entity listener instance :

.. code-block:: php

    <?php
    // User.php

    /** @Entity @EntityListeners({"UserListener"}) */
    class User
    {
        // ....
    }

    // UserListener.php
    class UserListener
    {
        public function __construct(MyService $service)
        {
            $this->service = $service;
        }

        public function preUpdate(User $user, PreUpdateEventArgs $event)
        {
            $this->service->doSomething($user);
        }
    }

    // register a entity listener.
    $listener = $container->get('user_listener');
    $em->getConfiguration()->getEntityListenerResolver()->register($listener);

Implementing your own resolver :

.. code-block:: php

    <?php
    class MyEntityListenerResolver extends \Doctrine\ORM\Mapping\DefaultEntityListenerResolver
    {
        public function __construct($container)
        {
            $this->container = $container;
        }

        public function resolve($className)
        {
            // resolve the service id by the given class name;
            $id = 'user_listener';

            return $this->container->get($id);
        }
    }

    // Configure the listener resolver only before instantiating the EntityManager
    $configurations->setEntityListenerResolver(new MyEntityListenerResolver);
    EntityManager::create(.., $configurations, ..);

Load ClassMetadata Event
------------------------

When the mapping information for an entity is read, it is populated
in to a ``ClassMetadataInfo`` instance. You can hook in to this
process and manipulate the instance.

.. code-block:: php

    <?php
    $test = new TestEvent();
    $metadataFactory = $em->getMetadataFactory();
    $evm = $em->getEventManager();
    $evm->addEventListener(Events::loadClassMetadata, $test);

    class TestEvent
    {
        public function loadClassMetadata(\Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs)
        {
            $classMetadata = $eventArgs->getClassMetadata();
            $fieldMapping = array(
                'fieldName' => 'about',
                'type' => 'string',
                'length' => 255
            );
            $classMetadata->mapField($fieldMapping);
        }
    }


