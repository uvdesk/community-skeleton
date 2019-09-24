Managing Migrations
===================

Managing migrations with Doctrine is easy. You can execute migrations from the console and easily revert them. You also
have the option to write the SQL for a migration to a file instead of executing it from PHP.

Status
------

Now that we have a new migration created, run the ``status`` command with the ``--show-versions`` option to see
that the new migration is registered and ready to be executed:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations status --show-versions

     == Configuration

        >> Name:                                               My Project Migrations
        >> Database Driver:                                    pdo_mysql
        >> Database Host:                                      localhost
        >> Database Name:                                      migrations_docs_example
        >> Configuration Source:                               /data/doctrine/migrations-docs-example/migrations.php
        >> Version Table Name:                                 doctrine_migration_versions
        >> Version Column Name:                                version
        >> Migrations Namespace:                               MyProject\Migrations
        >> Migrations Directory:                               /data/doctrine/migrations-docs-example/lib/MyProject/Migrations
        >> Previous Version:                                   Already at first version
        >> Current Version:                                    0
        >> Next Version:                                       2018-06-01 19:30:57 (20180601193057)
        >> Latest Version:                                     2018-06-01 19:30:57 (20180601193057)
        >> Executed Migrations:                                0
        >> Executed Unavailable Migrations:                    0
        >> Available Migrations:                               1
        >> New Migrations:                                     1

     == Available Migration Versions

        >> 2018-06-01 19:30:57 (20180601193057)                not migrated     This is my example migration.

As you can see we have a new migration version available and it is ready to be executed. The problem
is, it does not have anything in it so nothing would be executed! Let's add some code to it and add a new table:

.. code-block:: php

    <?php

    declare(strict_types=1);

    namespace MyProject\Migrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20180601193057 extends AbstractMigration
    {
        public function getDescription() : string
        {
            return 'This is my example migration.';
        }

        public function up(Schema $schema) : void
        {
            $this->addSql('CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        }

        public function down(Schema $schema) : void
        {
            $this->addSql('DROP TABLE example_table');
        }
    }

Dry Run
-------

Now we are ready to give it a test! First lets just do a dry-run to make sure it produces the SQL we expect:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --dry-run

                        My Project Migrations


    Executing dry run of migration up to 20180601193057 from 0

      ++ migrating 20180601193057

         -> CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))

      ++ migrated (took 60.9ms, used 8M memory)

      ------------------------

      ++ finished in 69.4ms
      ++ used 8M memory
      ++ 1 migrations executed
      ++ 1 sql queries

Executing Multiple Migrations
-----------------------------

Everything looks good so we can remove the ``--dry-run`` option and actually execute the migration.

.. note::

    The ``migrate`` command will execute multiple migrations if there are multiple new unexecuted migration versions
    available. It will attempt to go from the current version to the latest version available.

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate

                        My Project Migrations


    WARNING! You are about to execute a database migration that could result in schema changes and data loss. Are you sure you wish to continue? (y/n)y
    Migrating up to 20180601193057 from 0

      ++ migrating 20180601193057

         -> CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))

      ++ migrated (took 47.7ms, used 8M memory)

      ------------------------

      ++ finished in 49.1ms
      ++ used 8M memory
      ++ 1 migrations executed
      ++ 1 sql queries

Executing Single Migrations
---------------------------

You may want to just execute a single migration up or down. You can do this with the ``execute`` command:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations execute 20180601193057 --down
    WARNING! You are about to execute a database migration that could result in schema changes and data lost. Are you sure you wish to continue? (y/n)y

      ++ migrating 20180601193057

         -> DROP TABLE example_table

      ++ migrated (took 42.6ms, used 8M memory)

No Interaction
--------------

Alternately, if you wish to run the migrations in an unattended mode, we can add the ``--no--interaction`` option and then
execute the migrations without any extra prompting from Doctrine.

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --no-interaction

                        My Project Migrations


    Migrating up to 20180601193057 from 0

      ++ migrating 20180601193057

         -> CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))

      ++ migrated (took 46.5ms, used 8M memory)

      ------------------------

      ++ finished in 47.3ms
      ++ used 8M memory
      ++ 1 migrations executed
      ++ 1 sql queries

By checking the status again after using either method you will see everything is updated:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations status --show-versions

     == Configuration

        >> Name:                                               My Project Migrations
        >> Database Driver:                                    pdo_mysql
        >> Database Host:                                      localhost
        >> Database Name:                                      migrations_docs_example
        >> Configuration Source:                               /data/doctrine/migrations-docs-example/migrations.php
        >> Version Table Name:                                 doctrine_migration_versions
        >> Version Column Name:                                version
        >> Migrations Namespace:                               MyProject\Migrations
        >> Migrations Directory:                               /data/doctrine/migrations-docs-example/lib/MyProject/Migrations
        >> Previous Version:                                   0
        >> Current Version:                                    2018-06-01 19:30:57 (20180601193057)
        >> Next Version:                                       Already at latest version
        >> Latest Version:                                     2018-06-01 19:30:57 (20180601193057)
        >> Executed Migrations:                                1
        >> Executed Unavailable Migrations:                    0
        >> Available Migrations:                               1
        >> New Migrations:                                     0

     == Available Migration Versions

        >> 2018-06-01 19:30:57 (20180601193057)                migrated (executed at 2018-06-01 17:08:44)     This is my example migration.

Reverting Migrations
--------------------

The ``migrate`` command optionally accepts a version or version alias to migrate to. By default it will try to migrate up
from the current version to the latest version. If you pass a version that is older than the current version,
it will migrate down. To rollback to the the first version you can use the ``first`` version alias:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate first

                        My Project Migrations


    WARNING! You are about to execute a database migration that could result in schema changes and data loss. Are you sure you wish to continue? (y/n)y
    Migrating down to 0 from 20180601193057

      -- reverting 20180601193057

         -> DROP TABLE example_table

      -- reverted (took 38.4ms, used 8M memory)

      ------------------------

      ++ finished in 39.5ms
      ++ used 8M memory
      ++ 1 migrations executed
      ++ 1 sql queries

Now if you run the ``status`` command again, you will see that the database is back to the way it was before:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations status --show-versions

     == Configuration

        >> Name:                                               My Project Migrations
        >> Database Driver:                                    pdo_mysql
        >> Database Host:                                      localhost
        >> Database Name:                                      migrations_docs_example
        >> Configuration Source:                               /data/doctrine/migrations-docs-example/migrations.php
        >> Version Table Name:                                 doctrine_migration_versions
        >> Version Column Name:                                version
        >> Migrations Namespace:                               MyProject\Migrations
        >> Migrations Directory:                               /data/doctrine/migrations-docs-example/lib/MyProject/Migrations
        >> Previous Version:                                   Already at first version
        >> Current Version:                                    0
        >> Next Version:                                       2018-06-01 19:30:57 (20180601193057)
        >> Latest Version:                                     2018-06-01 19:30:57 (20180601193057)
        >> Executed Migrations:                                0
        >> Executed Unavailable Migrations:                    0
        >> Available Migrations:                               1
        >> New Migrations:                                     1

     == Available Migration Versions

        >> 2018-06-01 19:30:57 (20180601193057)                not migrated     This is my example migration.

Version Aliases
---------------

You can use version aliases when executing migrations. This is for your convenience so you don't have to always know
the version number. The following aliases are available:

- ``first`` - Migrate down to before the first version.
- ``prev`` - Migrate down to before the previous version.
- ``next`` - Migrate up to the next version.
- ``latest`` - Migrate up to the latest version.

Here is an example where we migrate to the latest version and then revert back to the first:

.. code-block:: bash

    $ ./vendor/bin/doctrine-migrations migrate latest
    $ ./vendor/bin/doctrine-migrations migrate first

Writing Migration SQL Files
---------------------------

You can optionally choose to not execute a migration directly on a database from PHP and instead output all the SQL
statement to a file. This is possible by using the ``--write-sql`` option:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --write-sql

                        My Project Migrations


    Executing dry run of migration up to 20180601193057 from 0

      ++ migrating 20180601193057

         -> CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))

      ++ migrated (took 55ms, used 8M memory)

      ------------------------

      ++ finished in 60.7ms
      ++ used 8M memory
      ++ 1 migrations executed
      ++ 1 sql queries
    -- Migrating from 0 to 20180601193057


    Writing migration file to "/data/doctrine/migrations-docs-example/doctrine_migration_20180601172528.sql"

Now if you have a look at the ``doctrine_migration_20180601172528.sql`` file you will see the would be
executed SQL outputted in a nice format:

.. code-block:: sh

    $ cat doctrine_migration_20180601172528.sql
    -- Doctrine Migration File Generated on 2018-06-01 17:25:28

    -- Version 20180601193057
    CREATE TABLE example_table (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id));
    INSERT INTO doctrine_migration_versions (version, executed_at) VALUES ('20180601193057', CURRENT_TIMESTAMP);

The ``--write-sql`` option also accepts an optional value for where to write the sql file. It can be a relative path
to a file that will write to the current working directory:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --write-sql=migration.sql

Or it can be an absolute path to the file:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --write-sql=/path/to/migration.sql

Or it can be a directory and it will write the default filename to it:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations migrate --write-sql=/path/to/directory

Managing the Version Table
--------------------------

Sometimes you may need to manually mark a migration as migrated or not. You can use the ``version`` command for this.

.. caution::

    Use caution when using the ``version`` command. If you delete a version from the table and then run the ``migrate``
    command, that migration version will be executed again.

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations version 20180601193057 --add

Or you can delete that version:

.. code-block:: sh

    $ ./vendor/bin/doctrine-migrations version 20180601193057 --delete

This command does not actually execute any migrations, it just adds or deletes the version from the version table where
we track whether or not a migration version has been executed or not.

:ref:`Next Chapter: Generating Migrations <generating-migrations>`
