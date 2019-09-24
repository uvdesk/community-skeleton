Caching
=======

Doctrine provides cache drivers in the ``Common`` package for some
of the most popular caching implementations such as APC, Memcache
and Xcache. We also provide an ``ArrayCache`` driver which stores
the data in a PHP array. Obviously, when using ``ArrayCache``, the 
cache does not persist between requests, but this is useful for 
testing in a development environment.

Cache Drivers
-------------

The cache drivers follow a simple interface that is defined in
``Doctrine\Common\Cache\Cache``. All the cache drivers extend a
base class ``Doctrine\Common\Cache\CacheProvider`` which implements
this interface.

The interface defines the following public methods for you to implement:


-  fetch($id) - Fetches an entry from the cache
-  contains($id) - Test if an entry exists in the cache
-  save($id, $data, $lifeTime = false) - Puts data into the cache for x seconds. 0 = infinite time
-  delete($id) - Deletes a cache entry

Each driver extends the ``CacheProvider`` class which defines a few
abstract protected methods that each of the drivers must
implement:


-  \_doFetch($id)
-  \_doContains($id)
-  \_doSave($id, $data, $lifeTime = false)
-  \_doDelete($id)

The public methods ``fetch()``, ``contains()`` etc. use the
above protected methods which are implemented by the drivers. The
code is organized this way so that the protected methods in the
drivers do the raw interaction with the cache implementation and
the ``CacheProvider`` can build custom functionality on top of
these methods.

This documentation does not cover every single cache driver included
with Doctrine. For an up-to-date-list, see the
`cache directory on GitHub <https://github.com/doctrine/cache/tree/master/lib/Doctrine/Common/Cache>`.

APC
~~~

In order to use the APC cache driver you must have it compiled and
enabled in your php.ini. You can read about APC
`in the PHP Documentation <http://us2.php.net/apc>`_. It will give
you a little background information about what it is and how you
can use it as well as how to install it.

Below is a simple example of how you could use the APC cache driver
by itself.

.. code-block:: php

    <?php
    $cacheDriver = new \Doctrine\Common\Cache\ApcCache();
    $cacheDriver->save('cache_id', 'my_data');

APCu
~~~~

In order to use the APCu cache driver you must have it compiled and
enabled in your php.ini. You can read about APCu
`in the PHP Documentation <http://us2.php.net/apcu>`_. It will give
you a little background information about what it is and how you
can use it as well as how to install it.

Below is a simple example of how you could use the APCu cache driver
by itself.

.. code-block:: php

    <?php
    $cacheDriver = new \Doctrine\Common\Cache\ApcuCache();
    $cacheDriver->save('cache_id', 'my_data');

Memcache
~~~~~~~~

In order to use the Memcache cache driver you must have it compiled
and enabled in your php.ini. You can read about Memcache
`on the PHP website <http://php.net/memcache>`_. It will
give you a little background information about what it is and how
you can use it as well as how to install it.

Below is a simple example of how you could use the Memcache cache
driver by itself.

.. code-block:: php

    <?php
    $memcache = new Memcache();
    $memcache->connect('memcache_host', 11211);
    
    $cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
    $cacheDriver->setMemcache($memcache);
    $cacheDriver->save('cache_id', 'my_data');

Memcached
~~~~~~~~~

Memcached is a more recent and complete alternative extension to
Memcache.

In order to use the Memcached cache driver you must have it compiled
and enabled in your php.ini. You can read about Memcached
`on the PHP website <http://php.net/memcached>`_. It will
give you a little background information about what it is and how
you can use it as well as how to install it.

Below is a simple example of how you could use the Memcached cache
driver by itself.

.. code-block:: php

    <?php
    $memcached = new Memcached();
    $memcached->addServer('memcache_host', 11211);
    
    $cacheDriver = new \Doctrine\Common\Cache\MemcachedCache();
    $cacheDriver->setMemcached($memcached);
    $cacheDriver->save('cache_id', 'my_data');

Xcache
~~~~~~

In order to use the Xcache cache driver you must have it compiled
and enabled in your php.ini. You can read about Xcache
`here <http://xcache.lighttpd.net/>`_. It will give you a little
background information about what it is and how you can use it as
well as how to install it.

Below is a simple example of how you could use the Xcache cache
driver by itself.

.. code-block:: php

    <?php
    $cacheDriver = new \Doctrine\Common\Cache\XcacheCache();
    $cacheDriver->save('cache_id', 'my_data');

Redis
~~~~~

In order to use the Redis cache driver you must have it compiled
and enabled in your php.ini. You can read about what Redis is
`from here <http://redis.io/>`_. Also check
`A PHP extension for Redis <https://github.com/nicolasff/phpredis/>`_ for how you can use
and install the Redis PHP extension.

Below is a simple example of how you could use the Redis cache
driver by itself.

.. code-block:: php

    <?php
    $redis = new Redis();
    $redis->connect('redis_host', 6379);

    $cacheDriver = new \Doctrine\Common\Cache\RedisCache();
    $cacheDriver->setRedis($redis);
    $cacheDriver->save('cache_id', 'my_data');

Using Cache Drivers
-------------------

In this section we'll describe how you can fully utilize the API of
the cache drivers to save data to a cache, check if some cached data 
exists, fetch the cached data and delete the cached data. We'll use the
``ArrayCache`` implementation as our example here.

.. code-block:: php

    <?php
    $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();

Saving
~~~~~~

Saving some data to the cache driver is as simple as using the
``save()`` method.

.. code-block:: php

    <?php
    $cacheDriver->save('cache_id', 'my_data');

The ``save()`` method accepts three arguments which are described
below:


-  ``$id`` - The cache id
-  ``$data`` - The cache entry/data.
-  ``$lifeTime`` - The lifetime. If != false, sets a specific
   lifetime for this cache entry (null => infinite lifeTime).

You can save any type of data whether it be a string, array,
object, etc.

.. code-block:: php

    <?php
    $array = array(
        'key1' => 'value1',
        'key2' => 'value2'
    );
    $cacheDriver->save('my_array', $array);

Checking
~~~~~~~~

Checking whether cached data exists is very simple: just use the
``contains()`` method. It accepts a single argument which is the ID
of the cache entry.

.. code-block:: php

    <?php
    if ($cacheDriver->contains('cache_id')) {
        echo 'cache exists';
    } else {
        echo 'cache does not exist';
    }

Fetching
~~~~~~~~

Now if you want to retrieve some cache entry you can use the
``fetch()`` method. It also accepts a single argument just like
``contains()`` which is again the ID of the cache entry.

.. code-block:: php

    <?php
    $array = $cacheDriver->fetch('my_array');

Deleting
~~~~~~~~

As you might guess, deleting is just as easy as saving, checking
and fetching. You can delete by an individual ID, or you can 
delete all entries.

By Cache ID
^^^^^^^^^^^

.. code-block:: php

    <?php
    $cacheDriver->delete('my_array');

All
^^^

If you simply want to delete all cache entries you can do so with
the ``deleteAll()`` method.

.. code-block:: php

    <?php
    $deleted = $cacheDriver->deleteAll();

Namespaces
~~~~~~~~~~

If you heavily use caching in your application and use it in
multiple parts of your application, or use it in different
applications on the same server you may have issues with cache
naming collisions. This can be worked around by using namespaces.
You can set the namespace a cache driver should use by using the
``setNamespace()`` method.

.. code-block:: php

    <?php
    $cacheDriver->setNamespace('my_namespace_');

Integrating with the ORM
------------------------

The Doctrine ORM package is tightly integrated with the cache
drivers to allow you to improve the performance of various aspects of
Doctrine by simply making some additional configurations and
method calls.

Query Cache
~~~~~~~~~~~

It is highly recommended that in a production environment you cache
the transformation of a DQL query to its SQL counterpart. It
doesn't make sense to do this parsing multiple times as it doesn't
change unless you alter the DQL query.

This can be done by configuring the query cache implementation to
use on your ORM configuration.

.. code-block:: php

    <?php
    $config = new \Doctrine\ORM\Configuration();
    $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcuCache());

Result Cache
~~~~~~~~~~~~

The result cache can be used to cache the results of your queries
so that we don't have to query the database or hydrate the data
again after the first time. You just need to configure the result
cache implementation.

.. code-block:: php

    <?php
    $config->setResultCacheImpl(new \Doctrine\Common\Cache\ApcuCache());

Now when you're executing DQL queries you can configure them to use
the result cache.

.. code-block:: php

    <?php
    $query = $em->createQuery('select u from \Entities\User u');
    $query->useResultCache(true);

You can also configure an individual query to use a different
result cache driver.

.. code-block:: php

    <?php
    $query->setResultCacheDriver(new \Doctrine\Common\Cache\ApcuCache());

.. note::

    Setting the result cache driver on the query will
    automatically enable the result cache for the query. If you want to
    disable it pass false to ``useResultCache()``.

    ::

        <?php
        $query->useResultCache(false);


If you want to set the time the cache has to live you can use the
``setResultCacheLifetime()`` method.

.. code-block:: php

    <?php
    $query->setResultCacheLifetime(3600);

The ID used to store the result set cache is a hash which is
automatically generated for you if you don't set a custom ID
yourself with the ``setResultCacheId()`` method.

.. code-block:: php

    <?php
    $query->setResultCacheId('my_custom_id');

You can also set the lifetime and cache ID by passing the values as
the second and third argument to ``useResultCache()``.

.. code-block:: php

    <?php
    $query->useResultCache(true, 3600, 'my_custom_id');

Metadata Cache
~~~~~~~~~~~~~~

Your class metadata can be parsed from a few different sources like
YAML, XML, Annotations, etc. Instead of parsing this information on
each request we should cache it using one of the cache drivers.

Just like the query and result cache we need to configure it
first.

.. code-block:: php

    <?php
    $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcuCache());

Now the metadata information will only be parsed once and stored in
the cache driver.

Clearing the Cache
------------------

We've already shown you how you can use the API of the
cache drivers to manually delete cache entries. For your
convenience we offer command line tasks to help you with
clearing the query, result and metadata cache.

From the Doctrine command line you can run the following commands:

To clear the query cache use the ``orm:clear-cache:query`` task.

.. code-block:: php

    $ ./doctrine orm:clear-cache:query

To clear the metadata cache use the ``orm:clear-cache:metadata`` task.

.. code-block:: php

    $ ./doctrine orm:clear-cache:metadata

To clear the result cache use the ``orm:clear-cache:result`` task.

.. code-block:: php

    $ ./doctrine orm:clear-cache:result

All these tasks accept a ``--flush`` option to flush the entire
contents of the cache instead of invalidating the entries.

Cache Chaining
--------------

A common pattern is to use a static cache to store data that is
requested many times in a single PHP request. Even though this data
may be stored in a fast memory cache, often that cache is over a
network link leading to sizable network traffic.

The ChainCache class allows multiple caches to be registered at once.
For example, a per-request ArrayCache can be used first, followed by
a (relatively) slower MemcacheCache if the ArrayCache misses.
ChainCache automatically handles pushing data up to faster caches in
the chain and clearing data in the entire stack when it is deleted.

A ChainCache takes a simple array of CacheProviders in the order that
they should be used.

.. code-block:: php

    $arrayCache = new \Doctrine\Common\Cache\ArrayCache();
    $memcache = new Memcache();
    $memcache->connect('memcache_host', 11211);
    $chainCache = new \Doctrine\Common\Cache\ChainCache([
        $arrayCache,
        $memcache,
    ]);

ChainCache itself extends the CacheProvider interface, so it is
possible to create chains of chains. While this may seem like an easy
way to build a simple high-availability cache, ChainCache does not
implement any exception handling so using it as a high-availability
mechanism is not recommended.

Cache Slams
-----------

Something to be careful of when using the cache drivers is
"cache slams". Imagine you have a heavily trafficked website with some
code that checks for the existence of a cache record and if it does
not exist it generates the information and saves it to the cache.
Now, if 100 requests were issued all at the same time and each one
sees the cache does not exist and they all try to insert the same
cache entry it could lock up APC, Xcache, etc. and cause problems.
Ways exist to work around this, like pre-populating your cache and
not letting your users' requests populate the cache.

You can read more about cache slams
`in this blog post <http://notmysock.org/blog/php/user-cache-timebomb.html>`_.


