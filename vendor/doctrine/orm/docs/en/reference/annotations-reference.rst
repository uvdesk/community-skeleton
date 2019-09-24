Annotations Reference
=====================

You've probably used docblock annotations in some form already,
most likely to provide documentation metadata for a tool like
``PHPDocumentor`` (@author, @link, ...). Docblock annotations are a
tool to embed metadata inside the documentation section which can
then be processed by some tool. Doctrine 2 generalizes the concept
of docblock annotations so that they can be used for any kind of
metadata and so that it is easy to define new docblock annotations.
In order to allow more involved annotation values and to reduce the
chances of clashes with other docblock annotations, the Doctrine 2
docblock annotations feature an alternative syntax that is heavily
inspired by the Annotation syntax introduced in Java 5.

The implementation of these enhanced docblock annotations is
located in the ``Doctrine\Common\Annotations`` namespace and
therefore part of the Common package. Doctrine 2 docblock
annotations support namespaces and nested annotations among other
things. The Doctrine 2 ORM defines its own set of docblock
annotations for supplying object-relational mapping metadata.

.. note::

    If you're not comfortable with the concept of docblock
    annotations, don't worry, as mentioned earlier Doctrine 2 provides
    XML and YAML alternatives and you could easily implement your own
    favourite mechanism for defining ORM metadata.

In this chapter a reference of every Doctrine 2 Annotation is given
with short explanations on their context and usage.

Index
-----

-  :ref:`@Column <annref_column>`
-  :ref:`@ColumnResult <annref_column_result>`
-  :ref:`@Cache <annref_cache>`
-  :ref:`@ChangeTrackingPolicy <annref_changetrackingpolicy>`
-  :ref:`@CustomIdGenerator <annref_customidgenerator>`
-  :ref:`@DiscriminatorColumn <annref_discriminatorcolumn>`
-  :ref:`@DiscriminatorMap <annref_discriminatormap>`
-  :ref:`@Embeddable <annref_embeddable>`
-  :ref:`@Embedded <annref_embedded>`
-  :ref:`@Entity <annref_entity>`
-  :ref:`@EntityResult <annref_entity_result>`
-  :ref:`@FieldResult <annref_field_result>`
-  :ref:`@GeneratedValue <annref_generatedvalue>`
-  :ref:`@HasLifecycleCallbacks <annref_haslifecyclecallbacks>`
-  :ref:`@Index <annref_index>`
-  :ref:`@Id <annref_id>`
-  :ref:`@InheritanceType <annref_inheritancetype>`
-  :ref:`@JoinColumn <annref_joincolumn>`
-  :ref:`@JoinColumns <annref_joincolumns>`
-  :ref:`@JoinTable <annref_jointable>`
-  :ref:`@ManyToOne <annref_manytoone>`
-  :ref:`@ManyToMany <annref_manytomany>`
-  :ref:`@MappedSuperclass <annref_mappedsuperclass>`
-  :ref:`@NamedNativeQuery <annref_named_native_query>`
-  :ref:`@OneToOne <annref_onetoone>`
-  :ref:`@OneToMany <annref_onetomany>`
-  :ref:`@OrderBy <annref_orderby>`
-  :ref:`@PostLoad <annref_postload>`
-  :ref:`@PostPersist <annref_postpersist>`
-  :ref:`@PostRemove <annref_postremove>`
-  :ref:`@PostUpdate <annref_postupdate>`
-  :ref:`@PrePersist <annref_prepersist>`
-  :ref:`@PreRemove <annref_preremove>`
-  :ref:`@PreUpdate <annref_preupdate>`
-  :ref:`@SequenceGenerator <annref_sequencegenerator>`
-  :ref:`@SqlResultSetMapping <annref_sql_resultset_mapping>`
-  :ref:`@Table <annref_table>`
-  :ref:`@UniqueConstraint <annref_uniqueconstraint>`
-  :ref:`@Version <annref_version>`

Reference
---------

.. _annref_column:

@Column
~~~~~~~

Marks an annotated instance variable as "persistent". It has to be
inside the instance variables PHP DocBlock comment. Any value hold
inside this variable will be saved to and loaded from the database
as part of the lifecycle of the instance variables entity-class.

Required attributes:

-  **type**: Name of the Doctrine Type which is converted between PHP
   and Database representation.

Optional attributes:

-  **name**: By default the property name is used for the database
   column name also, however the 'name' attribute allows you to
   determine the column name.

-  **length**: Used by the "string" type to determine its maximum
   length in the database. Doctrine does not validate the length of a
   string values for you.

-  **precision**: The precision for a decimal (exact numeric) column
   (applies only for decimal column), which is the maximum number of
   digits that are stored for the values.

-  **scale**: The scale for a decimal (exact numeric) column (applies
   only for decimal column), which represents the number of digits
   to the right of the decimal point and must not be greater than
   *precision*.

-  **unique**: Boolean value to determine if the value of the column
   should be unique across all rows of the underlying entities table.

-  **nullable**: Determines if NULL values allowed for this column. If not specified, default value is false.

-  **options**: Array of additional options:

   -  ``default``: The default value to set for the column if no value
      is supplied.

   -  ``unsigned``: Boolean value to determine if the column should
      be capable of representing only non-negative integers
      (applies only for integer column and might not be supported by
      all vendors).

   -  ``fixed``: Boolean value to determine if the specified length of
      a string column should be fixed or varying (applies only for
      string/binary column and might not be supported by all vendors).

   -  ``comment``: The comment of the column in the schema (might not
      be supported by all vendors).

   -  ``collation``: The collation of the column (only supported by Drizzle, Mysql, PostgreSQL>=9.1, Sqlite and SQLServer).

   -  ``check``: Adds a check constraint type to the column (might not
      be supported by all vendors).

-  **columnDefinition**: DDL SQL snippet that starts after the column
   name and specifies the complete (non-portable!) column definition.
   This attribute allows to make use of advanced RMDBS features.
   However you should make careful use of this feature and the
   consequences. SchemaTool will not detect changes on the column correctly
   anymore if you use "columnDefinition".

   Additionally you should remember that the "type"
   attribute still handles the conversion between PHP and Database
   values. If you use this attribute on a column that is used for
   joins between tables you should also take a look at
   :ref:`@JoinColumn <annref_joincolumn>`.

.. note::

    For more detailed information on each attribute, please refer to
    the DBAL ``Schema-Representation`` documentation.

Examples:

.. code-block:: php

    <?php
    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @Column(type="string", columnDefinition="CHAR(2) NOT NULL")
     */
    protected $country;

    /**
     * @Column(type="decimal", precision=2, scale=1)
     */
    protected $height;

    /**
     * @Column(type="string", length=2, options={"fixed":true, "comment":"Initial letters of first and last name"})
     */
    protected $initials;

    /**
     * @Column(type="integer", name="login_count" nullable=false, options={"unsigned":true, "default":0})
     */
    protected $loginCount;

.. _annref_column_result:

@ColumnResult
~~~~~~~~~~~~~~
References name of a column in the SELECT clause of a SQL query.
Scalar result types can be included in the query result by specifying this annotation in the metadata.

Required attributes:

-  **name**: The name of a column in the SELECT clause of a SQL query

.. _annref_cache:

@Cache
~~~~~~~~~~~~~~
Add caching strategy to a root entity or a collection.

Optional attributes:

-  **usage**: One of ``READ_ONLY``, ``READ_WRITE`` or ``NONSTRICT_READ_WRITE``, By default this is ``READ_ONLY``.
-  **region**: An specific region name

.. _annref_changetrackingpolicy:

@ChangeTrackingPolicy
~~~~~~~~~~~~~~~~~~~~~

The Change Tracking Policy annotation allows to specify how the
Doctrine 2 UnitOfWork should detect changes in properties of
entities during flush. By default each entity is checked according
to a deferred implicit strategy, which means upon flush UnitOfWork
compares all the properties of an entity to a previously stored
snapshot. This works out of the box, however you might want to
tweak the flush performance where using another change tracking
policy is an interesting option.

The :doc:`details on all the available change tracking policies <change-tracking-policies>`
can be found in the configuration section.

Example:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @ChangeTrackingPolicy("DEFERRED_IMPLICIT")
     * @ChangeTrackingPolicy("DEFERRED_EXPLICIT")
     * @ChangeTrackingPolicy("NOTIFY")
     */
    class User {}

.. _annref_customidgenerator:

@CustomIdGenerator
~~~~~~~~~~~~~~~~~~~~~

This annotations allows you to specify a user-provided class to generate identifiers. This annotation only works when both :ref:`@Id <annref_id>` and :ref:`@GeneratedValue(strategy="CUSTOM") <annref_generatedvalue>` are specified.

Required attributes:

-  **class**: name of the class which should extend Doctrine\ORM\Id\AbstractIdGenerator

Example:

.. code-block:: php

    <?php
    /**
     * @Id 
     * @Column(type="integer")
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="My\Namespace\MyIdGenerator")
     */
    public $id;

.. _annref_discriminatorcolumn:

@DiscriminatorColumn
~~~~~~~~~~~~~~~~~~~~~

This annotation is an optional annotation for the topmost/super
class of an inheritance hierarchy. It specifies the details of the
column which saves the name of the class, which the entity is
actually instantiated as.

If this annotation is not specified, the discriminator column defaults
to a string column of length 255 called ``dtype``.

Required attributes:


-  **name**: The column name of the discriminator. This name is also
   used during Array hydration as key to specify the class-name.

Optional attributes:


-  **type**: By default this is string.
-  **length**: By default this is 255.

.. _annref_discriminatormap:

@DiscriminatorMap
~~~~~~~~~~~~~~~~~~~~~

The discriminator map is a required annotation on the
topmost/super class in an inheritance hierarchy. Its only argument is an
array which defines which class should be saved under
which name in the database. Keys are the database value and values
are the classes, either as fully- or as unqualified class names
depending on whether the classes are in the namespace or not.

.. code-block:: php

    <?php
    /**
     * @Entity
     * @InheritanceType("JOINED")
     * @DiscriminatorColumn(name="discr", type="string")
     * @DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
     */
    class Person
    {
        // ...
    }


.. _annref_embeddable:

@Embeddable
~~~~~~~~~~~~~~~~~~~~~

The embeddable annotation is required on a class, in order to make it
embeddable inside an entity. It works together with the :ref:`@Embedded <annref_embedded>`
annotation to establish the relationship between the two classes.

.. code-block:: php

    <?php

    /**
     * @Embeddable
     */
    class Address
    {
    // ...
    class User
    {
        /**
         * @Embedded(class = "Address")
         */
        private $address;


.. _annref_embedded:

@Embedded
~~~~~~~~~~~~~~~~~~~~~

The embedded annotation is required on an entity's member variable,
in order to specify that it is an embedded class.

Required attributes:

-  **class**: The embeddable class


.. code-block:: php

    <?php

    // ...
    class User
    {
        /**
         * @Embedded(class = "Address")
         */
        private $address;

    /**
     * @Embeddable
     */
    class Address
    {
    // ...


.. _annref_entity:

@Entity
~~~~~~~

Required annotation to mark a PHP class as an entity. Doctrine manages
the persistence of all classes marked as entities.

Optional attributes:


-  **repositoryClass**: Specifies the FQCN of a subclass of the
   EntityRepository. Use of repositories for entities is encouraged to keep
   specialized DQL and SQL operations separated from the Model/Domain
   Layer.
-  **readOnly**: (>= 2.1) Specifies that this entity is marked as read only and not
   considered for change-tracking. Entities of this type can be persisted
   and removed though.

Example:

.. code-block:: php

    <?php
    /**
     * @Entity(repositoryClass="MyProject\UserRepository")
     */
    class User
    {
        //...
    }

.. _annref_entity_result:

@EntityResult
~~~~~~~~~~~~~~
References an entity in the SELECT clause of a SQL query.
If this annotation is used, the SQL statement should select all of the columns that are mapped to the entity object.
This should include foreign key columns to related entities.
The results obtained when insufficient data is available are undefined.

Required attributes:

-  **entityClass**: The class of the result.

Optional attributes:

-  **fields**: Array of @FieldResult, Maps the columns specified in the SELECT list of the query to the properties or fields of the entity class.
-  **discriminatorColumn**: Specifies the column name of the column in the SELECT list that is used to determine the type of the entity instance.

.. _annref_field_result:

@FieldResult
~~~~~~~~~~~~~
Is used to map the columns specified in the SELECT list of the query to the properties or fields of the entity class.

Required attributes:

-  **name**: Name of the persistent field or property of the class.


Optional attributes:

-  **column**: Name of the column in the SELECT clause.

.. _annref_generatedvalue:

@GeneratedValue
~~~~~~~~~~~~~~~~~~~~~

Specifies which strategy is used for identifier generation for an
instance variable which is annotated by :ref:`@Id <annref_id>`. This
annotation is optional and only has meaning when used in
conjunction with @Id.

If this annotation is not specified with @Id the NONE strategy is
used as default.

Optional attributes:


-  **strategy**: Set the name of the identifier generation strategy.
   Valid values are AUTO, SEQUENCE, TABLE, IDENTITY, UUID, CUSTOM and NONE.
   If not specified, default value is AUTO.

Example:

.. code-block:: php

    <?php
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id = null;

.. _annref_haslifecyclecallbacks:

@HasLifecycleCallbacks
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Annotation which has to be set on the entity-class PHP DocBlock to
notify Doctrine that this entity has entity lifecycle callback
annotations set on at least one of its methods. Using @PostLoad,
@PrePersist, @PostPersist, @PreRemove, @PostRemove, @PreUpdate or
@PostUpdate without this marker annotation will make Doctrine
ignore the callbacks.

Example:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @HasLifecycleCallbacks
     */
    class User
    {
        /**
         * @PostPersist
         */
        public function sendOptinMail() {}
    }

.. _annref_index:

@Index
~~~~~~~

Annotation is used inside the :ref:`@Table <annref_table>` annotation on
the entity-class level. It provides a hint to the SchemaTool to
generate a database index on the specified table columns. It only
has meaning in the SchemaTool schema generation context.

Required attributes:


-  **name**: Name of the Index
-  **columns**: Array of columns.

Optional attributes:

-  **options**: Array of platform specific options:

   -  ``where``: SQL WHERE condition to be used for partial indexes. It will
      only have effect on supported platforms.

Basic example:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Table(name="ecommerce_products",indexes={@Index(name="search_idx", columns={"name", "email"})})
     */
    class ECommerceProduct
    {
    }

Example with partial indexes:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Table(name="ecommerce_products",indexes={@Index(name="search_idx", columns={"name", "email"}, options={"where": "(((id IS NOT NULL) AND (name IS NULL)) AND (email IS NULL))"})})
     */
    class ECommerceProduct
    {
    }

.. _annref_id:

@Id
~~~~~~~

The annotated instance variable will be marked as entity
identifier, the primary key in the database. This annotation is a
marker only and has no required or optional attributes. For
entities that have multiple identifier columns each column has to
be marked with @Id.

Example:

.. code-block:: php

    <?php
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $id = null;

.. _annref_inheritancetype:

@InheritanceType
~~~~~~~~~~~~~~~~~~~~~

In an inheritance hierarchy you have to use this annotation on the
topmost/super class to define which strategy should be used for
inheritance. Currently Single Table and Class Table Inheritance are
supported.

This annotation has always been used in conjunction with the
:ref:`@DiscriminatorMap <annref_discriminatormap>` and
:ref:`@DiscriminatorColumn <annref_discriminatorcolumn>` annotations.

Examples:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @InheritanceType("SINGLE_TABLE")
     * @DiscriminatorColumn(name="discr", type="string")
     * @DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
     */
    class Person
    {
        // ...
    }

    /**
     * @Entity
     * @InheritanceType("JOINED")
     * @DiscriminatorColumn(name="discr", type="string")
     * @DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
     */
    class Person
    {
        // ...
    }

.. _annref_joincolumn:

@JoinColumn
~~~~~~~~~~~~~~

This annotation is used in the context of relations in
:ref:`@ManyToOne <annref_manytoone>`, :ref:`@OneToOne <annref_onetoone>` fields
and in the Context of :ref:`@JoinTable <annref_jointable>` nested inside
a @ManyToMany. This annotation is not required. If it is not
specified the attributes *name* and *referencedColumnName* are
inferred from the table and primary key names.

Required attributes:


-  **name**: Column name that holds the foreign key identifier for
   this relation. In the context of @JoinTable it specifies the column
   name in the join table.
-  **referencedColumnName**: Name of the primary key identifier that
   is used for joining of this relation.

Optional attributes:


-  **unique**: Determines whether this relation is exclusive between the
   affected entities and should be enforced as such on the database
   constraint level. Defaults to false.
-  **nullable**: Determine whether the related entity is required, or if
   null is an allowed state for the relation. Defaults to true.
-  **onDelete**: Cascade Action (Database-level)
-  **columnDefinition**: DDL SQL snippet that starts after the column
   name and specifies the complete (non-portable!) column definition.
   This attribute enables the use of advanced RMDBS features. Using
   this attribute on @JoinColumn is necessary if you need slightly
   different column definitions for joining columns, for example
   regarding NULL/NOT NULL defaults. However by default a
   "columnDefinition" attribute on :ref:`@Column <annref_column>` also sets
   the related @JoinColumn's columnDefinition. This is necessary to
   make foreign keys work.

Example:

.. code-block:: php

    <?php
    /**
     * @OneToOne(targetEntity="Customer")
     * @JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

.. _annref_joincolumns:

@JoinColumns
~~~~~~~~~~~~~~

An array of @JoinColumn annotations for a
:ref:`@ManyToOne <annref_manytoone>` or :ref:`@OneToOne <annref_onetoone>`
relation with an entity that has multiple identifiers.

.. _annref_jointable:

@JoinTable
~~~~~~~~~~~~~~

Using :ref:`@OneToMany <annref_onetomany>` or
:ref:`@ManyToMany <annref_manytomany>` on the owning side of the relation
requires to specify the @JoinTable annotation which describes the
details of the database join table. If you do not specify
@JoinTable on these relations reasonable mapping defaults apply
using the affected table and the column names.

Optional attributes:


-  **name**: Database name of the join-table
-  **joinColumns**: An array of @JoinColumn annotations describing the
   join-relation between the owning entities table and the join table.
-  **inverseJoinColumns**: An array of @JoinColumn annotations
   describing the join-relation between the inverse entities table and
   the join table.

Example:

.. code-block:: php

    <?php
    /**
     * @ManyToMany(targetEntity="Phonenumber")
     * @JoinTable(name="users_phonenumbers",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="phonenumber_id", referencedColumnName="id", unique=true)}
     * )
     */
    public $phonenumbers;

.. _annref_manytoone:

@ManyToOne
~~~~~~~~~~~~~~

Defines that the annotated instance variable holds a reference that
describes a many-to-one relationship between two entities.

Required attributes:


-  **targetEntity**: FQCN of the referenced target entity. Can be the
   unqualified class name if both classes are in the same namespace.
   *IMPORTANT:* No leading backslash!

Optional attributes:


-  **cascade**: Cascade Option
-  **fetch**: One of LAZY or EAGER
-  inversedBy - The inversedBy attribute designates the field in
   the entity that is the inverse side of the relationship.

Example:

.. code-block:: php

    <?php
    /**
     * @ManyToOne(targetEntity="Cart", cascade={"all"}, fetch="EAGER")
     */
    private $cart;

.. _annref_manytomany:

@ManyToMany
~~~~~~~~~~~~~~

Defines that the annotated instance variable holds a many-to-many relationship
between two entities. :ref:`@JoinTable <annref_jointable>` is an
additional, optional annotation that has reasonable default
configuration values using the table and names of the two related
entities.

Required attributes:


-  **targetEntity**: FQCN of the referenced target entity. Can be the
   unqualified class name if both classes are in the same namespace.
   *IMPORTANT:* No leading backslash!

Optional attributes:


-  **mappedBy**: This option specifies the property name on the
   targetEntity that is the owning side of this relation. It is a
   required attribute for the inverse side of a relationship.
-  **inversedBy**: The inversedBy attribute designates the field in the
   entity that is the inverse side of the relationship.
-  **cascade**: Cascade Option
-  **fetch**: One of LAZY, EXTRA_LAZY or EAGER
-  **indexBy**: Index the collection by a field on the target entity.

.. note::

    For ManyToMany bidirectional relationships either side may
    be the owning side (the side that defines the @JoinTable and/or
    does not make use of the mappedBy attribute, thus using a default
    join table).

Example:

.. code-block:: php

    <?php
    /**
     * Owning Side
     *
     * @ManyToMany(targetEntity="Group", inversedBy="features")
     * @JoinTable(name="user_groups",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    private $groups;

    /**
     * Inverse Side
     *
     * @ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $features;

.. _annref_mappedsuperclass:

@MappedSuperclass
~~~~~~~~~~~~~~~~~~~~~

A mapped superclass is an abstract or concrete class that provides
persistent entity state and mapping information for its subclasses,
but which is not itself an entity. This annotation is specified on
the Class docblock and has no additional attributes.

The @MappedSuperclass annotation cannot be used in conjunction with
@Entity. See the Inheritance Mapping section for
:doc:`more details on the restrictions of mapped superclasses <inheritance-mapping>`.

Optional attributes:


-  **repositoryClass**: (>= 2.2) Specifies the FQCN of a subclass of the EntityRepository.
   That will be inherited for all subclasses of that Mapped Superclass.

Example:

.. code-block:: php

    <?php
    /**
     * @MappedSuperclass
     */
    class MappedSuperclassBase
    {
        // ... fields and methods
    }

    /**
     * @Entity
     */
    class EntitySubClassFoo extends MappedSuperclassBase
    {
        // ... fields and methods
    }

.. _annref_named_native_query:

@NamedNativeQuery
~~~~~~~~~~~~~~~~~
Is used to specify a native SQL named query.
The NamedNativeQuery annotation can be applied to an entity or mapped superclass.

Required attributes:

-  **name**: The name used to refer to the query with the EntityManager methods that create query objects.
-  **query**: The SQL query string.


Optional attributes:

-  **resultClass**: The class of the result.
-  **resultSetMapping**: The name of a SqlResultSetMapping, as defined in metadata.


Example:

.. code-block:: php

    <?php
    /**
     * @NamedNativeQueries({
     *      @NamedNativeQuery(
     *          name            = "fetchJoinedAddress",
     *          resultSetMapping= "mappingJoinedAddress",
     *          query           = "SELECT u.id, u.name, u.status, a.id AS a_id, a.country, a.zip, a.city FROM cms_users u INNER JOIN cms_addresses a ON u.id = a.user_id WHERE u.username = ?"
     *      ),
     * })
     * @SqlResultSetMappings({
     *      @SqlResultSetMapping(
     *          name    = "mappingJoinedAddress",
     *          entities= {
     *              @EntityResult(
     *                  entityClass = "__CLASS__",
     *                  fields      = {
     *                      @FieldResult(name = "id"),
     *                      @FieldResult(name = "name"),
     *                      @FieldResult(name = "status"),
     *                      @FieldResult(name = "address.zip"),
     *                      @FieldResult(name = "address.city"),
     *                      @FieldResult(name = "address.country"),
     *                      @FieldResult(name = "address.id", column = "a_id"),
     *                  }
     *              )
     *          }
     *      )
     * })
     */
    class User
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        public $id;

        /** @Column(type="string", length=50, nullable=true) */
        public $status;

        /** @Column(type="string", length=255, unique=true) */
        public $username;

        /** @Column(type="string", length=255) */
        public $name;

        /** @OneToOne(targetEntity="Address") */
        public $address;

        // ....
    }
.. _annref_onetoone:

@OneToOne
~~~~~~~~~~~~~~

The @OneToOne annotation works almost exactly as the
:ref:`@ManyToOne <annref_manytoone>` with one additional option which can
be specified. The configuration defaults for
:ref:`@JoinColumn <annref_joincolumn>` using the target entity table and
primary key column names apply here too.

Required attributes:


-  **targetEntity**: FQCN of the referenced target entity. Can be the
   unqualified class name if both classes are in the same namespace.
   *IMPORTANT:* No leading backslash!

Optional attributes:


-  **cascade**: Cascade Option
-  **fetch**: One of LAZY or EAGER
-  **orphanRemoval**: Boolean that specifies if orphans, inverse
   OneToOne entities that are not connected to any owning instance,
   should be removed by Doctrine. Defaults to false.
-  **inversedBy**: The inversedBy attribute designates the field in the
   entity that is the inverse side of the relationship.

Example:

.. code-block:: php

    <?php
    /**
     * @OneToOne(targetEntity="Customer")
     * @JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

.. _annref_onetomany:

@OneToMany
~~~~~~~~~~~~~~

Required attributes:


-  **targetEntity**: FQCN of the referenced target entity. Can be the
   unqualified class name if both classes are in the same namespace.
   *IMPORTANT:* No leading backslash!

Optional attributes:


-  **cascade**: Cascade Option
-  **orphanRemoval**: Boolean that specifies if orphans, inverse
   OneToOne entities that are not connected to any owning instance,
   should be removed by Doctrine. Defaults to false.
-  **mappedBy**: This option specifies the property name on the
   targetEntity that is the owning side of this relation. Its a
   required attribute for the inverse side of a relationship.
-  **fetch**: One of LAZY, EXTRA_LAZY or EAGER.
-  **indexBy**: Index the collection by a field on the target entity.

Example:

.. code-block:: php

    <?php
    /**
     * @OneToMany(targetEntity="Phonenumber", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    public $phonenumbers;

.. _annref_orderby:

@OrderBy
~~~~~~~~~~~~~~

Optional annotation that can be specified with a
:ref:`@ManyToMany <annref_manytomany>` or :ref:`@OneToMany <annref_onetomany>`
annotation to specify by which criteria the collection should be
retrieved from the database by using an ORDER BY clause.

This annotation requires a single non-attributed value with an DQL
snippet:

Example:

.. code-block:: php

    <?php
    /**
     * @ManyToMany(targetEntity="Group")
     * @OrderBy({"name" = "ASC"})
     */
    private $groups;

The DQL Snippet in OrderBy is only allowed to consist of
unqualified, unquoted field names and of an optional ASC/DESC
positional statement. Multiple Fields are separated by a comma (,).
The referenced field names have to exist on the ``targetEntity``
class of the ``@ManyToMany`` or ``@OneToMany`` annotation.

.. _annref_postload:

@PostLoad
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PostLoad event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_postpersist:

@PostPersist
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PostPersist event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_postremove:

@PostRemove
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PostRemove event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_postupdate:

@PostUpdate
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PostUpdate event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_prepersist:

@PrePersist
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PrePersist event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_preremove:

@PreRemove
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PreRemove event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_preupdate:

@PreUpdate
~~~~~~~~~~~~~~

Marks a method on the entity to be called as a @PreUpdate event.
Only works with @HasLifecycleCallbacks in the entity class PHP
DocBlock.

.. _annref_sequencegenerator:

@SequenceGenerator
~~~~~~~~~~~~~~~~~~~~~

For use with @GeneratedValue(strategy="SEQUENCE") this
annotation allows to specify details about the sequence, such as
the increment size and initial values of the sequence.

Required attributes:


-  **sequenceName**: Name of the sequence

Optional attributes:


-  **allocationSize**: Increment the sequence by the allocation size
   when its fetched. A value larger than 1 allows optimization for
   scenarios where you create more than one new entity per request.
   Defaults to 10
-  **initialValue**: Where the sequence starts, defaults to 1.

Example:

.. code-block:: php

    <?php
    /**
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @Column(type="integer")
     * @SequenceGenerator(sequenceName="tablename_seq", initialValue=1, allocationSize=100)
     */
    protected $id = null;

.. _annref_sql_resultset_mapping:

@SqlResultSetMapping
~~~~~~~~~~~~~~~~~~~~
The SqlResultSetMapping annotation is used to specify the mapping of the result of a native SQL query.
The SqlResultSetMapping annotation can be applied to an entity or mapped superclass.

Required attributes:

-  **name**: The name given to the result set mapping, and used to refer to it in the methods of the Query API.


Optional attributes:

-  **entities**: Array of @EntityResult, Specifies the result set mapping to entities.
-  **columns**: Array of @ColumnResult, Specifies the result set mapping to scalar values.

Example:

.. code-block:: php

    <?php
    /**
     * @NamedNativeQueries({
     *      @NamedNativeQuery(
     *          name            = "fetchUserPhonenumberCount",
     *          resultSetMapping= "mappingUserPhonenumberCount",
     *          query           = "SELECT id, name, status, COUNT(phonenumber) AS numphones FROM cms_users INNER JOIN cms_phonenumbers ON id = user_id WHERE username IN (?) GROUP BY id, name, status, username ORDER BY username"
     *      ),
     *      @NamedNativeQuery(
     *          name            = "fetchMultipleJoinsEntityResults",
     *          resultSetMapping= "mappingMultipleJoinsEntityResults",
     *          query           = "SELECT u.id AS u_id, u.name AS u_name, u.status AS u_status, a.id AS a_id, a.zip AS a_zip, a.country AS a_country, COUNT(p.phonenumber) AS numphones FROM cms_users u INNER JOIN cms_addresses a ON u.id = a.user_id INNER JOIN cms_phonenumbers p ON u.id = p.user_id GROUP BY u.id, u.name, u.status, u.username, a.id, a.zip, a.country ORDER BY u.username"
     *      ),
     * })
     * @SqlResultSetMappings({
     *      @SqlResultSetMapping(
     *          name    = "mappingUserPhonenumberCount",
     *          entities= {
     *              @EntityResult(
     *                  entityClass = "User",
     *                  fields      = {
     *                      @FieldResult(name = "id"),
     *                      @FieldResult(name = "name"),
     *                      @FieldResult(name = "status"),
     *                  }
     *              )
     *          },
     *          columns = {
     *              @ColumnResult("numphones")
     *          }
     *      ),
     *      @SqlResultSetMapping(
     *          name    = "mappingMultipleJoinsEntityResults",
     *          entities= {
     *              @EntityResult(
     *                  entityClass = "__CLASS__",
     *                  fields      = {
     *                      @FieldResult(name = "id",       column="u_id"),
     *                      @FieldResult(name = "name",     column="u_name"),
     *                      @FieldResult(name = "status",   column="u_status"),
     *                  }
     *              ),
     *              @EntityResult(
     *                  entityClass = "Address",
     *                  fields      = {
     *                      @FieldResult(name = "id",       column="a_id"),
     *                      @FieldResult(name = "zip",      column="a_zip"),
     *                      @FieldResult(name = "country",  column="a_country"),
     *                  }
     *              )
     *          },
     *          columns = {
     *              @ColumnResult("numphones")
     *          }
     *      )
     *})
     */
     class User
    {
        /** @Id @Column(type="integer") @GeneratedValue */
        public $id;

        /** @Column(type="string", length=50, nullable=true) */
        public $status;

        /** @Column(type="string", length=255, unique=true) */
        public $username;

        /** @Column(type="string", length=255) */
        public $name;

        /** @OneToMany(targetEntity="Phonenumber") */
        public $phonenumbers;

        /** @OneToOne(targetEntity="Address") */
        public $address;

        // ....
    }
.. _annref_table:

@Table
~~~~~~~

Annotation describes the table an entity is persisted in. It is
placed on the entity-class PHP DocBlock and is optional. If it is
not specified the table name will default to the entity's
unqualified classname.

Required attributes:


-  **name**: Name of the table

Optional attributes:


-  **indexes**: Array of @Index annotations
-  **uniqueConstraints**: Array of @UniqueConstraint annotations.
-  **schema**: (>= 2.5) Name of the schema the table lies in.

Example:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Table(name="user",
     *      uniqueConstraints={@UniqueConstraint(name="user_unique",columns={"username"})},
     *      indexes={@Index(name="user_idx", columns={"email"})}
     *      schema="schema_name"
     * )
     */
    class User { }

.. _annref_uniqueconstraint:

@UniqueConstraint
~~~~~~~~~~~~~~~~~~~~~

Annotation is used inside the :ref:`@Table <annref_table>` annotation on
the entity-class level. It allows to hint the SchemaTool to
generate a database unique constraint on the specified table
columns. It only has meaning in the SchemaTool schema generation
context.

Required attributes:


-  **name**: Name of the Index
-  **columns**: Array of columns.

Optional attributes:

-  **options**: Array of platform specific options:

   -  ``where``: SQL WHERE condition to be used for partial indexes. It will
      only have effect on supported platforms.

Basic example:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Table(name="ecommerce_products",uniqueConstraints={@UniqueConstraint(name="search_idx", columns={"name", "email"})})
     */
    class ECommerceProduct
    {
    }

Example with partial indexes:

.. code-block:: php

    <?php
    /**
     * @Entity
     * @Table(name="ecommerce_products",uniqueConstraints={@UniqueConstraint(name="search_idx", columns={"name", "email"}, options={"where": "(((id IS NOT NULL) AND (name IS NULL)) AND (email IS NULL))"})})
     */
    class ECommerceProduct
    {
    }

.. _annref_version:

@Version
~~~~~~~~

Marker annotation that defines a specified column as version attribute used in
an :ref:`optimistic locking <transactions-and-concurrency_optimistic-locking>`
scenario. It only works on :ref:`@Column <annref_column>` annotations that have
the type ``integer`` or ``datetime``. Combining ``@Version`` with
:ref:`@Id <annref_id>` is not supported.

Example:

.. code-block:: php

    <?php
    /**
     * @Column(type="integer")
     * @Version
     */
    protected $version;

