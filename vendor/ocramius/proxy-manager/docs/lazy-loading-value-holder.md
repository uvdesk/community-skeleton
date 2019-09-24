---
title: Lazy Loading Value Holder Proxy
---

# Lazy Loading Value Holder Proxy

A lazy loading value holder proxy is a virtual proxy that wraps and lazily initializes a "real" instance of the proxied
class.

## What is lazy loading?

In pseudo-code, in userland, [lazy loading](http://www.martinfowler.com/eaaCatalog/lazyLoad.html) looks like following:

```php
class MyObjectProxy
{
    private $wrapped;

    public function doFoo()
    {
        $this->init();

        return $this->wrapped->doFoo();
    }

    private function init()
    {
        if (null === $this->wrapped) {
            $this->wrapped = new MyObject();
        }
    }
}
```

This code is problematic, and adds a lot of complexity that makes your unit tests' code even worse.

Also, this kind of usage often ends up in coupling your code with a particular
[Dependency Injection Container](http://martinfowler.com/articles/injection.html)
or a framework that fetches dependencies for you.
That way, further complexity is introduced, and some problems related
with service location raise, as I've explained
[in this article](http://ocramius.github.com/blog/zf2-and-symfony-service-proxies-with-doctrine-proxies/).

Lazy loading value holders abstract this logic for you, hiding your complex, slow, performance-impacting objects behind
tiny wrappers that have their same API, and that get initialized at first usage.

## When do I use a lazy value holder?

You usually need a lazy value holder in cases where following applies

 * your object takes a lot of time and memory to be initialized (with all dependencies)
 * your object is not always used, and the instantiation overhead can be avoided

## Usage examples

[ProxyManager](https://github.com/Ocramius/ProxyManager) provides a factory that eases instantiation of lazy loading
value holders. To use it, follow these steps:

First of all, define your object's logic without taking care of lazy loading:

```php
namespace MyApp;

class HeavyComplexObject
{
    public function __construct()
    {
        // just write your business logic
        // don't worry about how heavy initialization of this will be!
    }

    public function doFoo() {
        echo 'OK!';
    }
}
```

Then use the proxy manager to create a lazy version of the object (as a proxy):

```php
namespace MyApp;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\LazyLoadingInterface;

require_once __DIR__ . '/vendor/autoload.php';

$factory     = new LazyLoadingValueHolderFactory();
$initializer = function (& $wrappedObject, LazyLoadingInterface $proxy, $method, array $parameters, & $initializer) {
    $initializer   = null; // disable initialization
    $wrappedObject = new HeavyComplexObject(); // fill your object with values here

    return true; // confirm that initialization occurred correctly
};

$proxy = $factory->createProxy('MyApp\HeavyComplexObject', $initializer);
```

You can now simply use your object as before:

```php
// this will just work as before
$proxy->doFoo(); // OK!
```

## Lazy Initialization

As you can see, we use a closure to handle lazy initialization of the proxy instance at runtime.
The initializer closure signature should be as following:

```php
/**
 * @var object  $wrappedObject the instance (passed by reference) of the wrapped object,
 *                             set it to your real object
 * @var object  $proxy         the instance proxy that is being initialized
 * @var string  $method        the name of the method that triggered lazy initialization
 * @var array   $parameters    an ordered list of parameters passed to the method that
 *                             triggered initialization, indexed by parameter name
 * @var Closure $initializer   a reference to the property that is the initializer for the
 *                             proxy. Set it to null to disable further initialization
 *
 * @return bool true on success
 */
$initializer = function (& $wrappedObject, $proxy, $method, array $parameters, & $initializer) {};
```

The initializer closure should usually be coded like following:

```php
$initializer = function (& $wrappedObject, $proxy, $method, array $parameters, & $initializer) {
    $newlyCreatedObject = new Foo(); // instantiation logic
    $newlyCreatedObject->setBar('baz') // instantiation logic
    $newlyCreatedObject->setBat('bam') // instantiation logic

    $wrappedObject = $newlyCreatedObject; // set wrapped object in the proxy
    $initializer   = null; // disable initializer

    return true; // report success
};
```

The
[`ProxyManager\Factory\LazyLoadingValueHolderFactory`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Factory/LazyLoadingValueHolderFactory.php)
produces proxies that implement both the
[`ProxyManager\Proxy\ValueHolderInterface`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Proxy/ValueHolderInterface.php)
and the
[`ProxyManager\Proxy\LazyLoadingInterface`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Proxy/LazyLoadingInterface.php).

At any point in time, you can set a new initializer for the proxy:

```php
$proxy->setProxyInitializer($initializer);
```

In your initializer, you currently **MUST** turn off any further initialization:

```php
$proxy->setProxyInitializer(null);
```

or

```php
$initializer = null; // if you use the initializer by reference
```

## Triggering Initialization

A lazy loading proxy is initialized whenever you access any property or method of it.
Any of the following interactions would trigger lazy initialization:

```php
// calling a method
$proxy->someMethod();

// reading a property
echo $proxy->someProperty;

// writing a property
$proxy->someProperty = 'foo';

// checking for existence of a property
isset($proxy->someProperty);

// removing a property
unset($proxy->someProperty);

// cloning the entire proxy
clone $proxy;

// serializing the proxy
$unserialized = serialize(unserialize($proxy));
```

Remember to call `$proxy->setProxyInitializer(null);` to disable initialization of your proxy, or it will happen more
than once.

## Proxying interfaces

You can also generate proxies from an interface FQCN. By proxying an interface, you will only be able to access the
methods defined by the interface itself, even if the `wrappedObject` implements more methods. This will anyway save
some memory since the proxy won't contain useless inherited properties.

## Known limitations

 * methods using `func_get_args()`, `func_get_arg()` and `func_num_arg()` will not function properly
   for parameters that are not part of the proxied object interface: use 
   [variadic arguments](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list)
   instead.

## Tuning performance for production

See [Tuning ProxyManager for Production](tuning-for-production.md).
