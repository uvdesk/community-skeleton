Filters
=======

.. versionadded:: 2.2

Doctrine 2.2 features a filter system that allows the developer to add SQL to
the conditional clauses of queries, regardless the place where the SQL is
generated (e.g. from a DQL query, or by loading associated entities).

The filter functionality works on SQL level. Whether a SQL query is generated
in a Persister, during lazy loading, in extra lazy collections or from DQL.
Each time the system iterates over all the enabled filters, adding a new SQL
part as a filter returns.

By adding SQL to the conditional clauses of queries, the filter system filters
out rows belonging to the entities at the level of the SQL result set. This
means that the filtered entities are never hydrated (which can be expensive).


Example filter class
--------------------
Throughout this document the example ``MyLocaleFilter`` class will be used to
illustrate how the filter feature works. A filter class must extend the base
``Doctrine\ORM\Query\Filter\SQLFilter`` class and implement the ``addFilterConstraint``
method. The method receives the ``ClassMetadata`` of the filtered entity and the
table alias of the SQL table of the entity.

.. note::

    In the case of joined or single table inheritance, you always get passed the ClassMetadata of the
    inheritance root. This is necessary to avoid edge cases that would break the SQL when applying the filters.

Parameters for the query should be set on the filter object by
``SQLFilter#setParameter()``. Only parameters set via this function can be used
in filters.  The ``SQLFilter#getParameter()`` function takes care of the
proper quoting of parameters.

.. code-block:: php

    <?php
    namespace Example;
    use Doctrine\ORM\Mapping\ClassMetaData,
        Doctrine\ORM\Query\Filter\SQLFilter;

    class MyLocaleFilter extends SQLFilter
    {
        public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
        {
            // Check if the entity implements the LocalAware interface
            if (!$targetEntity->reflClass->implementsInterface('LocaleAware')) {
                return "";
            }

            return $targetTableAlias.'.locale = ' . $this->getParameter('locale'); // getParameter applies quoting automatically
        }
    }


Configuration
-------------
Filter classes are added to the configuration as following:

.. code-block:: php

    <?php
    $config->addFilter("locale", "\Doctrine\Tests\ORM\Functional\MyLocaleFilter");


The ``Configuration#addFilter()`` method takes a name for the filter and the name of the
class responsible for the actual filtering.


Disabling/Enabling Filters and Setting Parameters
---------------------------------------------------
Filters can be disabled and enabled via the ``FilterCollection`` which is
stored in the ``EntityManager``. The ``FilterCollection#enable($name)`` method
will retrieve the filter object. You can set the filter parameters on that
object.

.. code-block:: php

    <?php
    $filter = $em->getFilters()->enable("locale");
    $filter->setParameter('locale', 'en');

    // Disable it
    $filter = $em->getFilters()->disable("locale");

.. warning::
    Disabling and enabling filters has no effect on managed entities. If you
    want to refresh or reload an object after having modified a filter or the
    FilterCollection, then you should clear the EntityManager and re-fetch your
    entities, having the new rules for filtering applied.
