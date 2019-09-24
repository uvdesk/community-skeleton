# Manual counting

**Note:** this documentation concerns more advanced usage of ORM
query pagination. Paginator cannot support two **FROM** components
or composite identifiers, because it cannot predict the total count
in the database.

The solution to that is simple and direct, you can provide the **count**
manually through the hint on the query.

## Usage example

``` php
<?php

$paginator = new Paginator;

$count = $entityManager
    ->createQuery('SELECT COUNT(c) FROM Entity\CompositeKey c')
    ->getSingleScalarResult()
;

$query = $entityManager
    ->createQuery('SELECT c FROM Entity\CompositeKey c')
    ->setHint('knp_paginator.count', $count)
;
$pagination = $paginator->paginate($query, 1, 10, array('distinct' => false));
```

Distinction in this case also cannot be determined by paginator. It will take direct result
of the query and limit with offset. In some cases you may need to use **GROUP BY**

