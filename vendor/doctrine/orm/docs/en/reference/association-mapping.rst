Association Mapping
===================

This chapter explains mapping associations between objects.

Instead of working with foreign keys in your code, you will always work with
references to objects instead and Doctrine will convert those references
to foreign keys internally.

- A reference to a single object is represented by a foreign key.
- A collection of objects is represented by many foreign keys pointing to the object holding the collection

This chapter is split into three different sections.

- A list of all the possible association mapping use-cases is given.
- :ref:`association_mapping_defaults` are explained that simplify the use-case examples.
- :ref:`collections` are introduced that contain entities in associations.

One tip for working with relations is to read the relation from left to right, where the left word refers to the current Entity. For example:

- OneToMany - One instance of the current Entity has Many instances (references) to the refered Entity.
- ManyToOne - Many instances of the current Entity refer to One instance of the refered Entity.
- OneToOne - One instance of the current Entity refers to One instance of the refered Entity.

See below for all the possible relations. 

An association is considered to be unidirectional if only one side of the association has 
a property referring to the other side.

To gain a full understanding of associations you should also read about :doc:`owning and
inverse sides of associations <unitofwork-associations>`

Many-To-One, Unidirectional
---------------------------

A many-to-one association is the most common association between objects. Example: Many Users have One Address:

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class User
        {
            // ...

            /**
             * @ManyToOne(targetEntity="Address")
             * @JoinColumn(name="address_id", referencedColumnName="id")
             */
            private $address;
        }

        /** @Entity */
        class Address
        {
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <many-to-one field="address" target-entity="Address">
                    <join-column name="address_id" referenced-column-name="id" />
                </many-to-one>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToOne:
            address:
              targetEntity: Address
              joinColumn:
                name: address_id
                referencedColumnName: id


.. note::

    The above ``@JoinColumn`` is optional as it would default
    to ``address_id`` and ``id`` anyways. You can omit it and let it
    use the defaults.

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE User (
        id INT AUTO_INCREMENT NOT NULL,
        address_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;

    CREATE TABLE Address (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;

    ALTER TABLE User ADD FOREIGN KEY (address_id) REFERENCES Address(id);

One-To-One, Unidirectional
--------------------------

Here is an example of a one-to-one association with a ``Product`` entity that
references one ``Shipment`` entity.

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class Product
        {
            // ...

            /**
             * One Product has One Shipment.
             * @OneToOne(targetEntity="Shipment")
             * @JoinColumn(name="shipment_id", referencedColumnName="id")
             */
            private $shipment;

            // ...
        }

        /** @Entity */
        class Shipment
        {
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity class="Product">
                <one-to-one field="shipment" target-entity="Shipment">
                    <join-column name="shipment_id" referenced-column-name="id" />
                </one-to-one>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Product:
          type: entity
          oneToOne:
            shipment:
              targetEntity: Shipment
              joinColumn:
                name: shipment_id
                referencedColumnName: id

Note that the @JoinColumn is not really necessary in this example,
as the defaults would be the same.

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE Product (
        id INT AUTO_INCREMENT NOT NULL,
        shipment_id INT DEFAULT NULL,
        UNIQUE INDEX UNIQ_6FBC94267FE4B2B (shipment_id),
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE Shipment (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE Product ADD FOREIGN KEY (shipment_id) REFERENCES Shipment(id);

One-To-One, Bidirectional
-------------------------

Here is a one-to-one relationship between a ``Customer`` and a
``Cart``. The ``Cart`` has a reference back to the ``Customer`` so
it is bidirectional.

Here we see the ``mappedBy`` and ``inversedBy`` annotations for the first time.
They are used to tell Doctrine which property on the other side refers to the
object.

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class Customer
        {
            // ...

            /**
             * One Customer has One Cart.
             * @OneToOne(targetEntity="Cart", mappedBy="customer")
             */
            private $cart;

            // ...
        }

        /** @Entity */
        class Cart
        {
            // ...

            /**
             * One Cart has One Customer.
             * @OneToOne(targetEntity="Customer", inversedBy="cart")
             * @JoinColumn(name="customer_id", referencedColumnName="id")
             */
            private $customer;

            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="Customer">
                <one-to-one field="cart" target-entity="Cart" mapped-by="customer" />
            </entity>
            <entity name="Cart">
                <one-to-one field="customer" target-entity="Customer" inversed-by="cart">
                    <join-column name="customer_id" referenced-column-name="id" />
                </one-to-one>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Customer:
          oneToOne:
            cart:
              targetEntity: Cart
              mappedBy: customer
        Cart:
          oneToOne:
            customer:
              targetEntity: Customer
              inversedBy: cart
              joinColumn:
                name: customer_id
                referencedColumnName: id

Note that the @JoinColumn is not really necessary in this example,
as the defaults would be the same.

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE Cart (
        id INT AUTO_INCREMENT NOT NULL,
        customer_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE Customer (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE Cart ADD FOREIGN KEY (customer_id) REFERENCES Customer(id);

We had a choice of sides on which to place the ``inversedBy`` attribute. Because it
is on the ``Cart``, that is the owning side of the relation, and thus holds the
foreign key.

One-To-One, Self-referencing
----------------------------

You can define a self-referencing one-to-one relationships like
below.

.. code-block:: php

    <?php
    /** @Entity */
    class Student
    {
        // ...

        /**
         * One Student has One Student.
         * @OneToOne(targetEntity="Student")
         * @JoinColumn(name="mentor_id", referencedColumnName="id")
         */
        private $mentor;

        // ...
    }

Note that the @JoinColumn is not really necessary in this example,
as the defaults would be the same.

With the generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE Student (
        id INT AUTO_INCREMENT NOT NULL,
        mentor_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE Student ADD FOREIGN KEY (mentor_id) REFERENCES Student(id);

One-To-Many, Bidirectional
--------------------------

A one-to-many association has to be bidirectional, unless you are using a
join table. This is because the "many" side in a one-to-many association holds
the foreign key, making it the owning side. Doctrine needs the "many" side
defined in order to understand the association.

This bidirectional mapping requires the ``mappedBy`` attribute on the
"one" side and the ``inversedBy`` attribute on the "many" side.

This means there is no difference between a bidirectional one-to-many and a
bidirectional many-to-one.

.. configuration-block::

    .. code-block:: php

        <?php
        use Doctrine\Common\Collections\ArrayCollection;

        /** @Entity */
        class Product
        {
            // ...
            /**
             * One product has many features. This is the inverse side.
             * @OneToMany(targetEntity="Feature", mappedBy="product")
             */
            private $features;
            // ...

            public function __construct() {
                $this->features = new ArrayCollection();
            }
        }

        /** @Entity */
        class Feature
        {
            // ...
            /**
             * Many features have one product. This is the owning side.
             * @ManyToOne(targetEntity="Product", inversedBy="features")
             * @JoinColumn(name="product_id", referencedColumnName="id")
             */
            private $product;
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="Product">
                <one-to-many field="features" target-entity="Feature" mapped-by="product" />
            </entity>
            <entity name="Feature">
                <many-to-one field="product" target-entity="Product" inversed-by="features">
                    <join-column name="product_id" referenced-column-name="id" />
                </many-to-one>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Product:
          type: entity
          oneToMany:
            features:
              targetEntity: Feature
              mappedBy: product
        Feature:
          type: entity
          manyToOne:
            product:
              targetEntity: Product
              inversedBy: features
              joinColumn:
                name: product_id
                referencedColumnName: id

Note that the @JoinColumn is not really necessary in this example,
as the defaults would be the same.

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE Product (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE Feature (
        id INT AUTO_INCREMENT NOT NULL,
        product_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE Feature ADD FOREIGN KEY (product_id) REFERENCES Product(id);

One-To-Many, Unidirectional with Join Table
-------------------------------------------

A unidirectional one-to-many association can be mapped through a
join table. From Doctrine's point of view, it is simply mapped as a
unidirectional many-to-many whereby a unique constraint on one of
the join columns enforces the one-to-many cardinality.

The following example sets up such a unidirectional one-to-many association:

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class User
        {
            // ...

            /**
             * Many User have Many Phonenumbers.
             * @ManyToMany(targetEntity="Phonenumber")
             * @JoinTable(name="users_phonenumbers",
             *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
             *      inverseJoinColumns={@JoinColumn(name="phonenumber_id", referencedColumnName="id", unique=true)}
             *      )
             */
            private $phonenumbers;

            public function __construct()
            {
                $this->phonenumbers = new \Doctrine\Common\Collections\ArrayCollection();
            }

            // ...
        }

        /** @Entity */
        class Phonenumber
        {
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <many-to-many field="phonenumbers" target-entity="Phonenumber">
                    <join-table name="users_phonenumbers">
                        <join-columns>
                            <join-column name="user_id" referenced-column-name="id" />
                        </join-columns>
                        <inverse-join-columns>
                            <join-column name="phonenumber_id" referenced-column-name="id" unique="true" />
                        </inverse-join-columns>
                    </join-table>
                </many-to-many>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            phonenumbers:
              targetEntity: Phonenumber
              joinTable:
                name: users_phonenumbers
                joinColumns:
                  user_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  phonenumber_id:
                    referencedColumnName: id
                    unique: true


Generates the following MySQL Schema:

.. code-block:: sql

    CREATE TABLE User (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;

    CREATE TABLE users_phonenumbers (
        user_id INT NOT NULL,
        phonenumber_id INT NOT NULL,
        UNIQUE INDEX users_phonenumbers_phonenumber_id_uniq (phonenumber_id),
        PRIMARY KEY(user_id, phonenumber_id)
    ) ENGINE = InnoDB;

    CREATE TABLE Phonenumber (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;

    ALTER TABLE users_phonenumbers ADD FOREIGN KEY (user_id) REFERENCES User(id);
    ALTER TABLE users_phonenumbers ADD FOREIGN KEY (phonenumber_id) REFERENCES Phonenumber(id);

One-To-Many, Self-referencing
-----------------------------

You can also setup a one-to-many association that is
self-referencing. In this example we setup a hierarchy of
``Category`` objects by creating a self referencing relationship.
This effectively models a hierarchy of categories and from the
database perspective is known as an adjacency list approach.

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class Category
        {
            // ...
            /**
             * One Category has Many Categories.
             * @OneToMany(targetEntity="Category", mappedBy="parent")
             */
            private $children;

            /**
             * Many Categories have One Category.
             * @ManyToOne(targetEntity="Category", inversedBy="children")
             * @JoinColumn(name="parent_id", referencedColumnName="id")
             */
            private $parent;
            // ...

            public function __construct() {
                $this->children = new \Doctrine\Common\Collections\ArrayCollection();
            }
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="Category">
                <one-to-many field="children" target-entity="Category" mapped-by="parent" />
                <many-to-one field="parent" target-entity="Category" inversed-by="children" />
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Category:
          type: entity
          oneToMany:
            children:
              targetEntity: Category
              mappedBy: parent
          manyToOne:
            parent:
              targetEntity: Category
              inversedBy: children

Note that the @JoinColumn is not really necessary in this example,
as the defaults would be the same.

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE Category (
        id INT AUTO_INCREMENT NOT NULL,
        parent_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE Category ADD FOREIGN KEY (parent_id) REFERENCES Category(id);

Many-To-Many, Unidirectional
----------------------------

Real many-to-many associations are less common. The following
example shows a unidirectional association between User and Group
entities:

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class User
        {
            // ...

            /**
             * Many Users have Many Groups.
             * @ManyToMany(targetEntity="Group")
             * @JoinTable(name="users_groups",
             *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
             *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")}
             *      )
             */
            private $groups;

            // ...

            public function __construct() {
                $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
            }
        }

        /** @Entity */
        class Group
        {
            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <many-to-many field="groups" target-entity="Group">
                    <join-table name="users_groups">
                        <join-columns>
                            <join-column name="user_id" referenced-column-name="id" />
                        </join-columns>
                        <inverse-join-columns>
                            <join-column name="group_id" referenced-column-name="id" />
                        </inverse-join-columns>
                    </join-table>
                </many-to-many>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            groups:
              targetEntity: Group
              joinTable:
                name: users_groups
                joinColumns:
                  user_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  group_id:
                    referencedColumnName: id

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE User (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE users_groups (
        user_id INT NOT NULL,
        group_id INT NOT NULL,
        PRIMARY KEY(user_id, group_id)
    ) ENGINE = InnoDB;
    CREATE TABLE Group (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ALTER TABLE users_groups ADD FOREIGN KEY (user_id) REFERENCES User(id);
    ALTER TABLE users_groups ADD FOREIGN KEY (group_id) REFERENCES Group(id);

.. note::

    Why are many-to-many associations less common? Because
    frequently you want to associate additional attributes with an
    association, in which case you introduce an association class.
    Consequently, the direct many-to-many association disappears and is
    replaced by one-to-many/many-to-one associations between the 3
    participating classes.

Many-To-Many, Bidirectional
---------------------------

Here is a similar many-to-many relationship as above except this
one is bidirectional.

.. configuration-block::

    .. code-block:: php

        <?php
        /** @Entity */
        class User
        {
            // ...

            /**
             * Many Users have Many Groups.
             * @ManyToMany(targetEntity="Group", inversedBy="users")
             * @JoinTable(name="users_groups")
             */
            private $groups;

            public function __construct() {
                $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
            }

            // ...
        }

        /** @Entity */
        class Group
        {
            // ...
            /**
             * Many Groups have Many Users.
             * @ManyToMany(targetEntity="User", mappedBy="groups")
             */
            private $users;

            public function __construct() {
                $this->users = new \Doctrine\Common\Collections\ArrayCollection();
            }

            // ...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="User">
                <many-to-many field="groups" inversed-by="users" target-entity="Group">
                    <join-table name="users_groups">
                        <join-columns>
                            <join-column name="user_id" referenced-column-name="id" />
                        </join-columns>
                        <inverse-join-columns>
                            <join-column name="group_id" referenced-column-name="id" />
                        </inverse-join-columns>
                    </join-table>
                </many-to-many>
            </entity>

            <entity name="Group">
                <many-to-many field="users" mapped-by="groups" target-entity="User"/>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            groups:
              targetEntity: Group
              inversedBy: users
              joinTable:
                name: users_groups
                joinColumns:
                  user_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  group_id:
                    referencedColumnName: id

        Group:
          type: entity
          manyToMany:
            users:
              targetEntity: User
              mappedBy: groups

The MySQL schema is exactly the same as for the Many-To-Many
uni-directional case above.

Owning and Inverse Side on a ManyToMany Association
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For Many-To-Many associations you can chose which entity is the
owning and which the inverse side. There is a very simple semantic
rule to decide which side is more suitable to be the owning side
from a developers perspective. You only have to ask yourself which
entity is responsible for the connection management, and pick that
as the owning side.

Take an example of two entities ``Article`` and ``Tag``. Whenever
you want to connect an Article to a Tag and vice-versa, it is
mostly the Article that is responsible for this relation. Whenever
you add a new article, you want to connect it with existing or new
tags. Your "Create Article" form will probably support this notion
and allow specifying the tags directly. This is why you should pick
the Article as owning side, as it makes the code more
understandable:

.. code-block:: php

    <?php
    class Article
    {
        private $tags;

        public function addTag(Tag $tag)
        {
            $tag->addArticle($this); // synchronously updating inverse side
            $this->tags[] = $tag;
        }
    }

    class Tag
    {
        private $articles;

        public function addArticle(Article $article)
        {
            $this->articles[] = $article;
        }
    }

This allows to group the tag adding on the ``Article`` side of the
association:

.. code-block:: php

    <?php
    $article = new Article();
    $article->addTag($tagA);
    $article->addTag($tagB);

Many-To-Many, Self-referencing
------------------------------

You can even have a self-referencing many-to-many association. A
common scenario is where a ``User`` has friends and the target
entity of that relationship is a ``User`` so it is self
referencing. In this example it is bidirectional so ``User`` has a
field named ``$friendsWithMe`` and ``$myFriends``.

.. code-block:: php

    <?php
    /** @Entity */
    class User
    {
        // ...

        /**
         * Many Users have Many Users.
         * @ManyToMany(targetEntity="User", mappedBy="myFriends")
         */
        private $friendsWithMe;

        /**
         * Many Users have many Users.
         * @ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
         * @JoinTable(name="friends",
         *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
         *      inverseJoinColumns={@JoinColumn(name="friend_user_id", referencedColumnName="id")}
         *      )
         */
        private $myFriends;

        public function __construct() {
            $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
            $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
        }

        // ...
    }

Generated MySQL Schema:

.. code-block:: sql

    CREATE TABLE User (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE friends (
        user_id INT NOT NULL,
        friend_user_id INT NOT NULL,
        PRIMARY KEY(user_id, friend_user_id)
    ) ENGINE = InnoDB;
    ALTER TABLE friends ADD FOREIGN KEY (user_id) REFERENCES User(id);
    ALTER TABLE friends ADD FOREIGN KEY (friend_user_id) REFERENCES User(id);

.. _association_mapping_defaults:

Mapping Defaults
----------------

The ``@JoinColumn`` and ``@JoinTable`` definitions are usually optional and have
sensible default values. The defaults for a join column in a
one-to-one/many-to-one association is as follows:

::

    name: "<fieldname>_id"
    referencedColumnName: "id"

As an example, consider this mapping:

.. configuration-block::

    .. code-block:: php

        <?php
        /** @OneToOne(targetEntity="Shipment") */
        private $shipment;

    .. code-block:: xml

        <doctrine-mapping>
            <entity class="Product">
                <one-to-one field="shipment" target-entity="Shipment" />
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Product:
          type: entity
          oneToOne:
            shipment:
              targetEntity: Shipment

This is essentially the same as the following, more verbose,
mapping:

.. configuration-block::

    .. code-block:: php

        <?php
        /**
         * One Product has One Shipment.
         * @OneToOne(targetEntity="Shipment")
         * @JoinColumn(name="shipment_id", referencedColumnName="id")
         */
        private $shipment;

    .. code-block:: xml

        <doctrine-mapping>
            <entity class="Product">
                <one-to-one field="shipment" target-entity="Shipment">
                    <join-column name="shipment_id" referenced-column-name="id" />
                </one-to-one>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        Product:
          type: entity
          oneToOne:
            shipment:
              targetEntity: Shipment
              joinColumn:
                name: shipment_id
                referencedColumnName: id

The @JoinTable definition used for many-to-many mappings has
similar defaults. As an example, consider this mapping:

.. configuration-block::

    .. code-block:: php

        <?php
        class User
        {
            //...
            /** @ManyToMany(targetEntity="Group") */
            private $groups;
            //...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity class="User">
                <many-to-many field="groups" target-entity="Group" />
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            groups:
              targetEntity: Group

This is essentially the same as the following, more verbose, mapping:

.. configuration-block::

    .. code-block:: php

        <?php
        class User
        {
            //...
            /**
             * Many Users have Many Groups.
             * @ManyToMany(targetEntity="Group")
             * @JoinTable(name="User_Group",
             *      joinColumns={@JoinColumn(name="User_id", referencedColumnName="id")},
             *      inverseJoinColumns={@JoinColumn(name="Group_id", referencedColumnName="id")}
             *      )
             */
            private $groups;
            //...
        }

    .. code-block:: xml

        <doctrine-mapping>
            <entity class="User">
                <many-to-many field="groups" target-entity="Group">
                    <join-table name="User_Group">
                        <join-columns>
                            <join-column id="User_id" referenced-column-name="id" />
                        </join-columns>
                        <inverse-join-columns>
                            <join-column id="Group_id" referenced-column-name="id" />
                        </inverse-join-columns>
                    </join-table>
                </many-to-many>
            </entity>
        </doctrine-mapping>

    .. code-block:: yaml

        User:
          type: entity
          manyToMany:
            groups:
              targetEntity: Group
              joinTable:
                name: User_Group
                joinColumns:
                  User_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  Group_id:
                    referencedColumnName: id

In that case, the name of the join table defaults to a combination
of the simple, unqualified class names of the participating
classes, separated by an underscore character. The names of the
join columns default to the simple, unqualified class name of the
targeted class followed by "\_id". The referencedColumnName always
defaults to "id", just as in one-to-one or many-to-one mappings.

If you accept these defaults, you can reduce the mapping code to a
minimum.

.. _collections:

Collections
-----------

Unfortunately, PHP arrays, while being great for many things, are missing
features that make them suitable for lazy loading in the context of an ORM.
This is why in all the examples of many-valued associations in this manual we
will make use of a ``Collection`` interface and its
default implementation ``ArrayCollection`` that are both defined in the
``Doctrine\Common\Collections`` namespace. A collection implements
the PHP interfaces ``ArrayAccess``, ``Traversable`` and ``Countable``.

.. note::

    The Collection interface and ArrayCollection class,
    like everything else in the Doctrine namespace, are neither part of
    the ORM, nor the DBAL, it is a plain PHP class that has no outside
    dependencies apart from dependencies on PHP itself (and the SPL).
    Therefore using this class in your model and elsewhere
    does not introduce a coupling to the ORM.

Initializing Collections
------------------------

You should always initialize the collections of your ``@OneToMany``
and ``@ManyToMany`` associations in the constructor of your entities:

.. code-block:: php

    <?php
    use Doctrine\Common\Collections\Collection;
    use Doctrine\Common\Collections\ArrayCollection;

    /** @Entity */
    class User
    {
        /**
         * Many Users have Many Groups.
         * @var Collection
         * @ManyToMany(targetEntity="Group")
         */
        private $groups;

        public function __construct()
        {
            $this->groups = new ArrayCollection();
        }

        public function getGroups()
        {
            return $this->groups;
        }
    }

The following code will then work even if the Entity hasn't
been associated with an EntityManager yet:

.. code-block:: php

    <?php
    $group = new Group();
    $user = new User();
    $user->getGroups()->add($group);
