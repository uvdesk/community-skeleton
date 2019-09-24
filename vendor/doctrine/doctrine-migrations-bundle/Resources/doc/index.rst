DoctrineMigrationsBundle
========================

Database migrations are a way to safely update your database schema both locally
and on production. Instead of running the ``doctrine:schema:update`` command or
applying the database changes manually with SQL statements, migrations allow to
replicate the changes in your database schema in a safe manner.

Migrations are available in Symfony applications via the `DoctrineMigrationsBundle`_,
which uses the external `Doctrine Database Migrations`_ library. Read the
`documentation`_ of that library if you need a general introduction about migrations.

Installation
------------

Run this command in your terminal:

.. code-block:: bash

    $ composer require doctrine/doctrine-migrations-bundle "^2.0"

If you don't use Symfony Flex, you must enable the bundle manually in the application:

.. code-block:: php

    // config/bundles.php
    // in older Symfony apps, enable the bundle in app/AppKernel.php
    return [
        // ...
        Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    ];

Configuration
-------------

If you use Symfony Flex, the ``doctrine_migrations.yaml`` config file is created
automatically. Otherwise, create the following file and configure it for your
application:

.. code-block:: yaml

    # config/packages/doctrine_migrations.yaml
    doctrine_migrations:
        dir_name: '%kernel.project_dir%/src/Migrations'
        # namespace is arbitrary but should be different from App\Migrations
        # as migrations classes should NOT be autoloaded
        namespace: DoctrineMigrations
        table_name: 'migration_versions'
        column_name: 'version'
        column_length: 14
        executed_at_column_name: 'executed_at'
        name: 'Application Migrations'
        # available in version >= 1.2. Possible values: "BY_YEAR", "BY_YEAR_AND_MONTH", false
        organize_migrations: false
        # available in version >= 1.2. Path to your custom migrations template
        custom_template: ~
        all_or_nothing: false

Usage
-----

All of the migrations functionality is contained in a few console commands:

.. code-block:: bash

    doctrine
     doctrine:migrations:diff                [diff] Generate a migration by comparing your current database to your mapping information.
     doctrine:migrations:dump-schema         [dump-schema] Dump the schema for your database to a migration.
     doctrine:migrations:execute             [execute] Execute a single migration version up or down manually.
     doctrine:migrations:generate            [generate] Generate a blank migration class.
     doctrine:migrations:latest              [latest] Outputs the latest version number
     doctrine:migrations:migrate             [migrate] Execute a migration to a specified version or the latest available version.
     doctrine:migrations:rollup              [rollup] Rollup migrations by deleting all tracked versions and insert the one version that exists.
     doctrine:migrations:status              [status] View the status of a set of migrations.
     doctrine:migrations:up-to-date          [up-to-date] Tells you if your schema is up-to-date.
     doctrine:migrations:version             [version] Manually add and delete migration versions from the version table.

Start by getting the status of migrations in your application by running
the ``status`` command:

.. code-block:: bash

    $ php bin/console doctrine:migrations:status

     == Configuration

        >> Name:                                               Application Migrations
        >> Database Driver:                                    pdo_mysql
        >> Database Host:                                      127.0.0.1
        >> Database Name:                                      symfony_migrations
        >> Configuration Source:                               manually configured
        >> Version Table Name:                                 migration_versions
        >> Version Column Name:                                version
        >> Migrations Namespace:                               App\Migrations
        >> Migrations Directory:                               /path/to/project/app/Migrations
        >> Previous Version:                                   Already at first version
        >> Current Version:                                    0
        >> Next Version:                                       Already at latest version
        >> Latest Version:                                     0
        >> Executed Migrations:                                0
        >> Executed Unavailable Migrations:                    0
        >> Available Migrations:                               0
        >> New Migrations:                                     0

Now, you can start working with migrations by generating a new blank migration
class. Later, you'll learn how Doctrine can generate migrations automatically
for you.

.. code-block:: bash

    $ php bin/console doctrine:migrations:generate
    Generated new migration class to "/path/to/project/app/Migrations/Version20180605025653.php"

    To run just this migration for testing purposes, you can use migrations:execute --up 20180605025653

    To revert the migration you can use migrations:execute --down 20180605025653

Have a look at the newly generated migration class and you will see something
like the following:

.. code-block:: php

    declare(strict_types=1);

    namespace App\Migrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20180605025653 extends AbstractMigration
    {
        public function getDescription() : string
        {
            return '';
        }

        public function up(Schema $schema) : void
        {
            // this up() migration is auto-generated, please modify it to your needs

        }

        public function down(Schema $schema) : void
        {
            // this down() migration is auto-generated, please modify it to your needs

        }
    }

If you run the ``status`` command it will now show that you have one new
migration to execute:

.. code-block:: bash

    $ php bin/console doctrine:migrations:status --show-versions

     == Configuration

        >> Name:                                               Application Migrations
        >> Database Driver:                                    pdo_mysql
        >> Database Host:                                      127.0.0.1
        >> Database Name:                                      symfony_migrations
        >> Configuration Source:                               manually configured
        >> Version Table Name:                                 migration_versions
        >> Version Column Name:                                version
        >> Migrations Namespace:                               DoctrineMigrations
        >> Migrations Directory:                               /path/to/project/app/Migrations
        >> Previous Version:                                   Already at first version
        >> Current Version:                                    0
        >> Next Version:                                       2018-06-05 02:56:53 (20180605025653)
        >> Latest Version:                                     2018-06-05 02:56:53 (20180605025653)
        >> Executed Migrations:                                0
        >> Executed Unavailable Migrations:                    0
        >> Available Migrations:                               1
        >> New Migrations:                                     1

     == Available Migration Versions

        >> 2018-06-05 02:56:53 (20180605025653)                not migrated

Now you can add some migration code to the ``up()`` and ``down()`` methods and
finally migrate when you're ready:

.. code-block:: bash

    $ php bin/console doctrine:migrations:migrate 20180605025653

For more information on how to write the migrations themselves (i.e. how to
fill in the ``up()`` and ``down()`` methods), see the official Doctrine Migrations
`documentation`_.

Running Migrations during Deployment
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Of course, the end goal of writing migrations is to be able to use them to
reliably update your database structure when you deploy your application.
By running the migrations locally (or on a beta server), you can ensure that
the migrations work as you expect.

When you do finally deploy your application, you just need to remember to run
the ``doctrine:migrations:migrate`` command. Internally, Doctrine creates
a ``migration_versions`` table inside your database and tracks which migrations
have been executed there. So, no matter how many migrations you've created
and executed locally, when you run the command during deployment, Doctrine
will know exactly which migrations it hasn't run yet by looking at the ``migration_versions``
table of your production database. Regardless of what server you're on, you
can always safely run this command to execute only the migrations that haven't
been run yet on *that* particular database.

Skipping Migrations
~~~~~~~~~~~~~~~~~~~

You can skip single migrations by explicitly adding them to the ``migration_versions`` table:

.. code-block:: bash

    $ php bin/console doctrine:migrations:version YYYYMMDDHHMMSS --add

Doctrine will then assume that this migration has already been run and will ignore it.

Generating Migrations Automatically
-----------------------------------

In reality, you should rarely need to write migrations manually, as the migrations
library can generate migration classes automatically by comparing your Doctrine
mapping information (i.e. what your database *should* look like) with your
actual current database structure.

For example, suppose you create a new ``User`` entity and add mapping information
for Doctrine's ORM:

.. configuration-block::

    .. code-block:: php-annotations

        // src/Entity/User.php
        namespace App\Entity;

        use Doctrine\ORM\Mapping as ORM;

        /**
         * @ORM\Entity
         * @ORM\Table(name="hello_user")
         */
        class User
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            private $id;

            /**
             * @ORM\Column(type="string", length=255)
             */
            private $name;

    .. code-block:: yaml

        # config/doctrine/User.orm.yml
        App\Entity\User:
            type: entity
            table: user
            id:
                id:
                    type: integer
                    generator:
                        strategy: AUTO
            fields:
                name:
                    type: string
                    length: 255

    .. code-block:: xml

        <!-- config/doctrine/User.orm.xml -->
        <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                            http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

            <entity name="App\Entity\User" table="user">
                <id name="id" type="integer" column="id">
                    <generator strategy="AUTO"/>
                </id>
                <field name="name" column="name" type="string" length="255" />
            </entity>

        </doctrine-mapping>

With this information, Doctrine is now ready to help you persist your new
``User`` object to and from the ``user`` table. Of course, this table
doesn't exist yet! Generate a new migration for this table automatically by
running the following command:

.. code-block:: bash

    $ php bin/console doctrine:migrations:diff

You should see a message that a new migration class was generated based on
the schema differences. If you open this file, you'll find that it has the
SQL code needed to create the ``user`` table. Next, run the migration
to add the table to your database:

.. code-block:: bash

    $ php bin/console doctrine:migrations:migrate

The moral of the story is this: after each change you make to your Doctrine
mapping information, run the ``doctrine:migrations:diff`` command to automatically
generate your migration classes.

If you do this from the very beginning of your project (i.e. so that even
the first tables were loaded via a migration class), you'll always be able
to create a fresh database and run your migrations in order to get your database
schema fully up to date. In fact, this is an easy and dependable workflow
for your project.

If you don't want to use this workflow and instead create your schema via
``doctrine:schema:create``, you can tell Doctrine to skip all existing migrations:

.. code-block:: bash

    $ php bin/console doctrine:migrations:version --add --all

Otherwise Doctrine will try to run all migrations, which probably will not work.

Manual Tables
-------------

It is a common use case, that in addition to your generated database structure
based on your doctrine entities you might need custom tables. By default such
tables will be removed by the doctrine:migrations:diff command.

If you follow a specific scheme you can configure doctrine/dbal to ignore those
tables. Let's say all custom tables will be prefixed by ``t_``. In this case you
just have to add the following configuration option to your doctrine configuration:

.. configuration-block::

    .. code-block:: yaml

        doctrine:
            dbal:
                schema_filter: ~^(?!t_)~

    .. code-block:: xml

        <doctrine:dbal schema-filter="~^(?!t_)~" ... />


    .. code-block:: php

        $container->loadFromExtension('doctrine', array(
            'dbal' => array(
                'schema_filter'  => '~^(?!t_)~',
                // ...
            ),
            // ...
        ));

This ignores the tables on the DBAL level and they will be ignored by the diff command.

Note that if you have multiple connections configured then the ``schema_filter`` configuration
will need to be placed per-connection.

.. _documentation: https://www.doctrine-project.org/projects/doctrine-migrations/en/current/index.html
.. _DoctrineMigrationsBundle: https://github.com/doctrine/DoctrineMigrationsBundle
.. _`Doctrine Database Migrations`: https://github.com/doctrine/migrations
