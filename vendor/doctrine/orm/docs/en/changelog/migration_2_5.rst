What is new in Doctrine ORM 2.5?
================================

This document describes changes between Doctrine ORM 2.4 and 2.5.
It contains a description of all the new features and sections about
behavioral changes and potential backwards compatibility breaks.
Please review this document carefully when updating to Doctrine 2.5.

First note, that with the ORM 2.5 release we are dropping support
for PHP 5.3. We are enforcing this with Composer, servers without
at least PHP 5.4 will not allow installing Doctrine 2.5.

New Features and Improvements
-----------------------------

Events: PostLoad now triggered after associations are loaded
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Before Doctrine 2.5 if you had an entity with a ``@PostLoad`` event
defined then Doctrine would trigger listeners after the fields were
loaded, but before assocations are available.

- `DDC-54 <http://doctrine-project.org/jira/browse/DDC-54>`_
- `Commit #a90629 <https://github.com/doctrine/doctrine2/commit/a906295c65f1516737458fbee2f6fa96254f27a5>`_

Events: Add API to programatically add event listeners to Entity
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When developing third party libraries or decoupled applications
it can be interesting to develop an entity listener without knowing
the entities that require this listener.

You can now attach entity listeners to entities using the
``AttachEntityListenersListener`` class, which is listening to the
``loadMetadata`` event that is fired once for every entity during
metadata generation:

.. code-block:: php

    <?php
    use Doctrine\ORM\Tools\AttachEntityListenersListener;
    use Doctrine\ORM\Events;

    $listener = new AttachEntityListenersListener();
    $listener->addEntityListener(
        'MyProject\Entity\User', 'MyProject\Listener\TimestampableListener',
        Events::prePersist, 'onPrePersist'
    );

    $evm->addEventListener(Events::loadClassMetadata, $listener);

    class TimestampableListener
    {
        public function onPrePersist($event)
        {
            $entity = $event->getEntity();
            $entity->setCreated(new \DateTime('now'));
        }
    }

Embeddable Objects
~~~~~~~~~~~~~~~~~~

Doctrine now supports creating multiple PHP objects from one database table
implementing a feature called "Embeddable Objects". Next to an ``@Entity``
class you can now define a class that is embeddable into a database table of an
entity using the ``@Embeddable`` annotation. Embeddable objects can never be
saved, updated or deleted on their own, only as part of an entity (called
"root-entity" or "aggregate"). Consequently embeddables don't have a primary
key, they are identified only by their values.

Example of defining and using embeddables classes:

.. code-block:: php

    <?php

    /** @Entity */
    class Product
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        private $id;

        /** @Embedded(class = "Money") */
        private $price;
    }

    /** @Embeddable */
    class Money
    {
        /** @Column(type = "decimal") */
        private $value;

        /** @Column(type = "string") */
        private $currency = 'EUR';
    }

You can read more on the features of Embeddables objects `in the documentation
<http://docs.doctrine-project.org/en/latest/tutorials/embeddables.html>`_.

This feature was developed by external contributor `Johannes Schmitt
<https://twitter.com/schmittjoh>`_

- `DDC-93 <http://doctrine-project.org/jira/browse/DDC-93>`_
- `Pull Request #835 <https://github.com/doctrine/doctrine2/pull/835>`_

Second-Level-Cache
~~~~~~~~~~~~~~~~~~

Since version 2.0 of Doctrine, fetching the same object twice by primary key
would result in just one query. This was achieved by the identity map pattern
(first-level-cache) that kept entities in memory. 

The newly introduced second-level-cache works a bit differently. Instead
of saving objects in memory, it saves them in a fast in-memory cache such
as Memcache, Redis, Riak or MongoDB. Additionally it allows saving the result
of more complex queries than by primary key. Summarized this feature works
like the existing Query result cache, but it is much more powerful.

As an example lets cache an entity Country that is a relation to the User
entity. We always want to display the country, but avoid the additional
query to this table.

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Cache(usage="READ_ONLY", region="country_region")
     */
    class Country
    {
        /**
         * @Id
         * @GeneratedValue
         * @Column(type="integer")
         */
        protected $id;

        /**
         * @Column(unique=true)
         */
        protected $name;
    }

In this example we have specified a caching region name called
``country_region``, which we have to configure now on the EntityManager:

.. code-block:: php

    $config = new \Doctrine\ORM\Configuration();
    $config->setSecondLevelCacheEnabled();

    $cacheConfig  =  $config->getSecondLevelCacheConfiguration();
    $regionConfig =  $cacheConfig->getRegionsConfiguration();
    $regionConfig->setLifetime('country_region', 3600); 

Now Doctrine will first check for the data of any country in the cache
instead of the database.

- `Documentation
  <http://docs.doctrine-project.org/en/latest/reference/second-level-cache.html>`_
- `Pull Request #808 <https://github.com/doctrine/doctrine2/pull/808>`_

Criteria API: Support for ManyToMany assocations
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

We introduced support for querying collections using the `Criteria API
<http://docs.doctrine-project.org/en/latest/reference/working-with-associations.html#filtering-collections>`_
in 2.4. This only worked efficently for One-To-Many assocations, not for
Many-To-Many. With the start of 2.5 also Many-To-Many associations get queried
instead of loading them into memory.

Criteria API: Add new contains() expression
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is now possible to use the Criteria API to check for string contains needle
using ``contains()``. This translates to using a ``column LIKE '%needle%'`` SQL
condition.

.. code-block:: php

    <?php
    use \Doctrine\Common\Collections\Criteria;

    $criteria = Criteria::create()
        ->where(Criteria::expr()->contains('name', 'Benjamin'));

    $users = $repository->matching($criteria);

Criteria API: Support for EXTRA_LAZY
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A collection that is marked as ``fetch="EXTRA_LAZY"`` will now return another
lazy collection when using ``Collection::matching($criteria)``:

.. code-block:: php

    <?php

    class Post
    {
        /** @OneToMany(targetEntity="Comment", fetch="EXTRA_LAZY") */
        private $comments;
    }

    $criteria = Criteria::create()
        ->where(Criteria->expr()->eq("published", 1));

    $publishedComments = $post->getComments()->matching($criteria);

    echo count($publishedComments);

The lazy criteria currently supports the ``count()`` and ``contains()``
functionality lazily. All other operations of the ``Collection`` interface
trigger a full load of the collection.

This feature was contributed by `Michaël Gallego <https://github.com/bakura10>`_.

- `Pull Request #882 <https://github.com/doctrine/doctrine2/pull/882>`_
- `Pull Request #1032 <https://github.com/doctrine/doctrine2/pull/1032>`_

Mapping: Allow configuring Index flags
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is now possible to control the index flags in the DBAL
schema abstraction from the ORM using metadata. This was possible
only with a schema event listener before.

.. code-block:: php

    <?php

    /**
     * @Table(name="product", indexes={@Index(columns={"description"},flags={"fulltext"})})
     */
    class Product
    {
        private $description;
    }

This feature was contributed by `Adrian Olek <https://github.com/adrianolek>`_.

- `Pull Request #973 <https://github.com/doctrine/doctrine2/pull/973>`_

SQLFilter API: Check if a parameter is set
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can now check in your SQLFilter if a parameter was set. This allows
to more easily control which features of a filter to enable or disable.

Extending on the locale example of the documentation:

.. code-block:: php

    <?php
    class MyLocaleFilter extends SQLFilter
    {
        public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
        {
            if (!$targetEntity->reflClass->implementsInterface('LocaleAware')) {
                return "";
            }

            if (!$this->hasParameter('locale')) {
                return "";
            }

            return $targetTableAlias.'.locale = ' . $this->getParameter('locale');
        }
    }

This feature was contributed by `Miroslav Demovic <https://github.com/mdemo>`_

- `Pull Request #963 <https://github.com/doctrine/doctrine2/pull/963>`_


EXTRA_LAZY Improvements
~~~~~~~~~~~~~~~~~~~~~~~

1. Efficient query when using EXTRA_LAZY and containsKey

    When calling ``Collection::containsKey($key)`` on one-to-many and many-to-many
    collections using ``indexBy`` and ``EXTRA_LAZY`` a query is now executed to check
    for the existance for the item. Prevoiusly this operation was performed in memory
    by loading all entities of the collection.

    .. code-block:: php

        <?php

        class User
        {
            /** @OneToMany(targetEntity="Group", indexBy="id") */
            private $groups;
        }

        if ($user->getGroups()->containsKey($groupId)) {
            echo "User is in group $groupId\n";
        }

    This feature was contributed by `Asmir Mustafic <https://github.com/goetas>`_

    - `Pull Request #937 <https://github.com/doctrine/doctrine2/pull/937>`_

2. Add EXTRA_LAZY Support for get() for owning and inverse many-to-many 

   This was contributed by `Sander Marechal <https://github.com/sandermarechal>`_.

Improve efficiency of One-To-Many EAGER
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When marking a one-to-many association with ``fetch="EAGER"`` it will now
execute one query less than before and work correctly in combination with
``indexBy``.

Better support for EntityManagerInterface
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Many of the locations where previously only the ``Doctrine\ORM\EntityManager``
was allowed are now changed to accept the ``EntityManagerInterface`` that was
introduced in 2.4. This allows you to more easily use the decorator pattern
to extend the EntityManager if you need. It's still not replaced everywhere,
so you still have to be careful.

DQL Improvements
~~~~~~~~~~~~~~~~

1. It is now possible to add functions to the ``ORDER BY`` clause in DQL statements:

.. code-block:: php

    <?php
    $dql = "SELECT u FROM User u ORDER BY CONCAT(u.username, u.name)";

2. Support for functions in ``IS NULL`` expressions:

.. code-block:: php

    <?php
    $dql = "SELECT u.name FROM User u WHERE MAX(u.name) IS NULL";

3. A ``LIKE`` expression is now suported in ``HAVING`` clause.

4. Subselects are now supported inside a ``NEW()`` expression:

.. code-block:: php

    <?php
    $dql = "SELECT new UserDTO(u.name, SELECT count(g.id) FROM Group g WHERE g.id = u.id) FROM User u";

5. ``MEMBER OF`` expression now allows to filter for more than one result:

.. code-block:: php

   <?php
   $dql = "SELECT u FROM User u WHERE :groups MEMBER OF u.groups";
   $query = $entityManager->createQuery($dql);
   $query->setParameter('groups', array(1, 2, 3));

   $users = $query->getResult();

6. Expressions inside ``COUNT()`` now allowed

.. code-block:: php

    <?php
    $dql = "SELECT COUNT(DISTINCT CONCAT(u.name, u.lastname)) FROM User u";

7. Add support for ``HOUR`` in ``DATE_ADD()``/``DATE_SUB()`` functions

Custom DQL Functions: Add support for factories
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Previously custom DQL functions could only be provided with their
full-qualified class-name, preventing runtime configuration through
dependency injection.

A simplistic approach has been contributed by `Matthieu Napoli
<https://github.com/mnapoli>`_ to pass a callback instead that resolves
the function:

.. code-block:: php

    <?php

    $config = new \Doctrine\ORM\Configuration();

    $config->addCustomNumericFunction(
        'IS_PUBLISHED', function($funcName) use ($currentSiteId) {
            return new IsPublishedFunction($currentSiteId);
         }
    );

Query API: WHERE IN Query using a Collection as parameter
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When performing a ``WHERE IN`` query for a collection of entities you can
now pass the array collection of entities as a parameter value to the query
object:

.. code-block:: php

    <?php

    $categories = $rootCategory->getChildren();

    $queryBuilder
        ->select('p')
        ->from('Product', 'p')
        ->where('p.category IN (:categories)')
        ->setParameter('categories', $categories)
    ;

This feature was contributed by `Michael Perrin
<https://github.com/michaelperrin>`_.

- `Pull Request #590 <https://github.com/doctrine/doctrine2/pull/590>`_
- `DDC-2319 <http://doctrine-project.org/jira/browse/DDC-2319>`_

Query API: Add support for default Query Hints
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To configure multiple different features such as custom AST Walker, fetch modes,
locking and other features affecting DQL generation we have had a feature
called "query hints" since version 2.0. 

It is now possible to add query hints that are always enabled for every Query:

.. code-block:: php

    <?php

    $config = new \Doctrine\ORM\Configuration();
    $config->setDefaultQueryHints(
        'doctrine.customOutputWalker' => 'MyProject\CustomOutputWalker'
    );

This feature was contributed by `Artur Eshenbrener
<https://github.com/Strate>`_.

- `Pull Request #863 <https://github.com/doctrine/doctrine2/pull/863>`_

ResultSetMappingBuilder: Add support for Single-Table Inheritance
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Before 2.5 the ResultSetMappingBuilder did not work with entities
that are using Single-Table-Inheritance. This restriction was lifted
by adding the missing support.

YAML Mapping: Many-To-Many doesnt require join column definition
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In Annotations and XML it was not necessary using conventions for naming
the many-to-many join column names, in YAML it was not possible however.

A many-to-many definition in YAML is now possible using this minimal
definition:

.. code-block:: yaml

    manyToMany:
        groups:
            targetEntity: Group
            joinTable:
                name: users_groups

Schema Validator Command: Allow to skip sub-checks
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The Schema Validator command executes two independent checks
for validity of the mappings and if the schema is synchronized
correctly. It is now possible to skip any of the two steps
when executing the command:

::

    $ php vendor/bin/doctrine orm:validate-schema --skip-mapping
    $ php vendor/bin/doctrine orm:validate-schema --skip-sync

This allows you to write more specialized continuous integration and automation
checks. When no changes are found the command returns the exit code 0
and 1, 2 or 3 when failing because of mapping, sync or both.

EntityGenerator Command: Avoid backups
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When calling the EntityGenerator for an existing entity, Doctrine would
create a backup file every time to avoid losing changes to the code. You
can now skip generating the backup file by passing the ``--no-backup``
flag:

::

    $ php vendor/bin/doctrine orm:generate-entities src/ --no-backup

Support for Objects as Identifiers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is now possible to use Objects as identifiers for Entities
as long as they implement the magic method ``__toString()``.

.. code-block:: php

    <?php

    class UserId
    {
        private $value;

        public function __construct($value)
        {
            $this->value = $value;
        }

        public function __toString()
        {
            return (string)$this->value;
        }
    }

    class User
    {
        /** @Id @Column(type="userid") */
        private $id;

        public function __construct(UserId $id)
        {
            $this->id = $id;
        }
    }

    class UserIdType extends \Doctrine\DBAL\Types\Type
    {
        // ...
    }

    Doctrine\DBAL\Types\Type::addType('userid', 'MyProject\UserIdType');

Behavioral Changes (BC Breaks)
------------------------------

NamingStrategy interface changed
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The ``Doctrine\ORM\Mapping\NamingStrategyInterface`` changed slightly
to pass the Class Name of the entity into the join column name generation:

:: 

    -    function joinColumnName($propertyName);
    +    function joinColumnName($propertyName, $className = null);

It also received a new method for supporting embeddables:

::

    public function embeddedFieldToColumnName($propertyName, $embeddedColumnName);

Minor BC BREAK: EntityManagerInterface instead of EntityManager in type-hints
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 
As of 2.5, classes requiring the ``EntityManager`` in any method signature will now require 
an ``EntityManagerInterface`` instead.
If you are extending any of the following classes, then you need to check following
signatures:

- ``Doctrine\ORM\Tools\DebugUnitOfWorkListener#dumpIdentityMap(EntityManagerInterface $em)``
- ``Doctrine\ORM\Mapping\ClassMetadataFactory#setEntityManager(EntityManagerInterface $em)``

Minor BC BREAK: Custom Hydrators API change
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

As of 2.5, ``AbstractHydrator`` does not enforce the usage of cache as part of
API, and now provides you a clean API for column information through the method
``hydrateColumnInfo($column)``.
Cache variable being passed around by reference is no longer needed since
Hydrators are per query instantiated since Doctrine 2.4.

- `DDC-3060 <http://doctrine-project.org/jira/browse/DDC-3060>`_

Minor BC BREAK: All non-transient classes in an inheritance must be part of the inheritance map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

As of 2.5, classes, if you define an inheritance map for an inheritance tree, you are required
to map all non-transient classes in that inheritance, including the root of the inheritance.

So far, the root of the inheritance was allowed to be skipped in the inheritance map: this is
not possible anymore, and if you don't plan to persist instances of that class, then you should
either:

- make that class as ``abstract``
- add that class to your inheritance map

If you fail to do so, then a ``Doctrine\ORM\Mapping\MappingException`` will be thrown.


- `DDC-3300 <http://doctrine-project.org/jira/browse/DDC-3300>`_
- `DDC-3503 <http://doctrine-project.org/jira/browse/DDC-3503>`_

Minor BC BREAK: Entity based EntityManager#clear() calls follow cascade detach
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Whenever ``EntityManager#clear()`` method gets called with a given entity class
name, until 2.4, it was only detaching the specific requested entity.
As of 2.5, ``EntityManager`` will follow configured cascades, providing a better
memory management since associations will be garbage collected, optimizing
resources consumption on long running jobs.

Updates on entities scheduled for deletion are no longer processed
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In Doctrine 2.4, if you modified properties of an entity scheduled for deletion, UnitOfWork would
produce an ``UPDATE`` statement to be executed right before the ``DELETE`` statement. The entity in question
was therefore present in ``UnitOfWork#entityUpdates``, which means that ``preUpdate`` and ``postUpdate``
listeners were (quite pointlessly) called. In ``preFlush`` listeners, it used to be possible to undo
the scheduled deletion for updated entities (by calling ``persist()`` if the entity was found in both
``entityUpdates`` and ``entityDeletions``). This does not work any longer, because the entire changeset
calculation logic is optimized away.

Minor BC BREAK: Default lock mode changed from LockMode::NONE to null in method signatures
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A misconception concerning default lock mode values in method signatures lead to unexpected behaviour
in SQL statements on SQL Server. With a default lock mode of ``LockMode::NONE`` throughout the
method signatures in ORM, the table lock hint ``WITH (NOLOCK)`` was appended to all locking related
queries by default. This could result in unpredictable results because an explicit ``WITH (NOLOCK)``
table hint tells SQL Server to run a specific query in transaction isolation level READ UNCOMMITTED
instead of the default READ COMMITTED transaction isolation level.
Therefore there now is a distinction between ``LockMode::NONE`` and ``null`` to be able to tell
Doctrine whether to add table lock hints to queries by intention or not. To achieve this, the following
method signatures have been changed to declare ``$lockMode = null`` instead of ``$lockMode = LockMode::NONE``:

- ``Doctrine\ORM\Cache\Persister\AbstractEntityPersister#getSelectSQL()``
- ``Doctrine\ORM\Cache\Persister\AbstractEntityPersister#load()``
- ``Doctrine\ORM\Cache\Persister\AbstractEntityPersister#refresh()``
- ``Doctrine\ORM\Decorator\EntityManagerDecorator#find()``
- ``Doctrine\ORM\EntityManager#find()``
- ``Doctrine\ORM\EntityRepository#find()``
- ``Doctrine\ORM\Persisters\BasicEntityPersister#getSelectSQL()``
- ``Doctrine\ORM\Persisters\BasicEntityPersister#load()``
- ``Doctrine\ORM\Persisters\BasicEntityPersister#refresh()``
- ``Doctrine\ORM\Persisters\EntityPersister#getSelectSQL()``
- ``Doctrine\ORM\Persisters\EntityPersister#load()``
- ``Doctrine\ORM\Persisters\EntityPersister#refresh()``
- ``Doctrine\ORM\Persisters\JoinedSubclassPersister#getSelectSQL()``

You should update signatures for these methods if you have subclassed one of the above classes.
Please also check the calling code of these methods in your application and update if necessary.

.. note::

    This in fact is really a minor BC BREAK and should not have any affect on database vendors
    other than SQL Server because it is the only one that supports and therefore cares about
    ``LockMode::NONE``. It's really just a FIX for SQL Server environments using ORM.

Minor BC BREAK: __clone method not called anymore when entities are instantiated via metadata API
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

As of PHP 5.6, instantiation of new entities is deferred to the
`doctrine/instantiator <https://github.com/doctrine/instantiator>`_ library, which will avoid calling ``__clone``
or any public API on instantiated objects.

BC BREAK: DefaultRepositoryFactory is now final
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Please implement the ``Doctrine\ORM\Repository\RepositoryFactory`` interface instead of extending
the ``Doctrine\ORM\Repository\DefaultRepositoryFactory``.

BC BREAK: New object expression DQL queries now respects user provided aliasing and not return consumed fields
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When executing DQL queries with new object expressions, instead of returning
DTOs numerically indexes, it will now respect user provided aliases. Consider
the following query:

::

    SELECT new UserDTO(u.id,u.name) as user,new AddressDTO(a.street,a.postalCode) as address, a.id as addressId
    FROM User u INNER JOIN u.addresses a WITH a.isPrimary = true
    
Previously, your result would be similar to this:

::

    array(
        0=>array(
            0=>{UserDTO object},
            1=>{AddressDTO object},
            2=>{u.id scalar},
            3=>{u.name scalar},
            4=>{a.street scalar},
            5=>{a.postalCode scalar},
            'addressId'=>{a.id scalar},
        ),
        ...
    )

From now on, the resultset will look like this:

::

    array(
        0=>array(
            'user'=>{UserDTO object},
            'address'=>{AddressDTO object},
            'addressId'=>{a.id scalar}
        ),
        ...
    )

