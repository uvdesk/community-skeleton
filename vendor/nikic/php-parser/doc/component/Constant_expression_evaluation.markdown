Constant expression evaluation
==============================

Initializers for constants, properties, parameters, etc. have limited support for expressions. For
example:

```php
<?php
class Test {
    const SECONDS_IN_HOUR = 60 * 60;
    const SECONDS_IN_DAY = 24 * self::SECONDS_IN_HOUR;
}
```

PHP-Parser supports evaluation of such constant expressions through the `ConstExprEvaluator` class:

```php
<?php

use PhpParser\{ConstExprEvaluator, ConstExprEvaluationException};

$evalutator = new ConstExprEvaluator();
try {
    $value = $evalutator->evaluateSilently($someExpr);
} catch (ConstExprEvaluationException $e) {
    // Either the expression contains unsupported expression types,
    // or an error occurred during evaluation
}
```

Error handling
--------------

The constant evaluator provides two methods, `evaluateDirectly()` and `evaluateSilently()`, which
differ in error behavior. `evaluateDirectly()` will evaluate the expression as PHP would, including
any generated warnings or Errors. `evaluateSilently()` will instead convert warnings and Errors into
a `ConstExprEvaluationException`. For example:

```php
<?php

use PhpParser\{ConstExprEvaluator, ConstExprEvaluationException};
use PhpParser\Node\{Expr, Scalar};

$evaluator = new ConstExprEvaluator();

// 10 / 0
$expr = new Expr\BinaryOp\Div(new Scalar\LNumber(10), new Scalar\LNumber(0));

var_dump($evaluator->evaluateDirectly($expr)); // float(INF)
// Warning: Division by zero

try {
    $evaluator->evaluateSilently($expr);
} catch (ConstExprEvaluationException $e) {
    var_dump($e->getPrevious()->getMessage()); // Division by zero
}
```

For the purposes of static analysis, you will likely want to use `evaluateSilently()` and leave
erroring expressions unevaluated.

Unsupported expressions and evaluator fallback
----------------------------------------------

The constant expression evaluator supports all expression types that are permitted in constant
expressions, apart from the following:

 * `Scalar\MagicConst\*`
 * `Expr\ConstFetch` (only null/false/true are handled)
 * `Expr\ClassConstFetch`

Handling these expression types requires non-local information, such as which global constants are
defined. By default, the evaluator will throw a `ConstExprEvaluationException` when it encounters
an unsupported expression type.

It is possible to override this behavior and support resolution for these expression types by
specifying an evaluation fallback function:

```php
<?php

use PhpParser\{ConstExprEvaluator, ConstExprEvaluationException};
use PhpParser\Node\Expr;

$evalutator = new ConstExprEvaluator(function(Expr $expr) {
    if ($expr instanceof Expr\ConstFetch) {
        return fetchConstantSomehow($expr);
    }
    if ($expr instanceof Expr\ClassConstFetch) {
        return fetchClassConstantSomehow($expr);
    }
    // etc.
    throw new ConstExprEvaluationException(
        "Expression of type {$expr->getType()} cannot be evaluated");
});

try {
    $evalutator->evaluateSilently($someExpr);
} catch (ConstExprEvaluationException $e) {
    // Handle exception
}
```

Implementers are advised to ensure that evaluation of indirect constant references cannot lead to
infinite recursion. For example, the following code could lead to infinite recursion if constant
lookup is implemented naively.

```php
<?php
class Test {
    const A = self::B;
    const B = self::A;
}
```