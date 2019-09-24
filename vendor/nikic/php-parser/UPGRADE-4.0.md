Upgrading from PHP-Parser 3.x to 4.0
====================================

### PHP version requirements

PHP-Parser now requires PHP 7.0 or newer to run. It is however still possible to *parse* PHP 5.2-5.6
source code, while running on a newer version.

HHVM is no longer actively supported.

### Changes to the node structure

* Many subnodes that previously held simple strings now store `Identifier` nodes instead (or
  `VarLikeIdentifier` nodes if they have form `$ident`). The constructors of the affected nodes will
  automatically convert strings to `Identifier`s and `Identifier`s implement `__toString()`. As such
  some code continues to work without changes, but anything using `is_string()`, type-strict
  comparisons or strict-mode may require adjustment. The following is an exhaustive list of all
  affected subnodes:

   * `Const_::$name`
   * `NullableType::$type` (for simple types)
   * `Param::$type` (for simple types)
   * `Expr\ClassConstFetch::$name`
   * `Expr\Closure::$returnType` (for simple types)
   * `Expr\MethodCall::$name`
   * `Expr\PropertyFetch::$name`
   * `Expr\StaticCall::$name`
   * `Expr\StaticPropertyFetch::$name` (uses `VarLikeIdentifier`)
   * `Stmt\Class_::$name`
   * `Stmt\ClassMethod::$name`
   * `Stmt\ClassMethod::$returnType` (for simple types)
   * `Stmt\Function_::$name`
   * `Stmt\Function_::$returnType` (for simple types)
   * `Stmt\Goto_::$name`
   * `Stmt\Interface_::$name`
   * `Stmt\Label::$name`
   * `Stmt\PropertyProperty::$name` (uses `VarLikeIdentifier`)
   * `Stmt\TraitUseAdaptation\Alias::$method`
   * `Stmt\TraitUseAdaptation\Alias::$newName`
   * `Stmt\TraitUseAdaptation\Precedence::$method`
   * `Stmt\Trait_::$name`
   * `Stmt\UseUse::$alias`

* Expression statements (`expr;`) are now represented using a `Stmt\Expression` node. Previously
  these statements were directly represented as their constituent expression.
* The `name` subnode of `Param` has been renamed to `var` and now contains a `Variable` rather than
  a plain string.
* The `name` subnode of `StaticVar` has been renamed to `var` and now contains a `Variable` rather
  than a plain string.
* The `var` subnode of `ClosureUse` now contains a `Variable` rather than a plain string.
* The `var` subnode of `Catch_` now contains a `Variable` rather than a plain string.
* The `alias` subnode of `UseUse` is now `null` if no explicit alias is given. As such,
  `use Foo\Bar` and `use Foo\Bar as Bar` are now represented differently. The `getAlias()` method
  can be used to get the effective alias, even if it is not explicitly given.

### Miscellaneous

* The indentation handling in the pretty printer has been changed (this is only relevant if you
  extend the pretty printer). Previously indentation was automatic, and parts were excluded using
  `pNoindent()`. Now no-indent is the default and newlines that require indentation should use
  `$this->nl`.

### Removed functionality

* Removed `type` subnode on `Class_`, `ClassMethod` and `Property` nodes. Use `flags` instead.
* The `ClassConst::isStatic()` method has been removed. Constants cannot have a static modifier.
* The `NodeTraverser` no longer accepts `false` as a return value from a `leaveNode()` method.
  `NodeTraverser::REMOVE_NODE` should be returned instead.
* The `Node::setLine()` method has been removed. If you really need to, you can use `setAttribute()`
  instead.
* The misspelled `Class_::VISIBILITY_MODIFER_MASK` constant has been dropped in favor of
  `Class_::VISIBILITY_MODIFIER_MASK`.
* The XML serializer has been removed. As such, the classes `Serializer\XML`, and
  `Unserializer\XML`, as well as the interfaces `Serializer` and `Unserializer` no longer exist.
* The `BuilderAbstract` class has been removed. It's functionality is moved into `BuilderHelpers`.
  However, this is an internal class and should not be used directly.
* The `Autoloader` class has been removed in favor of relying on the Composer autoloader.
