Migrations Events
=================

The Doctrine Migrations library emits a series of events during the migration process.

- ``onMigrationsMigrating``: dispatched immediately before starting to execute versions. This does not fire if
there are no versions to be executed.
- ``onMigrationsVersionExecuting``: dispatched before a single version executes.
- ``onMigrationsVersionExecuted``: dispatched after a single version executes.
- ``onMigrationsVersionSkipped``: dispatched when a single version is skipped.
- ``onMigrationsMigrated``: dispatched when all versions have been executed.

All of these events are emitted via the DBAL connection's event manager. Here's an example event subscriber that
listens for all possible migrations events.

.. code-block:: php

    <?php

    use Doctrine\Common\EventSubscriber;
    use Doctrine\Migrations\Event\MigrationsEventArgs;
    use Doctrine\Migrations\Event\MigrationsVersionEventArgs;
    use Doctrine\Migrations\Events;

    class MigrationsListener implements EventSubscriber
    {
        public function getSubscribedEvents() : array
        {
            return [
                Events::onMigrationsMigrating,
                Events::onMigrationsMigrated,
                Events::onMigrationsVersionExecuting,
                Events::onMigrationsVersionExecuted,
                Events::onMigrationsVersionSkipped,
            ];
        }

        public function onMigrationsMigrating(MigrationsEventArgs $args) : void
        {
            // ...
        }

        public function onMigrationsMigrated(MigrationsEventArgs $args) : void
        {
            // ...
        }

        public function onMigrationsVersionExecuting(MigrationsVersionEventArgs $args) : void
        {
            // ...
        }

        public function onMigrationsVersionExecuted(MigrationsVersionEventArgs $args) : void
        {
            // ...
        }

        public function onMigrationsVersionSkipped(MigrationsVersionEventArgs $args) : void
        {
            // ...
        }
    }

To add an event subscriber to a connections event manager, use the ``Connection::getEventManager()`` method
and the ``EventManager::addEventSubscriber()`` method:

This might go in the ``cli-config.php`` file or somewhere in a frameworks container or dependency injection configuration.

.. code-block:: php

    <?php

    use Doctrine\DBAL\DriverManager;

    $connection = DriverManager::getConnection([
        // ...
    ]);

    $connection->getEventManager()->addEventSubscriber(new MigrationsListener());

    // rest of the cli set up...

:ref:`Next Chapter: Version Numbers <version-numbers>`
