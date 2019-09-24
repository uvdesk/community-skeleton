# Usage of Pager component

This tutorial will cover installation and usage examples.

## Installation

    composer require "knplabs/knp-components:~1.2"

## Basic usage

As mentioned in [introduction](https://github.com/knplabs/knp-components/tree/master/doc/pager/intro.md)
paginator uses event listeners to paginate the given data. First we will start from the simplest data - array.
Lets add some code in **index.php** and see it in action:

``` php
<?php
// file: index.php
include 'autoloader.php';

// usage examples will continue here

use Knp\Component\Pager\Paginator; // used class name

// end of line and tab definition
define('EOL', php_sapi_name() === 'cli' ? PHP_EOL : '<br/>');
define('TAB', php_sapi_name() === 'cli' ? "\t" : '<span style="margin-left:25px"/>');

$paginator = new Paginator; // initializes default event dispatcher, with standard listeners
$target = range('a', 'z'); // an array to paginate
// paginate target and generate representation class, it can be overrided by event listener
$pagination = $paginator->paginate($target, 1/*page number*/, 10/*limit per page*/);

echo 'total count: '.$pagination->getTotalItemCount().EOL;
echo 'pagination items of page: '.$pagination->getCurrentPageNumber().EOL;
// iterate items
foreach ($pagination as $item) {
    //...
    echo TAB.'paginated item: '.$item.EOL;
}

$pagination = $paginator->paginate($target, 3/*page number*/, 10/*limit per page*/);
echo 'pagination items of page: '.$pagination->getCurrentPageNumber().EOL;
// iterate items
foreach ($pagination as $item) {
    //...
    echo TAB.'paginated item: '.$item.EOL;
}
```

### Rendering pagination

**$paginator->paginate($target...)** will return pagination class, which is by
default **SlidingPagination** it executes a **$pagination->renderer** callback
with all arguments reguired in view template. Its your decision to implement
it whatever way you like.

**Note:** this is the default method. There will be more examples on how to render pagination templates

So if you by default print the pagination you should see something like:

``` php
<?php
// continuing in file: index.php
// ...

echo $pagination; // outputs: "override in order to render a template"
```

Now if we override the renderer callback

``` php
<?php
// continuing in file: index.php
// ...

$pagination->renderer = function($data) {
    return EOL.TAB.'page range: '.implode(' ', $data['pagesInRange']).EOL;
};
echo $pagination; // outputs: "page range: 1 2 3"
```

## Sorting database query results by multiple columns (only Doctrine ORM)

It is not uncommonly that the result of a database query should be sorted by multiple columns.
For example users should be sorted by lastname and by firstname:

```php
$query = $entityManager->createQuery('SELECT u FROM User');

$pagination = $paginator->paginate($query, 1/*page number*/, 20/*limit per page*/, array(
    'defaultSortFieldName' => array('u.lastname', 'u.firstname'),
    'defaultSortDirection' => 'asc',
));
```

The Paginator will add an `ORDER BY` automatically for each attribute for the
`defaultSortFieldName` option.

## Filtering database query results by multiple columns (only Doctrine ORM and Propel)

You can also filter the result of a database query by multiple columns.
For example users should be filtered by lastname or by firstname:

```php
$query = $entityManager->createQuery('SELECT u FROM User');

$pagination = $paginator->paginate($query, 1/*page number*/, 20/*limit per page*/, array(
    'defaultFilterFields' => array('u.lastname', 'u.firstname'),
));
```

If the `filterValue` parameter is set, the Paginator will add an `WHERE` condition automatically 
for each attribute for the `defaultFilterFields` option. The conditions are `OR`-linked.
