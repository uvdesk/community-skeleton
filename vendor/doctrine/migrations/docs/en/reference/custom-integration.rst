Custom Integration
==================

If you don't want to use the ``./vendor/bin/doctrine-migrations`` script that comes with the project,
you can always setup your own custom integration.

In the root of your project, create a file named ``migrations`` and make it executable:

.. code-block:: bash

    $ chmod +x migrations

Now place the following code in the ``migrations`` file:

.. code-block:: php

    #!/usr/bin/env php
    <?php

    require_once __DIR__.'/vendor/autoload.php';

    use Doctrine\DBAL\DriverManager;
    use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
    use Doctrine\Migrations\Tools\Console\Command;
    use Symfony\Component\Console\Application;
    use Symfony\Component\Console\Helper\HelperSet;
    use Symfony\Component\Console\Helper\QuestionHelper;

    $dbParams = [
        'dbname' => 'migrations_test',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

    $connection = DriverManager::getConnection($dbParams);

    $helperSet = new HelperSet();
    $helperSet->set(new QuestionHelper(), 'question');
    $helperSet->set(new ConnectionHelper($connection), 'db');

    $cli = new Application('Doctrine Migrations');
    $cli->setCatchExceptions(true);
    $cli->setHelperSet($helperSet);

    $cli->addCommands(array(
        new Command\DumpSchemaCommand(),
        new Command\ExecuteCommand(),
        new Command\GenerateCommand(),
        new Command\LatestCommand(),
        new Command\MigrateCommand(),
        new Command\RollupCommand(),
        new Command\StatusCommand(),
        new Command\VersionCommand()
    ));

    $cli->run();

Now you can execute the migrations console application like this:

.. code-block:: bash

    $ ./migrations
