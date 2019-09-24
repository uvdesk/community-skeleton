Configuration
=============

So you are ready to start configuring your migrations? We just need to provide
a few bits of information for the console application in order to get started.

Migrations Configuration
------------------------

First we need to configure information about your migrations. In ``/data/doctrine/migrations-docs-example``
go ahead and create a folder to store your migrations in:

.. code-block:: sh

    $ mkdir -p lib/MyProject/Migrations

Now, in the root of your project place a file named ``migrations.php``, ``migrations.yml``,
``migrations.xml`` or ``migrations.json`` and place the following contents:

.. configuration-block::

    .. code-block:: php

        <?php

        return [
            'name' => 'My Project Migrations',
            'migrations_namespace' => 'MyProject\Migrations',
            'table_name' => 'doctrine_migration_versions',
            'column_name' => 'version',
            'column_length' => 14,
            'executed_at_column_name' => 'executed_at',
            'migrations_directory' => '/data/doctrine/migrations-docs-example/lib/MyProject/Migrations',
            'all_or_nothing' => true,
            'check_database_platform' => true,
        ];

    .. code-block:: yaml

        name: "My Project Migrations"
        migrations_namespace: "MyProject\Migrations"
        table_name: "doctrine_migration_versions"
        column_name: "version"
        column_length: 14
        executed_at_column_name: "executed_at"
        migrations_directory: "/data/doctrine/migrations-docs-example/lib/MyProject/Migrations"
        all_or_nothing: true
        check_database_platform: true

    .. code-block:: xml

        <?xml version="1.0" encoding="UTF-8"?>
        <doctrine-migrations xmlns="http://doctrine-project.org/schemas/migrations/configuration"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://doctrine-project.org/schemas/migrations/configuration
                            http://doctrine-project.org/schemas/migrations/configuration.xsd">

            <name>My Project Migrations</name>

            <migrations-namespace>MyProject\Migrations</migrations-namespace>

            <table name="doctrine_migration_versions" column="version" column_length="14" executed_at_column="executed_at" />

            <migrations-directory>/data/doctrine/migrations-docs-example/lib/MyProject/Migrations</migrations-directory>

            <all-or-nothing>true</all-or-nothing>

            <check-database-platform>true</check-database-platform>
        </doctrine-migrations>

    .. code-block:: json

        {
            "name": "My Project Migrations",
            "migrations_namespace": "MyProject\Migrations",
            "table_name": "doctrine_migration_versions",
            "column_name": "version",
            "column_length": 14,
            "executed_at_column_name": "executed_at",
            "migrations_directory": "/data/doctrine/migrations-docs-example/lib/MyProject/Migrations",
            "all_or_nothing": true,
            "check_database_platform": true
        }

Please note that if you want to use the YAML configuration option, you will need to install the ``symfony/yaml`` package with composer:

.. code-block:: sh

    composer require symfony/yaml

Here are details about what each configuration option does:

+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| Name                       | Required    | Default                    | Description                                                                      |
+============================+=============+============================+==================================================================================+
| name                       | no          | Doctrine Migrations        | The name that shows at the top of the migrations console application.            |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| migrations_namespace       | yes         | null                       | The PHP namespace your migration classes are located under.                      |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| table_name                 | no          | doctrine_migration_versions| The name of the table to track executed migrations in.                           |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| column_name                | no          | version                    | The name of the column which stores the version name.                            |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| column_length              | no          | 14                         | The length of the column which stores the version name.                          |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| executed_at_column_name    | no          | executed_at                | The name of the column which stores the date that a migration was executed.      |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| migrations_directory       | yes         | null                       | The path to a directory where to look for migration classes.                     |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| all_or_nothing             | no          | false                      | Whether or not to wrap multiple migrations in a single transaction.              |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| migrations                 | no          | []                         | Manually specify the array of migration versions instead of finding migrations.  |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+
| check_database_platform    | no          | true                       | Whether to add a database platform check at the beginning of the generated code. |
+----------------------------+-------------+----------------------------+----------------------------------------------------------------------------------+

Manually Providing Migrations
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you don't want to rely on Doctrine finding your migrations, you can explicitly specify the array of migration
classes using the ``migrations`` configuration setting:

.. configuration-block::

    .. code-block:: php

        <?php

        return [
            // ..

            'migrations' => [
                'migration1' => [
                    'version' => '1',
                    'class' => 'MyProject\Migrations\NewMigration',
                ],
            ],
        ];

    .. code-block:: yaml

        // ...

        migrations:
            migration1:
                version: "1"
                class: "MyProject\Migrations\NewMigration"

    .. code-block:: xml

        <?xml version="1.0" encoding="UTF-8"?>
        <doctrine-migrations xmlns="http://doctrine-project.org/schemas/migrations/configuration"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://doctrine-project.org/schemas/migrations/configuration
                            http://doctrine-project.org/schemas/migrations/configuration.xsd">

            // ...

            <migrations>
                <migration class="MyProject\Migrations\NewMigration" version="1" />
            </migrations>
        </doctrine-migrations>

    .. code-block:: json

        {
            // ...

            "migrations": {
                    "migration1": {
                        "version": 1,
                        "class": "DoctrineMigrations\NewMigration"
                    }
                }
            }
        }

All or Nothing Transaction
--------------------------

.. note::

    This is only works if your database supports transactions for DDL statements.

When using the ``all_or_nothing`` option, multiple migrations ran at the same time will be wrapped in a single
transaction. If one migration fails, all migrations will be rolled back

From the Command Line
~~~~~~~~~~~~~~~~~~~~~

You can also set this option from the command line with the ``migrate`` command and the ``--all-or-nothing`` option:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --all-or-nothing

If you have it enabled at the configuration level and want to change it for an individual migration you can
pass a value of ``0`` or ``1`` to ``--all-or-nothing``.

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --all-or-nothing=0

Connection Configuration
------------------------

Now that we've configured our migrations, the next thing we need to configure is how the migrations console
application knows how to get the connection to use for the migrations:

Simple
~~~~~~

The simplest configuration is to put a ``migrations-db.php`` file in the root of your
project and return an array of connection information that can be passed to the DBAL:

.. code-block:: php

    <?php

    return [
        'dbname' => 'migrations_docs_example',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

You will need to make sure the ``migrations_docs_example`` database exists. If you are using MySQL you can create it with
the following command:

.. code-block:: sh

    $ mysqladmin create migrations_docs_example

Advanced
~~~~~~~~

If you require a more advanced configuration and you want to get the connection to use
from your existing application setup then you can use this method of configuration.

In the root of your project, place a file named ``cli-config.php`` with the following
contents. It can also be placed in a folder named ``config`` if you prefer to keep it
out of the root of your project.

.. code-block:: php

    <?php

    require 'vendor/autoload.php';

    use Doctrine\DBAL\DriverManager;
    use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
    use Symfony\Component\Console\Helper\HelperSet;

    $dbParams = include 'migrations-db.php';

    $connection = DriverManager::getConnection($dbParams);

    return new HelperSet([
        'db' => new ConnectionHelper($connection),
    ]);

The above setup assumes you are not using the ORM. If you want to use the ORM, first require it in your project
with composer:

.. code-block:: sh

    composer require doctrine/orm

Now update your ``cli-config.php`` in the root of your project to look like the following:

.. code-block:: php

    <?php

    require 'vendor/autoload.php';

    use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
    use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;
    use Symfony\Component\Console\Helper\HelperSet;

    $paths = [__DIR__.'/lib/MyProject/Entities'];
    $isDevMode = true;

    $dbParams = include 'migrations-db.php';

    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
    $entityManager = EntityManager::create($dbParams, $config);

    return new HelperSet([
        'em' => new EntityManagerHelper($entityManager),
        'db' => new ConnectionHelper($entityManager->getConnection()),
    ]);

Make sure to create the directory where your ORM entities will be located:

.. code-block:: sh

    $ mkdir lib/MyProject/Entities

:ref:`Next Chapter: Migration Classes <migration-classes>`
