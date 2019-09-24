Inheritance Mapping
===================

Mapped Superclasses
-------------------

A mapped superclass is an abstract or concrete class that provides
persistent entity state and mapping information for its subclasses,
but which is not itself an entity. Typically, the purpose of such a
mapped superclass is to define state and mapping information that
is common to multiple entity classes.

Mapped superclasses, just as regular, non-mapped classes, can
appear in the middle of an otherwise mapped inheritance hierarchy
(through Single Table Inheritance or Class Table Inheritance).

.. note::

    A mapped superclass cannot be an entity, it is not query-able and
    persistent relationships defined by a mapped superclass must be
    unidirectional (with an owning side only). This means that One-To-Many
    associations are not possible on a mapped superclass at all.
    Furthermore Many-To-Many associations are only possible if the
    mapped superclass is only used in exactly one entity at the moment.
    For further support of inheritance, the single or
    joined table inheritance features have to be used.


Example:

.. code-block:: php

    <?php
    /** @MappedSuperclass */
    class MappedSuperclassBase
    {
        /** @Column(type="integer") */
        protected $mapped1;
        /** @Column(type="string") */
        protected $mapped2;
        /**
         * @OneToOne(targetEntity="MappedSuperclassRelated1")
         * @JoinColumn(name="related1_id", referencedColumnName="id")
         */
        protected $mappedRelated1;
    
        // ... more fields and methods
    }
    
    /** @Entity */
    class EntitySubClass extends MappedSuperclassBase
    {
        /** @Id @Column(type="integer") */
        private $id;
        /** @Column(type="string") */
        private $name;
    
        // ... more fields and methods
    }

The DDL for the corresponding database schema would look something
like this (this is for SQLite):

.. code-block:: sql

    CREATE TABLE EntitySubClass (mapped1 INTEGER NOT NULL, mapped2 TEXT NOT NULL, id INTEGER NOT NULL, name TEXT NOT NULL, related1_id INTEGER DEFAULT NULL, PRIMARY KEY(id))

As you can see from this DDL snippet, there is only a single table
for the entity subclass. All the mappings from the mapped
superclass were inherited to the subclass as if they had been
defined on that class directly.

Single Table Inheritance
------------------------

`Single Table Inheritance <http://martinfowler.com/eaaCatalog/singleTableInheritance.html>`_
is an inheritance mapping strategy where all classes of a hierarchy
are mapped to a single database table. In order to distinguish
which row represents which type in the hierarchy a so-called
discriminator column is used.

Example:

.. configuration-block::

    .. code-block:: php
    
        <?php
        namespace MyProject\Model;
        
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
         */
        class Employee extends Person
        {
            // ...
        }

    .. code-block:: yaml
    
        MyProject\Model\Person:
          type: entity
          inheritanceType: SINGLE_TABLE
          discriminatorColumn:
            name: discr
            type: string
          discriminatorMap:
            person: Person
            employee: Employee
                
        MyProject\Model\Employee:
          type: entity
            
Things to note:


-  The @InheritanceType and @DiscriminatorColumn must be specified 
   on the topmost class that is part of the mapped entity hierarchy.
-  The @DiscriminatorMap specifies which values of the
   discriminator column identify a row as being of a certain type. In
   the case above a value of "person" identifies a row as being of
   type ``Person`` and "employee" identifies a row as being of type
   ``Employee``.
-  All entity classes that is part of the mapped entity hierarchy
   (including the topmost class) should be specified in the
   @DiscriminatorMap. In the case above Person class included.
-  The names of the classes in the discriminator map do not need to
   be fully qualified if the classes are contained in the same
   namespace as the entity class on which the discriminator map is
   applied.
-  If no discriminator map is provided, then the map is generated
   automatically. The automatically generated discriminator map 
   contains the lowercase short name of each class as key.

Design-time considerations
~~~~~~~~~~~~~~~~~~~~~~~~~~

This mapping approach works well when the type hierarchy is fairly
simple and stable. Adding a new type to the hierarchy and adding
fields to existing supertypes simply involves adding new columns to
the table, though in large deployments this may have an adverse
impact on the index and column layout inside the database.

Performance impact
~~~~~~~~~~~~~~~~~~

This strategy is very efficient for querying across all types in
the hierarchy or for specific types. No table joins are required,
only a WHERE clause listing the type identifiers. In particular,
relationships involving types that employ this mapping strategy are
very performing.

There is a general performance consideration with Single Table
Inheritance: If the target-entity of a many-to-one or one-to-one 
association is an STI entity, it is preferable for performance reasons that it 
be a leaf entity in the inheritance hierarchy, (ie. have no subclasses). 
Otherwise Doctrine *CANNOT* create proxy instances
of this entity and will *ALWAYS* load the entity eagerly.

SQL Schema considerations
~~~~~~~~~~~~~~~~~~~~~~~~~

For Single-Table-Inheritance to work in scenarios where you are
using either a legacy database schema or a self-written database
schema you have to make sure that all columns that are not in the
root entity but in any of the different sub-entities has to allows
null values. Columns that have NOT NULL constraints have to be on
the root entity of the single-table inheritance hierarchy.

Class Table Inheritance
-----------------------

`Class Table Inheritance <http://martinfowler.com/eaaCatalog/classTableInheritance.html>`_
is an inheritance mapping strategy where each class in a hierarchy
is mapped to several tables: its own table and the tables of all
parent classes. The table of a child class is linked to the table
of a parent class through a foreign key constraint. Doctrine 2
implements this strategy through the use of a discriminator column
in the topmost table of the hierarchy because this is the easiest
way to achieve polymorphic queries with Class Table Inheritance.

Example:

.. code-block:: php

    <?php
    namespace MyProject\Model;
    
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
    
    /** @Entity */
    class Employee extends Person
    {
        // ...
    }

Things to note:


-  The @InheritanceType, @DiscriminatorColumn and @DiscriminatorMap
   must be specified on the topmost class that is part of the mapped
   entity hierarchy.
-  The @DiscriminatorMap specifies which values of the
   discriminator column identify a row as being of which type. In the
   case above a value of "person" identifies a row as being of type
   ``Person`` and "employee" identifies a row as being of type
   ``Employee``.
-  The names of the classes in the discriminator map do not need to
   be fully qualified if the classes are contained in the same
   namespace as the entity class on which the discriminator map is
   applied.
-  If no discriminator map is provided, then the map is generated
   automatically. The automatically generated discriminator map 
   contains the lowercase short name of each class as key.

.. note::

    When you do not use the SchemaTool to generate the
    required SQL you should know that deleting a class table
    inheritance makes use of the foreign key property
    ``ON DELETE CASCADE`` in all database implementations. A failure to
    implement this yourself will lead to dead rows in the database.


Design-time considerations
~~~~~~~~~~~~~~~~~~~~~~~~~~

Introducing a new type to the hierarchy, at any level, simply
involves interjecting a new table into the schema. Subtypes of that
type will automatically join with that new type at runtime.
Similarly, modifying any entity type in the hierarchy by adding,
modifying or removing fields affects only the immediate table
mapped to that type. This mapping strategy provides the greatest
flexibility at design time, since changes to any type are always
limited to that type's dedicated table.

Performance impact
~~~~~~~~~~~~~~~~~~

This strategy inherently requires multiple JOIN operations to
perform just about any query which can have a negative impact on
performance, especially with large tables and/or large hierarchies.
When partial objects are allowed, either globally or on the
specific query, then querying for any type will not cause the
tables of subtypes to be OUTER JOINed which can increase
performance but the resulting partial objects will not fully load
themselves on access of any subtype fields, so accessing fields of
subtypes after such a query is not safe.

There is a general performance consideration with Class Table
Inheritance: If the target-entity of a many-to-one or one-to-one 
association is a CTI entity, it is preferable for performance reasons that it 
be a leaf entity in the inheritance hierarchy, (ie. have no subclasses). 
Otherwise Doctrine *CANNOT* create proxy instances
of this entity and will *ALWAYS* load the entity eagerly.

SQL Schema considerations
~~~~~~~~~~~~~~~~~~~~~~~~~

For each entity in the Class-Table Inheritance hierarchy all the
mapped fields have to be columns on the table of this entity.
Additionally each child table has to have an id column that matches
the id column definition on the root table (except for any sequence
or auto-increment details). Furthermore each child table has to
have a foreign key pointing from the id column to the root table id
column and cascading on delete.

.. _inheritence_mapping_overrides:

Overrides
---------
Used to override a mapping for an entity field or relationship.
May be applied to an entity that extends a mapped superclass
to override a relationship or field mapping defined by the mapped superclass.


Association Override
~~~~~~~~~~~~~~~~~~~~
Override a mapping for an entity relationship.

Could be used by an entity that extends a mapped superclass
to override a relationship mapping defined by the mapped superclass.

Example:

.. configuration-block::

    .. code-block:: php

        <?php
        // user mapping
        namespace MyProject\Model;
        /**
         * @MappedSuperclass
         */
        class User
        {
            //other fields mapping

            /**
             * @ManyToMany(targetEntity="Group", inversedBy="users")
             * @JoinTable(name="users_groups",
             *  joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
             *  inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")}
             * )
             */
            protected $groups;

            /**
             * @ManyToOne(targetEntity="Address")
             * @JoinColumn(name="address_id", referencedColumnName="id")
             */
            protected $address;
        }

        // admin mapping
        namespace MyProject\Model;
        /**
         * @Entity
         * @AssociationOverrides({
         *      @AssociationOverride(name="groups",
         *          joinTable=@JoinTable(
         *              name="users_admingroups",
         *              joinColumns=@JoinColumn(name="adminuser_id"),
         *              inverseJoinColumns=@JoinColumn(name="admingroup_id")
         *          )
         *      ),
         *      @AssociationOverride(name="address",
         *          joinColumns=@JoinColumn(
         *              name="adminaddress_id", referencedColumnName="id"
         *          )
         *      )
         * })
         */
        class Admin extends User
        {
        }

    .. code-block:: xml

        <!-- user mapping -->
        <doctrine-mapping>
          <mapped-superclass name="MyProject\Model\User">
                <!-- other fields mapping -->
                <many-to-many field="groups" target-entity="Group" inversed-by="users">
                    <cascade>
                        <cascade-persist/>
                        <cascade-merge/>
                        <cascade-detach/>
                    </cascade>
                    <join-table name="users_groups">
                        <join-columns>
                            <join-column name="user_id" referenced-column-name="id" />
                        </join-columns>
                        <inverse-join-columns>
                            <join-column name="group_id" referenced-column-name="id" />
                        </inverse-join-columns>
                    </join-table>
                </many-to-many>
            </mapped-superclass>
        </doctrine-mapping>

        <!-- admin mapping -->
        <doctrine-mapping>
            <entity name="MyProject\Model\Admin">
                <association-overrides>
                    <association-override name="groups">
                        <join-table name="users_admingroups">
                            <join-columns>
                                <join-column name="adminuser_id"/>
                            </join-columns>
                            <inverse-join-columns>
                                <join-column name="admingroup_id"/>
                            </inverse-join-columns>
                        </join-table>
                    </association-override>
                    <association-override name="address">
                        <join-columns>
                            <join-column name="adminaddress_id" referenced-column-name="id"/>
                        </join-columns>
                    </association-override>
                </association-overrides>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        # user mapping
        MyProject\Model\User:
          type: mappedSuperclass
          # other fields mapping
          manyToOne:
            address:
              targetEntity: Address
              joinColumn:
                name: address_id
                referencedColumnName: id
              cascade: [ persist, merge ]
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
              cascade: [ persist, merge, detach ]

        # admin mapping
        MyProject\Model\Admin:
          type: entity
          associationOverride:
            address:
              joinColumn:
                adminaddress_id:
                  name: adminaddress_id
                  referencedColumnName: id
            groups:
              joinTable:
                name: users_admingroups
                joinColumns:
                  adminuser_id:
                    referencedColumnName: id
                inverseJoinColumns:
                  admingroup_id:
                    referencedColumnName: id


Things to note:

-  The "association override" specifies the overrides base on the property name.
-  This feature is available for all kind of associations. (OneToOne, OneToMany, ManyToOne, ManyToMany)
-  The association type *CANNOT* be changed.
-  The override could redefine the joinTables or joinColumns depending on the association type.
-  The override could redefine inversedBy to reference more than one extended entity.
-  The override could redefine fetch to modify the fetch strategy of the extended entity.

Attribute Override
~~~~~~~~~~~~~~~~~~~~
Override the mapping of a field.

Could be used by an entity that extends a mapped superclass to override a field mapping defined by the mapped superclass.

.. configuration-block::

    .. code-block:: php

        <?php
        // user mapping
        namespace MyProject\Model;
        /**
         * @MappedSuperclass
         */
        class User
        {
            /** @Id @GeneratedValue @Column(type="integer", name="user_id", length=150) */
            protected $id;

            /** @Column(name="user_name", nullable=true, unique=false, length=250) */
            protected $name;

            // other fields mapping
        }

        // guest mapping
        namespace MyProject\Model;
        /**
         * @Entity
         * @AttributeOverrides({
         *      @AttributeOverride(name="id",
         *          column=@Column(
         *              name     = "guest_id",
         *              type     = "integer",
         *              length   = 140
         *          )
         *      ),
         *      @AttributeOverride(name="name",
         *          column=@Column(
         *              name     = "guest_name",
         *              nullable = false,
         *              unique   = true,
         *              length   = 240
         *          )
         *      )
         * })
         */
        class Guest extends User
        {
        }

    .. code-block:: xml

        <!-- user mapping -->
        <doctrine-mapping>
          <mapped-superclass name="MyProject\Model\User">
                <id name="id" type="integer" column="user_id" length="150">
                    <generator strategy="AUTO"/>
                </id>
                <field name="name" column="user_name" type="string" length="250" nullable="true" unique="false" />
                <many-to-one field="address" target-entity="Address">
                    <cascade>
                        <cascade-persist/>
                        <cascade-merge/>
                    </cascade>
                    <join-column name="address_id" referenced-column-name="id"/>
                </many-to-one>
                <!-- other fields mapping -->
            </mapped-superclass>
        </doctrine-mapping>

        <!-- admin mapping -->
        <doctrine-mapping>
            <entity name="MyProject\Model\Guest">
                <attribute-overrides>
                    <attribute-override name="id">
                        <field column="guest_id" length="140"/>
                    </attribute-override>
                    <attribute-override name="name">
                        <field column="guest_name" type="string" length="240" nullable="false" unique="true" />
                    </attribute-override>
                </attribute-overrides>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        # user mapping
        MyProject\Model\User:
          type: mappedSuperclass
          id:
            id:
              type: integer
              column: user_id
              length: 150
              generator:
                strategy: AUTO
          fields:
            name:
              type: string
              column: user_name
              length: 250
              nullable: true
              unique: false
          #other fields mapping


        # guest mapping
        MyProject\Model\Guest:
          type: entity
          attributeOverride:
            id:
              column: guest_id
              type: integer
              length: 140
            name:
              column: guest_name
              type: string
              length: 240
              nullable: false
              unique: true

Things to note:

-  The "attribute override" specifies the overrides base on the property name.
-  The column type *CANNOT* be changed. If the column type is not equal you get a ``MappingException``
-  The override can redefine all the columns except the type.

Query the Type
--------------

It may happen that the entities of a special type should be queried. Because there
is no direct access to the discriminator column, Doctrine provides the
``INSTANCE OF`` construct.

The following example shows how to use ``INSTANCE OF``. There is a three level hierarchy
with a base entity ``NaturalPerson`` which is extended by ``Staff`` which in turn
is extended by ``Technician``.

Querying for the staffs without getting any technicians can be achieved by this DQL:

.. code-block:: php

    <?php
    $query = $em->createQuery("SELECT staff FROM MyProject\Model\Staff staff WHERE staff NOT INSTANCE OF MyProject\Model\Technician");
    $staffs = $query->getResult();
