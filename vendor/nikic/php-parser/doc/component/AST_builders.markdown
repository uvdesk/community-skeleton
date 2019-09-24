AST builders
============

When PHP-Parser is used to generate (or modify) code by first creating an Abstract Syntax Tree and
then using the [pretty printer](Pretty_printing.markdown) to convert it to PHP code, it can often
be tedious to manually construct AST nodes. The project provides a number of utilities to simplify
the construction of common AST nodes.

Fluent builders
---------------

The library comes with a number of builders, which allow creating node trees using a fluent
interface. Builders are created using the `BuilderFactory` and the final constructed node is
accessed through `getNode()`. Fluent builders are available for
the following syntactic elements:

 * namespaces and use statements
 * classes, interfaces and traits
 * methods, functions and parameters
 * properties

Here is an example:

```php
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter;
use PhpParser\Node;

$factory = new BuilderFactory;
$node = $factory->namespace('Name\Space')
    ->addStmt($factory->use('Some\Other\Thingy')->as('SomeClass'))
    ->addStmt($factory->useFunction('strlen'))
    ->addStmt($factory->useConst('PHP_VERSION'))
    ->addStmt($factory->class('SomeOtherClass')
        ->extend('SomeClass')
        ->implement('A\Few', '\Interfaces')
        ->makeAbstract() // ->makeFinal()

        ->addStmt($factory->useTrait('FirstTrait'))

        ->addStmt($factory->useTrait('SecondTrait', 'ThirdTrait')
            ->and('AnotherTrait')
            ->with($factory->traitUseAdaptation('foo')->as('bar'))
            ->with($factory->traitUseAdaptation('AnotherTrait', 'baz')->as('test'))
            ->with($factory->traitUseAdaptation('AnotherTrait', 'func')->insteadof('SecondTrait')))

        ->addStmt($factory->method('someMethod')
            ->makePublic()
            ->makeAbstract() // ->makeFinal()
            ->setReturnType('bool') // ->makeReturnByRef()
            ->addParam($factory->param('someParam')->setType('SomeClass'))
            ->setDocComment('/**
                              * This method does something.
                              *
                              * @param SomeClass And takes a parameter
                              */')
        )

        ->addStmt($factory->method('anotherMethod')
            ->makeProtected() // ->makePublic() [default], ->makePrivate()
            ->addParam($factory->param('someParam')->setDefault('test'))
            // it is possible to add manually created nodes
            ->addStmt(new Node\Expr\Print_(new Node\Expr\Variable('someParam')))
        )

        // properties will be correctly reordered above the methods
        ->addStmt($factory->property('someProperty')->makeProtected())
        ->addStmt($factory->property('anotherProperty')->makePrivate()->setDefault(array(1, 2, 3)))
    )

    ->getNode()
;

$stmts = array($node);
$prettyPrinter = new PrettyPrinter\Standard();
echo $prettyPrinter->prettyPrintFile($stmts);
```

This will produce the following output with the standard pretty printer:

```php
<?php

namespace Name\Space;

use Some\Other\Thingy as SomeClass;
use function strlen;
use const PHP_VERSION;
abstract class SomeOtherClass extends SomeClass implements A\Few, \Interfaces
{
    use FirstTrait;
    use SecondTrait, ThirdTrait, AnotherTrait {
        foo as bar;
        AnotherTrait::baz as test;
        AnotherTrait::func insteadof SecondTrait;
    }
    protected $someProperty;
    private $anotherProperty = array(1, 2, 3);
    /**
     * This method does something.
     *
     * @param SomeClass And takes a parameter
     */
    public abstract function someMethod(SomeClass $someParam) : bool;
    protected function anotherMethod($someParam = 'test')
    {
        print $someParam;
    }
}
```

Additional helper methods
-------------------------

The `BuilderFactory` also provides a number of additional helper methods, which directly return
nodes. The following methods are currently available:

 * `val($value)`: Creates an AST node for a literal value like `42` or `[1, 2, 3]`.
 * `var($name)`: Creates variable node.
 * `args(array $args)`: Creates an array of function/method arguments, including the required `Arg`
   wrappers. Also converts literals to AST nodes.
 * `funcCall($name, array $args = [])`: Create a function call node. Converts `$name` to a `Name`
   node and normalizes arguments.
 * `methodCall(Expr $var, $name, array $args = [])`: Create a method call node. Converts `$name` to
   an `Identifier` node and normalizes arguments.
 * `staticCall($class, $name, array $args = [])`: Create a static method call node. Converts
   `$class` to a `Name` node, `$name` to an `Identifier` node and normalizes arguments.
 * `new($class, array $args = [])`: Create a "new" (object creation) node. Converts `$class` to a
   `Name` node.
 * `constFetch($name)`: Create a constant fetch node. Converts `$name` to a `Name` node.
 * `classConstFetch($class, $name)`: Create a class constant fetch node. Converts `$class` to a
   `Name` node and `$name` to an `Identifier` node.
 * `propertyFetch($var, $name)`: Creates a property fetch node. Converts `$name` to an `Identifier`
   node.
 * `concat(...$exprs)`: Create a tree of `BinaryOp\Concat` nodes for the given expressions.

These methods may be expanded on an as-needed basis. Please open an issue or PR if a common
operation is missing.
