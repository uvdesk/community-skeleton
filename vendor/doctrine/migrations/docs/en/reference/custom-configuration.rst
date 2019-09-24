Custom Configuration
====================

It is possible to build a custom configuration where you manually build the ``Doctrine\Migrations\Configuration\Configuration``
instance instead of using YAML, XML, etc. In order to do this, you will need to setup a :ref:`Custom Integration <custom-integration>`.

Once you have your custom integration setup, you can modify it to look like the following:

.. code-block:: php

    #!/usr/bin/env php
    <?php

    require_once __DIR__.'/vendor/autoload.php';

    use Doctrine\DBAL\DriverManager;
    use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
    use Doctrine\Migrations\Configuration\Configuration;
    use Doctrine\Migrations\Tools\Console\Command;
    use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
    use Symfony\Component\Console\Application;
    use Symfony\Component\Console\Helper\HelperSet;
    use Symfony\Component\Console\Helper\QuestionHelper;

    $dbParams = [
        'dbname' => 'migrations_docs_example',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

    $connection = DriverManager::getConnection($dbParams);

    $configuration = new Configuration($connection);
    $configuration->setName('My Project Migrations');
    $configuration->setMigrationsNamespace('MyProject\Migrations');
    $configuration->setMigrationsTableName('doctrine_migration_versions');
    $configuration->setMigrationsColumnName('version');
    $configuration->setMigrationsColumnLength(255);
    $configuration->setMigrationsExecutedAtColumnName('executed_at');
    $configuration->setMigrationsDirectory('/data/doctrine/migrations-docs-example/lib/MyProject/Migrations');
    $configuration->setAllOrNothing(true);
    $configuration->setCheckDatabasePlatform(false);

    $helperSet = new HelperSet();
    $helperSet->set(new QuestionHelper(), 'question');
    $helperSet->set(new ConnectionHelper($connection), 'db');
    $helperSet->set(new ConfigurationHelper($connection, $configuration));

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

:ref:`Next Chapter: Migrations Events <events>`
