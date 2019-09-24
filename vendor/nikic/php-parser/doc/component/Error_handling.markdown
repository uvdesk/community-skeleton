Error handling
==============

Errors during parsing or analysis are represented using the `PhpParser\Error` exception class. In addition to an error
message, an error can also store additional information about the location the error occurred at.

How much location information is available depends on the origin of the error and how many lexer attributes have been
enabled. At a minimum the start line of the error is usually available.

Column information
------------------

In order to receive information about not only the line, but also the column span an error occurred at, the file
position attributes in the lexer need to be enabled:

```php
$lexer = new PhpParser\Lexer(array(
    'usedAttributes' => array('comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos'),
));
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP7, $lexer);

try {
    $stmts = $parser->parse($code);
    // ...
} catch (PhpParser\Error $e) {
    // ...
}
```

Before using column information, its availability needs to be checked with `$e->hasColumnInfo()`, as the precise
location of an error cannot always be determined. The methods for retrieving column information also have to be passed
the source code of the parsed file. An example for printing an error:

```php
if ($e->hasColumnInfo()) {
    echo $e->getRawMessage() . ' from ' . $e->getStartLine() . ':' . $e->getStartColumn($code)
        . ' to ' . $e->getEndLine() . ':' . $e->getEndColumn($code);
    // or:
    echo $e->getMessageWithColumnInfo();
} else {
    echo $e->getMessage();
}
```

Both line numbers and column numbers are 1-based. EOF errors will be located at the position one past the end of the
file.

Error recovery
--------------

The error behavior of the parser (and other components) is controlled by an `ErrorHandler`. Whenever an error is
encountered, `ErrorHandler::handleError()` is invoked. The default error handling strategy is `ErrorHandler\Throwing`,
which will immediately throw when an error is encountered.

To instead collect all encountered errors into an array, while trying to continue parsing the rest of the source code,
an instance of `ErrorHandler\Collecting` can be passed to the `Parser::parse()` method. A usage example:

```php
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::ONLY_PHP7);
$errorHandler = new PhpParser\ErrorHandler\Collecting;

$stmts = $parser->parse($code, $errorHandler);

if ($errorHandler->hasErrors()) {
    foreach ($errorHandler->getErrors() as $error) {
        // $error is an ordinary PhpParser\Error
    }
}

if (null !== $stmts) {
    // $stmts is a best-effort partial AST
}
```

The `NameResolver` visitor also accepts an `ErrorHandler` as a constructor argument.