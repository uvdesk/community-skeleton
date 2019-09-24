---
title: Lazy Loading Ghost Object Proxies
---

# Lazy Loading Ghost Object Proxies

A Lazy Loading Ghost is a type of proxy object.

More specifically, it is a fake object that looks exactly like an object
that you want to interact with, but is actually just an empty instance
that gets all properties populated as soon as they are needed.

Those properties do not really exist until the ghost object is actually
initialized.

## Lazy loading with the Ghost Object

In pseudo-code, in userland, [lazy loading](http://www.martinfowler.com/eaaCatalog/lazyLoad.html) in a ghost object
looks like following:

```php
class MyObjectProxy
{
    private $initialized = false;
    private $name;
    private $surname;

    public function doFoo()
    {
        $this->init();

        // Perform doFoo routine using loaded variables
    }

    private function init()
    {
        if (! $this->initialized) {
            $data          = some_logic_that_loads_data();

            $this->name    = $data['name'];
            $this->surname = $data['surname'];

            $this->initialized = true;
        }
    }
}
```

Ghost objects work similarly to virtual proxies, but since they don't wrap around a "real" instance of the proxied
subject, they are better suited for representing dataset rows.

## When do I use a ghost object?

You usually need a ghost object in cases where following applies:

 * you are building a small data-mapper and want to lazily load data across associations in your object graph;
 * you want to initialize objects representing rows in a large dataset;
 * you want to compare instances of lazily initialized objects without the risk of comparing a proxy with a real subject;
 * you are aware of the internal state of the object and are confident in working with its internals via reflection
   or direct property access.

## Usage examples

[ProxyManager](https://github.com/Ocramius/ProxyManager) provides a factory that creates lazy loading ghost objects.
To use it, follow these steps:

First, define your object's logic without taking care of lazy loading:

```php
namespace MyApp;

class Customer
{
    private $name;
    private $surname;

    // just write your business logic or generally logic
    // don't worry about how complex this object will be!
    // don't code lazy-loading oriented optimizations in here!
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = (string) $name; }
    public function getSurname() { return $this->surname; }
    public function setSurname($surname) { $this->surname = (string) $surname; }
}
```

Then, use the proxy manager to create a ghost object of it.
You will be responsible for setting its state during lazy loading:

```php
namespace MyApp;

use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Proxy\GhostObjectInterface;

require_once __DIR__ . '/vendor/autoload.php';

$factory     = new LazyLoadingGhostFactory();
$initializer = function (
    GhostObjectInterface $ghostObject,
    string $method,
    array $parameters,
    & $initializer,
    array $properties
) {
    $initializer   = null; // disable initialization

    // load data and modify the object here
    $properties["\0MyApp\\Customer\0name"]    = 'Agent';
    $properties["\0MyApp\\Customer\0surname"] = 'Smith'; 
    
    // you may also call methods on the object, but remember that
    // the constructor was not called yet:
    $ghostObject->setSurname('Smith');

    return true; // confirm that initialization occurred correctly
};

$ghostObject = $factory->createProxy(\MyApp\Customer::class, $initializer);
```

You can now use your object as before:

```php
// this will work as before
echo $ghostObject->getName() . ' ' . $ghostObject->getSurname(); // Agent Smith
```

## Lazy Initialization

We use a closure to handle lazy initialization of the proxy instance at runtime.
The initializer closure signature for ghost objects is:

```php
/**
 * @var object  $ghostObject   The instance of the ghost object proxy that is being initialized.
 * @var string  $method        The name of the method that triggered lazy initialization.
 * @var array   $parameters    An ordered list of parameters passed to the method that
 *                             triggered initialization, indexed by parameter name.
 * @var Closure $initializer   A reference to the property that is the initializer for the
 *                             proxy. Set it to null to disable further initialization.
 * @var array   $properties    By-ref array with the properties defined in the object, with their
 *                             default values pre-assigned. Keys are in the same format that
 *                             an (array) cast of an object would provide:
 *                              - `"\0Ns\\ClassName\0propertyName"` for `private $propertyName`
 *                                defined on `Ns\ClassName`
 *                              - `"\0Ns\\ClassName\0propertyName"` for `protected $propertyName`
 *                                defined in any level of the hierarchy
 *                              - `"propertyName"` for `public $propertyName`
 *                                defined in any level of the hierarchy
 *
 * @return bool true on success
 */
$initializer = function (
    \ProxyManager\Proxy\GhostObjectInterface $ghostObject,
    string $method,
    array $parameters,
    & $initializer,
    array $properties
) {};
```

The initializer closure should usually be coded like following:

```php
$initializer = function (
    \ProxyManager\Proxy\GhostObjectInterface $ghostObject,
    string $method,
    array $parameters,
    & $initializer,
    array $properties
) {
    $initializer = null; // disable initializer for this proxy instance

    // initialize properties (please read further on)
    $properties["\0ClassName\0foo"] = 'foo';
    $properties["\0ClassName\0bar"] = 'bar'; 

    return true; // report success
};
```

### Lazy initialization `$properties` explained

The assignments to properties in this closure use unusual `"\0"` sequences.
This is to be consistent with how PHP represents private and protected properties when
casting an object to an array.
`ProxyManager` simply copies a reference to the properties into the `$properties` array passed to the
initializer, which allows you to set the state of the object without accessing any of its public
API. (This is a very important detail for mapper implementations!)

Specifically:

 * `"\0Ns\\ClassName\0propertyName"` means `private $propertyName` defined in `Ns\ClassName`;
 * `"\0*\0propertyName"` means `protected $propertyName` defined in any level of the class 
   hierarchy;
 * `"propertyName"` means `public $propertyName` defined in any level of the class hierarchy.

Therefore, given this class:

```php
namespace MyNamespace;

class MyClass
{
    private $property1;
    protected $property2;
    public $property3;
}
```

Its appropriate initialization code would be:

```php
namespace MyApp;

use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Proxy\GhostObjectInterface;

require_once __DIR__ . '/vendor/autoload.php';

$factory     = new LazyLoadingGhostFactory();
$initializer = function (
    GhostObjectInterface $ghostObject,
    string $method,
    array $parameters,
    & $initializer,
    array $properties
) {
    $initializer = null;

    $properties["\0MyNamespace\\MyClass\0property1"] = 'foo';  //private property of MyNamespace\MyClass
    $properties["\0*\0property2"]                    = 'bar';  //protected property in MyClass's hierarchy
    $properties["property3"]                         = 'baz';  //public property in MyClass's hierarchy

    return true;
};

$instance = $factory->createProxy(\MyNamespace\MyClass::class, $initializer);
```

This code would initialize `$property1`, `$property2` and `$property3`
respectively to `"foo"`, `"bar"` and `"baz"`.

You may read the default values for those properties by reading the respective array keys.

Although it is possible to initialize the object by interacting with its public API, it is
not safe to do so, because the object only contains default property values since its constructor was not called.

## Proxy implementation

The
[`ProxyManager\Factory\LazyLoadingGhostFactory`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Factory/LazyLoadingGhostFactory.php)
produces proxies that implement the
[`ProxyManager\Proxy\GhostObjectInterface`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/Proxy/GhostObjectInterface.php).

At any point in time, you can set a new initializer for the proxy:

```php
$ghostObject->setProxyInitializer($initializer);
```

In your initializer, you **MUST** turn off any further initialization:

```php
$ghostObject->setProxyInitializer(null);
```

or

```php
$initializer = null; // if you use the initializer passed by reference to the closure
```

Remember to call `$ghostObject->setProxyInitializer(null);`, or to set `$initializer = null` inside your
initializer closure to disable initialization of your proxy, or else initialization will trigger
more than once.

## Triggering Initialization

A lazy loading ghost object is initialized whenever you access any of its properties.
Any of the following interactions would trigger lazy initialization:

```php
// calling a method (only if the method accesses internal state)
$ghostObject->someMethod();

// reading a property
echo $ghostObject->someProperty;

// writing a property
$ghostObject->someProperty = 'foo';

// checking for existence of a property
isset($ghostObject->someProperty);

// removing a property
unset($ghostObject->someProperty);

// accessing a property via reflection
$reflection = new \ReflectionProperty($ghostObject, 'someProperty');
$reflection->setAccessible(true);
$reflection->getValue($ghostObject);

// cloning the entire proxy
clone $ghostObject;

// serializing the proxy
$unserialized = unserialize(serialize($ghostObject));
```

A method like following would never trigger lazy loading, in the context of a ghost object:

```php
public function sayHello() : string
{
    return 'Look ma! No property accessed!';
}
```

## Skipping properties (properties that should not be initialized)

In some contexts, you may want some properties to be completely ignored by the lazy-loading
system.

An example for that (in data mappers) is entities with identifiers: an identifier is usually

 * lightweight
 * known at all times

This means that it can be set in our object at all times, and we never need to lazy-load
it. Here is a typical example:

```php
namespace MyApp;

class User
{
    private $id;
    private $username;
    private $passwordHash;
    private $email;
    private $address;
    // ...
    
    public function getId() : int
    {
        return $this->id;
    }
}
```

If we want to skip the property `$id` from lazy-loading, we might want to tell that to
the `LazyLoadingGhostFactory`. Here is a longer example, with a more near-real-world
scenario:

```php
namespace MyApp;

use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Proxy\GhostObjectInterface;

require_once __DIR__ . '/vendor/autoload.php';

$factory     = new LazyLoadingGhostFactory();
$initializer = function (
    GhostObjectInterface $ghostObject,
    string $method,
    array $parameters,
    & $initializer,
    array $properties
) {
    $initializer = null;

    // note that `getId` won't initialize our proxy here
    $properties["\0MyApp\\User\0username"]     = $db->fetchField('users', 'username', $ghostObject->getId();
    $properties["\0MyApp\\User\0passwordHash"] = $db->fetchField('users', 'passwordHash', $ghostObject->getId();
    $properties["\0MyApp\\User\0email"]        = $db->fetchField('users', 'email', $ghostObject->getId();
    $properties["\0MyApp\\User\0address"]      = $db->fetchField('users', 'address', $ghostObject->getId();

    return true;
};
$proxyOptions = [
    'skippedProperties' => [
        "\0MyApp\\User\0id",
    ],
];

$instance = $factory->createProxy(User::class, $initializer, $proxyOptions);

$idReflection = new \ReflectionProperty(User::class, 'id');

$idReflection->setAccessible(true);

// write the identifier into our ghost object (assuming `setId` doesn't exist)
$idReflection->setValue($instance, 1234);
```

In this example, we pass a `skippedProperties` array to our proxy factory. Note the use of the `"\0"` parameter syntax as described above.

## Proxying interfaces

A lazy loading ghost object cannot proxy an interface directly, as it operates directly around
the state of an object. Use a [Virtual Proxy](lazy-loading-value-holder.md) for that instead.

## Tuning performance for production

See [Tuning ProxyManager for Production](tuning-for-production.md).
