# Intro to Knp Pager Component

This is a PHP 7 paginator with a totally different core concept.

**Note:** it is still experimental, any ideas on structural design are very welcome

How is it different? First of all, it uses Symfony's **event dispatcher** to paginate whatever is needed.
The pagination process involves triggering events which hit the **subscribers**. If the subscriber
knows how to paginate the given object, it does. Finally, some subscriber must initialize the
**pagination view** object, which will be the result of pagination request. Pagination view
can be anything which will be responsible for how to render the pagination.

**Magic?** no! only KISS principle

Why reinvent the wheel? Can someone tell me what's the definition of **wheel** in the software world? 

## Requirements:

- Symfony EventDispatcher component
- Namespace based autoloader for this library

## Features:

- Can be customized in any way needed, etc.: pagination view, event subscribers.
- Possibility to add custom filtering, sorting functionality depending on request parameters.
- Pagination view extensions based on event.
- Paginator extensions based on events, etc.: another object pagination compatibilities.
- Supports multiple paginations during one request
- Separation of concern, paginator is responsible for generating the pagination view only,
pagination view - for representation purposes.
- Does not require initializing specific adapters
- [configurable](config.md)

## Usage examples:

### Controller

```php
$paginator = new Knp\Component\Pager\Paginator;
$target = range('a', 'u');
// uses event subscribers to paginate $target
$pagination = $paginator->paginate($target, 2/*page*/, 10/*limit*/);

// iterate paginated items
foreach ($pagination as $item) {
    //...
}
echo $pagination; // renders pagination

// overriding view rendering

$pagination->renderer = function($data) use ($template) {
    return $twig->render($template, $data);
};

echo $pagination;

```

### Doctrine query pagination

Easy paginate over Doctrine ORM query:

```php
$pagination = $paginator->paginate($em->createQuery('SELECT a FROM Entity\Article a'), 1/*page*/, 10/*limit*/);
```

### Custom data repository pagination

For applications having custom data repositories (like DDD repositories, CQRS read models) you can provide custom
data rerieval inside callbacks.

```php
$repository = ...;

$count = function () use ($repository) {
    // your $repository invocation here
};
$items = function ($offset, $limit) use ($repository) {
    // your $repository invocation here
};
$target = CallbackPagination($count, $items);
$pagination = $paginator->paginate($target, 2/*page*/, 10/*limit*/);

// ...
```
