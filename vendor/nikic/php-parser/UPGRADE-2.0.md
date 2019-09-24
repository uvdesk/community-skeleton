Upgrading from PHP-Parser 1.x to 2.0
====================================

### PHP version requirements

PHP-Parser now requires PHP 5.4 or newer to run. It is however still possible to *parse* PHP 5.2 and
PHP 5.3 source code, while running on a newer version.

### Creating a parser instance

Parser instances should now be created through the `ParserFactory`. Old direct instantiation code
will not work, because the parser class was renamed.

Old:

```php
use PhpParser\Parser, PhpParser\Lexer;
$parser = new Parser(new Lexer\Emulative);
```

New:

```php
use PhpParser\ParserFactory;
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
```

The first argument to `ParserFactory` determines how different PHP versions are handled. The
possible values are:

 * `ParserFactory::PREFER_PHP7`: Try to parse code as PHP 7. If this fails, try to parse it as PHP 5.
 * `ParserFactory::PREFER_PHP5`: Try to parse code as PHP 5. If this fails, try to parse it as PHP 7.
 * `ParserFactory::ONLY_PHP7`: Parse code as PHP 7.
 * `ParserFactory::ONLY_PHP5`: Parse code as PHP 5.

For most practical purposes the difference between `PREFER_PHP7` and `PREFER_PHP5` is mainly whether
a scalar type hint like `string` will be stored as `'string'` (PHP 7) or as `new Name('string')`
(PHP 5).

To use a custom lexer, pass it as the second argument to the `create()` method:

```php
use PhpParser\ParserFactory;
$lexer = new MyLexer;
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7, $lexer);
```

### Rename of the `PhpParser\Parser` class

`PhpParser\Parser` is now an interface, which is implemented by `Parser\Php5`, `Parser\Php7` and
`Parser\Multiple`. Parser tokens are now defined in `Parser\Tokens`. If you use the `ParserFactory`
described above to create your parser instance, these changes should have no further impact on you.

### Removal of legacy aliases

All legacy aliases for classes have been removed. This includes the old non-namespaced `PHPParser_`
classes, as well as the classes that had to be renamed for PHP 7 support.

### Deprecations

The `set()`, `setFirst()`, `append()` and `prepend()` methods of the `Node\Name` class have been
deprecated. Instead `Name::concat()` and `Name->slice()` should be used.

### Miscellaneous

* The `NodeTraverser` no longer clones nodes by default. If you want to restore the old behavior,
  pass `true` to the constructor.
* The legacy node format has been removed. If you use custom nodes, they are now expected to
  implement a `getSubNodeNames()` method.
* The default value for `Scalar` node constructors was removed. This means that something like
  `new LNumber()` should be replaced by `new LNumber(0)`.
* String parts of encapsed strings are now represented using `Scalar\EncapsStringPart` nodes, while
  previously raw strings were used. This affects the `parts` child of `Scalar\Encaps` and
  `Expr\ShellExec`.