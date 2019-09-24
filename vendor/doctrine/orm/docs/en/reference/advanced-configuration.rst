Advanced Configuration
======================

The configuration of the EntityManager requires a
``Doctrine\ORM\Configuration`` instance as well as some database
connection parameters. This example shows all the potential
steps of configuration.

.. code-block:: php

    <?php
    use Doctrine\ORM\EntityManager,
        Doctrine\ORM\Configuration;
    
    // ...
    
    if ($applicationMode == "development") {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
    } else {
        $cache = new \Doctrine\Common\Cache\ApcCache;
    }
    
    $config = new Configuration;
    $config->setMetadataCacheImpl($cache);
    $driverImpl = $config->newDefaultAnnotationDriver('/path/to/lib/MyProject/Entities');
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    $config->setProxyDir('/path/to/myproject/lib/MyProject/Proxies');
    $config->setProxyNamespace('MyProject\Proxies');
    
    if ($applicationMode == "development") {
        $config->setAutoGenerateProxyClasses(true);
    } else {
        $config->setAutoGenerateProxyClasses(false);
    }
    
    $connectionOptions = array(
        'driver' => 'pdo_sqlite',
        'path' => 'database.sqlite'
    );
    
    $em = EntityManager::create($connectionOptions, $config);

.. note::

    Do not use Doctrine without a metadata and query cache!
    Doctrine is optimized for working with caches. The main
    parts in Doctrine that are optimized for caching are the metadata
    mapping information with the metadata cache and the DQL to SQL
    conversions with the query cache. These 2 caches require only an
    absolute minimum of memory yet they heavily improve the runtime
    performance of Doctrine. The recommended cache driver to use with
    Doctrine is `APC <http://www.php.net/apc>`_. APC provides you with
    an opcode-cache (which is highly recommended anyway) and a very
    fast in-memory cache storage that you can use for the metadata and
    query caches as seen in the previous code snippet.

Configuration Options
---------------------

The following sections describe all the configuration options
available on a ``Doctrine\ORM\Configuration`` instance.

Proxy Directory (***REQUIRED***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setProxyDir($dir);
    $config->getProxyDir();

Gets or sets the directory where Doctrine generates any proxy
classes. For a detailed explanation on proxy classes and how they
are used in Doctrine, refer to the "Proxy Objects" section further
down.

Proxy Namespace (***REQUIRED***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setProxyNamespace($namespace);
    $config->getProxyNamespace();

Gets or sets the namespace to use for generated proxy classes. For
a detailed explanation on proxy classes and how they are used in
Doctrine, refer to the "Proxy Objects" section further down.

Metadata Driver (***REQUIRED***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setMetadataDriverImpl($driver);
    $config->getMetadataDriverImpl();

Gets or sets the metadata driver implementation that is used by
Doctrine to acquire the object-relational metadata for your
classes.

There are currently 4 available implementations:


-  ``Doctrine\ORM\Mapping\Driver\AnnotationDriver``
-  ``Doctrine\ORM\Mapping\Driver\XmlDriver``
-  ``Doctrine\ORM\Mapping\Driver\YamlDriver``
-  ``Doctrine\ORM\Mapping\Driver\DriverChain``

Throughout the most part of this manual the AnnotationDriver is
used in the examples. For information on the usage of the XmlDriver
or YamlDriver please refer to the dedicated chapters
``XML Mapping`` and ``YAML Mapping``.

The annotation driver can be configured with a factory method on
the ``Doctrine\ORM\Configuration``:

.. code-block:: php

    <?php
    $driverImpl = $config->newDefaultAnnotationDriver('/path/to/lib/MyProject/Entities');
    $config->setMetadataDriverImpl($driverImpl);

The path information to the entities is required for the annotation
driver, because otherwise mass-operations on all entities through
the console could not work correctly. All of metadata drivers
accept either a single directory as a string or an array of
directories. With this feature a single driver can support multiple
directories of Entities.

Metadata Cache (***RECOMMENDED***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setMetadataCacheImpl($cache);
    $config->getMetadataCacheImpl();

Gets or sets the cache implementation to use for caching metadata
information, that is, all the information you supply via
annotations, xml or yaml, so that they do not need to be parsed and
loaded from scratch on every single request which is a waste of
resources. The cache implementation must implement the
``Doctrine\Common\Cache\Cache`` interface.

Usage of a metadata cache is highly recommended.

The recommended implementations for production are:


-  ``Doctrine\Common\Cache\ApcCache``
-  ``Doctrine\Common\Cache\ApcuCache``
-  ``Doctrine\Common\Cache\MemcacheCache``
-  ``Doctrine\Common\Cache\XcacheCache``
-  ``Doctrine\Common\Cache\RedisCache``

For development you should use the
``Doctrine\Common\Cache\ArrayCache`` which only caches data on a
per-request basis.

Query Cache (***RECOMMENDED***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setQueryCacheImpl($cache);
    $config->getQueryCacheImpl();

Gets or sets the cache implementation to use for caching DQL
queries, that is, the result of a DQL parsing process that includes
the final SQL as well as meta information about how to process the
SQL result set of a query. Note that the query cache does not
affect query results. You do not get stale data. This is a pure
optimization cache without any negative side-effects (except some
minimal memory usage in your cache).

Usage of a query cache is highly recommended.

The recommended implementations for production are:


-  ``Doctrine\Common\Cache\ApcCache``
-  ``Doctrine\Common\Cache\ApcuCache``
-  ``Doctrine\Common\Cache\MemcacheCache``
-  ``Doctrine\Common\Cache\XcacheCache``
-  ``Doctrine\Common\Cache\RedisCache``

For development you should use the
``Doctrine\Common\Cache\ArrayCache`` which only caches data on a
per-request basis.

SQL Logger (***Optional***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php
    $config->setSQLLogger($logger);
    $config->getSQLLogger();

Gets or sets the logger to use for logging all SQL statements
executed by Doctrine. The logger class must implement the
``Doctrine\DBAL\Logging\SQLLogger`` interface. A simple default
implementation that logs to the standard output using ``echo`` and
``var_dump`` can be found at
``Doctrine\DBAL\Logging\EchoSQLLogger``.

Auto-generating Proxy Classes (***OPTIONAL***)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Proxy classes can either be generated manually through the Doctrine
Console or automatically at runtime by Doctrine. The configuration
option that controls this behavior is:

.. code-block:: php

    <?php
    $config->setAutoGenerateProxyClasses($mode);

Possible values for ``$mode`` are:

-  ``Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_NEVER``

Never autogenerate a proxy. You will need to generate the proxies
manually, for this use the Doctrine Console like so:

.. code-block:: php

    $ ./doctrine orm:generate-proxies

When you do this in a development environment,
be aware that you may get class/file not found errors if certain proxies
are not yet generated. You may also get failing lazy-loads if new
methods were added to the entity class that are not yet in the proxy class.
In such a case, simply use the Doctrine Console to (re)generate the
proxy classes.

-  ``Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_ALWAYS``

Always generates a new proxy in every request and writes it to disk.

-  ``Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS``

Generate the proxy class when the proxy file does not exist.
This strategy causes a file exists call whenever any proxy is
used the first time in a request.

-  ``Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_EVAL``

Generate the proxy classes and evaluate them on the fly via eval(),
avoiding writing the proxies to disk.
This strategy is only sane for development.

In a production environment, it is highly recommended to use
AUTOGENERATE_NEVER to allow for optimal performances. The other
options are interesting in development environment.

Before v2.4, ``setAutoGenerateProxyClasses`` would accept a boolean
value. This is still possible, ``FALSE`` being equivalent to
AUTOGENERATE_NEVER and ``TRUE`` to AUTOGENERATE_ALWAYS.

Development vs Production Configuration
---------------------------------------

You should code your Doctrine2 bootstrapping with two different
runtime models in mind. There are some serious benefits of using
APC or Memcache in production. In development however this will
frequently give you fatal errors, when you change your entities and
the cache still keeps the outdated metadata. That is why we
recommend the ``ArrayCache`` for development.

Furthermore you should have the Auto-generating Proxy Classes
option to true in development and to false in production. If this
option is set to ``TRUE`` it can seriously hurt your script
performance if several proxy classes are re-generated during script
execution. Filesystem calls of that magnitude can even slower than
all the database queries Doctrine issues. Additionally writing a
proxy sets an exclusive file lock which can cause serious
performance bottlenecks in systems with regular concurrent
requests.

Connection Options
------------------

The ``$connectionOptions`` passed as the first argument to
``EntityManager::create()`` has to be either an array or an
instance of ``Doctrine\DBAL\Connection``. If an array is passed it
is directly passed along to the DBAL Factory
``Doctrine\DBAL\DriverManager::getConnection()``. The DBAL
configuration is explained in the
`DBAL section <./../../../../../projects/doctrine-dbal/en/latest/reference/configuration.html>`_.

Proxy Objects
-------------

A proxy object is an object that is put in place or used instead of
the "real" object. A proxy object can add behavior to the object
being proxied without that object being aware of it. In Doctrine 2,
proxy objects are used to realize several features but mainly for
transparent lazy-loading.

Proxy objects with their lazy-loading facilities help to keep the
subset of objects that are already in memory connected to the rest
of the objects. This is an essential property as without it there
would always be fragile partial objects at the outer edges of your
object graph.

Doctrine 2 implements a variant of the proxy pattern where it
generates classes that extend your entity classes and adds
lazy-loading capabilities to them. Doctrine can then give you an
instance of such a proxy class whenever you request an object of
the class being proxied. This happens in two situations:

Reference Proxies
~~~~~~~~~~~~~~~~~

The method ``EntityManager#getReference($entityName, $identifier)``
lets you obtain a reference to an entity for which the identifier
is known, without loading that entity from the database. This is
useful, for example, as a performance enhancement, when you want to
establish an association to an entity for which you have the
identifier. You could simply do this:

.. code-block:: php

    <?php
    // $em instanceof EntityManager, $cart instanceof MyProject\Model\Cart
    // $itemId comes from somewhere, probably a request parameter
    $item = $em->getReference('MyProject\Model\Item', $itemId);
    $cart->addItem($item);

Here, we added an Item to a Cart without loading the Item from the
database. If you invoke any method on the Item instance, it would
fully initialize its state transparently from the database. Here
$item is actually an instance of the proxy class that was generated
for the Item class but your code does not need to care. In fact it
**should not care**. Proxy objects should be transparent to your
code.

Association proxies
~~~~~~~~~~~~~~~~~~~

The second most important situation where Doctrine uses proxy
objects is when querying for objects. Whenever you query for an
object that has a single-valued association to another object that
is configured LAZY, without joining that association in the same
query, Doctrine puts proxy objects in place where normally the
associated object would be. Just like other proxies it will
transparently initialize itself on first access.

.. note::

    Joining an association in a DQL or native query
    essentially means eager loading of that association in that query.
    This will override the 'fetch' option specified in the mapping for
    that association, but only for that query.


Generating Proxy classes
~~~~~~~~~~~~~~~~~~~~~~~~

In a production environment, it is highly recommended to use
``AUTOGENERATE_NEVER`` to allow for optimal performances.
However you will be required to generate the proxies manually
using the Doctrine Console:

.. code-block:: php

    $ ./doctrine orm:generate-proxies

The other options are interesting in development environment:

- ``AUTOGENERATE_ALWAYS`` will require you to create and configure
  a proxy directory. Proxies will be generated and written to file
  on each request, so any modification to your code will be acknowledged.

- ``AUTOGENERATE_FILE_NOT_EXISTS`` will not overwrite an existing
  proxy file. If your code changes, you will need to regenerate the
  proxies manually.

- ``AUTOGENERATE_EVAL`` will regenerate each proxy on each request,
  but without writing them to disk.

Autoloading Proxies
-------------------

When you deserialize proxy objects from the session or any other storage
it is necessary to have an autoloading mechanism in place for these classes.
For implementation reasons Proxy class names are not PSR-0 compliant. This
means that you have to register a special autoloader for these classes:

.. code-block:: php

    <?php
    use Doctrine\Common\Proxy\Autoloader;

    $proxyDir = "/path/to/proxies";
    $proxyNamespace = "MyProxies";

    Autoloader::register($proxyDir, $proxyNamespace);

If you want to execute additional logic to intercept the proxy file not found
state you can pass a closure as the third argument. It will be called with
the arguments proxydir, namespace and className when the proxy file could not
be found.

Multiple Metadata Sources
-------------------------

When using different components using Doctrine 2 you may end up
with them using two different metadata drivers, for example XML and
YAML. You can use the DriverChain Metadata implementations to
aggregate these drivers based on namespaces:

.. code-block:: php

    <?php
    use Doctrine\ORM\Mapping\Driver\DriverChain;

    $chain = new DriverChain();
    $chain->addDriver($xmlDriver, 'Doctrine\Tests\Models\Company');
    $chain->addDriver($yamlDriver, 'Doctrine\Tests\ORM\Mapping');

Based on the namespace of the entity the loading of entities is
delegated to the appropriate driver. The chain semantics come from
the fact that the driver loops through all namespaces and matches
the entity class name against the namespace using a
``strpos() === 0`` call. This means you need to order the drivers
correctly if sub-namespaces use different metadata driver
implementations.


Default Repository (***OPTIONAL***)
-----------------------------------

Specifies the FQCN of a subclass of the EntityRepository.
That will be available for all entities without a custom repository class.

.. code-block:: php

    <?php
    $config->setDefaultRepositoryClassName($fqcn);
    $config->getDefaultRepositoryClassName();

The default value is ``Doctrine\ORM\EntityRepository``.
Any repository class must be a subclass of EntityRepository otherwise you got an ORMException

Setting up the Console
----------------------

Doctrine uses the Symfony Console component for generating the command
line interface. You can take a look at the ``vendor/bin/doctrine.php``
script and the ``Doctrine\ORM\Tools\Console\ConsoleRunner`` command
for inspiration how to setup the cli.

In general the required code looks like this:

.. code-block:: php

    <?php
    $cli = new Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
    $cli->setCatchExceptions(true);
    $cli->setHelperSet($helperSet);
    Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);
    $cli->run();

