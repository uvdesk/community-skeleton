Doctrine Internals explained
============================

Object relational mapping is a complex topic and sufficiently understanding how Doctrine works internally helps you use its full power.

How Doctrine keeps track of Objects
-----------------------------------

Doctrine uses the Identity Map pattern to track objects. Whenever you fetch an
object from the database, Doctrine will keep a reference to this object inside
its UnitOfWork. The array holding all the entity references is two-levels deep
and has the keys "root entity name" and "id". Since Doctrine allows composite
keys the id is a sorted, serialized version of all the key columns.

This allows Doctrine room for optimizations. If you call the EntityManager and
ask for an entity with a specific ID twice, it will return the same instance:

.. code-block:: php

    public function testIdentityMap()
    {
        $objectA = $this->entityManager->find('EntityName', 1);
        $objectB = $this->entityManager->find('EntityName', 1);

        $this->assertSame($objectA, $objectB)
    }

Only one SELECT query will be fired against the database here. In the second
``EntityManager#find()`` call Doctrine will check the identity map first and
doesn't need to make that database roundtrip.

Even if you get a proxy object first then fetch the object by the same id you
will still end up with the same reference:

.. code-block:: php

    public function testIdentityMapReference()
    {
        $objectA = $this->entityManager->getReference('EntityName', 1);
        // check for proxyinterface
        $this->assertInstanceOf('Doctrine\ORM\Proxy\Proxy', $objectA);

        $objectB = $this->entityManager->find('EntityName', 1);

        $this->assertSame($objectA, $objectB)
    }

The identity map being indexed by primary keys only allows shortcuts when you
ask for objects by primary key. Assume you have the following ``persons``
table:

::

    id | name
    -------------
    1  | Benjamin
    2  | Bud

Take the following example where two
consecutive calls are made against a repository to fetch an entity by a set of
criteria:

.. code-block:: php

    public function testIdentityMapRepositoryFindBy()
    {
        $repository = $this->entityManager->getRepository('Person');
        $objectA = $repository->findOneBy(array('name' => 'Benjamin'));
        $objectB = $repository->findOneBy(array('name' => 'Benjamin'));

        $this->assertSame($objectA, $objectB);
    }

This query will still return the same references and `$objectA` and `$objectB`
are indeed referencing the same object. However when checking your SQL logs you
will realize that two queries have been executed against the database. Doctrine
only knows objects by id, so a query for different criteria has to go to the
database, even if it was executed just before.

But instead of creating a second Person object Doctrine first gets the primary
key from the row and check if it already has an object inside the UnitOfWork
with that primary key. In our example it finds an object and decides to return
this instead of creating a new one.

The identity map has a second use-case. When you call ``EntityManager#flush``
Doctrine will ask the identity map for all objects that are currently managed.
This means you don't have to call ``EntityManager#persist`` over and over again
to pass known objects to the EntityManager. This is a NO-OP for known entities,
but leads to much code written that is confusing to other developers.

The following code WILL update your database with the changes made to the
``Person`` object, even if you did not call ``EntityManager#persist``:

.. code-block:: php

    <?php
    $user = $entityManager->find("Person", 1);
    $user->setName("Guilherme");
    $entityManager->flush();

How Doctrine Detects Changes
----------------------------

Doctrine is a data-mapper that tries to achieve persistence-ignorance (PI).
This means you map php objects into a relational database that don't
necessarily know about the database at all. A natural question would now be,
"how does Doctrine even detect objects have changed?". 

For this Doctrine keeps a second map inside the UnitOfWork. Whenever you fetch
an object from the database Doctrine will keep a copy of all the properties and
associations inside the UnitOfWork. Because variables in the PHP language are
subject to "copy-on-write" the memory usage of a PHP request that only reads
objects from the database is the same as if Doctrine did not keep this variable
copy. Only if you start changing variables PHP will create new variables internally
that consume new memory.

Now whenever you call ``EntityManager#flush`` Doctrine will iterate over the
Identity Map and for each object compares the original property and association
values with the values that are currently set on the object. If changes are
detected then the object is queued for a SQL UPDATE operation. Only the fields
that actually changed are updated.

This process has an obvious performance impact. The larger the size of the
UnitOfWork is, the longer this computation takes. There are several ways to
optimize the performance of the Flush Operation:

- Mark entities as read only. These entities can only be inserted or removed,
  but are never updated. They are omitted in the changeset calculation.
- Temporarily mark entities as read only. If you have a very large UnitOfWork
  but know that a large set of entities has not changed, just mark them as read
  only with ``$entityManager->getUnitOfWork()->markReadOnly($entity)``.
- Flush only a single entity with ``$entityManager->flush($entity)``.
- Use :doc:`Change Tracking Policies <change-tracking-policies>` to use more
  explicit strategies of notifying the UnitOfWork what objects/properties
  changed.


Query Internals
---------------

The different ORM Layers
------------------------

Doctrine ships with a set of layers with different responsibilities. This
section gives a short explanation of each layer.

Hydration
~~~~~~~~~

Responsible for creating a final result from a raw database statement and a
result-set mapping object. The developer can choose which kind of result he
wishes to be hydrated. Default result-types include:

- SQL to Entities
- SQL to structured Arrays
- SQL to simple scalar result arrays
- SQL to a single result variable

Hydration to entities and arrays is one of most complex parts of Doctrine
algorithm-wise. It can build results with for example:

- Single table selects
- Joins with n:1 or 1:n cardinality, grouping belonging to the same parent.
- Mixed results of objects and scalar values
- Hydration of results by a given scalar value as key.

Persisters
~~~~~~~~~~

tbr

UnitOfWork
~~~~~~~~~~

tbr

ResultSetMapping
~~~~~~~~~~~~~~~~

tbr

DQL Parser
~~~~~~~~~~

tbr

SQLWalker
~~~~~~~~~

tbr

EntityManager
~~~~~~~~~~~~~

tbr

ClassMetadataFactory
~~~~~~~~~~~~~~~~~~~~

tbr

