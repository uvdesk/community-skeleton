Working with Associations
=========================

Associations between entities are represented just like in regular
object-oriented PHP code using references to other objects or
collections of objects.

Changes to associations in your code are not synchronized to the
database directly, only when calling ``EntityManager#flush()``.

There are other concepts you should know about when working
with associations in Doctrine:

-  If an entity is removed from a collection, the association is
   removed, not the entity itself. A collection of entities always
   only represents the association to the containing entities, not the
   entity itself.
-  When a bidirectional association is updated, Doctrine only checks
   on one of both sides for these changes. This is called the :doc:`owning side <unitofwork-associations>`
   of the association.
-  A property with a reference to many entities has to be instances of the
   ``Doctrine\Common\Collections\Collection`` interface.

Association Example Entities
----------------------------

We will use a simple comment system with Users and Comments as
entities to show examples of association management. See the PHP
docblocks of each association in the following example for
information about its type and if it's the owning or inverse side.

.. code-block:: php

    <?php
    /** @Entity */
    class User
    {
        /** @Id @GeneratedValue @Column(type="string") */
        private $id;
    
        /**
         * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
         *
         * @ManyToMany(targetEntity="Comment", inversedBy="userFavorites")
         * @JoinTable(name="user_favorite_comments")
         */
        private $favorites;
    
        /**
         * Unidirectional - Many users have marked many comments as read
         *
         * @ManyToMany(targetEntity="Comment")
         * @JoinTable(name="user_read_comments")
         */
        private $commentsRead;
    
        /**
         * Bidirectional - One-To-Many (INVERSE SIDE)
         *
         * @OneToMany(targetEntity="Comment", mappedBy="author")
         */
        private $commentsAuthored;
    
        /**
         * Unidirectional - Many-To-One
         *
         * @ManyToOne(targetEntity="Comment")
         */
        private $firstComment;
    }
    
    /** @Entity */
    class Comment
    {
        /** @Id @GeneratedValue @Column(type="string") */
        private $id;
    
        /**
         * Bidirectional - Many comments are favorited by many users (INVERSE SIDE)
         *
         * @ManyToMany(targetEntity="User", mappedBy="favorites")
         */
        private $userFavorites;
    
        /**
         * Bidirectional - Many Comments are authored by one user (OWNING SIDE)
         *
         * @ManyToOne(targetEntity="User", inversedBy="commentsAuthored")
         */
         private $author;
    }

This two entities generate the following MySQL Schema (Foreign Key
definitions omitted):

.. code-block:: sql

    CREATE TABLE User (
        id VARCHAR(255) NOT NULL,
        firstComment_id VARCHAR(255) DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    
    CREATE TABLE Comment (
        id VARCHAR(255) NOT NULL,
        author_id VARCHAR(255) DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    
    CREATE TABLE user_favorite_comments (
        user_id VARCHAR(255) NOT NULL,
        favorite_comment_id VARCHAR(255) NOT NULL,
        PRIMARY KEY(user_id, favorite_comment_id)
    ) ENGINE = InnoDB;
    
    CREATE TABLE user_read_comments (
        user_id VARCHAR(255) NOT NULL,
        comment_id VARCHAR(255) NOT NULL,
        PRIMARY KEY(user_id, comment_id)
    ) ENGINE = InnoDB;

Establishing Associations
-------------------------

Establishing an association between two entities is
straight-forward. Here are some examples for the unidirectional
relations of the ``User``:

.. code-block:: php

    <?php
    class User
    {
        // ...
        public function getReadComments() {
             return $this->commentsRead;
        }
    
        public function setFirstComment(Comment $c) {
            $this->firstComment = $c;
        }
    }

The interaction code would then look like in the following snippet
(``$em`` here is an instance of the EntityManager):

.. code-block:: php

    <?php
    $user = $em->find('User', $userId);
    
    // unidirectional many to many
    $comment = $em->find('Comment', $readCommentId);
    $user->getReadComments()->add($comment);
    
    $em->flush();
    
    // unidirectional many to one
    $myFirstComment = new Comment();
    $user->setFirstComment($myFirstComment);
    
    $em->persist($myFirstComment);
    $em->flush();

In the case of bi-directional associations you have to update the
fields on both sides:

.. code-block:: php

    <?php
    class User
    {
        // ..
    
        public function getAuthoredComments() {
            return $this->commentsAuthored;
        }
    
        public function getFavoriteComments() {
            return $this->favorites;
        }
    }
    
    class Comment
    {
        // ...
    
        public function getUserFavorites() {
            return $this->userFavorites;
        }
    
        public function setAuthor(User $author = null) {
            $this->author = $author;
        }
    }
    
    // Many-to-Many
    $user->getFavorites()->add($favoriteComment);
    $favoriteComment->getUserFavorites()->add($user);
    
    $em->flush();
    
    // Many-To-One / One-To-Many Bidirectional
    $newComment = new Comment();
    $user->getAuthoredComments()->add($newComment);
    $newComment->setAuthor($user);
    
    $em->persist($newComment);
    $em->flush();

Notice how always both sides of the bidirectional association are
updated. The previous unidirectional associations were simpler to
handle.

Removing Associations
---------------------

Removing an association between two entities is similarly
straight-forward. There are two strategies to do so, by key and by
element. Here are some examples:

.. code-block:: php

    <?php
    // Remove by Elements
    $user->getComments()->removeElement($comment);
    $comment->setAuthor(null);
    
    $user->getFavorites()->removeElement($comment);
    $comment->getUserFavorites()->removeElement($user);
    
    // Remove by Key
    $user->getComments()->remove($ithComment);
    $comment->setAuthor(null);

You need to call ``$em->flush()`` to make persist these changes in
the database permanently.

Notice how both sides of the bidirectional association are always
updated. Unidirectional associations are consequently simpler to
handle.

Also note that if you use type-hinting in your methods, you will 
have to specify a nullable type, i.e. ``setAddress(?Address $address)``,
otherwise ``setAddress(null)`` will fail to remove the association.
Another way to deal with this is to provide a special method, like
``removeAddress()``. This can also provide better encapsulation as
it hides the internal meaning of not having an address.

When working with collections, keep in mind that a Collection is
essentially an ordered map (just like a PHP array). That is why the
``remove`` operation accepts an index/key. ``removeElement`` is a
separate method that has O(n) complexity using ``array_search``,
where n is the size of the map.

.. note::

    Since Doctrine always only looks at the owning side of a
    bidirectional association for updates, it is not necessary for
    write operations that an inverse collection of a bidirectional
    one-to-many or many-to-many association is updated. This knowledge
    can often be used to improve performance by avoiding the loading of
    the inverse collection.


You can also clear the contents of a whole collection using the
``Collections::clear()`` method. You should be aware that using
this method can lead to a straight and optimized database delete or
update call during the flush operation that is not aware of
entities that have been re-added to the collection.

Say you clear a collection of tags by calling
``$post->getTags()->clear();`` and then call
``$post->getTags()->add($tag)``. This will not recognize the tag having 
already been added previously and will consequently issue two separate database 
calls.

Association Management Methods
------------------------------

It is generally a good idea to encapsulate proper association
management inside the entity classes. This makes it easier to use
the class correctly and can encapsulate details about how the
association is maintained.

The following code shows updates to the previous User and Comment
example that encapsulate much of the association management code:

.. code-block:: php

    <?php
    class User
    {
        //...
        public function markCommentRead(Comment $comment) {
            // Collections implement ArrayAccess
            $this->commentsRead[] = $comment;
        }
    
        public function addComment(Comment $comment) {
            if (count($this->commentsAuthored) == 0) {
                $this->setFirstComment($comment);
            }
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }
    
        private function setFirstComment(Comment $c) {
            $this->firstComment = $c;
        }
    
        public function addFavorite(Comment $comment) {
            $this->favorites->add($comment);
            $comment->addUserFavorite($this);
        }
    
        public function removeFavorite(Comment $comment) {
            $this->favorites->removeElement($comment);
            $comment->removeUserFavorite($this);
        }
    }
    
    class Comment
    {
        // ..
    
        public function addUserFavorite(User $user) {
            $this->userFavorites[] = $user;
        }
    
        public function removeUserFavorite(User $user) {
            $this->userFavorites->removeElement($user);
        }
    }

You will notice that ``addUserFavorite`` and ``removeUserFavorite``
do not call ``addFavorite`` and ``removeFavorite``, thus the
bidirectional association is strictly-speaking still incomplete.
However if you would naively add the ``addFavorite`` in
``addUserFavorite``, you end up with an infinite loop, so more work
is needed. As you can see, proper bidirectional association
management in plain OOP is a non-trivial task and encapsulating all
the details inside the classes can be challenging.

.. note::

    If you want to make sure that your collections are perfectly
    encapsulated you should not return them from a
    ``getCollectionName()`` method directly, but call
    ``$collection->toArray()``. This way a client programmer for the
    entity cannot circumvent the logic you implement on your entity for
    association management. For example:


.. code-block:: php

    <?php
    class User {
        public function getReadComments() {
            return $this->commentsRead->toArray();
        }
    }

This will however always initialize the collection, with all the
performance penalties given the size. In some scenarios of large
collections it might even be a good idea to completely hide the
read access behind methods on the EntityRepository.

There is no single, best way for association management. It greatly
depends on the requirements of your concrete domain model as well
as your preferences.

Synchronizing Bidirectional Collections
---------------------------------------

In the case of Many-To-Many associations you as the developer have the 
responsibility of keeping the collections on the owning and inverse side
in sync when you apply changes to them. Doctrine can only
guarantee a consistent state for the hydration, not for your client
code.

Using the User-Comment entities from above, a very simple example
can show the possible caveats you can encounter:

.. code-block:: php

    <?php
    $user->getFavorites()->add($favoriteComment);
    // not calling $favoriteComment->getUserFavorites()->add($user);
    
    $user->getFavorites()->contains($favoriteComment); // TRUE
    $favoriteComment->getUserFavorites()->contains($user); // FALSE

There are two approaches to handle this problem in your code:


1. Ignore updating the inverse side of bidirectional collections,
   BUT never read from them in requests that changed their state. In
   the next request Doctrine hydrates the consistent collection state
   again.
2. Always keep the bidirectional collections in sync through
   association management methods. Reads of the Collections directly
   after changes are consistent then.

.. _transitive-persistence:

Transitive persistence / Cascade Operations
-------------------------------------------

Doctrine 2 provides a mechanism for transitive persistence through cascading of certain operations.
Each association to another entity or a collection of
entities can be configured to automatically cascade the following operations to the associated entities:
``persist``, ``remove``, ``merge``, ``detach``, ``refresh`` or ``all``.

The main use case for ``cascade: persist`` is to avoid "exposing" associated entities to your PHP application.
Continuing with the User-Comment example of this chapter, this is how the creation of a new user and a new
comment might look like in your controller (without ``cascade: persist``):

.. code-block:: php

    <?php
    $user = new User();
    $myFirstComment = new Comment();
    $user->addComment($myFirstComment);
    
    $em->persist($user);
    $em->persist($myFirstComment); // required, if `cascade: persist` is not set
    $em->flush();

Note that the Comment entity is instantiated right here in the controller.
To avoid this, ``cascade: persist`` allows you to "hide" the Comment entity from the controller,
only accessing it through the User entity:

.. code-block:: php

    <?php
    // User entity
    class User
    {
        private $id;
        private $comments;

        public function __construct()
        {
            $this->id = User::new();
            $this->comments = new ArrayCollection();
        }

        public function comment(string $text, DateTimeInterface $time) : void
        {
            $newComment = Comment::create($text, $time);
            $newComment->setUser($this);
            $this->comments->add($newComment);
        }

        // ...
    }

If you then set up the cascading to the ``User#commentsAuthored`` property...

.. code-block:: php

    <?php
    class User
    {
        //...
        /**
         * Bidirectional - One-To-Many (INVERSE SIDE)
         *
         * @OneToMany(targetEntity="Comment", mappedBy="author", cascade={"persist", "remove"})
         */
        private $commentsAuthored;
        //...
    }

...you can now create a user and an associated comment like this:

.. code-block:: php

    <?php
    $user = new User();
    $user->comment('Lorem ipsum', new DateTime());
    
    $em->persist($user);
    $em->flush();

.. note::

    The idea of ``cascade: persist`` is not to save you any lines of code in the controller.
    If you instantiate the comment object in the controller (i.e. don't set up the user entity as shown above),
    even with ``cascade: persist`` you still have to call ``$myFirstComment->setUser($user);``.

Thanks to ``cascade: remove``, you can easily delete a user and all linked comments without having to loop through them:

.. code-block:: php

    <?php
    $user = $em->find('User', $deleteUserId);

    $em->remove($user);
    $em->flush();

.. note::

    Cascade operations are performed in memory. That means collections and related entities
    are fetched into memory (even if they are marked as lazy) when
    the cascade operation is about to be performed. This approach allows
    entity lifecycle events to be performed for each of these operations.

    However, pulling object graphs into memory on cascade can cause considerable performance
    overhead, especially when the cascaded collections are large. Make sure
    to weigh the benefits and downsides of each cascade operation that you define.

    To rely on the database level cascade operations for the delete operation instead, you can
    configure each join column with :doc:`the onDelete option <working-with-objects>`.

Even though automatic cascading is convenient, it should be used
with care. Do not blindly apply ``cascade=all`` to all associations as
it will unnecessarily degrade the performance of your application.
For each cascade operation that gets activated, Doctrine also
applies that operation to the association, be it single or
collection valued.

Persistence by Reachability: Cascade Persist
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

There are additional semantics that apply to the Cascade Persist
operation. During each ``flush()`` operation Doctrine detects if there
are new entities in any collection and three possible cases can
happen:


1. New entities in a collection marked as ``cascade: persist`` will be
   directly persisted by Doctrine.
2. New entities in a collection not marked as ``cascade: persist`` will
   produce an Exception and rollback the ``flush()`` operation.
3. Collections without new entities are skipped.

This concept is called Persistence by Reachability: New entities
that are found on already managed entities are automatically
persisted as long as the association is defined as ``cascade: persist``.

Orphan Removal
--------------

There is another concept of cascading that is relevant only when removing entities
from collections. If an Entity of type ``A`` contains references to privately
owned Entities ``B`` then if the reference from ``A`` to ``B`` is removed the
entity ``B`` should also be removed, because it is not used anymore.

OrphanRemoval works with one-to-one, one-to-many and many-to-many associations.

.. note::

    When using the ``orphanRemoval=true`` option Doctrine makes the assumption
    that the entities are privately owned and will **NOT** be reused by other entities.
    If you neglect this assumption your entities will get deleted by Doctrine even if
    you assigned the orphaned entity to another one.

As a better example consider an Addressbook application where you have Contacts, Addresses
and StandingData:

.. code-block:: php

    <?php

    namespace Addressbook;

    use Doctrine\Common\Collections\ArrayCollection;

    /**
     * @Entity
     */
    class Contact
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        private $id;

        /** @OneToOne(targetEntity="StandingData", orphanRemoval=true) */
        private $standingData;

        /** @OneToMany(targetEntity="Address", mappedBy="contact", orphanRemoval=true) */
        private $addresses;

        public function __construct()
        {
            $this->addresses = new ArrayCollection();
        }

        public function newStandingData(StandingData $sd)
        {
            $this->standingData = $sd;
        }

        public function removeAddress($pos)
        {
            unset($this->addresses[$pos]);
        }
    }

Now two examples of what happens when you remove the references:

.. code-block:: php

    <?php

    $contact = $em->find("Addressbook\Contact", $contactId);
    $contact->newStandingData(new StandingData("Firstname", "Lastname", "Street"));
    $contact->removeAddress(1);

    $em->flush();

In this case you have not only changed the ``Contact`` entity itself but 
you have also removed the references for standing data and as well as one 
address reference. When flush is called not only are the references removed 
but both the old standing data and the one address entity are also deleted 
from the database.

.. _filtering-collections:

Filtering Collections
---------------------

Collections have a filtering API that allows to slice parts of data from
a collection. If the collection has not been loaded from the database yet,
the filtering API can work on the SQL level to make optimized access to
large collections.

.. code-block:: php

    <?php

    use Doctrine\Common\Collections\Criteria;

    $group          = $entityManager->find('Group', $groupId);
    $userCollection = $group->getUsers();

    $criteria = Criteria::create()
        ->where(Criteria::expr()->eq("birthday", "1982-02-17"))
        ->orderBy(array("username" => Criteria::ASC))
        ->setFirstResult(0)
        ->setMaxResults(20)
    ;

    $birthdayUsers = $userCollection->matching($criteria);

.. tip::

    You can move the access of slices of collections into dedicated methods of
    an entity. For example ``Group#getTodaysBirthdayUsers()``.

The Criteria has a limited matching language that works both on the
SQL and on the PHP collection level. This means you can use collection matching
interchangeably, independent of in-memory or sql-backed collections.

.. code-block:: php

    <?php

    use Doctrine\Common\Collections;

    class Criteria
    {
        /**
         * @return Criteria
         */
        static public function create();
        /**
         * @param Expression $where
         * @return Criteria
         */
        public function where(Expression $where);
        /**
         * @param Expression $where
         * @return Criteria
         */
        public function andWhere(Expression $where);
        /**
         * @param Expression $where
         * @return Criteria
         */
        public function orWhere(Expression $where);
        /**
         * @param array $orderings
         * @return Criteria
         */
        public function orderBy(array $orderings);
        /**
         * @param int $firstResult
         * @return Criteria
         */
        public function setFirstResult($firstResult);
        /**
         * @param int $maxResults
         * @return Criteria
         */
        public function setMaxResults($maxResults);
        public function getOrderings();
        public function getWhereExpression();
        public function getFirstResult();
        public function getMaxResults();
    }

You can build expressions through the ExpressionBuilder. It has the following
methods:

* ``andX($arg1, $arg2, ...)``
* ``orX($arg1, $arg2, ...)``
* ``eq($field, $value)``
* ``gt($field, $value)``
* ``lt($field, $value)``
* ``lte($field, $value)``
* ``gte($field, $value)``
* ``neq($field, $value)``
* ``isNull($field)``
* ``in($field, array $values)``
* ``notIn($field, array $values)``
* ``contains($field, $value)``
* ``startsWith($field, $value)``
* ``endsWith($field, $value)``


.. note::

    There is a limitation on the compatibility of Criteria comparisons.
    You have to use scalar values only as the value in a comparison or
    the behaviour between different backends is not the same.
