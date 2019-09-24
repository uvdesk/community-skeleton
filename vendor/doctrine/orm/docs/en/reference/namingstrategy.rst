Implementing a NamingStrategy
==============================

.. versionadded:: 2.3

Using a naming strategy you can provide rules for generating database identifiers,
column or table names when the column or table name is not given. This feature helps
reduce the verbosity of the mapping document, eliminating repetitive noise (eg: ``TABLE_``).

Configuring a naming strategy
-----------------------------
The default strategy used by Doctrine is quite minimal.

By default the ``Doctrine\ORM\Mapping\DefaultNamingStrategy``
uses the simple class name and the attribute names to generate tables and columns.

You can specify a different strategy by calling ``Doctrine\ORM\Configuration#setNamingStrategy()``:

.. code-block:: php

    <?php
    $namingStrategy = new MyNamingStrategy();
    $configuration->setNamingStrategy($namingStrategy);

Underscore naming strategy
---------------------------

``\Doctrine\ORM\Mapping\UnderscoreNamingStrategy`` is a built-in strategy.

.. code-block:: php

    <?php
    $namingStrategy = new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy(CASE_UPPER);
    $configuration->setNamingStrategy($namingStrategy);

For SomeEntityName the strategy will generate the table SOME_ENTITY_NAME with the
``CASE_UPPER`` option, or some_entity_name with the ``CASE_LOWER`` option.

Naming strategy interface
-------------------------
The interface ``Doctrine\ORM\Mapping\NamingStrategy`` allows you to specify
a naming strategy for database tables and columns.

.. code-block:: php

    <?php
    /**
     * Return a table name for an entity class
     *
     * @param string $className The fully-qualified class name
     * @return string A table name
     */
    function classToTableName($className);

    /**
     * Return a column name for a property
     *
     * @param string $propertyName A property
     * @return string A column name
     */
    function propertyToColumnName($propertyName);

    /**
     * Return the default reference column name
     *
     * @return string A column name
     */
    function referenceColumnName();

    /**
     * Return a join column name for a property
     *
     * @param string $propertyName A property
     * @return string A join column name
     */
    function joinColumnName($propertyName, $className = null);

    /**
     * Return a join table name
     *
     * @param string $sourceEntity The source entity
     * @param string $targetEntity The target entity
     * @param string $propertyName A property
     * @return string A join table name
     */
    function joinTableName($sourceEntity, $targetEntity, $propertyName = null);

    /**
     * Return the foreign key column name for the given parameters
     *
     * @param string $entityName A entity
     * @param string $referencedColumnName A property
     * @return string A join column name
     */
    function joinKeyColumnName($entityName, $referencedColumnName = null);

Implementing a naming strategy
-------------------------------
If you have database naming standards, like all table names should be prefixed
by the application prefix, all column names should be lower case, you can easily
achieve such standards by implementing a naming strategy.

You need to create a class which implements ``Doctrine\ORM\Mapping\NamingStrategy``.


.. code-block:: php

    <?php
    class MyAppNamingStrategy implements NamingStrategy
    {
        public function classToTableName($className)
        {
            return 'MyApp_' . substr($className, strrpos($className, '\\') + 1);
        }
        public function propertyToColumnName($propertyName)
        {
            return $propertyName;
        }
        public function referenceColumnName()
        {
            return 'id';
        }
        public function joinColumnName($propertyName, $className = null)
        {
            return $propertyName . '_' . $this->referenceColumnName();
        }
        public function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
        {
            return strtolower($this->classToTableName($sourceEntity) . '_' .
                    $this->classToTableName($targetEntity));
        }
        public function joinKeyColumnName($entityName, $referencedColumnName = null)
        {
            return strtolower($this->classToTableName($entityName) . '_' .
                    ($referencedColumnName ?: $this->referenceColumnName()));
        }
    }
