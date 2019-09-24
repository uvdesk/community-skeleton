# Migrating from zend-code v2 to v3

## `string`, `int`, `float`, `bool` are no longer ignored

In 2.x, a `Zend\Code\Generator\ParameterGenerator` with name `foo` and type 
`string`, `int`, `float` or `bool` simply generated code `"$foo"`:

```php
$generator = new \Zend\Code\ParameterGenerator('foo');

$generator->setType('string');

echo $generator->generate(); // "$foo"
```

In 3.x, this code will instead produce `"string $foo"`.
If you generate code that should run in PHP 5.x, it is advisable to strip
`string`, `int`, `float` and `bool` from type definitions passed to
`Zend\Code\ParameterGenerator` instances. The quickest way is to set the 
type to `null`, if it matches any of these scalar types:

```php
if (in_array($type, ['string', 'int', 'float', 'bool'])) {
    $type = null;
}

$generator->setType($type);
```

## `ParameterReflection::getType()` changes

PHP 7 introduced [`ReflectionParameter#getType()`](http://php.net/manual/en/reflectionparameter.gettype.php).

In order to not override this method, `Zend\Code\Reflection\ParameterReflection#getType()`
was renamed to `Zend\Code\Reflection\ParameterReflection#detectType()`.

If you relied on `Zend\Code\Reflection\ParameterReflection#getType()`, you can
simply replace the method calls in your code.
 
## DocBlock types ignored by `ParameterGenerator::fromReflection()`

As a direct consequence of the previous change, calls to 
`Zend\Code\Generator\ParameterGenerator::fromReflection()` will not mirror the
type hints read from a method's DocBlock.

As an example, take following code:

```php
class Foo
{
    /**
     * @param string $baz
     */
    public function bar($baz)
    {
    }
}

$methodGenerator = \Zend\Code\Generator\MethodGenerator::fromReflection(
    new \Zend\Code\Reflection\MethodReflection('Foo', 'bar')
);

var_dump($methodGenerator->getParameters()[0]->getType());
```

In version 2.x, this code produces `"string"`, in version 3.x it returns `null`. If you 
need to rely on the types in the annotations, please use
`Zend\Code\Reflection\ParameterReflection#detectType()` instead, and build a
`MethodGenerator` instance manually.

This change is required: since signatures in PHP 7 include scalar type hints.
That also means that reflecting scalar type hints from DocBlocks into the
signature of a generated method may lead to fatal errors (due to signature
mismatch) at runtime.

## Type strings are validated

If you attempt to generate type-hints for parameters or return types, those types are
now validated before the code is generated.

Be sure to check which values you pass to `Zend\Code\Generator\MethodGenerator#setReturnType()`
or `Zend\Code\Generator\ParameterGenerator#setType()`, as you may incur in a
`Zend\Code\Generator\Exception\InvalidArgumentException` being thrown if any
of those types are invalid strings:

```php
$parameterGenerator->setType('foo'); // valid
$parameterGenerator->setType('array'); // valid
$parameterGenerator->setType('bool'); // valid
$parameterGenerator->setType('123'); // invalid (throws exception)
$parameterGenerator->setType(''); // invalid (throws exception)
$parameterGenerator->setType('*'); // invalid (throws exception)
$parameterGenerator->setType('\\'); // invalid (throws exception)
```


## Generated type-hints are now prefixed by `"\"`

Generated type-hints are now prefixed with the `NAMESPACE_SEPARATOR`,
`"\"`.

Take following example code:

```php
$parameter = new \Zend\Code\Generator\ParameterGenerator('bar', 'baz');
$method    = new \Zend\Code\Generator\MethodGenerator('foo', [$parameter]);

$method->setReturnType('tab');

echo $method->generate();
```

This code produces `public function foo(baz $bar) {}` in 2.x.
In version 3.x, it produces `public function foo(\baz $bar) : \tab {}`.

In order to avoid migration problems, be sure to always pass fully qualified class
names to `Zend\Code\Generator\MethodGenerator` and `Zend\Code\Generator\ParameterGenerator`.

## `ParameterGenerator::$simple` was removed

If you extended `Zend\Code\Generator\ParameterGenerator`, be sure to check if you
are accessing the protected static variable `$simple`: it was removed, and you should
adapt your code by either copying it into your class or avoiding its usage.

## `ParameterGenerator::$type` has changed

If you extended `Zend\Code\Generator\ParameterGenerator`, be sure to check if you
are accessing the protected variable `$type`: its type has changed.
While it can still be used as a string via an explicit `(string)` cast, the type of
this protected member is now `null|Zend\Code\Generator\TypeGenerator`.
