Upgrading from PHP-Parser 2.x to 3.0
====================================

The backwards-incompatible changes in this release may be summarized as follows:

 * The specific details of the node representation have changed in some cases, primarily to
   accommodate new PHP 7.1 features.
 * There have been significant changes to the error recovery implementation. This may affect you,
   if you used the error recovery mode or have a custom lexer implementation.
 * A number of deprecated methods were removed.

### PHP version requirements

PHP-Parser now requires PHP 5.5 or newer to run. It is however still possible to *parse* PHP 5.2,
5.3 and 5.4 source code, while running on a newer version.

### Changes to the node structure

The following changes are likely to require code changes if the respective nodes are used:

 * The `List` subnode `vars` has been renamed to `items` and now contains `ArrayItem`s instead of
   plain variables.
 * The `Catch` subnode `type` has been renamed to `types` and is now an array of `Name`s.
 * The `TryCatch` subnode `finallyStmts` has been replaced with a `finally` subnode that holds an
   explicit `Finally` node.
 * The `type` subnode on `Class`, `ClassMethod` and `Property` has been renamed to `flags`. The
   `type` subnode has retained for backwards compatibility and is populated to the same value as
   `flags`. However, writes to `type` will not update `flags` and use of `type` is discouraged.

The following changes are unlikely to require code changes:

 * The `ClassConst` constructor changed to accept an additional `flags` subnode.
 * The `Trait` constructor now has the same form as the `Class` and `Interface` constructors: It
   takes an array of subnodes. Unlike classes/interfaces, traits can only have a `stmts` subnode.
 * The `Array` subnode `items` may now contain `null` elements (due to destructuring).
 * `void` and `iterable` types are now stored as strings if the PHP 7 parser is used. Previously
   these would have been represented as `Name` instances.

### Changes to error recovery mode

Previously, error recovery mode was enabled by setting the `throwOnError` option to `false` when
creating the parser, while collected errors were retrieved using the `getErrors()` method:

```php
$lexer = ...;
$parser = (new ParserFactory)->create(ParserFactor::ONLY_PHP7, $lexer, [
    'throwOnError' => true,
]);

$stmts = $parser->parse($code);
$errors = $parser->getErrors();
if ($errors) {
    handleErrors($errors);
}
processAst($stmts);
```

Both the `throwOnError` option and the `getErrors()` method have been removed in PHP-Parser 3.0.
Instead an instance of `ErrorHandler\Collecting` should be passed to the `parse()` method:

```php
$lexer = ...;
$parser = (new ParserFactory)->create(ParserFactor::ONLY_PHP7, $lexer);

$errorHandler = new ErrorHandler\Collecting;
$stmts = $parser->parse($code, $errorHandler);
if ($errorHandler->hasErrors()) {
    handleErrors($errorHandler->getErrors());
}
processAst($stmts);
```

#### Multiple parser fallback in error recovery mode

As a result of this change, if a `Multiple` parser is used (e.g. through the `ParserFactory` using
`PREFER_PHP7` or `PREFER_PHP5`), it will now return the result of the first *non-throwing* parse. As
parsing never throws in error recovery mode, the result from the first parser will always be
returned.

The PHP 7 parser is a superset of the PHP 5 parser, with the exceptions that `=& new` and
`global $$foo->bar` are not supported (other differences are in representation only). The PHP 7
parser will be able to recover from the error in both cases. For this reason, this change will
likely pass unnoticed if you do not specifically test for this syntax.

It is possible to restore the precise previous behavior with the following code:

```php
$lexer = ...;
$parser7 = new Parser\Php7($lexer);
$parser5 = new Parser\Php5($lexer);

$errors7 = new ErrorHandler\Collecting();
$stmts7 = $parser7->parse($code, $errors7);
if ($errors7->hasErrors()) {
    $errors5 = new ErrorHandler\Collecting();
    $stmts5 = $parser5->parse($code, $errors5);
    if (!$errors5->hasErrors()) {
        // If PHP 7 parse has errors but PHP 5 parse has no errors, use PHP 5 result
        return [$stmts5, $errors5];
    }
}
// If PHP 7 succeeds or both fail use PHP 7 result
return [$stmts7, $errors7];
```

#### Error handling in the lexer

In order to support recovery from lexer errors, the signature of the `startLexing()` method changed
to optionally accept an `ErrorHandler`:

```php
// OLD
public function startLexing($code);
// NEW
public function startLexing($code, ErrorHandler $errorHandler = null);
```

If you use a custom lexer with overridden `startLexing()` method, it needs to be changed to accept
the extra parameter. The value should be passed on to the parent method.

#### Error checks in node constructors

The constructors of certain nodes used to contain additional checks for semantic errors, such as
creating a try block without either catch or finally. These checks have been moved from the node
constructors into the parser. This allows recovery from such errors, as well as representing the
resulting (invalid) AST.

This means that certain error conditions are no longer checked for manually constructed nodes.

### Removed methods, arguments, options

The following methods, arguments or options have been removed:

 * `Comment::setLine()`, `Comment::setText()`: Create new `Comment` instances instead.
 * `Name::set()`, `Name::setFirst()`, `Name::setLast()`, `Name::append()`, `Name::prepend()`:
    Use `Name::concat()` in combination with `Name::slice()` instead.
 * `Error::getRawLine()`, `Error::setRawLine()`. Use `Error::getStartLine()` and
   `Error::setStartLine()` instead.
 * `Parser::getErrors()`. Use `ErrorHandler\Collecting` instead.
 * `$separator` argument of `Name::toString()`. Use `strtr()` instead, if you really need it.
 * `$cloneNodes` argument of `NodeTraverser::__construct()`. Explicitly clone nodes in the visitor
   instead.
 * `throwOnError` parser option. Use `ErrorHandler\Collecting` instead.

### Miscellaneous

 * The `NameResolver` will now resolve unqualified function and constant names in the global
   namespace into fully qualified names. For example `foo()` in the global namespace resolves to
   `\foo()`. For names where no static resolution is possible, a `namespacedName` attribute is
   added now, containing the namespaced variant of the name.
 * All methods on `PrettyPrinter\Standard` are now protected. Previously most of them were public.
   The pretty printer should only be invoked using the `prettyPrint()`, `prettyPrintFile()` and
   `prettyPrintExpr()` methods.
 * The node dumper now prints numeric values that act as enums/flags in a string representation.
   If node dumper results are used in tests, updates may be needed to account for this.
 * The constants on `NameTraverserInterface` have been moved into the `NameTraverser` class.
 * The emulative lexer now directly postprocesses tokens, instead of using `~__EMU__~` sequences.
   This changes the protected API of the emulative lexer.
 * The `Name::slice()` method now returns `null` for empty slices, previously `new Name([])` was
   used. `Name::concat()` now also supports concatenation with `null`.
