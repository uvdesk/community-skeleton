Introduction
============

The Doctrine Event Manager is a simple event system used by the various Doctrine projects. It was originally built
for the DBAL and ORM but over time other projects adopted it and now it is available as a standalone library.

Installation
============

The library can easily be installed with composer.

.. code-block:: sh

    $ composer require doctrine/event-manager

Setup
=====

The event system is controlled by the ``Doctrine\Common\EventManager`` class.

.. code-block:: php

    use Doctrine\Common\EventManager;

    $eventManager = new EventManager();

Listeners
=========

Now you are ready to listen for events. Here is an example of a custom event listener named ``TestEvent``.

.. code-block:: php

    use Doctrine\Common\EventArgs;
    use Doctrine\Common\EventManager;

    final class TestEvent
    {
        public const preFoo = 'preFoo';
        public const postFoo = 'postFoo';

        /** @var EventManager */
        private $eventManager;

        /** @var bool */
        public $preFooInvoked = false;

        /** @var bool */
        public $postFooInvoked = false;

        public function __construct(EventManager $eventManager)
        {
            $eventManager->addEventListener([self::preFoo, self::postFoo], $this);
        }

        public function preFoo(EventArgs $eventArgs) : void
        {
            $this->preFooInvoked = true;
        }

        public function postFoo(EventArgs $eventArgs) : void
        {
            $this->postFooInvoked = true;
        }
    }

    // Create a new instance
    $testEvent = new TestEvent($eventManager);

Dispatching Events
==================

Now you can dispatch events with the ``dispatchEvent()`` method.

.. code-block:: php

    $eventManager->dispatchEvent(TestEvent::preFoo);
    $eventManager->dispatchEvent(TestEvent::postFoo);

Removing Event Listeners
========================

You can easily remove a listener with the ``removeEventListener()`` method.

.. code-block:: php

    $eventManager->removeEventListener([TestEvent::preFoo, TestEvent::postFoo], $testEvent);

Event Subscribers
=================

The Doctrine event system also has a simple concept of event subscribers. We can define a simple ``TestEventSubscriber`` class which implements the ``Doctrine\Common\EventSubscriber`` interface with a ``getSubscribedEvents()`` method which returns an array of events it should be subscribed to.

.. code-block:: php

    use Doctrine\Common\EventSubscriber;

    final class TestEventSubscriber implements EventSubscriber
    {
        /** @var bool */
        public $preFooInvoked = false;

        public function preFoo() : void
        {
            $this->preFooInvoked = true;
        }

        public function getSubscribedEvents() : array
        {
            return [TestEvent::preFoo];
        }
    }

    $eventSubscriber = new TestEventSubscriber();
    $eventManager->addEventSubscriber($eventSubscriber);

.. note::

    The array returned by the ``getSubscribedEvents()`` method is a simple array with the values being the event names. The subscriber must have a method that is named exactly like the event.

Now when you dispatch an event, any event subscribers will be notified of that event.

.. code-block:: php

    $eventManager->dispatchEvent(TestEvent::preFoo);

Now you can check the ``preFooInvoked`` property to see if the event subscriber was notified of the event:

.. code-block:: php

    if ($eventSubscriber->preFooInvoked) {
        // the preFoo method was invoked
    }
