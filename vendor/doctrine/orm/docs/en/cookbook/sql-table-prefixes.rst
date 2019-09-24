SQL-Table Prefixes
==================

This recipe is intended as an example of implementing a
loadClassMetadata listener to provide a Table Prefix option for
your application. The method used below is not a hack, but fully
integrates into the Doctrine system, all SQL generated will include
the appropriate table prefix.

In most circumstances it is desirable to separate different
applications into individual databases, but in certain cases, it
may be beneficial to have a table prefix for your Entities to
separate them from other vendor products in the same database.

Implementing the listener
-------------------------

The listener in this example has been set up with the
DoctrineExtensions namespace. You create this file in your
library/DoctrineExtensions directory, but will need to set up
appropriate autoloaders.

.. code-block:: php

    <?php
    
    namespace DoctrineExtensions;
    use \Doctrine\ORM\Event\LoadClassMetadataEventArgs;
    
    class TablePrefix
    {
        protected $prefix = '';
    
        public function __construct($prefix)
        {
            $this->prefix = (string) $prefix;
        }
    
        public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
        {
            $classMetadata = $eventArgs->getClassMetadata();

            if (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName) {
                $classMetadata->setPrimaryTable([
                    'name' => $this->prefix . $classMetadata->getTableName()
                ]);
            }

            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
                if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide']) {
                    $mappedTableName = $mapping['joinTable']['name'];
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
                }
            }
        }

    }

Telling the EntityManager about our listener
--------------------------------------------

A listener of this type must be set up before the EntityManager has
been initialised, otherwise an Entity might be created or cached
before the prefix has been set.

.. note::

    If you set this listener up, be aware that you will need
    to clear your caches and drop then recreate your database schema.


.. code-block:: php

    <?php
    
    // $connectionOptions and $config set earlier
    
    $evm = new \Doctrine\Common\EventManager;
    
    // Table Prefix
    $tablePrefix = new \DoctrineExtensions\TablePrefix('prefix_');
    $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
    
    $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config, $evm);


