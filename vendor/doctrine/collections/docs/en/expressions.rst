Expressions
===========

The ``Doctrine\Common\Collections\Expr\Comparison`` class
can be used to create expressions to be used with the
``Doctrine\Common\Collections\Criteria`` class. It has the
following operator constants:

- ``Comparison::EQ``
- ``Comparison::NEQ``
- ``Comparison::LT``
- ``Comparison::LTE``
- ``Comparison::GT``
- ``Comparison::GTE``
- ``Comparison::IS``
- ``Comparison::IN``
- ``Comparison::NIN``
- ``Comparison::CONTAINS``
- ``Comparison::MEMBER_OF``
- ``Comparison::STARTS_WITH``
- ``Comparison::ENDS_WITH``

The ``Doctrine\Common\Collections\Criteria`` class has the following
API to be used with expressions:

where
-----

Sets the where expression to evaluate when this Criteria is searched for.

.. code-block:: php
    $expr = new Comparison('key', Comparison::EQ, 'value');

    $criteria->where($expr);

andWhere
--------

Appends the where expression to evaluate when this Criteria is searched for
using an AND with previous expression.

.. code-block:: php
    $expr = new Comparison('key', Comparison::EQ, 'value');

    $criteria->andWhere($expr);

orWhere
-------

Appends the where expression to evaluate when this Criteria is searched for
using an OR with previous expression.

.. code-block:: php
    $expr1 = new Comparison('key', Comparison::EQ, 'value1');
    $expr2 = new Comparison('key', Comparison::EQ, 'value2');

    $criteria->where($expr1);
    $criteria->orWhere($expr2);

orderBy
-------

Sets the ordering of the result of this Criteria.

.. code-block:: php
    $criteria->orderBy(['name' => Criteria::ASC]);

setFirstResult
--------------

Set the number of first result that this Criteria should return.

.. code-block:: php
    $criteria->setFirstResult(0);

getFirstResult
--------------

Gets the current first result option of this Criteria.

.. code-block:: php
    $criteria->setFirstResult(10);

    echo $criteria->getFirstResult(); // 10

setMaxResults
-------------

Sets the max results that this Criteria should return.

.. code-block:: php
    $criteria->setMaxResults(20);

getMaxResults
-------------

Gets the current max results option of this Criteria.

.. code-block:: php
    $criteria->setMaxResults(20);

    echo $criteria->getMaxResults(); // 20
