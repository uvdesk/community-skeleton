---
title: Remote Object Proxy
---

# Remote Object Proxy

The remote object implementation is a mechanism that enables an local object to control an other object on an other server.
Each call method on the local object will do a network call to get information or execute operations on the remote object.

## What is remote object proxy ?

A remote object is based on an interface. The remote interface defines the API that a consumer can call. This interface 
must be implemented both by the client and the RPC server.

## Adapters

ZendFramework's RPC components (XmlRpc, JsonRpc & Soap) can be used easily with the remote object.
You will need to require the one you need via composer, though:

```sh
$ php composer.phar require zendframework/zend-xmlrpc:2.*
$ php composer.phar require zendframework/zend-json:2.*
$ php composer.phar require zendframework/zend-soap:2.*
```

ProxyManager comes with 3 adapters:

 * `ProxyManager\Factory\RemoteObject\Adapter\XmlRpc`
 * `ProxyManager\Factory\RemoteObject\Adapter\JsonRpc`
 * `ProxyManager\Factory\RemoteObject\Adapter\Soap`

## Usage examples

RPC server side code (`xmlrpc.php` in your local webroot):

```php
interface FooServiceInterface
{
    public function foo();
}

class Foo implements FooServiceInterface
{
    /**
     * Foo function
     * @return string
     */
    public function foo()
    {
        return 'bar remote';
    }
}

$server = new Zend\XmlRpc\Server();
$server->setClass('Foo', 'FooServiceInterface');  // my FooServiceInterface implementation
$server->handle();
```

Client side code (proxy) :

```php

interface FooServiceInterface
{
    public function foo();
}

$factory = new \ProxyManager\Factory\RemoteObjectFactory(
    new \ProxyManager\Factory\RemoteObject\Adapter\XmlRpc(
        new \Zend\XmlRpc\Client('https://localhost/xmlrpc.php')
    )
);

$proxy = $factory->createProxy('FooServiceInterface');

var_dump($proxy->foo()); // "bar remote"
```

## Implementing custom adapters

Your adapters must implement `ProxyManager\Factory\RemoteObject\AdapterInterface` :

```php
interface AdapterInterface
{
    /**
     * Call remote object
     *
     * @param string $wrappedClass
     * @param string $method
     * @param array $params
     *
     * @return mixed
     */
    public function call($wrappedClass, $method, array $params = []);
}
```

It is very easy to create your own implementation (for RESTful web services, for example). Simply pass
your own adapter instance to your factory at construction time

## Known limitations

 * methods using `func_get_args()`, `func_get_arg()` and `func_num_arg()` will not function properly
   for parameters that are not part of the proxied object interface: use 
   [variadic arguments](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list)
   instead.

## Tuning performance for production

See [Tuning ProxyManager for Production](tuning-for-production.md).
