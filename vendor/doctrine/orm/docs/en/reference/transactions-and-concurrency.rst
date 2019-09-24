Transactions and Concurrency
============================

.. _transactions-and-concurrency_transaction-demarcation:

Transaction Demarcation
-----------------------

Transaction demarcation is the task of defining your transaction
boundaries. Proper transaction demarcation is very important
because if not done properly it can negatively affect the
performance of your application. Many databases and database
abstraction layers like PDO by default operate in auto-commit mode,
which means that every single SQL statement is wrapped in a small
transaction. Without any explicit transaction demarcation from your
side, this quickly results in poor performance because transactions
are not cheap.

For the most part, Doctrine 2 already takes care of proper
transaction demarcation for you: All the write operations
(INSERT/UPDATE/DELETE) are queued until ``EntityManager#flush()``
is invoked which wraps all of these changes in a single
transaction.

However, Doctrine 2 also allows (and encourages) you to take over
and control transaction demarcation yourself.

These are two ways to deal with transactions when using the
Doctrine ORM and are now described in more detail.

.. _transactions-and-concurrency_approach-implicitly:

Approach 1: Implicitly
~~~~~~~~~~~~~~~~~~~~~~

The first approach is to use the implicit transaction handling
provided by the Doctrine ORM EntityManager. Given the following
code snippet, without any explicit transaction demarcation:

.. code-block:: php

    <?php
    // $em instanceof EntityManager
    $user = new User;
    $user->setName('George');
    $em->persist($user);
    $em->flush();

Since we do not do any custom transaction demarcation in the above
code, ``EntityManager#flush()`` will begin and commit/rollback a
transaction. This behavior is made possible by the aggregation of
the DML operations by the Doctrine ORM and is sufficient if all the
data manipulation that is part of a unit of work happens through
the domain model and thus the ORM.

.. _transactions-and-concurrency_approach-explicitly:

Approach 2: Explicitly
~~~~~~~~~~~~~~~~~~~~~~

The explicit alternative is to use the ``Doctrine\DBAL\Connection``
API directly to control the transaction boundaries. The code then
looks like this:

.. code-block:: php

    <?php
    // $em instanceof EntityManager
    $em->getConnection()->beginTransaction(); // suspend auto-commit
    try {
        //... do some work
        $user = new User;
        $user->setName('George');
        $em->persist($user);
        $em->flush();
        $em->getConnection()->commit();
    } catch (Exception $e) {
        $em->getConnection()->rollBack();
        throw $e;
    }

Explicit transaction demarcation is required when you want to
include custom DBAL operations in a unit of work or when you want
to make use of some methods of the ``EntityManager`` API that
require an active transaction. Such methods will throw a
``TransactionRequiredException`` to inform you of that
requirement.

A more convenient alternative for explicit transaction demarcation is the use
of provided control abstractions in the form of
``Connection#transactional($func)`` and ``EntityManager#transactional($func)``.
When used, these control abstractions ensure that you never forget to rollback
the transaction, in addition to the obvious code reduction. An example that is
functionally equivalent to the previously shown code looks as follows:

.. code-block:: php

    <?php
    // $em instanceof EntityManager
    $em->transactional(function($em) {
        //... do some work
        $user = new User;
        $user->setName('George');
        $em->persist($user);
    });

.. warning::

    For historical reasons, ``EntityManager#transactional($func)`` will return
    ``true`` whenever the return value of ``$func`` is loosely false.
    Some examples of this include ``array()``, ``"0"``, ``""``, ``0``, and
    ``null``.

The difference between ``Connection#transactional($func)`` and
``EntityManager#transactional($func)`` is that the latter
abstraction flushes the ``EntityManager`` prior to transaction
commit and rolls back the transaction when an
exception occurs.

.. _transactions-and-concurrency_exception-handling:

Exception Handling
~~~~~~~~~~~~~~~~~~

When using implicit transaction demarcation and an exception occurs
during ``EntityManager#flush()``, the transaction is automatically
rolled back and the ``EntityManager`` closed.

When using explicit transaction demarcation and an exception
occurs, the transaction should be rolled back immediately and the
``EntityManager`` closed by invoking ``EntityManager#close()`` and
subsequently discarded, as demonstrated in the example above. This
can be handled elegantly by the control abstractions shown earlier.
Note that when catching ``Exception`` you should generally re-throw
the exception. If you intend to recover from some exceptions, catch
them explicitly in earlier catch blocks (but do not forget to
rollback the transaction and close the ``EntityManager`` there as
well). All other best practices of exception handling apply
similarly (i.e. either log or re-throw, not both, etc.).

As a result of this procedure, all previously managed or removed
instances of the ``EntityManager`` become detached. The state of
the detached objects will be the state at the point at which the
transaction was rolled back. The state of the objects is in no way
rolled back and thus the objects are now out of synch with the
database. The application can continue to use the detached objects,
knowing that their state is potentially no longer accurate.

If you intend to start another unit of work after an exception has
occurred you should do that with a new ``EntityManager``.

.. _transactions-and-concurrency_locking-support:

Locking Support
---------------

Doctrine 2 offers support for Pessimistic- and Optimistic-locking
strategies natively. This allows to take very fine-grained control
over what kind of locking is required for your Entities in your
application.

.. _transactions-and-concurrency_optimistic-locking:

Optimistic Locking
~~~~~~~~~~~~~~~~~~

Database transactions are fine for concurrency control during a
single request. However, a database transaction should not span
across requests, the so-called "user think time". Therefore a
long-running "business transaction" that spans multiple requests
needs to involve several database transactions. Thus, database
transactions alone can no longer control concurrency during such a
long-running business transaction. Concurrency control becomes the
partial responsibility of the application itself.

Doctrine has integrated support for automatic optimistic locking
via a version field. In this approach any entity that should be
protected against concurrent modifications during long-running
business transactions gets a version field that is either a simple
number (mapping type: integer) or a timestamp (mapping type:
datetime). When changes to such an entity are persisted at the end
of a long-running conversation the version of the entity is
compared to the version in the database and if they don't match, an
``OptimisticLockException`` is thrown, indicating that the entity
has been modified by someone else already.

You designate a version field in an entity as follows. In this
example we'll use an integer.

.. configuration-block::

    .. code-block:: php

        <?php
        class User
        {
            // ...
            /** @Version @Column(type="integer") */
            private $version;
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
          <entity name="User">
            <field name="version" type="integer" version="true" />
          </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          fields:
            version:
              type: integer
              version: true

Alternatively a datetime type can be used (which maps to a SQL
timestamp or datetime):

.. configuration-block::

    .. code-block:: php

        <?php
        class User
        {
            // ...
            /** @Version @Column(type="datetime") */
            private $version;
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
          <entity name="User">
            <field name="version" type="datetime" version="true" />
          </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          fields:
            version:
              type: datetime
              version: true

Version numbers (not timestamps) should however be preferred as
they can not potentially conflict in a highly concurrent
environment, unlike timestamps where this is a possibility,
depending on the resolution of the timestamp on the particular
database platform.

When a version conflict is encountered during
``EntityManager#flush()``, an ``OptimisticLockException`` is thrown
and the active transaction rolled back (or marked for rollback).
This exception can be caught and handled. Potential responses to an
OptimisticLockException are to present the conflict to the user or
to refresh or reload objects in a new transaction and then retrying
the transaction.

With PHP promoting a share-nothing architecture, the time between
showing an update form and actually modifying the entity can in the
worst scenario be as long as your applications session timeout. If
changes happen to the entity in that time frame you want to know
directly when retrieving the entity that you will hit an optimistic
locking exception:

You can always verify the version of an entity during a request
either when calling ``EntityManager#find()``:

.. code-block:: php

    <?php
    use Doctrine\DBAL\LockMode;
    use Doctrine\ORM\OptimisticLockException;
    
    $theEntityId = 1;
    $expectedVersion = 184;
    
    try {
        $entity = $em->find('User', $theEntityId, LockMode::OPTIMISTIC, $expectedVersion);
    
        // do the work
    
        $em->flush();
    } catch(OptimisticLockException $e) {
        echo "Sorry, but someone else has already changed this entity. Please apply the changes again!";
    }

Or you can use ``EntityManager#lock()`` to find out:

.. code-block:: php

    <?php
    use Doctrine\DBAL\LockMode;
    use Doctrine\ORM\OptimisticLockException;
    
    $theEntityId = 1;
    $expectedVersion = 184;
    
    $entity = $em->find('User', $theEntityId);
    
    try {
        // assert version
        $em->lock($entity, LockMode::OPTIMISTIC, $expectedVersion);
    
    } catch(OptimisticLockException $e) {
        echo "Sorry, but someone else has already changed this entity. Please apply the changes again!";
    }

Important Implementation Notes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You can easily get the optimistic locking workflow wrong if you
compare the wrong versions. Say you have Alice and Bob editing a
hypothetical blog post:

-  Alice reads the headline of the blog post being "Foo", at
   optimistic lock version 1 (GET Request)
-  Bob reads the headline of the blog post being "Foo", at
   optimistic lock version 1 (GET Request)
-  Bob updates the headline to "Bar", upgrading the optimistic lock
   version to 2 (POST Request of a Form)
-  Alice updates the headline to "Baz", ... (POST Request of a
   Form)

Now at the last stage of this scenario the blog post has to be read
again from the database before Alice's headline can be applied. At
this point you will want to check if the blog post is still at
version 1 (which it is not in this scenario).

Using optimistic locking correctly, you *have* to add the version
as an additional hidden field (or into the SESSION for more
safety). Otherwise you cannot verify the version is still the one
being originally read from the database when Alice performed her
GET request for the blog post. If this happens you might see lost
updates you wanted to prevent with Optimistic Locking.

See the example code, The form (GET Request):

.. code-block:: php

    <?php
    $post = $em->find('BlogPost', 123456);
    
    echo '<input type="hidden" name="id" value="' . $post->getId() . '" />';
    echo '<input type="hidden" name="version" value="' . $post->getCurrentVersion() . '" />';

And the change headline action (POST Request):

.. code-block:: php

    <?php
    $postId = (int)$_GET['id'];
    $postVersion = (int)$_GET['version'];
    
    $post = $em->find('BlogPost', $postId, \Doctrine\DBAL\LockMode::OPTIMISTIC, $postVersion);

.. _transactions-and-concurrency_pessimistic-locking:

Pessimistic Locking
~~~~~~~~~~~~~~~~~~~

Doctrine 2 supports Pessimistic Locking at the database level. No
attempt is being made to implement pessimistic locking inside
Doctrine, rather vendor-specific and ANSI-SQL commands are used to
acquire row-level locks. Every Entity can be part of a pessimistic
lock, there is no special metadata required to use this feature.

However for Pessimistic Locking to work you have to disable the
Auto-Commit Mode of your Database and start a transaction around
your pessimistic lock use-case using the "Approach 2: Explicit
Transaction Demarcation" described above. Doctrine 2 will throw an
Exception if you attempt to acquire an pessimistic lock and no
transaction is running.

Doctrine 2 currently supports two pessimistic lock modes:


-  Pessimistic Write
   (``Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE``), locks the
   underlying database rows for concurrent Read and Write Operations.
-  Pessimistic Read (``Doctrine\DBAL\LockMode::PESSIMISTIC_READ``),
   locks other concurrent requests that attempt to update or lock rows
   in write mode.

You can use pessimistic locks in three different scenarios:


1. Using
   ``EntityManager#find($className, $id, \Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE)``
   or
   ``EntityManager#find($className, $id, \Doctrine\DBAL\LockMode::PESSIMISTIC_READ)``
2. Using
   ``EntityManager#lock($entity, \Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE)``
   or
   ``EntityManager#lock($entity, \Doctrine\DBAL\LockMode::PESSIMISTIC_READ)``
3. Using
   ``Query#setLockMode(\Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE)``
   or
   ``Query#setLockMode(\Doctrine\DBAL\LockMode::PESSIMISTIC_READ)``


