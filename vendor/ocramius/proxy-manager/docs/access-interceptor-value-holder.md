---
title: Access Interceptor Value Holder Proxy
---

# Access Interceptor Value Holder Proxy

An access interceptor value holder is a smart reference proxy that allows you to dynamically
define logic to be executed before or after any of the wrapped object's methods
logic.

It wraps around a real instance of the object to be proxied, and can be useful for things like:

 * caching execution of slow and heavy methods
 * log method calls
 * debugging
 * event triggering
 * handling of orthogonal logic, and [AOP](http://en.wikipedia.org/wiki/Aspect-oriented_programming) in general

## Example

Here's an example of how you can create and use an access interceptor value holder:

```php
<?php

use ProxyManager\Factory\AccessInterceptorValueHolderFactory as Factory;

require_once __DIR__ . '/vendor/autoload.php';

class Foo
{
    public function doFoo()
    {
        echo "Foo!\n";
    }
}

$factory = new Factory();

$proxy = $factory->createProxy(
    new Foo(),
    ['doFoo' => function () { echo "PreFoo!\n"; }],
    ['doFoo' => function () { echo "PostFoo!\n"; }]
);

$proxy->doFoo();
```

This send something like following to your output:

```
PreFoo!
Foo!
PostFoo!
```

## Implementing pre- and post- access interceptors

A proxy produced by the
[`ProxyManager\Factory\AccessInterceptorValueHolderFactory`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Factory/AccessInterceptorValueHolderFactory.php)
implements the
[`ProxyManager\Proxy\AccessInterceptorValueHolderInterface`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Proxy/AccessInterceptorValueHolderInterface.php).

Therefore, you can set an access interceptor callback by calling:

```php
$proxy->setMethodPrefixInterceptor('methodName', function () { echo 'pre'; });
$proxy->setMethodSuffixInterceptor('methodName', function () { echo 'post'; });
```

You can also listen to public properties access by attaching interceptors to `__get`, `__set`, `__isset` and `__unset`.

A prefix interceptor (executed before method logic) should have the following signature:

```php
/**
 * @var object $proxy       the proxy that intercepted the method call
 * @var object $instance    the wrapped instance within the proxy
 * @var string $method      name of the called method
 * @var array  $params      sorted array of parameters passed to the intercepted
 *                          method, indexed by parameter name
 * @var bool   $returnEarly flag to tell the interceptor proxy to return early, returning
 *                          the interceptor's return value instead of executing the method logic
 *
 * @return mixed
 */
$prefixInterceptor = function ($proxy, $instance, $method, $params, & $returnEarly) {};
```

A suffix interceptor (executed after method logic) should have the following signature:

```php
/**
 * @var object $proxy       the proxy that intercepted the method call
 * @var object $instance    the wrapped instance within the proxy
 * @var string $method      name of the called method
 * @var array  $params      sorted array of parameters passed to the intercepted
 *                          method, indexed by parameter name
 * @var mixed  $returnValue the return value of the intercepted method
 * @var bool   $returnEarly flag to tell the proxy to return early, returning the interceptor's
 *                          return value instead of the value produced by the method
 *
 * @return mixed
 */
$suffixInterceptor = function ($proxy, $instance, $method, $params, $returnValue, & $returnEarly) {};
```

## Known limitations

 * methods using `func_get_args()`, `func_get_arg()` and `func_num_arg()` will not function properly
   for parameters that are not part of the proxied object interface: use 
   [variadic arguments](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list)
   instead.

## Tuning performance for production

See [Tuning ProxyManager for Production](https://github.com/Ocramius/ProxyManager/blob/master/docs/tuning-for-production.md).
