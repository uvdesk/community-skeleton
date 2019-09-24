The QueryBuilder
================

A ``QueryBuilder`` provides an API that is designed for
conditionally constructing a DQL query in several steps.

It provides a set of classes and methods that is able to
programmatically build queries, and also provides a fluent API.
This means that you can change between one methodology to the other
as you want, or just pick a preferred one.

Constructing a new QueryBuilder object
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The same way you build a normal Query, you build a ``QueryBuilder``
object. Here is an example of how to build a ``QueryBuilder``
object:

.. code-block:: php

    <?php
    // $em instanceof EntityManager

    // example1: creating a QueryBuilder instance
    $qb = $em->createQueryBuilder();

An instance of QueryBuilder has several informative methods.  One
good example is to inspect what type of object the
``QueryBuilder`` is.

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // example2: retrieving type of QueryBuilder
    echo $qb->getType(); // Prints: 0

There're currently 3 possible return values for ``getType()``:


-  ``QueryBuilder::SELECT``, which returns value 0
-  ``QueryBuilder::DELETE``, returning value 1
-  ``QueryBuilder::UPDATE``, which returns value 2

It is possible to retrieve the associated ``EntityManager`` of the
current ``QueryBuilder``, its DQL and also a ``Query`` object when
you finish building your DQL.

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // example3: retrieve the associated EntityManager
    $em = $qb->getEntityManager();

    // example4: retrieve the DQL string of what was defined in QueryBuilder
    $dql = $qb->getDql();

    // example5: retrieve the associated Query object with the processed DQL
    $q = $qb->getQuery();

Internally, ``QueryBuilder`` works with a DQL cache to increase
performance. Any changes that may affect the generated DQL actually
modifies the state of ``QueryBuilder`` to a stage we call
STATE\_DIRTY. One ``QueryBuilder`` can be in two different states:


-  ``QueryBuilder::STATE_CLEAN``, which means DQL haven't been
   altered since last retrieval or nothing were added since its
   instantiation
-  ``QueryBuilder::STATE_DIRTY``, means DQL query must (and will)
   be processed on next retrieval

Working with QueryBuilder
~~~~~~~~~~~~~~~~~~~~~~~~~


High level API methods
^^^^^^^^^^^^^^^^^^^^^^

To simplify even more the way you build a query in Doctrine, you can take
advantage of Helper methods. For all base code, there is a set of
useful methods to simplify a programmer's life. To illustrate how
to work with them, here is the same example 6 re-written using
``QueryBuilder`` helper methods:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    $qb->select('u')
       ->from('User', 'u')
       ->where('u.id = ?1')
       ->orderBy('u.name', 'ASC');

``QueryBuilder`` helper methods are considered the standard way to
build DQL queries. Although it is supported, using string-based
queries should be avoided.  You are greatly encouraged to use
``$qb->expr()->*`` methods. Here is a converted example 8 to
suggested standard way to build queries:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    $qb->select(array('u')) // string 'u' is converted to array internally
       ->from('User', 'u')
       ->where($qb->expr()->orX(
           $qb->expr()->eq('u.id', '?1'),
           $qb->expr()->like('u.nickname', '?2')
       ))
       ->orderBy('u.surname', 'ASC');

Here is a complete list of helper methods available in ``QueryBuilder``:

.. code-block:: php

    <?php
    class QueryBuilder
    {
        // Example - $qb->select('u')
        // Example - $qb->select(array('u', 'p'))
        // Example - $qb->select($qb->expr()->select('u', 'p'))
        public function select($select = null);

        // addSelect does not override previous calls to select
        //
        // Example - $qb->select('u');
        //              ->addSelect('p.area_code');
        public function addSelect($select = null);

        // Example - $qb->delete('User', 'u')
        public function delete($delete = null, $alias = null);

        // Example - $qb->update('Group', 'g')
        public function update($update = null, $alias = null);

        // Example - $qb->set('u.firstName', $qb->expr()->literal('Arnold'))
        // Example - $qb->set('u.numChilds', 'u.numChilds + ?1')
        // Example - $qb->set('u.numChilds', $qb->expr()->sum('u.numChilds', '?1'))
        public function set($key, $value);

        // Example - $qb->from('Phonenumber', 'p')
        // Example - $qb->from('Phonenumber', 'p', 'p.id')
        public function from($from, $alias, $indexBy = null);

        // Example - $qb->join('u.Group', 'g', Expr\Join::WITH, $qb->expr()->eq('u.status_id', '?1'))
        // Example - $qb->join('u.Group', 'g', 'WITH', 'u.status = ?1')
        // Example - $qb->join('u.Group', 'g', 'WITH', 'u.status = ?1', 'g.id')
        public function join($join, $alias, $conditionType = null, $condition = null, $indexBy = null);

        // Example - $qb->innerJoin('u.Group', 'g', Expr\Join::WITH, $qb->expr()->eq('u.status_id', '?1'))
        // Example - $qb->innerJoin('u.Group', 'g', 'WITH', 'u.status = ?1')
        // Example - $qb->innerJoin('u.Group', 'g', 'WITH', 'u.status = ?1', 'g.id')
        public function innerJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null);

        // Example - $qb->leftJoin('u.Phonenumbers', 'p', Expr\Join::WITH, $qb->expr()->eq('p.area_code', 55))
        // Example - $qb->leftJoin('u.Phonenumbers', 'p', 'WITH', 'p.area_code = 55')
        // Example - $qb->leftJoin('u.Phonenumbers', 'p', 'WITH', 'p.area_code = 55', 'p.id')
        public function leftJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null);

        // NOTE: ->where() overrides all previously set conditions
        //
        // Example - $qb->where('u.firstName = ?1', $qb->expr()->eq('u.surname', '?2'))
        // Example - $qb->where($qb->expr()->andX($qb->expr()->eq('u.firstName', '?1'), $qb->expr()->eq('u.surname', '?2')))
        // Example - $qb->where('u.firstName = ?1 AND u.surname = ?2')
        public function where($where);

        // NOTE: ->andWhere() can be used directly, without any ->where() before
        //
        // Example - $qb->andWhere($qb->expr()->orX($qb->expr()->lte('u.age', 40), 'u.numChild = 0'))
        public function andWhere($where);

        // Example - $qb->orWhere($qb->expr()->between('u.id', 1, 10));
        public function orWhere($where);

        // NOTE: -> groupBy() overrides all previously set grouping conditions
        //
        // Example - $qb->groupBy('u.id')
        public function groupBy($groupBy);

        // Example - $qb->addGroupBy('g.name')
        public function addGroupBy($groupBy);

        // NOTE: -> having() overrides all previously set having conditions
        //
        // Example - $qb->having('u.salary >= ?1')
        // Example - $qb->having($qb->expr()->gte('u.salary', '?1'))
        public function having($having);

        // Example - $qb->andHaving($qb->expr()->gt($qb->expr()->count('u.numChild'), 0))
        public function andHaving($having);

        // Example - $qb->orHaving($qb->expr()->lte('g.managerLevel', '100'))
        public function orHaving($having);

        // NOTE: -> orderBy() overrides all previously set ordering conditions
        //
        // Example - $qb->orderBy('u.surname', 'DESC')
        public function orderBy($sort, $order = null);

        // Example - $qb->addOrderBy('u.firstName')
        public function addOrderBy($sort, $order = null); // Default $order = 'ASC'
    }

Binding parameters to your query
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Doctrine supports dynamic binding of parameters to your query,
similar to preparing queries. You can use both strings and numbers
as placeholders, although both have a slightly different syntax.
Additionally, you must make your choice: Mixing both styles is not
allowed. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    $qb->select('u')
       ->from('User', 'u')
       ->where('u.id = ?1')
       ->orderBy('u.name', 'ASC')
       ->setParameter(1, 100); // Sets ?1 to 100, and thus we will fetch a user with u.id = 100

You are not forced to enumerate your placeholders as the
alternative syntax is available:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    $qb->select('u')
       ->from('User', 'u')
       ->where('u.id = :identifier')
       ->orderBy('u.name', 'ASC')
       ->setParameter('identifier', 100); // Sets :identifier to 100, and thus we will fetch a user with u.id = 100

Note that numeric placeholders start with a ? followed by a number
while the named placeholders start with a : followed by a string.

Calling ``setParameter()`` automatically infers which type you are setting as
value. This works for integers, arrays of strings/integers, DateTime instances
and for managed entities. If you want to set a type explicitly you can call
the third argument to ``setParameter()`` explicitly. It accepts either a PDO
type or a DBAL Type name for conversion.

If you've got several parameters to bind to your query, you can
also use setParameters() instead of setParameter() with the
following syntax:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // Query here...
    $qb->setParameters(array(1 => 'value for ?1', 2 => 'value for ?2'));

Getting already bound parameters is easy - simply use the above
mentioned syntax with "getParameter()" or "getParameters()":

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // See example above
    $params = $qb->getParameters();
    // $params instanceof \Doctrine\Common\Collections\ArrayCollection

    // Equivalent to
    $param = $qb->getParameter(1);
    // $param instanceof \Doctrine\ORM\Query\Parameter

Note: If you try to get a parameter that was not bound yet,
getParameter() simply returns NULL.

The API of a Query Parameter is:

.. code-block:: php

    namespace Doctrine\ORM\Query;

    class Parameter
    {
        public function getName();
        public function getValue();
        public function getType();
        public function setValue($value, $type = null);
    }

Limiting the Result
^^^^^^^^^^^^^^^^^^^

To limit a result the query builder has some methods in common with
the Query object which can be retrieved from ``EntityManager#createQuery()``.

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder
    $offset = (int)$_GET['offset'];
    $limit = (int)$_GET['limit'];

    $qb->add('select', 'u')
       ->add('from', 'User u')
       ->add('orderBy', 'u.name ASC')
       ->setFirstResult( $offset )
       ->setMaxResults( $limit );

Executing a Query
^^^^^^^^^^^^^^^^^

The QueryBuilder is a builder object only -  it has no means of actually
executing the Query. Additionally a set of parameters such as query hints
cannot be set on the QueryBuilder itself. This is why you always have to convert
a querybuilder instance into a Query object:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder
    $query = $qb->getQuery();

    // Set additional Query options
    $query->setQueryHint('foo', 'bar');
    $query->useResultCache('my_cache_id');

    // Execute Query
    $result = $query->getResult();
    $single = $query->getSingleResult();
    $array = $query->getArrayResult();
    $scalar = $query->getScalarResult();
    $singleScalar = $query->getSingleScalarResult();

The Expr class
^^^^^^^^^^^^^^

To workaround some of the issues that ``add()`` method may cause,
Doctrine created a class that can be considered as a helper for
building expressions. This class is called ``Expr``, which provides a
set of useful methods to help build expressions:

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // example8: QueryBuilder port of:
    // "SELECT u FROM User u WHERE u.id = ? OR u.nickname LIKE ? ORDER BY u.name ASC" using Expr class
    $qb->add('select', new Expr\Select(array('u')))
       ->add('from', new Expr\From('User', 'u'))
       ->add('where', $qb->expr()->orX(
           $qb->expr()->eq('u.id', '?1'),
           $qb->expr()->like('u.nickname', '?2')
       ))
       ->add('orderBy', new Expr\OrderBy('u.name', 'ASC'));

Although it still sounds complex, the ability to programmatically
create conditions are the main feature of ``Expr``. Here it is a
complete list of supported helper methods available:

.. code-block:: php

    <?php
    class Expr
    {
        /** Conditional objects **/

        // Example - $qb->expr()->andX($cond1 [, $condN])->add(...)->...
        public function andX($x = null); // Returns Expr\AndX instance

        // Example - $qb->expr()->orX($cond1 [, $condN])->add(...)->...
        public function orX($x = null); // Returns Expr\OrX instance


        /** Comparison objects **/

        // Example - $qb->expr()->eq('u.id', '?1') => u.id = ?1
        public function eq($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->neq('u.id', '?1') => u.id <> ?1
        public function neq($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->lt('u.id', '?1') => u.id < ?1
        public function lt($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->lte('u.id', '?1') => u.id <= ?1
        public function lte($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->gt('u.id', '?1') => u.id > ?1
        public function gt($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->gte('u.id', '?1') => u.id >= ?1
        public function gte($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->isNull('u.id') => u.id IS NULL
        public function isNull($x); // Returns string

        // Example - $qb->expr()->isNotNull('u.id') => u.id IS NOT NULL
        public function isNotNull($x); // Returns string


        /** Arithmetic objects **/

        // Example - $qb->expr()->prod('u.id', '2') => u.id * 2
        public function prod($x, $y); // Returns Expr\Math instance

        // Example - $qb->expr()->diff('u.id', '2') => u.id - 2
        public function diff($x, $y); // Returns Expr\Math instance

        // Example - $qb->expr()->sum('u.id', '2') => u.id + 2
        public function sum($x, $y); // Returns Expr\Math instance

        // Example - $qb->expr()->quot('u.id', '2') => u.id / 2
        public function quot($x, $y); // Returns Expr\Math instance


        /** Pseudo-function objects **/

        // Example - $qb->expr()->exists($qb2->getDql())
        public function exists($subquery); // Returns Expr\Func instance

        // Example - $qb->expr()->all($qb2->getDql())
        public function all($subquery); // Returns Expr\Func instance

        // Example - $qb->expr()->some($qb2->getDql())
        public function some($subquery); // Returns Expr\Func instance

        // Example - $qb->expr()->any($qb2->getDql())
        public function any($subquery); // Returns Expr\Func instance

        // Example - $qb->expr()->not($qb->expr()->eq('u.id', '?1'))
        public function not($restriction); // Returns Expr\Func instance

        // Example - $qb->expr()->in('u.id', array(1, 2, 3))
        // Make sure that you do NOT use something similar to $qb->expr()->in('value', array('stringvalue')) as this will cause Doctrine to throw an Exception.
        // Instead, use $qb->expr()->in('value', array('?1')) and bind your parameter to ?1 (see section above)
        public function in($x, $y); // Returns Expr\Func instance

        // Example - $qb->expr()->notIn('u.id', '2')
        public function notIn($x, $y); // Returns Expr\Func instance

        // Example - $qb->expr()->like('u.firstname', $qb->expr()->literal('Gui%'))
        public function like($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->notLike('u.firstname', $qb->expr()->literal('Gui%'))
        public function notLike($x, $y); // Returns Expr\Comparison instance

        // Example - $qb->expr()->between('u.id', '1', '10')
        public function between($val, $x, $y); // Returns Expr\Func


        /** Function objects **/

        // Example - $qb->expr()->trim('u.firstname')
        public function trim($x); // Returns Expr\Func

        // Example - $qb->expr()->concat('u.firstname', $qb->expr()->concat($qb->expr()->literal(' '), 'u.lastname'))
        public function concat($x, $y); // Returns Expr\Func

        // Example - $qb->expr()->substring('u.firstname', 0, 1)
        public function substring($x, $from, $len); // Returns Expr\Func

        // Example - $qb->expr()->lower('u.firstname')
        public function lower($x); // Returns Expr\Func

        // Example - $qb->expr()->upper('u.firstname')
        public function upper($x); // Returns Expr\Func

        // Example - $qb->expr()->length('u.firstname')
        public function length($x); // Returns Expr\Func

        // Example - $qb->expr()->avg('u.age')
        public function avg($x); // Returns Expr\Func

        // Example - $qb->expr()->max('u.age')
        public function max($x); // Returns Expr\Func

        // Example - $qb->expr()->min('u.age')
        public function min($x); // Returns Expr\Func

        // Example - $qb->expr()->abs('u.currentBalance')
        public function abs($x); // Returns Expr\Func

        // Example - $qb->expr()->sqrt('u.currentBalance')
        public function sqrt($x); // Returns Expr\Func

        // Example - $qb->expr()->count('u.firstname')
        public function count($x); // Returns Expr\Func

        // Example - $qb->expr()->countDistinct('u.surname')
        public function countDistinct($x); // Returns Expr\Func
    }

Adding a Criteria to a Query
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You can also add a :ref:`Criteria <filtering-collections>` to a QueryBuilder by
using ``addCriteria``:

.. code-block:: php

    <?php
    use Doctrine\Common\Collections\Criteria;
    // ...

    $criteria = Criteria::create()
        ->orderBy(['firstName', 'ASC']);

    // $qb instanceof QueryBuilder
    $qb->addCriteria($criteria);
    // then execute your query like normal

Low Level API
^^^^^^^^^^^^^

Now we will describe the low level method of creating queries.
It may be useful to work at this level for optimization purposes,
but most of the time it is preferred to work at a higher level of
abstraction.

All helper methods in ``QueryBuilder`` actually rely on a single
one: ``add()``. This method is responsible of building every piece
of DQL. It takes 3 parameters: ``$dqlPartName``, ``$dqlPart`` and
``$append`` (default=false)


-  ``$dqlPartName``: Where the ``$dqlPart`` should be placed.
   Possible values: select, from, where, groupBy, having, orderBy
-  ``$dqlPart``: What should be placed in ``$dqlPartName``. Accepts
   a string or any instance of ``Doctrine\ORM\Query\Expr\*``
-  ``$append``: Optional flag (default=false) if the ``$dqlPart``
   should override all previously defined items in ``$dqlPartName`` or
   not (no effect on the ``where`` and ``having`` DQL query parts,
   which always override all previously defined items)

-

.. code-block:: php

    <?php
    // $qb instanceof QueryBuilder

    // example6: how to define:
    // "SELECT u FROM User u WHERE u.id = ? ORDER BY u.name ASC"
    // using QueryBuilder string support
    $qb->add('select', 'u')
       ->add('from', 'User u')
       ->add('where', 'u.id = ?1')
       ->add('orderBy', 'u.name ASC');

Expr\* classes
^^^^^^^^^^^^^^

When you call ``add()`` with string, it internally evaluates to an
instance of ``Doctrine\ORM\Query\Expr\Expr\*`` class. Here is the
same query of example 6 written using
``Doctrine\ORM\Query\Expr\Expr\*`` classes:

.. code-block:: php

   <?php
   // $qb instanceof QueryBuilder

   // example7: how to define:
   // "SELECT u FROM User u WHERE u.id = ? ORDER BY u.name ASC"
   // using QueryBuilder using Expr\* instances
   $qb->add('select', new Expr\Select(array('u')))
      ->add('from', new Expr\From('User', 'u'))
      ->add('where', new Expr\Comparison('u.id', '=', '?1'))
      ->add('orderBy', new Expr\OrderBy('u.name', 'ASC'));

