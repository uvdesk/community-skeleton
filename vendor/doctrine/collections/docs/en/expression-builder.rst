Expression Builder
==================

The Expression Builder is a convenient fluent interface for
building expressions to be used with the ``Doctrine\Common\Collections\Criteria``
class:

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $criteria = new Criteria();
    $criteria->where($expressionBuilder->eq('name', 'jwage'));
    $criteria->orWhere($expressionBuilder->eq('name', 'romanb'));

    $collection->matching($criteria);

The ``ExpressionBuilder`` has the following API:

andX
----

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->andX(
        $expressionBuilder->eq('foo', 1),
        $expressionBuilder->eq('bar', 1)
    );

    $collection->matching(new Criteria($expression));

orX
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->orX(
        $expressionBuilder->eq('foo', 1),
        $expressionBuilder->eq('bar', 1)
    );

    $collection->matching(new Criteria($expression));

eq
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->eq('foo', 1);

    $collection->matching(new Criteria($expression));

gt
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->gt('foo', 1);

    $collection->matching(new Criteria($expression));

lt
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->lt('foo', 1);

    $collection->matching(new Criteria($expression));

gte
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->gte('foo', 1);

    $collection->matching(new Criteria($expression));

lte
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->lte('foo', 1);

    $collection->matching(new Criteria($expression));

neq
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->neq('foo', 1);

    $collection->matching(new Criteria($expression));

isNull
------

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->isNull('foo');

    $collection->matching(new Criteria($expression));

in
---

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->in('foo', ['value1', 'value2']);

    $collection->matching(new Criteria($expression));

notIn
-----

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->notIn('foo', ['value1', 'value2']);

    $collection->matching(new Criteria($expression));

contains
--------

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->contains('foo', 'value1');

    $collection->matching(new Criteria($expression));

memberOf
--------

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->memberOf('foo', ['value1', 'value2']);

    $collection->matching(new Criteria($expression));

startsWith
----------

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->startsWith('foo', 'hello');

    $collection->matching(new Criteria($expression));

endsWith
--------

.. code-block:: php
    $expressionBuilder = Criteria::expr();

    $expression = $expressionBuilder->endsWith('foo', 'world');

    $collection->matching(new Criteria($expression));
