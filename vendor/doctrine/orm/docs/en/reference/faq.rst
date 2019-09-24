Frequently Asked Questions
==========================

.. note::

    This FAQ is a work in progress. We will add lots of questions and not answer them right away just to remember
    what is often asked. If you stumble across an unanswered question please write a mail to the mailing-list or
    join the #doctrine channel on Freenode IRC.

Database Schema
---------------

How do I set the charset and collation for MySQL tables?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can't set these values inside the annotations, yml or xml mapping files. To make a database
work with the default charset and collation you should configure MySQL to use it as default charset,
or create the database with charset and collation details. This way they get inherited to all newly
created database tables and columns.

Entity Classes
--------------

How can I add default values to a column?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Doctrine does not support to set the default values in columns through the "DEFAULT" keyword in SQL.
This is not necessary however, you can just use your class properties as default values. These are then used
upon insert:

.. code-block:: php

    class User
    {
        const STATUS_DISABLED = 0;
        const STATUS_ENABLED = 1;

        private $algorithm = "sha1";
        private $status = self:STATUS_DISABLED;
    }

.

Mapping
-------

Why do I get exceptions about unique constraint failures during ``$em->flush()``?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Doctrine does not check if you are re-adding entities with a primary key that already exists
or adding entities to a collection twice. You have to check for both conditions yourself
in the code before calling ``$em->flush()`` if you know that unique constraint failures
can occur.

In `Symfony2 <http://www.symfony.com>`_ for example there is a Unique Entity Validator
to achieve this task.

For collections you can check with ``$collection->contains($entity)`` if an entity is already
part of this collection. For a FETCH=LAZY collection this will initialize the collection,
however for FETCH=EXTRA_LAZY this method will use SQL to determine if this entity is already
part of the collection.

Associations
------------

What is wrong when I get an InvalidArgumentException "A new entity was found through the relationship.."?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This exception is thrown during ``EntityManager#flush()`` when there exists an object in the identity map
that contains a reference to an object that Doctrine does not know about. Say for example you grab
a "User"-entity from the database with a specific id and set a completely new object into one of the associations
of the User object. If you then call ``EntityManager#flush()`` without letting Doctrine know about
this new object using ``EntityManager#persist($newObject)`` you will see this exception.

You can solve this exception by:

* Calling ``EntityManager#persist($newObject)`` on the new object
* Using cascade=persist on the association that contains the new object

How can I filter an association?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Natively you can't filter associations in 2.0 and 2.1. You should use DQL queries to query for the filtered set of entities.

I call clear() on a One-To-Many collection but the entities are not deleted
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This is an expected behavior that has to do with the inverse/owning side handling of Doctrine.
By definition a One-To-Many association is on the inverse side, that means changes to it
will not be recognized by Doctrine.

If you want to perform the equivalent of the clear operation you have to iterate the
collection and set the owning side many-to-one reference to NULL as well to detach all entities
from the collection. This will trigger the appropriate UPDATE statements on the database.

How can I add columns to a many-to-many table?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The many-to-many association is only supporting foreign keys in the table definition
To work with many-to-many tables containing extra columns you have to use the
foreign keys as primary keys feature of Doctrine introduced in version 2.1.

See :doc:`the tutorial on composite primary keys for more information<../tutorials/composite-primary-keys>`.


How can i paginate fetch-joined collections?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you are issuing a DQL statement that fetches a collection as well you cannot easily iterate
over this collection using a LIMIT statement (or vendor equivalent).

Doctrine does not offer a solution for this out of the box but there are several extensions
that do:

* `DoctrineExtensions <http://github.com/beberlei/DoctrineExtensions>`_
* `Pagerfanta <http://github.com/whiteoctober/pagerfanta>`_

Why does pagination not work correctly with fetch joins?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Pagination in Doctrine uses a LIMIT clause (or vendor equivalent) to restrict the results.
However when fetch-joining this is not returning the correct number of results since joining
with a one-to-many or many-to-many association multiplies the number of rows by the number
of associated entities.

See the previous question for a solution to this task.

Inheritance
-----------

Can I use Inheritance with Doctrine 2?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 
Yes, you can use Single- or Joined-Table Inheritance in Doctrine 2.

See the documentation chapter on :doc:`inheritance mapping <inheritance-mapping>` for
the details.

Why does Doctrine not create proxy objects for my inheritance hierarchy?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you set a many-to-one or one-to-one association target-entity to any parent class of
an inheritance hierarchy Doctrine does not know what PHP class the foreign is actually of.
To find this out it has to execute a SQL query to look this information up in the database.

EntityGenerator
---------------

Why does the EntityGenerator not do X?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The EntityGenerator is not a full fledged code-generator that solves all tasks. Code-Generation
is not a first-class priority in Doctrine 2 anymore (compared to Doctrine 1). The EntityGenerator
is supposed to kick-start you, but not towards 100%.

Why does the EntityGenerator not generate inheritance correctly?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Just from the details of the discriminator map the EntityGenerator cannot guess the inheritance hierarchy.
This is why the generation of inherited entities does not fully work. You have to adjust some additional
code to get this one working correctly.

Performance
-----------

Why is an extra SQL query executed every time I fetch an entity with a one-to-one relation?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If Doctrine detects that you are fetching an inverse side one-to-one association
it has to execute an additional query to load this object, because it cannot know
if there is no such object (setting null) or if it should set a proxy and which id this proxy has.

To solve this problem currently a query has to be executed to find out this information.

Doctrine Query Language
-----------------------

What is DQL?
~~~~~~~~~~~~

DQL stands for Doctrine Query Language, a query language that very much looks like SQL
but has some important benefits when using Doctrine:

-  It uses class names and fields instead of tables and columns, separating concerns between backend and your object model.
-  It utilizes the metadata defined to offer a range of shortcuts when writing. For example you do not have to specify the ON clause of joins, since Doctrine already knows about them.
-  It adds some functionality that is related to object management and transforms them into SQL.

It also has some drawbacks of course:

-  The syntax is slightly different to SQL so you have to learn and remember the differences.
-  To be vendor independent it can only implement a subset of all the existing SQL dialects. Vendor specific functionality and optimizations cannot be used through DQL unless implemented by you explicitly.
-  For some DQL constructs subselects are used which are known to be slow in MySQL.

Can I sort by a function (for example ORDER BY RAND()) in DQL?
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

No, it is not supported to sort by function in DQL. If you need this functionality you should either
use a native-query or come up with another solution. As a side note: Sorting with ORDER BY RAND() is painfully slow
starting with 1000 rows.

A Query fails, how can I debug it?
----------------------------------

First, if you are using the QueryBuilder you can use
``$queryBuilder->getDQL()`` to get the DQL string of this query. The
corresponding SQL you can get from the Query instance by calling
``$query->getSQL()``.

.. code-block:: php

    <?php
    $dql = "SELECT u FROM User u";
    $query = $entityManager->createQuery($dql);
    var_dump($query->getSQL());

    $qb = $entityManager->createQueryBuilder();
    $qb->select('u')->from('User', 'u');
    var_dump($qb->getDQL());
