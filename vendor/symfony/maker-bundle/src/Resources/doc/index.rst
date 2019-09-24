The Symfony MakerBundle
=======================

Symfony Maker helps you create empty commands, controllers, form classes,
tests and more so you can forget about writing boilerplate code. This
bundle is an alternative to `SensioGeneratorBundle`_ for modern Symfony
applications and requires using Symfony 3.4 or newer. This bundle
assumes you're using a standard Symfony 4 directory structure, but many
commands can generate code into any application.

Installation
------------

Run this command to install and enable this bundle in your application:

.. code-block:: terminal

    $ composer require symfony/maker-bundle --dev

Usage
-----

This bundle provides several commands under the ``make:`` namespace. List them
all executing this command:

.. code-block:: terminal

    $ php bin/console list make

     make:command            Creates a new console command class
     make:controller         Creates a new controller class
     make:entity             Creates a new Doctrine entity class

     [...]

     make:validator          Creates a new validator and constraint class
     make:voter              Creates a new security voter class

The names of the commands are self-explanatory, but some of them include
optional arguments and options. Check them out with the ``--help`` option:

.. code-block:: terminal

    $ php bin/console make:controller --help

Configuration
-------------

This bundle doesn't require any configuration. But, you *can* configure
the root namespace that is used to "guess" what classes you want to generate:

.. code-block:: yaml

    # config/packages/dev/maker.yaml
    # create this file if you need to configure anything
    maker:
        # tell MakerBundle that all of your classes lives in an
        # Acme namespace, instead of the default App
        # (e.g. Acme\Entity\Article, Acme\Command\MyCommand, etc)
        root_namespace: 'Acme'

Creating your Own Makers
------------------------

In case your applications need to generate custom boilerplate code, you can
create your own ``make:...`` command reusing the tools provided by this bundle.
To do that, you should create a class that extends
`AbstractMaker`_ in your ``src/Maker/``
directory. And this is really it!

For examples of how to complete your new maker command, see the `core maker commands`_.
Make sure your class is registered as a service and tagged with ``maker.command``.
If you're using the standard Symfony ``services.yaml`` configuration, this
will be done automatically.

Overriding the Generated Code
-----------------------------

Generated code can never be perfect for everyone. The MakerBundle tries to balance
adding "extension points" with keeping the library simple so that existing commands
can be improved and new commands can be added.

For that reason, in general, the generated code cannot be modified. In many cases,
adding your *own* maker command is so easy, that we recommend that. However, if there
is some extension point that you'd like, please open an issue so we can discuss!

.. _`SensioGeneratorBundle`: https://github.com/sensiolabs/SensioGeneratorBundle
.. _`AbstractMaker`: https://github.com/symfony/maker-bundle/blob/master/src/Maker/AbstractMaker.php
.. _`core maker commands`: https://github.com/symfony/maker-bundle/tree/master/src/Maker
