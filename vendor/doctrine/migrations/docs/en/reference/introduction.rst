Introduction
============

The Doctrine Migrations project offers additional functionality on top of the
DBAL_ and ORM_ for versioning your database schema. It makes it easy and safe
to deploy changes to it in a way that can be reviewed and tested before being
deployed to production.

Installation
------------

You can use the Doctrine Migrations project by installing it with Composer_ or by downloading
the latest PHAR from the releases_ page on GitHub.

For this documentation exercise we will assume you are starting a new project so create a new folder to work in:

.. code-block:: sh

    $ mkdir /data/doctrine/migrations-docs-example
    $ cd /data/doctrine/migrations-docs-example

Composer
~~~~~~~~

Now to install with Composer it is as simple as running the following command in your project.

.. code-block:: sh

    composer require doctrine/migrations:2.0

Now you will have a file in ``vendor/bin`` available to run the migrations console application:

.. code-block:: sh

    ./vendor/bin/doctrine-migrations

PHAR
~~~~

To install by downloading the PHAR, you just need to download the latest PHAR file from the
releases_ page on GitHub.

Here is an example using the ``2.0.0`` release:

.. code-block:: sh

    wget https://github.com/doctrine/migrations/releases/download/v2.0.0/doctrine-migrations.phar

Now you can execute the PHAR like this:

.. code-block:: sh

    php doctrine-migrations.phar

:ref:`Next Chapter: Configuration <configuration>`

.. _Composer: https://getcomposer.org/
.. _DBAL: https://www.doctrine-project.org/projects/dbal.html
.. _ORM: https://www.doctrine-project.org/projects/orm.html
.. _releases: https://github.com/doctrine/migrations/releases
