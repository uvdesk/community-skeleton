---
title: Changelog
---

This is a list of changes/improvements that were introduced in ProxyManager

## 2.2.0

This release provides support for the PHP 7.2 `object` type hint, as
well as dramatic (~300%) speed improvement during proxy class generation.
PHP 7.1 support has been dropped.

Total issues resolved: **11**

- [367: Property name (suffixes) differ after each generation of a proxy](https://github.com/Ocramius/ProxyManager/issues/367) thanks to @holtkamp
- [381: Adding `object` hit based tests and test assets - preparing for PHP 7.2 compatibility](https://github.com/Ocramius/ProxyManager/pull/381) thanks to @Ocramius
- [382: Removed redundant docblocks](https://github.com/Ocramius/ProxyManager/pull/382) thanks to @Ocramius
- [383: PHPStan version upgrade 0.8](https://github.com/Ocramius/ProxyManager/pull/383) thanks to @Ocramius
- [384: Group generated unique identifiers by name](https://github.com/Ocramius/ProxyManager/pull/384) thanks to @nicolas-grekas
- [385: #384 #367 deterministic generated property suffixes for generated properties](https://github.com/Ocramius/ProxyManager/pull/385) thanks to @Ocramius
- [386: Removed licence headers from all single source files](https://github.com/Ocramius/ProxyManager/pull/386) thanks to @Ocramius
- [387: Correct createProxy PHPDoc](https://github.com/Ocramius/ProxyManager/pull/387) thanks to @PurpleBooth
- [391: PHPUnit 6.x upgrade](https://github.com/Ocramius/ProxyManager/pull/391) thanks to @Ocramius
- [392: PHPStan level 7 analysis](https://github.com/Ocramius/ProxyManager/pull/392) thanks to @snapshotpl
- [393: remove inheritdoc &amp; body parsing from generated proxies](https://github.com/Ocramius/ProxyManager/pull/393) thanks to @Tobion

## 2.1.1

This release provides aggressive improvements in static introspection via
[phpstan/phpstan](https://github.com/phpstan/phpstan). No functional
changes, just removed possible bugs due to excessive parameter count
in method calls, as well as test type hint fixes.

Total issues resolved: **3**

- [351: Travis already has xdebug pre-installed for PHP 7.1](https://github.com/Ocramius/ProxyManager/pull/351)
- [358: Fix #351 - travis has xdebug pre-installed for PHP 7.1](https://github.com/Ocramius/ProxyManager/pull/358)
- [361: PHPStan inspection fixes](https://github.com/Ocramius/ProxyManager/pull/361)

## 2.1.0

### Improved

- Introduced support for PHP 7.1, `void` and nullable (`?`)
  types [#314](https://github.com/Ocramius/ProxyManager/issues/314)
  [#327](https://github.com/Ocramius/ProxyManager/pull/327)
- The test suite is now fully CI-covered by mutation testing [#348](https://github.com/Ocramius/ProxyManager/pull/348)
- Moved all performance testing to PHPBench [#326](https://github.com/Ocramius/ProxyManager/pull/326)
- PHP 7.0 support dropped [#327](https://github.com/Ocramius/ProxyManager/pull/327)

Total issues resolved: **9**

- [290: Branch-alias version bump: master bump to 3.0.x](https://github.com/Ocramius/ProxyManager/pull/290)
- [314: Nullable params type](https://github.com/Ocramius/ProxyManager/issues/314)
- [326: Moved performance tests to phpbench-based suite](https://github.com/Ocramius/ProxyManager/pull/326)
- [327: PHP 7.1 support](https://github.com/Ocramius/ProxyManager/pull/327)
- [336: Hotfix tests for php 7 support](https://github.com/Ocramius/ProxyManager/pull/336)
- [339: Provided type ?... is invalid](https://github.com/Ocramius/ProxyManager/issues/339)
- [343: Fix typo in ghost objects lazy loading code example](https://github.com/Ocramius/ProxyManager/pull/343)
- [348: Introduced full mutation testing](https://github.com/Ocramius/ProxyManager/pull/348)
- [349: install xdebug manually for php 7.1](https://github.com/Ocramius/ProxyManager/pull/349)

## 2.0.4

### Fixed

- Remove deprecated `getMock` usage from tests [#325](https://github.com/Ocramius/ProxyManager/pull/325)
- Fix incorrect type in docs example [#329](https://github.com/Ocramius/ProxyManager/pull/329)
- Bug when proxy `__get` magic method [#344](https://github.com/Ocramius/ProxyManager/pull/344)
- Fix lazy loading value holder magic method support [#345](https://github.com/Ocramius/ProxyManager/pull/345)

## 2.0.3

### Fixed

- Various test suite cleanups, mostly because of
  [new PHPUnit 5.4.0 deprecations being introduced](https://github.com/sebastianbergmann/phpunit/wiki/Release-Announcement-for-PHPUnit-5.4.0)
  [#318](https://github.com/Ocramius/ProxyManager/issues/318)
- Removed `zendframework/zend-code:3.0.3` from installable dependencies, since
  a critical bug was introduced in it [#321](https://github.com/Ocramius/ProxyManager/issues/321) 
  [#323](https://github.com/Ocramius/ProxyManager/issues/323)
  [#324](https://github.com/Ocramius/ProxyManager/issues/324). Please upgrade to
  `zendframework/zend-code:3.0.4` or newer.

## 2.0.2

### Fixed

- Various optimizations were performed in the [`ocramius/package-versions`](https://github.com/Ocramius/PackageVersions)
  integration in order to prevent "class not found" fatals. [#294](https://github.com/Ocramius/ProxyManager/issues/294)
- Null objects produced via a given class name were not extending from the given class name, causing obvious LSP
  compliance and type-compatibility issues. [#300](https://github.com/Ocramius/ProxyManager/issues/300)
  [#301](https://github.com/Ocramius/ProxyManager/issues/301)
- Specific installation versions were removed from the [README.md](README.md) install instructions, since composer
  is installing the latest available version by default. [#305](https://github.com/Ocramius/ProxyManager/issues/305)
- PHP 7.0.6 support was dropped. PHP 7.0.6 includes some nasty reflection bugs that caused `__isset` to be called when
  `ReflectionProperty#getValue()` is used (https://bugs.php.net/72174).
  [#306](https://github.com/Ocramius/ProxyManager/issues/306)
  [#308](https://github.com/Ocramius/ProxyManager/issues/308)
- PHP 7.0.7 contains additional limitations as to when `$this` can be used. Specifically, `$this` cannot be used as a
  parameter name for closures that have an already assigned `$this`. Due to `$this` being incorrectly used as parameter
  name within this library, running ProxyManager on PHP 7.0.7 would have caused a fatal error.
  [#306](https://github.com/Ocramius/ProxyManager/issues/306)
  [#308](https://github.com/Ocramius/ProxyManager/issues/308)
  [#316](https://github.com/Ocramius/ProxyManager/issues/316)
- PHP 7.1.0-DEV includes type-checks for incompatible arithmetic operations: some of those operations were erroneously
  performed in the library internals. [#308](https://github.com/Ocramius/ProxyManager/issues/308)

## 2.0.1

### Fixed

- Travis-CI environment was fixed to test the library using the minimum dependencies version.

### Added

- Added unit test to make sure that properties skipped should be preserved even being cloned.

## 2.0.0

### BC Breaks

Please refer to [the upgrade documentation](UPGRADE.md) to see which backwards-incompatible
changes were applied to this release.

### New features

#### PHP 7 support

ProxyManager will now correctly operate in PHP 7 environments.

#### PHP 7 Return type hints

ProxyManager will now correctly mimic signatures of methods with return type hints:

```php
class SayHello
{
    public function hello() : string
    {
        return 'hello!';
    }
}
```

#### PHP 7 Scalar type hints

ProxyManager will now correctly mimic signatures of methods with scalar type hints

```php
class SayHello
{
    public function hello(string $name) : string
    {
        return 'hello, ' . $name;
    }
}
```

#### PHP 5.6 Variadics support

ProxyManager will now correctly mimic behavior of methods with variadic parameters:

```php
class SayHello
{
    public function hello(string ...$names) : string
    {
        return 'hello, ' . implode(', ', $names);
    }
}
```

By-ref variadic arguments are also supported:

```php
class SayHello
{
    public function hello(string ... & $names)
    {
        foreach ($names as & $name) {
            $name = 'hello, ' . $name;
        }
    }
}
```

#### Constructors in proxies are not replaced anymore

In ProxyManager v1.x, the constructor of a proxy was completely replaced with a method
accepting proxy-specific parameters.

This is no longer true, and you will be able to use the constructor of your objects as
if the class wasn't proxied at all:

```php
class SayHello
{
    public function __construct()
    {
        echo 'Hello!';
    }
}

/* @var $proxyGenerator \ProxyManager\ProxyGenerator\ProxyGeneratorInterface */
$proxyClass = $proxyGenerator->generateProxy(
    new ReflectionClass(SayHello::class),
    new ClassGenerator('ProxyClassName')
);

eval('<?php ' . $proxyClass->generate());

$proxyName = $proxyClass->getName();
$object = new ProxyClassName(); // echoes "Hello!"

var_dump($object); // a proxy object
```

If you still want to manually build a proxy (without factories), a
`public static staticProxyConstructor` method is added to the generated proxy classes.

#### Friend classes support

You can now access state of "friend objects" at any time.

```php
class EmailAddress
{
    private $address;

    public function __construct(string $address)
    {
        assertEmail($address);
        
        $this->address = $address;
    }
    
    public function equalsTo(EmailAddress $other)
    {
        return $this->address === $other->address;
    }
}
```

When using lazy-loading or access-interceptors, the `equalsTo` method will
properly work, as even `protected` and `private` access are now correctly proxied.

#### Ghost objects now only lazy-load on state-access

Lazy loading ghost objects now trigger lazy-loading only when their state is accessed.
This also implies that lazy loading ghost objects cannot be used with interfaces anymore.

```php
class AccessPolicy
{
    private $policyName;
    
    /**
     * Calling this method WILL cause lazy-loading, when using a ghost object,
     * as the method is accessing the object's state
     */
    public function getPolicyName() : string
    {
        return $this->policyName;        
    }
    
    /**
     * Calling this method WILL NOT cause lazy-loading, when using a ghost object,
     * as the method is not reading any from the object.
     */
    public function allowAccess() : bool
    {
        return false;
    }
}
```

#### Faster ghost object state initialization

Lazy loading ghost objects can now be initialized in a more efficient way, by avoiding
reflection or setters:

```php
class Foo
{
    private $a;
    protected $b;
    public $c;
}

$factory = new \ProxyManager\Factory\LazyLoadingGhostFactory();

$proxy = $factory-createProxy(
    Foo::class,
    function (
        GhostObjectInterface $proxy, 
        string $method, 
        array $parameters, 
        & $initializer,
        array $properties
    ) {
        $initializer   = null;

        $properties["\0Foo\0a"] = 'abc';
        $properties["\0*\0b"]   = 'def';
        $properties['c']        = 'ghi';

        return true;
    }
);


$reflectionA = new ReflectionProperty(Foo::class, 'a');
$reflectionA->setAccessible(true);

var_dump($reflectionA->getValue($proxy)); // dumps "abc"

$reflectionB = new ReflectionProperty(Foo::class, 'b');
$reflectionB->setAccessible(true);

var_dump($reflectionB->getValue($proxy)); // dumps "def"

var_dump($proxy->c); // dumps "ghi"
```

#### Skipping lazy-loaded properties in generated proxies

Lazy loading ghost objects can now skip lazy-loading for certain properties.
This is especially useful when you have properties that are always available,
such as identifiers of entities:

```php
class User
{
    private $id;
    private $username;

    public function getId() : int
    {
        return $this->id;
    }

    public function getUsername() : string
    {
        return $this->username;
    }
}

/* @var $proxy User */
$proxy = (new \ProxyManager\Factory\LazyLoadingGhostFactory())->createProxy(
    User::class,
    function (
        GhostObjectInterface $proxy,
        string $method,
        array $parameters,
        & $initializer,
        array $properties
    ) {
        $initializer   = null;

        var_dump('Triggered lazy-loading!');

        $properties["\0User\0username"] = 'Ocramius';

        return true;
    },
    [
        'skippedProperties' => [
            "\0User\0id",
        ],
    ]
);

$idReflection = new \ReflectionProperty(User::class, 'id');

$idReflection->setAccessible(true);
$idReflection->setValue($proxy, 123);

var_dump($proxy->getId());       // 123
var_dump($proxy->getUsername()); // "Triggered lazy-loading!", then "Ocramius"
```

#### Proxies are now always generated on-the-fly by default

Proxies are now automatically generated any time you require them: no configuration
needed. If you want to gain better performance, you may still want to read
the [tuning for production docs](docs/tuning-for-production.md).

#### Proxy names are now hashed, simplified signature is attached to them

Proxy classes now have shorter names, as the parameters used to generate them are
hashed into their name. A signature is attached to proxy classes (as a private static
property) so that proxy classes aren't re-used across library updates.
Upgrading ProxyManager will now cause all proxies to be re-generated automatically,
while the old proxy files are going to be ignored.
