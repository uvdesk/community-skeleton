---
title: Null Object Proxy
---

# Null Object Proxy

A Null Object proxy is a [null object pattern](http://en.wikipedia.org/wiki/Null_Object_pattern) implementation.
The proxy factory creates a new object with defined neutral behavior based on an other object, class name or interface.

## What is null object proxy ?

In your application, when you can't return the object related to the request, the consumer of the model must check 
for the return value and handle the failing condition gracefully, thus generating an explosion of conditionals throughout your code.
Fortunately, this seemingly-tangled situation can be sorted out simply by creating a polymorphic implementation of the 
domain object, which would implement the same interface as the one of the object in question, only that its methods 
wouldn't do anything, therefore offloading client code from doing repetitive checks for ugly null values when the operation
 is executed.

## Usage examples

```php
class UserMapper
{   
    private $adapter;
    
    public function __construct(DatabaseAdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchById($id) {
        $this->adapter->select('users', ['id' => $id]);
        
        if (!$row = $this->adapter->fetch()) {
            return null;
        }
        
        return $this->createUser($row);
    }
     
    private function createUser(array $row) {
        $user = new Entity\User($row['name'], $row['email']);
        
        $user->setId($row['id']);
        
        return $user;
    }
}
```

If you want to remove conditionals from client code, you need to have a version of the entity conforming to the corresponding 
interface. With the Null Object Proxy, you can build this object :

```php
$factory = new \ProxyManager\Factory\NullObjectFactory();

$nullUser = $factory->createProxy('Entity\User');

var_dump($nullUser->getName()); // empty return
```

You can now return a valid entity :

```php
class UserMapper
{   
    private $adapter;
    
    public function __construct(DatabaseAdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchById($id) {
        $this->adapter->select('users', ['id' => $id]);
        
        return $this->createUser($this->adapter->fetch());
    }
     
    private function createUser($row) {
        if (!$row) {
            $factory = new \ProxyManager\Factory\NullObjectFactory();

            return $factory->createProxy('Entity\User');
        }
        
        $user = new Entity\User($row['name'], $row['email']);
        
        $user->setId($row['id']);
        
        return $user; 
    }
}
```

## Proxying interfaces

You can also generate proxies from an interface FQCN. By proxying an interface, you will only be able to access the
methods defined by the interface itself, and like with the object, the methods are empty.

## Tuning performance for production

See [Tuning ProxyManager for Production](tuning-for-production.md).
