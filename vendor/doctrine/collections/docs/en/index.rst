Introduction
============

Doctrine Collections is a library that contains classes for working with
arrays of data. Here is an example using the simple
``Doctrine\Common\Collections\ArrayCollection`` class:

.. code-block:: php
    <?php

    use Doctrine\Common\Collections\ArrayCollection;

    $collection = new ArrayCollection([1, 2, 3]);

    $filteredCollection = $collection->filter(function($count) {
        return $count > 1;
    }); // [2, 3]

Collection Methods
==================

Doctrine Collections provides an interface named ``Doctrine\Common\Collections\Collection``
that resembles the nature of a regular PHP array. That is,
it is essentially an **ordered map** that can also be used
like a list.

A Collection has an internal iterator just like a PHP array. In addition,
a Collection can be iterated with external iterators, which is preferable.
To use an external iterator simply use the foreach language construct to
iterate over the collection, which calls ``getIterator()`` internally, or
explicitly retrieve an iterator though ``getIterator()`` which can then be
used to iterate over the collection. You can not rely on the internal iterator
of the collection being at a certain position unless you explicitly positioned it before.

The methods available on the interface are:

add
---

Adds an element at the end of the collection.

.. code-block:: php
    $collection->add('test');

clear
-----

Clears the collection, removing all elements.

.. code-block:: php
    $collection->clear();

contains
--------

Checks whether an element is contained in the collection. This is an O(n) operation, where n is the size of the collection.

.. code-block:: php
    $collection = new Collection(['test']);

    $contains = $collection->contains('test'); // true

containsKey
-----------

Checks whether the collection contains an element with the specified key/index.

.. code-block:: php
    $collection = new Collection(['test' => true]);

    $contains = $collection->containsKey('test'); // true

current
-------

Gets the element of the collection at the current iterator position.

.. code-block:: php
    $collection = new Collection(['first', 'second', 'third']);

    $current = $collection->current(); // first

get
---

Gets the element at the specified key/index.

.. code-block:: php
    $collection = new Collection([
        'key' => 'value',
    ]);

    $value = $collection->get('key'); // value

getKeys
-------

Gets all keys/indices of the collection.

.. code-block:: php
    $collection = new Collection(['a', 'b', 'c']);

    $keys = $collection->getKeys(); // [0, 1, 2]

getValues
---------

Gets all values of the collection.

.. code-block:: php
    $collection = new Collection([
        'key1' => 'value1',
        'key2' => 'value2',
        'key3' => 'value3',
    ]);

    $values = $collection->getValues(); // ['value1', 'value2', 'value3']

isEmpty
-------

Checks whether the collection is empty (contains no elements).

.. code-block:: php
    $collection = new Collection(['a', 'b', 'c']);

    $isEmpty = $collection->isEmpty(); // false

first
-----

Sets the internal iterator to the first element in the collection and returns this element.

.. code-block:: php
    $collection = new Collection(['first', 'second', 'third']);

    $first = $collection->first(); // first

exists
------

Tests for the existence of an element that satisfies the given predicate.

.. code-block:: php
    $collection = new Collection(['first', 'second', 'third']);

    $exists = $collection->exists(function($key, $value) {
        return $value === 'first';
    }); // true

filter
------

Returns all the elements of this collection that satisfy the predicate. The order of the elements is preserved.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $filteredCollection = $collection->filter(function($count) {
        return $count > 1;
    }); // [2, 3]

forAll
------

Tests whether the given predicate holds for all elements of this collection.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $forAll = $collection->forAll(function($key, $value) {
        return $value > 1;
    }); // false

indexOf
-------

Gets the index/key of a given element. The comparison of two elements is strict, that means not only the value but also the type must match. For objects this means reference equality.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $indexOf = $collection->indexOf(3); // 2

key
---

Gets the key/index of the element at the current iterator position.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $collection->next();

    $key = $collection->key(); // 1

last
----

Sets the internal iterator to the last element in the collection and returns this element.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $last = $collection->last(); // 3

map
---

Applies the given function to each element in the collection and returns a new collection with the elements returned by the function.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $mappedCollection = $collection->map(function($value) {
        return $value + 1;
    }); // [2, 3, 4]

next
----

Moves the internal iterator position to the next element and returns this element.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $next = $collection->next(); // 2

partition
---------

Partitions this collection in two collections according to a predicate. Keys are preserved in the resulting collections.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $mappedCollection = $collection->partition(function($key, $value) {
        return $value > 1
    }); // [[2, 3], [1]]

remove
------

Removes the element at the specified index from the collection.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $collection->remove(0); // [2, 3]

removeElement
-------------

Removes the specified element from the collection, if it is found.

.. code-block:: php
    $collection = new ArrayCollection([1, 2, 3]);

    $collection->removeElement(3); // [1, 2]

set
---

Sets an element in the collection at the specified key/index.

.. code-block:: php
    $collection = new ArrayCollection();

    $collection->set('name', 'jwage');

slice
-----

Extracts a slice of $length elements starting at position $offset from the Collection. If $length is null it returns all elements from $offset to the end of the Collection. Keys have to be preserved by this method. Calling this method will only return the selected slice and NOT change the elements contained in the collection slice is called on.

.. code-block:: php
    $collection = new ArrayCollection([0, 1, 2, 3, 4, 5]);

    $slice = $collection->slice(1, 2); // [1, 2]

toArray
-------

Gets a native PHP array representation of the collection.

.. code-block:: php
    $collection = new ArrayCollection([0, 1, 2, 3, 4, 5]);

    $array = $collection->toArray(); // [0, 1, 2, 3, 4, 5]

Selectable Methods
==================

Some Doctrine Collections, like ``Doctrine\Common\Collections\ArrayCollection``,
implement an interface named ``Doctrine\Common\Collections\Selectable``
that offers the usage of a powerful expressions API, where conditions
can be applied to a collection to get a result with matching elements
only.

matching
--------

Selects all elements from a selectable that match the expression and
returns a new collection containing these elements.

.. code-block:: php
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\Common\Collections\Expr\Comparison;

    $collection = new ArrayCollection([
        [
            'name' => 'jwage',
        ],
        [
            'name' => 'romanb',
        ],
    ]);

    $expr = new Comparison('name', '=', 'jwage');

    $criteria = new Criteria();

    $criteria->where($expr);

    $matched = $collection->matching($criteria); // ['jwage']

You can read more about expressions :ref:`here <expressions>`.
