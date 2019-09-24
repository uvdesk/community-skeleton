Native SQL
==========

With ``NativeQuery`` you can execute native SELECT SQL statements
and map the results to Doctrine entities or any other result format
supported by Doctrine.

In order to make this mapping possible, you need to describe
to Doctrine what columns in the result map to which entity property.
This description is represented by a ``ResultSetMapping`` object.

With this feature you can map arbitrary SQL code to objects, such as highly
vendor-optimized SQL or stored-procedures.

Writing ``ResultSetMapping`` from scratch is complex, but there is a convenience
wrapper around it called a ``ResultSetMappingBuilder``. It can generate
the mappings for you based on Entities and even generates the ``SELECT``
clause based on this information for you.

.. note::

    If you want to execute DELETE, UPDATE or INSERT statements
    the Native SQL API cannot be used and will probably throw errors.
    Use ``EntityManager#getConnection()`` to access the native database
    connection and call the ``executeUpdate()`` method for these
    queries.

The NativeQuery class
---------------------

To create a ``NativeQuery`` you use the method
``EntityManager#createNativeQuery($sql, $resultSetMapping)``. As you can see in
the signature of this method, it expects 2 ingredients: The SQL you want to
execute and the ``ResultSetMapping`` that describes how the results will be
mapped.

Once you obtained an instance of a ``NativeQuery``, you can bind parameters to
it with the same API that ``Query`` has and execute it.

.. code-block:: php

    <?php
    use Doctrine\ORM\Query\ResultSetMapping;

    $rsm = new ResultSetMapping();
    // build rsm here

    $query = $entityManager->createNativeQuery('SELECT id, name, discr FROM users WHERE name = ?', $rsm);
    $query->setParameter(1, 'romanb');

    $users = $query->getResult();

ResultSetMappingBuilder
-----------------------

An easy start into ResultSet mapping is the ``ResultSetMappingBuilder`` object.
This has several benefits:

- The builder takes care of automatically updating your ``ResultSetMapping``
  when the fields or associations change on the metadata of an entity.
- You can generate the required ``SELECT`` expression for a builder
  by converting it to a string.
- The API is much simpler than the usual ``ResultSetMapping`` API.

One downside is that the builder API does not yet support entities
with inheritance hierarchies.

.. code-block:: php

    <?php

    use Doctrine\ORM\Query\ResultSetMappingBuilder;

    $sql = "SELECT u.id, u.name, a.id AS address_id, a.street, a.city " . 
           "FROM users u INNER JOIN address a ON u.address_id = a.id";

    $rsm = new ResultSetMappingBuilder($entityManager);
    $rsm->addRootEntityFromClassMetadata('MyProject\User', 'u');
    $rsm->addJoinedEntityFromClassMetadata('MyProject\Address', 'a', 'u', 'address', array('id' => 'address_id'));

The builder extends the ``ResultSetMapping`` class and as such has all the functionality of it as well.

.. versionadded:: 2.4

Starting with Doctrine ORM 2.4 you can generate the ``SELECT`` clause
from a ``ResultSetMappingBuilder``. You can either cast the builder
object to ``(string)`` and the DQL aliases are used as SQL table aliases
or use the ``generateSelectClause($tableAliases)`` method and pass
a mapping from DQL alias (key) to SQL alias (value)

.. code-block:: php

    <?php

    $selectClause = $builder->generateSelectClause(array(
        'u' => 't1',
        'g' => 't2'
    ));
    $sql = "SELECT " . $selectClause . " FROM users t1 JOIN groups t2 ON t1.group_id = t2.id";


The ResultSetMapping
--------------------

Understanding the ``ResultSetMapping`` is the key to using a
``NativeQuery``. A Doctrine result can contain the following
components:


-  Entity results. These represent root result elements.
-  Joined entity results. These represent joined entities in
   associations of root entity results.
-  Field results. These represent a column in the result set that
   maps to a field of an entity. A field result always belongs to an
   entity result or joined entity result.
-  Scalar results. These represent scalar values in the result set
   that will appear in each result row. Adding scalar results to a
   ResultSetMapping can also cause the overall result to become
   **mixed** (see DQL - Doctrine Query Language) if the same
   ResultSetMapping also contains entity results.
-  Meta results. These represent columns that contain
   meta-information, such as foreign keys and discriminator columns.
   When querying for objects (``getResult()``), all meta columns of
   root entities or joined entities must be present in the SQL query
   and mapped accordingly using ``ResultSetMapping#addMetaResult``.

.. note::

    It might not surprise you that Doctrine uses
    ``ResultSetMapping`` internally when you create DQL queries. As
    the query gets parsed and transformed to SQL, Doctrine fills a
    ``ResultSetMapping`` that describes how the results should be
    processed by the hydration routines.


We will now look at each of the result types that can appear in a
ResultSetMapping in detail.

Entity results
~~~~~~~~~~~~~~

An entity result describes an entity type that appears as a root
element in the transformed result. You add an entity result through
``ResultSetMapping#addEntityResult()``. Let's take a look at the
method signature in detail:

.. code-block:: php

    <?php
    /**
     * Adds an entity result to this ResultSetMapping.
     *
     * @param string $class The class name of the entity.
     * @param string $alias The alias for the class. The alias must be unique among all entity
     *                      results or joined entity results within this ResultSetMapping.
     */
    public function addEntityResult($class, $alias)

The first parameter is the fully qualified name of the entity
class. The second parameter is some arbitrary alias for this entity
result that must be unique within a ``ResultSetMapping``. You use
this alias to attach field results to the entity result. It is very
similar to an identification variable that you use in DQL to alias
classes or relationships.

An entity result alone is not enough to form a valid
``ResultSetMapping``. An entity result or joined entity result
always needs a set of field results, which we will look at soon.

Joined entity results
~~~~~~~~~~~~~~~~~~~~~

A joined entity result describes an entity type that appears as a
joined relationship element in the transformed result, attached to
a (root) entity result. You add a joined entity result through
``ResultSetMapping#addJoinedEntityResult()``. Let's take a look at
the method signature in detail:

.. code-block:: php

    <?php
    /**
     * Adds a joined entity result.
     *
     * @param string $class The class name of the joined entity.
     * @param string $alias The unique alias to use for the joined entity.
     * @param string $parentAlias The alias of the entity result that is the parent of this joined result.
     * @param object $relation The association field that connects the parent entity result with the joined entity result.
     */
    public function addJoinedEntityResult($class, $alias, $parentAlias, $relation)

The first parameter is the class name of the joined entity. The
second parameter is an arbitrary alias for the joined entity that
must be unique within the ``ResultSetMapping``. You use this alias
to attach field results to the entity result. The third parameter
is the alias of the entity result that is the parent type of the
joined relationship. The fourth and last parameter is the name of
the field on the parent entity result that should contain the
joined entity result.

Field results
~~~~~~~~~~~~~

A field result describes the mapping of a single column in a SQL
result set to a field in an entity. As such, field results are
inherently bound to entity results. You add a field result through
``ResultSetMapping#addFieldResult()``. Again, let's examine the
method signature in detail:

.. code-block:: php

    <?php
    /**
     * Adds a field result that is part of an entity result or joined entity result.
     *
     * @param string $alias The alias of the entity result or joined entity result.
     * @param string $columnName The name of the column in the SQL result set.
     * @param string $fieldName The name of the field on the (joined) entity.
     */
    public function addFieldResult($alias, $columnName, $fieldName)

The first parameter is the alias of the entity result to which the
field result will belong. The second parameter is the name of the
column in the SQL result set. Note that this name is case
sensitive, i.e. if you use a native query against Oracle it must be
all uppercase. The third parameter is the name of the field on the
entity result identified by ``$alias`` into which the value of the
column should be set.

Scalar results
~~~~~~~~~~~~~~

A scalar result describes the mapping of a single column in a SQL
result set to a scalar value in the Doctrine result. Scalar results
are typically used for aggregate values but any column in the SQL
result set can be mapped as a scalar value. To add a scalar result
use ``ResultSetMapping#addScalarResult()``. The method signature in
detail:

.. code-block:: php

    <?php
    /**
     * Adds a scalar result mapping.
     *
     * @param string $columnName The name of the column in the SQL result set.
     * @param string $alias The result alias with which the scalar result should be placed in the result structure.
     */
    public function addScalarResult($columnName, $alias)

The first parameter is the name of the column in the SQL result set
and the second parameter is the result alias under which the value
of the column will be placed in the transformed Doctrine result.

Meta results
~~~~~~~~~~~~

A meta result describes a single column in a SQL result set that
is either a foreign key or a discriminator column. These columns
are essential for Doctrine to properly construct objects out of SQL
result sets. To add a column as a meta result use
``ResultSetMapping#addMetaResult()``. The method signature in
detail:

.. code-block:: php

    <?php
    /**
     * Adds a meta column (foreign key or discriminator column) to the result set.
     * 
     * @param string  $alias
     * @param string  $columnAlias
     * @param string  $columnName
     * @param boolean $isIdentifierColumn
     */
    public function addMetaResult($alias, $columnAlias, $columnName, $isIdentifierColumn = false)

The first parameter is the alias of the entity result to which the
meta column belongs. A meta result column (foreign key or
discriminator column) always belongs to an entity result. The
second parameter is the column alias/name of the column in the SQL
result set and the third parameter is the column name used in the
mapping.
The fourth parameter should be set to true in case the primary key
of the entity is the foreign key you're adding.

Discriminator Column
~~~~~~~~~~~~~~~~~~~~

When joining an inheritance tree you have to give Doctrine a hint
which meta-column is the discriminator column of this tree.

.. code-block:: php

    <?php
    /**
     * Sets a discriminator column for an entity result or joined entity result.
     * The discriminator column will be used to determine the concrete class name to
     * instantiate.
     *
     * @param string $alias The alias of the entity result or joined entity result the discriminator
     *                      column should be used for.
     * @param string $discrColumn The name of the discriminator column in the SQL result set.
     */
    public function setDiscriminatorColumn($alias, $discrColumn)

Examples
~~~~~~~~

Understanding a ResultSetMapping is probably easiest through
looking at some examples.

First a basic example that describes the mapping of a single
entity.

.. code-block:: php

    <?php
    // Equivalent DQL query: "select u from User u where u.name=?1"
    // User owns no associations.
    $rsm = new ResultSetMapping;
    $rsm->addEntityResult('User', 'u');
    $rsm->addFieldResult('u', 'id', 'id');
    $rsm->addFieldResult('u', 'name', 'name');
    
    $query = $this->_em->createNativeQuery('SELECT id, name FROM users WHERE name = ?', $rsm);
    $query->setParameter(1, 'romanb');
    
    $users = $query->getResult();

The result would look like this:

.. code-block:: php

    array(
        [0] => User (Object)
    )

Note that this would be a partial object if the entity has more
fields than just id and name. In the example above the column and
field names are identical but that is not necessary, of course.
Also note that the query string passed to createNativeQuery is
**real native SQL**. Doctrine does not touch this SQL in any way.

In the previous basic example, a User had no relations and the
table the class is mapped to owns no foreign keys. The next example
assumes User has a unidirectional or bidirectional one-to-one
association to a CmsAddress, where the User is the owning side and
thus owns the foreign key.

.. code-block:: php

    <?php
    // Equivalent DQL query: "select u from User u where u.name=?1"
    // User owns an association to an Address but the Address is not loaded in the query.
    $rsm = new ResultSetMapping;
    $rsm->addEntityResult('User', 'u');
    $rsm->addFieldResult('u', 'id', 'id');
    $rsm->addFieldResult('u', 'name', 'name');
    $rsm->addMetaResult('u', 'address_id', 'address_id');
    
    $query = $this->_em->createNativeQuery('SELECT id, name, address_id FROM users WHERE name = ?', $rsm);
    $query->setParameter(1, 'romanb');
    
    $users = $query->getResult();

Foreign keys are used by Doctrine for lazy-loading purposes when
querying for objects. In the previous example, each user object in
the result will have a proxy (a "ghost") in place of the address
that contains the address\_id. When the ghost proxy is accessed, it
loads itself based on this key.

Consequently, associations that are *fetch-joined* do not require
the foreign keys to be present in the SQL result set, only
associations that are lazy.

.. code-block:: php

    <?php
    // Equivalent DQL query: "select u from User u join u.address a WHERE u.name = ?1"
    // User owns association to an Address and the Address is loaded in the query.
    $rsm = new ResultSetMapping;
    $rsm->addEntityResult('User', 'u');
    $rsm->addFieldResult('u', 'id', 'id');
    $rsm->addFieldResult('u', 'name', 'name');
    $rsm->addJoinedEntityResult('Address' , 'a', 'u', 'address');
    $rsm->addFieldResult('a', 'address_id', 'id');
    $rsm->addFieldResult('a', 'street', 'street');
    $rsm->addFieldResult('a', 'city', 'city');
    
    $sql = 'SELECT u.id, u.name, a.id AS address_id, a.street, a.city FROM users u ' .
           'INNER JOIN address a ON u.address_id = a.id WHERE u.name = ?';
    $query = $this->_em->createNativeQuery($sql, $rsm);
    $query->setParameter(1, 'romanb');
    
    $users = $query->getResult();

In this case the nested entity ``Address`` is registered with the
``ResultSetMapping#addJoinedEntityResult`` method, which notifies
Doctrine that this entity is not hydrated at the root level, but as
a joined entity somewhere inside the object graph. In this case we
specify the alias 'u' as third parameter and ``address`` as fourth
parameter, which means the ``Address`` is hydrated into the
``User::$address`` property.

If a fetched entity is part of a mapped hierarchy that requires a
discriminator column, this column must be present in the result set
as a meta column so that Doctrine can create the appropriate
concrete type. This is shown in the following example where we
assume that there are one or more subclasses that extend User and
either Class Table Inheritance or Single Table Inheritance is used
to map the hierarchy (both use a discriminator column).

.. code-block:: php

    <?php
    // Equivalent DQL query: "select u from User u where u.name=?1"
    // User is a mapped base class for other classes. User owns no associations.
    $rsm = new ResultSetMapping;
    $rsm->addEntityResult('User', 'u');
    $rsm->addFieldResult('u', 'id', 'id');
    $rsm->addFieldResult('u', 'name', 'name');
    $rsm->addMetaResult('u', 'discr', 'discr'); // discriminator column
    $rsm->setDiscriminatorColumn('u', 'discr');
    
    $query = $this->_em->createNativeQuery('SELECT id, name, discr FROM users WHERE name = ?', $rsm);
    $query->setParameter(1, 'romanb');
    
    $users = $query->getResult();

Note that in the case of Class Table Inheritance, an example as
above would result in partial objects if any objects in the result
are actually a subtype of User. When using DQL, Doctrine
automatically includes the necessary joins for this mapping
strategy but with native SQL it is your responsibility.

Named Native Query
------------------

You can also map a native query using a named native query mapping.

To achieve that, you must describe the SQL resultset structure
using named native query (and sql resultset mappings if is a several resultset mappings).

Like named query, a named native query can be defined at class level or in a XML or YAML file.


A resultSetMapping parameter is defined in @NamedNativeQuery,
it represents the name of a defined @SqlResultSetMapping.

.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Model;
        /**
         * @NamedNativeQueries({
         *      @NamedNativeQuery(
         *          name            = "fetchMultipleJoinsEntityResults",
         *          resultSetMapping= "mappingMultipleJoinsEntityResults",
         *          query           = "SELECT u.id AS u_id, u.name AS u_name, u.status AS u_status, a.id AS a_id, a.zip AS a_zip, a.country AS a_country, COUNT(p.phonenumber) AS numphones FROM users u INNER JOIN addresses a ON u.id = a.user_id INNER JOIN phonenumbers p ON u.id = p.user_id GROUP BY u.id, u.name, u.status, u.username, a.id, a.zip, a.country ORDER BY u.username"
         *      ),
         * })
         * @SqlResultSetMappings({
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

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Model\User">
                <named-native-queries>
                    <named-native-query name="fetchMultipleJoinsEntityResults" result-set-mapping="mappingMultipleJoinsEntityResults">
                        <query>SELECT u.id AS u_id, u.name AS u_name, u.status AS u_status, a.id AS a_id, a.zip AS a_zip, a.country AS a_country, COUNT(p.phonenumber) AS numphones FROM users u INNER JOIN addresses a ON u.id = a.user_id INNER JOIN phonenumbers p ON u.id = p.user_id GROUP BY u.id, u.name, u.status, u.username, a.id, a.zip, a.country ORDER BY u.username</query>
                    </named-native-query>
                </named-native-queries>
                <sql-result-set-mappings>
                    <sql-result-set-mapping name="mappingMultipleJoinsEntityResults">
                        <entity-result entity-class="__CLASS__">
                            <field-result name="id" column="u_id"/>
                            <field-result name="name" column="u_name"/>
                            <field-result name="status" column="u_status"/>
                        </entity-result>
                        <entity-result entity-class="Address">
                            <field-result name="id" column="a_id"/>
                            <field-result name="zip" column="a_zip"/>
                            <field-result name="country" column="a_country"/>
                        </entity-result>
                        <column-result name="numphones"/>
                    </sql-result-set-mapping>
                </sql-result-set-mappings>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Model\User:
          type: entity
          namedNativeQueries:
            fetchMultipleJoinsEntityResults:
              name: fetchMultipleJoinsEntityResults
              resultSetMapping: mappingMultipleJoinsEntityResults
              query: SELECT u.id AS u_id, u.name AS u_name, u.status AS u_status, a.id AS a_id, a.zip AS a_zip, a.country AS a_country, COUNT(p.phonenumber) AS numphones FROM users u INNER JOIN addresses a ON u.id = a.user_id INNER JOIN phonenumbers p ON u.id = p.user_id GROUP BY u.id, u.name, u.status, u.username, a.id, a.zip, a.country ORDER BY u.username
          sqlResultSetMappings:
            mappingMultipleJoinsEntityResults:
              name: mappingMultipleJoinsEntityResults
              columnResult:
                0:
                  name: numphones
              entityResult:
                0:
                  entityClass: __CLASS__
                  fieldResult:
                    0:
                      name: id
                      column: u_id
                    1:
                      name: name
                      column: u_name
                    2:
                      name: status
                      column: u_status
                1:
                  entityClass: Address
                  fieldResult:
                    0:
                      name: id
                      column: a_id
                    1:
                      name: zip
                      column: a_zip
                    2:
                      name: country
                      column: a_country


Things to note:
    - The resultset mapping declares the entities retrieved by this native query.
    - Each field of the entity is bound to a SQL alias (or column name).
    - All fields of the entity including the ones of subclasses
      and the foreign key columns of related entities have to be present in the SQL query.
    - Field definitions are optional provided that they map to the same
      column name as the one declared on the class property.
    - ``__CLASS__`` is an alias for the mapped class


In the above example,
the ``fetchJoinedAddress`` named query use the joinMapping result set mapping.
This mapping returns 2 entities, User and Address, each property is declared and associated to a column name,
actually the column name retrieved by the query.

Let's now see an implicit declaration of the property / column.

.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Model;
            /**
             * @NamedNativeQueries({
             *      @NamedNativeQuery(
             *          name                = "findAll",
             *          resultSetMapping    = "mappingFindAll",
             *          query               = "SELECT * FROM addresses"
             *      ),
             * })
             * @SqlResultSetMappings({
             *      @SqlResultSetMapping(
             *          name    = "mappingFindAll",
             *          entities= {
             *              @EntityResult(
             *                  entityClass = "Address"
             *              )
             *          }
             *      )
             * })
             */
           class Address
           {
                /**  @Id @Column(type="integer") @GeneratedValue */
                public $id;

                /** @Column() */
                public $country;

                /** @Column() */
                public $zip;

                /** @Column()*/
                public $city;

                // ....
            }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Model\Address">
                <named-native-queries>
                    <named-native-query name="findAll" result-set-mapping="mappingFindAll">
                        <query>SELECT * FROM addresses</query>
                    </named-native-query>
                </named-native-queries>
                <sql-result-set-mappings>
                    <sql-result-set-mapping name="mappingFindAll">
                        <entity-result entity-class="Address"/>
                    </sql-result-set-mapping>
                </sql-result-set-mappings>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Model\Address:
          type: entity
          namedNativeQueries:
            findAll:
              resultSetMapping: mappingFindAll
              query: SELECT * FROM addresses
          sqlResultSetMappings:
            mappingFindAll:
              name: mappingFindAll
              entityResult:
                address:
                  entityClass: Address


In this example, we only describe the entity member of the result set mapping.
The property / column mappings is done using the entity mapping values.
In this case the model property is bound to the model_txt column.
If the association to a related entity involve a composite primary key,
a @FieldResult element should be used for each foreign key column.
The @FieldResult name is composed of the property name for the relationship,
followed by a dot ("."), followed by the name or the field or property of the primary key.


.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Model;
            /**
             * @NamedNativeQueries({
             *      @NamedNativeQuery(
             *          name            = "fetchJoinedAddress",
             *          resultSetMapping= "mappingJoinedAddress",
             *          query           = "SELECT u.id, u.name, u.status, a.id AS a_id, a.country AS a_country, a.zip AS a_zip, a.city AS a_city FROM users u INNER JOIN addresses a ON u.id = a.user_id WHERE u.username = ?"
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
             *                      @FieldResult(name = "address.id", column = "a_id"),
             *                      @FieldResult(name = "address.zip", column = "a_zip"),
             *                      @FieldResult(name = "address.city", column = "a_city"),
             *                      @FieldResult(name = "address.country", column = "a_country"),
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

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Model\User">
                <named-native-queries>
                    <named-native-query name="fetchJoinedAddress" result-set-mapping="mappingJoinedAddress">
                        <query>SELECT u.id, u.name, u.status, a.id AS a_id, a.country AS a_country, a.zip AS a_zip, a.city AS a_city FROM users u INNER JOIN addresses a ON u.id = a.user_id WHERE u.username = ?</query>
                    </named-native-query>
                </named-native-queries>
                <sql-result-set-mappings>
                    <sql-result-set-mapping name="mappingJoinedAddress">
                        <entity-result entity-class="__CLASS__">
                            <field-result name="id"/>
                            <field-result name="name"/>
                            <field-result name="status"/>
                            <field-result name="address.id" column="a_id"/>
                            <field-result name="address.zip"  column="a_zip"/>
                            <field-result name="address.city"  column="a_city"/>
                            <field-result name="address.country" column="a_country"/>
                        </entity-result>
                    </sql-result-set-mapping>
                </sql-result-set-mappings>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Model\User:
          type: entity
          namedNativeQueries:
            fetchJoinedAddress:
              name: fetchJoinedAddress
              resultSetMapping: mappingJoinedAddress
              query: SELECT u.id, u.name, u.status, a.id AS a_id, a.country AS a_country, a.zip AS a_zip, a.city AS a_city FROM users u INNER JOIN addresses a ON u.id = a.user_id WHERE u.username = ?
          sqlResultSetMappings:
            mappingJoinedAddress:
              entityResult:
                0:
                  entityClass: __CLASS__
                  fieldResult:
                    0:
                      name: id
                    1:
                      name: name
                    2:
                      name: status
                    3:
                      name: address.id
                      column: a_id
                    4:
                      name: address.zip
                      column: a_zip
                    5:
                      name: address.city
                      column: a_city
                    6:
                      name: address.country
                      column: a_country
                    


If you retrieve a single entity and if you use the default mapping,
you can use the resultClass attribute instead of resultSetMapping:

.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Model;
            /**
             * @NamedNativeQueries({
             *      @NamedNativeQuery(
             *          name           = "find-by-id",
             *          resultClass    = "Address",
             *          query          = "SELECT * FROM addresses"
             *      ),
             * })
             */
           class Address
           {
                // ....
           }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Model\Address">
                <named-native-queries>
                    <named-native-query name="find-by-id" result-class="Address">
                        <query>SELECT * FROM addresses WHERE id = ?</query>
                    </named-native-query>
                </named-native-queries>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Model\Address:
          type: entity
          namedNativeQueries:
            findAll:
              name: findAll
              resultClass: Address
              query: SELECT * FROM addresses


In some of your native queries, you'll have to return scalar values,
for example when building report queries.
You can map them in the @SqlResultsetMapping through @ColumnResult.
You actually can even mix, entities and scalar returns in the same native query (this is probably not that common though).

.. configuration-block::

    .. code-block:: php

        <?php
        namespace MyProject\Model;
            /**
             * @NamedNativeQueries({
             *      @NamedNativeQuery(
             *          name            = "count",
             *          resultSetMapping= "mappingCount",
             *          query           = "SELECT COUNT(*) AS count FROM addresses"
             *      )
             * })
             * @SqlResultSetMappings({
             *      @SqlResultSetMapping(
             *          name    = "mappingCount",
             *          columns = {
             *              @ColumnResult(
             *                  name = "count"
             *              )
             *          }
             *      )
             * })
             */
           class Address
           {
                // ....
           }

    .. code-block:: xml

        <doctrine-mapping>
            <entity name="MyProject\Model\Address">
                <named-native-query name="count" result-set-mapping="mappingCount">
                    <query>SELECT COUNT(*) AS count FROM addresses</query>
                </named-native-query>
                <sql-result-set-mappings>
                    <sql-result-set-mapping name="mappingCount">
                        <column-result name="count"/>
                    </sql-result-set-mapping>
                </sql-result-set-mappings>
            </entity>
        </doctrine-mapping>
    .. code-block:: yaml

        MyProject\Model\Address:
          type: entity
          namedNativeQueries:
            count:
              name: count
              resultSetMapping: mappingCount
              query: SELECT COUNT(*) AS count FROM addresses
          sqlResultSetMappings:
            mappingCount:
              name: mappingCount
              columnResult:
                count:
                  name: count
