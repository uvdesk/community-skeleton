Lexer component documentation
=============================

The lexer is responsible for providing tokens to the parser. The project comes with two lexers: `PhpParser\Lexer` and
`PhpParser\Lexer\Emulative`. The latter is an extension of the former, which adds the ability to emulate tokens of
newer PHP versions and thus allows parsing of new code on older versions.

This documentation discusses options available for the default lexers and explains how lexers can be extended.

Lexer options
-------------

The two default lexers accept an `$options` array in the constructor. Currently only the `'usedAttributes'` option is
supported, which allows you to specify which attributes will be added to the AST nodes. The attributes can then be
accessed using `$node->getAttribute()`, `$node->setAttribute()`, `$node->hasAttribute()` and `$node->getAttributes()`
methods. A sample options array:

```php
$lexer = new PhpParser\Lexer(array(
    'usedAttributes' => array(
        'comments', 'startLine', 'endLine'
    )
));
```

The attributes used in this example match the default behavior of the lexer. The following attributes are supported:

 * `comments`: Array of `PhpParser\Comment` or `PhpParser\Comment\Doc` instances, representing all comments that occurred
   between the previous non-discarded token and the current one. Use of this attribute is required for the
   `$node->getComments()` and `$node->getDocComment()` methods to work. The attribute is also needed if you wish the pretty
   printer to retain comments present in the original code.
 * `startLine`: Line in which the node starts. This attribute is required for the `$node->getLine()` to work. It is also
   required if syntax errors should contain line number information.
 * `endLine`: Line in which the node ends. Required for `$node->getEndLine()`.
 * `startTokenPos`: Offset into the token array of the first token in the node. Required for `$node->getStartTokenPos()`.
 * `endTokenPos`: Offset into the token array of the last token in the node. Required for `$node->getEndTokenPos()`.
 * `startFilePos`: Offset into the code string of the first character that is part of the node. Required for `$node->getStartFilePos()`.
 * `endFilePos`: Offset into the code string of the last character that is part of the node. Required for `$node->getEndFilePos()`.

### Using token positions

> **Note:** The example in this section is outdated in that this information is directly available in the AST: While
> `$property->isPublic()` does not distinguish between `public` and `var`, directly checking `$property->flags` for
> the `$property->flags & Class_::VISIBILITY_MODIFIER_MASK) === 0` allows making this distinction without resorting to
> tokens. However the general idea behind the example still applies in other cases.

The token offset information is useful if you wish to examine the exact formatting used for a node. For example the AST
does not distinguish whether a property was declared using `public` or using `var`, but you can retrieve this
information based on the token position:

```php
function isDeclaredUsingVar(array $tokens, PhpParser\Node\Stmt\Property $prop) {
    $i = $prop->getAttribute('startTokenPos');
    return $tokens[$i][0] === T_VAR;
}
```

In order to make use of this function, you will have to provide the tokens from the lexer to your node visitor using
code similar to the following:

```php
class MyNodeVisitor extends PhpParser\NodeVisitorAbstract {
    private $tokens;
    public function setTokens(array $tokens) {
        $this->tokens = $tokens;
    }

    public function leaveNode(PhpParser\Node $node) {
        if ($node instanceof PhpParser\Node\Stmt\Property) {
            var_dump(isDeclaredUsingVar($this->tokens, $node));
        }
    }
}

$lexer = new PhpParser\Lexer(array(
    'usedAttributes' => array(
        'comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'
    )
));
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::ONLY_PHP7, $lexer);

$visitor = new MyNodeVisitor();
$traverser = new PhpParser\NodeTraverser();
$traverser->addVisitor($visitor);

try {
    $stmts = $parser->parse($code);
    $visitor->setTokens($lexer->getTokens());
    $stmts = $traverser->traverse($stmts);
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
```

The same approach can also be used to perform specific modifications in the code, without changing the formatting in
other places (which is the case when using the pretty printer).

Lexer extension
---------------

A lexer has to define the following public interface:

```php
function startLexing(string $code, ErrorHandler $errorHandler = null): void;
function getTokens(): array;
function handleHaltCompiler(): string;
function getNextToken(string &$value = null, array &$startAttributes = null, array &$endAttributes = null): int;
```

The `startLexing()` method is invoked whenever the `parse()` method of the parser is called and is passed the source
code that is to be lexed (including the opening tag). It can be used to reset state or preprocess the source code or tokens. The
passed `ErrorHandler` should be used to report lexing errors.

The `getTokens()` method returns the current token array, in the usual `token_get_all()` format. This method is not
used by the parser (which uses `getNextToken()`), but is useful in combination with the token position attributes.

The `handleHaltCompiler()` method is called whenever a `T_HALT_COMPILER` token is encountered. It has to return the
remaining string after the construct (not including `();`).

The `getNextToken()` method returns the ID of the next token (as defined by the `Parser::T_*` constants). If no more
tokens are available it must return `0`, which is the ID of the `EOF` token. Furthermore the string content of the
token should be written into the by-reference `$value` parameter (which will then be available as `$n` in the parser).

### Attribute handling

The other two by-ref variables `$startAttributes` and `$endAttributes` define which attributes will eventually be
assigned to the generated nodes: The parser will take the `$startAttributes` from the first token which is part of the
node and the `$endAttributes` from the last token that is part of the node.

E.g. if the tokens `T_FUNCTION T_STRING ... '{' ... '}'` constitute a node, then the `$startAttributes` from the
`T_FUNCTION` token will be taken and the `$endAttributes` from the `'}'` token.

An application of custom attributes is storing the exact original formatting of literals: While the parser does retain
some information about the formatting of integers (like decimal vs. hexadecimal) or strings (like used quote type), it
does not preserve the exact original formatting (e.g. leading zeros for integers or escape sequences in strings). This
can be remedied by storing the original value in an attribute:

```php
use PhpParser\Lexer;
use PhpParser\Parser\Tokens;

class KeepOriginalValueLexer extends Lexer // or Lexer\Emulative
{
    public function getNextToken(&$value = null, &$startAttributes = null, &$endAttributes = null) {
        $tokenId = parent::getNextToken($value, $startAttributes, $endAttributes);

        if ($tokenId == Tokens::T_CONSTANT_ENCAPSED_STRING   // non-interpolated string
            || $tokenId == Tokens::T_ENCAPSED_AND_WHITESPACE // interpolated string
            || $tokenId == Tokens::T_LNUMBER                 // integer
            || $tokenId == Tokens::T_DNUMBER                 // floating point number
        ) {
            // could also use $startAttributes, doesn't really matter here
            $endAttributes['originalValue'] = $value;
        }

        return $tokenId;
    }
}
```
