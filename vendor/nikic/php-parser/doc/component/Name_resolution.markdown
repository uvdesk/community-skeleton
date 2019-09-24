Name resolution
===============

Since the introduction of namespaces in PHP 5.3, literal names in PHP code are subject to a
relatively complex name resolution process, which is based on the current namespace, the current
import table state, as well the type of the referenced symbol. PHP-Parser implements name
resolution and related functionality, both as reusable logic (NameContext), as well as a node
visitor (NameResolver) based on it.

The NameResolver visitor
------------------------

The `NameResolver` visitor can (and for nearly all uses of the AST, is) be applied to resolve names
to their fully-qualified form, to the degree that this is possible.

```php
$nameResolver = new PhpParser\NodeVisitor\NameResolver;
$nodeTraverser = new PhpParser\NodeTraverser;
$nodeTraverser->addVisitor($nameResolver);

// Resolve names
$stmts = $nodeTraverser->traverse($stmts);
```

In the default configuration, the name resolver will perform three actions:

 * Declarations of functions, classes, interfaces, traits and global constants will have a
   `namespacedName` property added, which contains the function/class/etc name including the
   namespace prefix. For historic reasons this is a **property** rather than an attribute.
 * Names will be replaced by fully qualified resolved names, which are instances of
   `Node\Name\FullyQualified`.
 * Unqualified function and constant names inside a namespace cannot be statically resolved. Inside
   a namespace `Foo`, a call to `strlen()` may either refer to the namespaced `\Foo\strlen()`, or
   the global `\strlen()`. Because PHP-Parser does not have the necessary context to decide this,
   such names are left unresolved. Additionally a `namespacedName` **attribute** is added to the
   name node.

The name resolver accepts an option array as the second argument, with the following default values:

```php
$nameResolver = new PhpParser\NodeVisitor\NameResolver(null, [
    'preserveOriginalNames' => false,
    'replaceNodes' => true,
]);
```

If the `preserveOriginalNames` option is enabled, then the resolved (fully qualified) name will have
an `originalName` attribute, which contains the unresolved name.

If the `replaceNodes` option is disabled, then names will no longer be resolved in-place. Instead a
`resolvedName` attribute will be added to each name, which contains the resolved (fully qualified)
name. Once again, if an unqualified function or constant name cannot be resolved, then the
`resolvedName` attribute will not be present, and instead a `namespacedName` attribute is added.

The `replaceNodes` attribute is useful if you wish to perform modifications on the AST, as you
probably do not wish the resoluting code to have fully resolved names as a side-effect.

The NameContext
---------------

The actual name resolution logic is implemented in the `NameContext` class, which has the following
public API:

```php
class NameContext {
    public function __construct(ErrorHandler $errorHandler);
    public function startNamespace(Name $namespace = null);
    public function addAlias(Name $name, string $aliasName, int $type, array $errorAttrs = []);

    public function getNamespace();
    public function getResolvedName(Name $name, int $type);
    public function getResolvedClassName(Name $name) : Name;
    public function getPossibleNames(string $name, int $type) : array;
    public function getShortName(string $name, int $type) : Name;
}
```

The `$type` parameters accept on of the `Stmt\Use_::TYPE_*` constants, which represent the three
basic symbol types in PHP (functions, constants and everything else).

Next to name resolution, the `NameContext` also supports the reverse operation of finding a short
representation of a name given the current name resolution environment.

The name context is intended to be used for name resolution operations outside the AST itself, such
as class names inside doc comments. A visitor running in parallel with the name resolver can access
the name context using `$nameResolver->getNameContext()`. Alternatively a visitor can use an
independent context and explicitly feed `Namespace` and `Use` nodes to it.