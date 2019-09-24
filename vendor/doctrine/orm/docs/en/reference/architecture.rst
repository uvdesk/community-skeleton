Architecture
============

This chapter gives an overview of the overall architecture,
terminology and constraints of Doctrine 2. It is recommended to
read this chapter carefully.

Using an Object-Relational Mapper
---------------------------------

As the term ORM already hints at, Doctrine 2 aims to simplify the
translation between database rows and the PHP object model. The
primary use case for Doctrine are therefore applications that
utilize the Object-Oriented Programming Paradigm. For applications
that do not primarily work with objects Doctrine 2 is not suited very
well.

Requirements
------------

Doctrine 2 requires a minimum of PHP 5.4. For greatly improved
performance it is also recommended that you use APC with PHP.

Doctrine 2 Packages
-------------------

Doctrine 2 is divided into three main packages.

-  Common
-  DBAL (includes Common)
-  ORM (includes DBAL+Common)

This manual mainly covers the ORM package, sometimes touching parts
of the underlying DBAL and Common packages. The Doctrine code base
is split in to these packages for a few reasons and they are to...


-  ...make things more maintainable and decoupled
-  ...allow you to use the code in Doctrine Common without the ORM
   or DBAL
-  ...allow you to use the DBAL without the ORM

The Common Package
~~~~~~~~~~~~~~~~~~

The Common package contains highly reusable components that have no
dependencies beyond the package itself (and PHP, of course). The
root namespace of the Common package is ``Doctrine\Common``.

The DBAL Package
~~~~~~~~~~~~~~~~

The DBAL package contains an enhanced database abstraction layer on
top of PDO but is not strongly bound to PDO. The purpose of this
layer is to provide a single API that bridges most of the
differences between the different RDBMS vendors. The root namespace
of the DBAL package is ``Doctrine\DBAL``.

The ORM Package
~~~~~~~~~~~~~~~

The ORM package contains the object-relational mapping toolkit that
provides transparent relational persistence for plain PHP objects.
The root namespace of the ORM package is ``Doctrine\ORM``.

Terminology
-----------

Entities
~~~~~~~~

An entity is a lightweight, persistent domain object. An entity can
be any regular PHP class observing the following restrictions:


-  An entity class must not be final or contain final methods.
-  All persistent properties/field of any entity class should
   always be private or protected, otherwise lazy-loading might not
   work as expected. In case you serialize entities (for example Session)
   properties should be protected (See Serialize section below).
-  An entity class must not implement ``__clone`` or
   :doc:`do so safely <../cookbook/implementing-wakeup-or-clone>`.
-  An entity class must not implement ``__wakeup`` or
   :doc:`do so safely <../cookbook/implementing-wakeup-or-clone>`.
   Also consider implementing
   `Serializable <http://php.net/manual/en/class.serializable.php>`_
   instead.
-  Any two entity classes in a class hierarchy that inherit
   directly or indirectly from one another must not have a mapped
   property with the same name. That is, if B inherits from A then B
   must not have a mapped field with the same name as an already
   mapped field that is inherited from A.
-  An entity cannot make use of func_get_args() to implement variable parameters.
   Generated proxies do not support this for performance reasons and your code might
   actually fail to work when violating this restriction.

Entities support inheritance, polymorphic associations, and
polymorphic queries. Both abstract and concrete classes can be
entities. Entities may extend non-entity classes as well as entity
classes, and non-entity classes may extend entity classes.

.. note::

    The constructor of an entity is only ever invoked when
    *you* construct a new instance with the *new* keyword. Doctrine
    never calls entity constructors, thus you are free to use them as
    you wish and even have it require arguments of any type.


Entity states
~~~~~~~~~~~~~

An entity instance can be characterized as being NEW, MANAGED,
DETACHED or REMOVED.


-  A NEW entity instance has no persistent identity, and is not yet
   associated with an EntityManager and a UnitOfWork (i.e. those just
   created with the "new" operator).
-  A MANAGED entity instance is an instance with a persistent
   identity that is associated with an EntityManager and whose
   persistence is thus managed.
-  A DETACHED entity instance is an instance with a persistent
   identity that is not (or no longer) associated with an
   EntityManager and a UnitOfWork.
-  A REMOVED entity instance is an instance with a persistent
   identity, associated with an EntityManager, that will be removed
   from the database upon transaction commit.

.. _architecture_persistent_fields:

Persistent fields
~~~~~~~~~~~~~~~~~

The persistent state of an entity is represented by instance
variables. An instance variable must be directly accessed only from
within the methods of the entity by the entity instance itself.
Instance variables must not be accessed by clients of the entity.
The state of the entity is available to clients only through the
entity’s methods, i.e. accessor methods (getter/setter methods) or
other business methods.

Collection-valued persistent fields and properties must be defined
in terms of the ``Doctrine\Common\Collections\Collection``
interface. The collection implementation type may be used by the
application to initialize fields or properties before the entity is
made persistent. Once the entity becomes managed (or detached),
subsequent access must be through the interface type.

Serializing entities
~~~~~~~~~~~~~~~~~~~~

Serializing entities can be problematic and is not really
recommended, at least not as long as an entity instance still holds
references to proxy objects or is still managed by an
EntityManager. If you intend to serialize (and unserialize) entity
instances that still hold references to proxy objects you may run
into problems with private properties because of technical
limitations. Proxy objects implement ``__sleep`` and it is not
possible for ``__sleep`` to return names of private properties in
parent classes. On the other hand it is not a solution for proxy
objects to implement ``Serializable`` because Serializable does not
work well with any potential cyclic object references (at least we
did not find a way yet, if you did, please contact us).

The EntityManager
~~~~~~~~~~~~~~~~~

The ``EntityManager`` class is a central access point to the ORM
functionality provided by Doctrine 2. The ``EntityManager`` API is
used to manage the persistence of your objects and to query for
persistent objects.

Transactional write-behind
~~~~~~~~~~~~~~~~~~~~~~~~~~

An ``EntityManager`` and the underlying ``UnitOfWork`` employ a
strategy called "transactional write-behind" that delays the
execution of SQL statements in order to execute them in the most
efficient way and to execute them at the end of a transaction so
that all write locks are quickly released. You should see Doctrine
as a tool to synchronize your in-memory objects with the database
in well defined units of work. Work with your objects and modify
them as usual and when you're done call ``EntityManager#flush()``
to make your changes persistent.

The Unit of Work
~~~~~~~~~~~~~~~~

Internally an ``EntityManager`` uses a ``UnitOfWork``, which is a
typical implementation of the
`Unit of Work pattern <http://martinfowler.com/eaaCatalog/unitOfWork.html>`_,
to keep track of all the things that need to be done the next time
``flush`` is invoked. You usually do not directly interact with a
``UnitOfWork`` but with the ``EntityManager`` instead.


