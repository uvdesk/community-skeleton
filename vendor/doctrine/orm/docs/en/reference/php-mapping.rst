PHP Mapping
===========

Doctrine 2 also allows you to provide the ORM metadata in the form
of plain PHP code using the ``ClassMetadata`` API. You can write
the code in PHP files or inside of a static function named
``loadMetadata($class)`` on the entity class itself.

PHP Files
---------

If you wish to write your mapping information inside PHP files that
are named after the entity and included to populate the metadata
for an entity you can do so by using the ``PHPDriver``:

.. code-block:: php

    <?php
    $driver = new PHPDriver('/path/to/php/mapping/files');
    $em->getConfiguration()->setMetadataDriverImpl($driver);

Now imagine we had an entity named ``Entities\User`` and we wanted
to write a mapping file for it using the above configured
``PHPDriver`` instance:

.. code-block:: php

    <?php
    namespace Entities;

    class User
    {
        private $id;
        private $username;
    }

To write the mapping information you just need to create a file
named ``Entities.User.php`` inside of the
``/path/to/php/mapping/files`` folder:

.. code-block:: php

    <?php
    // /path/to/php/mapping/files/Entities.User.php

    $metadata->mapField(array(
       'id' => true,
       'fieldName' => 'id',
       'type' => 'integer'
    ));

    $metadata->mapField(array(
       'fieldName' => 'username',
       'type' => 'string',
       'options' => array(
           'fixed' => true,
           'comment' => "User's login name"
       )
    ));

    $metadata->mapField(array(
       'fieldName' => 'login_count',
       'type' => 'integer',
       'nullable' => false,
       'options' => array(
           'unsigned' => true,
           'default' => 0
       )
    ));

Now we can easily retrieve the populated ``ClassMetadata`` instance
where the ``PHPDriver`` includes the file and the
``ClassMetadataFactory`` caches it for later retrieval:

.. code-block:: php

    <?php
    $class = $em->getClassMetadata('Entities\User');
    // or
    $class = $em->getMetadataFactory()->getMetadataFor('Entities\User');

Static Function
---------------

In addition to the PHP files you can also specify your mapping
information inside of a static function defined on the entity class
itself. This is useful for cases where you want to keep your entity
and mapping information together but don't want to use annotations.
For this you just need to use the ``StaticPHPDriver``:

.. code-block:: php

    <?php
    $driver = new StaticPHPDriver('/path/to/entities');
    $em->getConfiguration()->setMetadataDriverImpl($driver);

Now you just need to define a static function named
``loadMetadata($metadata)`` on your entity:

.. code-block:: php

    <?php
    namespace Entities;

    use Doctrine\ORM\Mapping\ClassMetadata;

    class User
    {
        // ...

        public static function loadMetadata(ClassMetadata $metadata)
        {
            $metadata->mapField(array(
               'id' => true,
               'fieldName' => 'id',
               'type' => 'integer'
            ));

            $metadata->mapField(array(
               'fieldName' => 'username',
               'type' => 'string'
            ));
        }
    }

ClassMetadataBuilder
--------------------

To ease the use of the ClassMetadata API (which is very raw) there is a ``ClassMetadataBuilder`` that you can use.

.. code-block:: php

    <?php
    namespace Entities;

    use Doctrine\ORM\Mapping\ClassMetadata;
    use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

    class User
    {
        // ...

        public static function loadMetadata(ClassMetadata $metadata)
        {
            $builder = new ClassMetadataBuilder($metadata);
            $builder->createField('id', 'integer')->isPrimaryKey()->generatedValue()->build();
            $builder->addField('username', 'string');
        }
    }

The API of the ClassMetadataBuilder has the following methods with a fluent interface:

-   ``addField($name, $type, array $mapping)``
-   ``setMappedSuperclass()``
-   ``setReadOnly()``
-   ``setCustomRepositoryClass($className)``
-   ``setTable($name)``
-   ``addIndex(array $columns, $indexName)``
-   ``addUniqueConstraint(array $columns, $constraintName)``
-   ``addNamedQuery($name, $dqlQuery)``
-   ``setJoinedTableInheritance()``
-   ``setSingleTableInheritance()``
-   ``setDiscriminatorColumn($name, $type = 'string', $length = 255)``
-   ``addDiscriminatorMapClass($name, $class)``
-   ``setChangeTrackingPolicyDeferredExplicit()``
-   ``setChangeTrackingPolicyNotify()``
-   ``addLifecycleEvent($methodName, $event)``
-   ``addManyToOne($name, $targetEntity, $inversedBy = null)``
-   ``addInverseOneToOne($name, $targetEntity, $mappedBy)``
-   ``addOwningOneToOne($name, $targetEntity, $inversedBy = null)``
-   ``addOwningManyToMany($name, $targetEntity, $inversedBy = null)``
-   ``addInverseManyToMany($name, $targetEntity, $mappedBy)``
-   ``addOneToMany($name, $targetEntity, $mappedBy)``

It also has several methods that create builders (which are necessary for advanced mappings):

-   ``createField($name, $type)`` returns a ``FieldBuilder`` instance
-   ``createManyToOne($name, $targetEntity)`` returns an ``AssociationBuilder`` instance
-   ``createOneToOne($name, $targetEntity)`` returns an ``AssociationBuilder`` instance
-   ``createManyToMany($name, $targetEntity)`` returns an ``ManyToManyAssociationBuilder`` instance
-   ``createOneToMany($name, $targetEntity)`` returns an ``OneToManyAssociationBuilder`` instance

ClassMetadataInfo API
---------------------

The ``ClassMetadataInfo`` class is the base data object for storing
the mapping metadata for a single entity. It contains all the
getters and setters you need populate and retrieve information for
an entity.

General Setters
~~~~~~~~~~~~~~~


-  ``setTableName($tableName)``
-  ``setPrimaryTable(array $primaryTableDefinition)``
-  ``setCustomRepositoryClass($repositoryClassName)``
-  ``setIdGeneratorType($generatorType)``
-  ``setIdGenerator($generator)``
-  ``setSequenceGeneratorDefinition(array $definition)``
-  ``setChangeTrackingPolicy($policy)``
-  ``setIdentifier(array $identifier)``

Inheritance Setters
~~~~~~~~~~~~~~~~~~~


-  ``setInheritanceType($type)``
-  ``setSubclasses(array $subclasses)``
-  ``setParentClasses(array $classNames)``
-  ``setDiscriminatorColumn($columnDef)``
-  ``setDiscriminatorMap(array $map)``

Field Mapping Setters
~~~~~~~~~~~~~~~~~~~~~


-  ``mapField(array $mapping)``
-  ``mapOneToOne(array $mapping)``
-  ``mapOneToMany(array $mapping)``
-  ``mapManyToOne(array $mapping)``
-  ``mapManyToMany(array $mapping)``

Lifecycle Callback Setters
~~~~~~~~~~~~~~~~~~~~~~~~~~


-  ``addLifecycleCallback($callback, $event)``
-  ``setLifecycleCallbacks(array $callbacks)``

Versioning Setters
~~~~~~~~~~~~~~~~~~


-  ``setVersionMapping(array &$mapping)``
-  ``setVersioned($bool)``
-  ``setVersionField()``

General Getters
~~~~~~~~~~~~~~~


-  ``getTableName()``
-  ``getSchemaName()``
-  ``getTemporaryIdTableName()``

Identifier Getters
~~~~~~~~~~~~~~~~~~


-  ``getIdentifierColumnNames()``
-  ``usesIdGenerator()``
-  ``isIdentifier($fieldName)``
-  ``isIdGeneratorIdentity()``
-  ``isIdGeneratorSequence()``
-  ``isIdGeneratorTable()``
-  ``isIdentifierNatural()``
-  ``getIdentifierFieldNames()``
-  ``getSingleIdentifierFieldName()``
-  ``getSingleIdentifierColumnName()``

Inheritance Getters
~~~~~~~~~~~~~~~~~~~


-  ``isInheritanceTypeNone()``
-  ``isInheritanceTypeJoined()``
-  ``isInheritanceTypeSingleTable()``
-  ``isInheritanceTypeTablePerClass()``
-  ``isInheritedField($fieldName)``
-  ``isInheritedAssociation($fieldName)``

Change Tracking Getters
~~~~~~~~~~~~~~~~~~~~~~~


-  ``isChangeTrackingDeferredExplicit()``
-  ``isChangeTrackingDeferredImplicit()``
-  ``isChangeTrackingNotify()``

Field & Association Getters
~~~~~~~~~~~~~~~~~~~~~~~~~~~


-  ``isUniqueField($fieldName)``
-  ``isNullable($fieldName)``
-  ``getColumnName($fieldName)``
-  ``getFieldMapping($fieldName)``
-  ``getAssociationMapping($fieldName)``
-  ``getAssociationMappings()``
-  ``getFieldName($columnName)``
-  ``hasField($fieldName)``
-  ``getColumnNames(array $fieldNames = null)``
-  ``getTypeOfField($fieldName)``
-  ``getTypeOfColumn($columnName)``
-  ``hasAssociation($fieldName)``
-  ``isSingleValuedAssociation($fieldName)``
-  ``isCollectionValuedAssociation($fieldName)``

Lifecycle Callback Getters
~~~~~~~~~~~~~~~~~~~~~~~~~~


-  ``hasLifecycleCallbacks($lifecycleEvent)``
-  ``getLifecycleCallbacks($event)``

ClassMetadata API
-----------------

The ``ClassMetadata`` class extends ``ClassMetadataInfo`` and adds
the runtime functionality required by Doctrine. It adds a few extra
methods related to runtime reflection for working with the entities
themselves.


-  ``getReflectionClass()``
-  ``getReflectionProperties()``
-  ``getReflectionProperty($name)``
-  ``getSingleIdReflectionProperty()``
-  ``getIdentifierValues($entity)``
-  ``setIdentifierValues($entity, $id)``
-  ``setFieldValue($entity, $field, $value)``
-  ``getFieldValue($entity, $field)``


