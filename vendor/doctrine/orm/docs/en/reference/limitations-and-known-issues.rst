Limitations and Known Issues
============================

We try to make using Doctrine2 a very pleasant experience.
Therefore we think it is very important to be honest about the
current limitations to our users. Much like every other piece of
software Doctrine2 is not perfect and far from feature complete.
This section should give you an overview of current limitations of
Doctrine 2 as well as critical known issues that you should know
about.

Current Limitations
-------------------

There is a set of limitations that exist currently which might be
solved in the future. Any of this limitations now stated has at
least one ticket in the Tracker and is discussed for future
releases.

Join-Columns with non-primary keys
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is not possible to use join columns pointing to non-primary keys. Doctrine will think these are the primary
keys and create lazy-loading proxies with the data, which can lead to unexpected results. Doctrine can for performance
reasons not validate the correctness of this settings at runtime but only through the Validate Schema command.

Mapping Arrays to a Join Table
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Related to the previous limitation with "Foreign Keys as
Identifier" you might be interested in mapping the same table
structure as given above to an array. However this is not yet
possible either. See the following example:

.. code-block:: sql

    CREATE TABLE product (
        id INTEGER,
        name VARCHAR,
        PRIMARY KEY(id)
    );
    
    CREATE TABLE product_attributes (
        product_id INTEGER,
        attribute_name VARCHAR,
        attribute_value VARCHAR,
        PRIMARY KEY (product_id, attribute_name)
    );

This schema should be mapped to a Product Entity as follows:

.. code-block:: php

    class Product
    {
        private $id;
        private $name;
        private $attributes = array();
    }

Where the ``attribute_name`` column contains the key and
``attribute_value`` contains the value of each array element in
``$attributes``.

The feature request for persistence of primitive value arrays
`is described in the DDC-298 ticket <https://github.com/doctrine/doctrine2/issues/3743>`_.

Cascade Merge with Bi-directional Associations
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

There are two bugs now that concern the use of cascade merge in combination with bi-directional associations.
Make sure to study the behavior of cascade merge if you are using it:

-  `DDC-875 <https://github.com/doctrine/doctrine2/issues/5398>`_ Merge can sometimes add the same entity twice into a collection
-  `DDC-763 <https://github.com/doctrine/doctrine2/issues/5277>`_ Cascade merge on associated entities can insert too many rows through "Persistence by Reachability"

Custom Persisters
~~~~~~~~~~~~~~~~~

A Persister in Doctrine is an object that is responsible for the
hydration and write operations of an entity against the database.
Currently there is no way to overwrite the persister implementation
for a given entity, however there are several use-cases that can
benefit from custom persister implementations:

-  `Add Upsert Support <https://github.com/doctrine/doctrine2/issues/5178>`_
-  `Evaluate possible ways in which stored-procedures can be used <https://github.com/doctrine/doctrine2/issues/4946>`_

Persist Keys of Collections
~~~~~~~~~~~~~~~~~~~~~~~~~~~

PHP Arrays are ordered hash-maps and so should be the
``Doctrine\Common\Collections\Collection`` interface. We plan to
evaluate a feature that optionally persists and hydrates the keys
of a Collection instance.

`Ticket DDC-213 <https://github.com/doctrine/doctrine2/issues/2817>`_

Mapping many tables to one entity
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is not possible to map several equally looking tables onto one
entity. For example if you have a production and an archive table
of a certain business concept then you cannot have both tables map
to the same entity.

Behaviors
~~~~~~~~~

Doctrine 2 will **never** include a behavior system like Doctrine 1
in the core library. We don't think behaviors add more value than
they cost pain and debugging hell. Please see the many different
blog posts we have written on this topics:

-  `Doctrine2 "Behaviors" in a Nutshell <http://www.doctrine-project.org/2010/02/17/doctrine2-behaviours-nutshell.html>`_
-  `A re-usable Versionable behavior for Doctrine2 <http://www.doctrine-project.org/2010/02/24/doctrine2-versionable.html>`_
-  `Write your own ORM on top of Doctrine2 <http://www.doctrine-project.org/2010/07/19/your-own-orm-doctrine2.html>`_
-  `Doctrine 2 Behavioral Extensions <http://www.doctrine-project.org/2010/11/18/doctrine2-behavioral-extensions.html>`_
-  `Doctrator <https://github.com/pablodip/doctrator`>_

Doctrine 2 has enough hooks and extension points so that **you** can
add whatever you want on top of it. None of this will ever become
core functionality of Doctrine2 however, you will have to rely on
third party extensions for magical behaviors.

Nested Set
~~~~~~~~~~

NestedSet was offered as a behavior in Doctrine 1 and will not be
included in the core of Doctrine 2. However there are already two
extensions out there that offer support for Nested Set with
Doctrine 2:


-  `Doctrine2 Hierarchical-Structural Behavior <http://github.com/guilhermeblanco/Doctrine2-Hierarchical-Structural-Behavior>`_
-  `Doctrine2 NestedSet <http://github.com/blt04/doctrine2-nestedset>`_

Known Issues
------------

The Known Issues section describes critical/blocker bugs and other
issues that are either complicated to fix, not fixable due to
backwards compatibility issues or where no simple fix exists (yet).
We don't plan to add every bug in the tracker there, just those
issues that can potentially cause nightmares or pain of any sort.

See bugs, improvement and feature requests on `Github issues
<https://github.com/doctrine/doctrine2/issues>`_.

Identifier Quoting and Legacy Databases
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For compatibility reasons between all the supported vendors and
edge case problems Doctrine 2 does **NOT** do automatic identifier
quoting. This can lead to problems when trying to get
legacy-databases to work with Doctrine 2.


-  You can quote column-names as described in the
   :doc:`Basic-Mapping <basic-mapping>` section.
-  You cannot quote join column names.
-  You cannot use non [a-zA-Z0-9\_]+ characters, they will break
   several SQL statements.

Having problems with these kind of column names? Many databases
support all CRUD operations on views that semantically map to
certain tables. You can create views for all your problematic
tables and column names to avoid the legacy quoting nightmare.

Microsoft SQL Server and Doctrine "datetime"
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Doctrine assumes that you use ``DateTime2`` data-types. If your legacy database contains DateTime
datatypes then you have to add your own data-type (see Basic Mapping for an example).

MySQL with MyISAM tables
~~~~~~~~~~~~~~~~~~~~~~~~

Doctrine cannot provide atomic operations when calling ``EntityManager#flush()`` if one
of the tables involved uses the storage engine MyISAM. You must use InnoDB or
other storage engines that support transactions if you need integrity.

Entities, Proxies and Reflection
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Using methods for Reflection on entities can be prone to error, when the entity
is actually a proxy the following methods will not work correctly:

- ``new ReflectionClass``
- ``new ReflectionObject``
- ``get_class()``
- ``get_parent_class()``

This is why ``Doctrine\Common\Util\ClassUtils`` class exists that has similar
methods, which resolve the proxy problem beforehand.

.. code-block:: php

    <?php
    use Doctrine\Common\Util\ClassUtils;

    $bookProxy = $entityManager->getReference('Acme\Book');

    $reflection = ClassUtils::newReflectionClass($bookProxy);
    $class = ClassUtils::getClass($bookProxy)¸
