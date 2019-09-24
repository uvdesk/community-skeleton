Version 4.2.4-dev
-----------------

Nothing yet.

Version 4.2.3 (2019-08-12)
--------------------------

### Added

* [PHP 7.4] Add support for numeric literal separators. (#615)

### Fixed

* Fixed resolution of return types for arrow functions. (#613)
* Fixed compatibility with PHP 7.4.

Version 4.2.2 (2019-05-25)
--------------------------

### Added

* [PHP 7.4] Add support for arrow functions using a new `Expr\ArrowFunction` node. (#602)
* [PHP 7.4] Add support for array spreads, using a new `unpack` subnode on `ArrayItem`. (#609)
* Added support for inserting into empty list nodes in the formatting preserving pretty printer.

### Changed

* `php-parse` will now print messages to stderr, so that stdout only contains the actual result of
  the operation (such as a JSON dump). (#605)

### Fixed

* Fixed attribute assignment for zero-length nop statements, and a related assertion failure in
  the formatting-preserving pretty printer. (#589)

Version 4.2.1 (2019-02-16)
--------------------------

### Added

* [PHP 7.4] Add support for `??=` operator through a new `AssignOp\Coalesce` node. (#575)

Version 4.2.0 (2019-01-12)
--------------------------

### Added

* [PHP 7.4] Add support for typed properties through a new `type` subnode of `Stmt\Property`.
  Additionally `Builder\Property` now has a `setType()` method. (#567)
* Add `kind` attribute to `Cast\Double_`, which allows to distinguish between `(float)`,
  `(double)` and `(real)`. The form of the cast will be preserved by the pretty printer. (#565)

### Fixed

* Remove assertion when pretty printing anonymous class with a name (#554).

Version 4.1.1 (2018-12-26)
--------------------------

### Fixed

* Fix "undefined offset" notice when parsing specific malformed code (#551).

### Added

* Support error recovery for missing return type (`function foo() : {}`) (#544).

Version 4.1.0 (2018-10-10)
--------------------------

### Added

* Added support for PHP 7.3 flexible heredoc/nowdoc strings, completing support for PHP 7.3. There
  are two caveats for this feature:
   * In some rare, pathological cases flexible heredoc/nowdoc strings change the interpretation of
     existing doc strings. PHP-Parser will now use the new interpretation.
   * Flexible heredoc/nowdoc strings require special support from the lexer. Because this is not
     available on PHP versions before 7.3, support has to be emulated. This emulation is not perfect
     and some cases which we do not expect to occur in practice (such as flexible doc strings being
     nested within each other through abuse of variable-variable interpolation syntax) may not be
     recognized correctly.
* Added `DONT_TRAVERSE_CURRENT_AND_CHILDREN` to `NodeTraverser` to skip both traversal of child
  nodes, and prevent subsequent visitors from visiting the current node.

Version 4.0.4 (2018-09-18)
--------------------------

### Added

* The following methods have been added to `BuilderFactory`:
  * `useTrait()` (fluent builder)
  * `traitUseAdaptation()` (fluent builder)
  * `useFunction()` (fluent builder)
  * `useConst()` (fluent builder)
  * `var()`
  * `propertyFetch()`
  
### Deprecated

* `Builder\Param::setTypeHint()` has been deprecated in favor of the newly introduced
  `Builder\Param::setType()`.

Version 4.0.3 (2018-07-15)
--------------------------

### Fixed

* Fixed possible undefined offset notice in formatting-preserving printer. (#513)

### Added

* Improved error recovery inside arrays.
* Preserve trailing comment inside classes. **Note:** This change is possibly BC breaking if your
  code validates that classes can only contain certain statement types. After this change, classes
  can also contain Nop statements, while this was not previously possible. (#509)

Version 4.0.2 (2018-06-03)
--------------------------

### Added

* Improved error recovery inside classes.
* Support error recovery for `foreach` without `as`.
* Support error recovery for parameters without variable (`function (Type ) {}`).
* Support error recovery for functions without body (`function ($foo)`).

Version 4.0.1 (2018-03-25)
--------------------------

### Added

* [PHP 7.3] Added support for trailing commas in function calls.
* [PHP 7.3] Added support for by-reference array destructuring. 
* Added checks to node traverser to prevent replacing a statement with an expression or vice versa.
  This should prevent common mistakes in the implementation of node visitors.
* Added the following methods to `BuilderFactory`, to simplify creation of expressions:
  * `funcCall()`
  * `methodCall()`
  * `staticCall()`
  * `new()`
  * `constFetch()`
  * `classConstFetch()`

Version 4.0.0 (2018-02-28)
--------------------------

* No significant code changes since the beta 1 release.

Version 4.0.0-beta1 (2018-01-27)
--------------------------------

### Fixed

* In formatting-preserving pretty printer: Fixed indentation when inserting into lists. (#466)

### Added

* In formatting-preserving pretty printer: Improved formatting of elements inserted into multi-line
  arrays.

### Removed

* The `Autoloader` class has been removed. It is now required to use the Composer autoloader.

Version 4.0.0-alpha3 (2017-12-26)
---------------------------------

### Fixed

* In the formatting-preserving pretty printer:
  * Fixed comment indentation.
  * Fixed handling of inline HTML in the fallback case.
  * Fixed insertion into list nodes that require creation of a code block.

### Added

* Added support for inserting at the start of list nodes in formatting-preserving pretty printer.

Version 4.0.0-alpha2 (2017-11-10)
---------------------------------

### Added

* In the formatting-preserving pretty printer:
  * Added support for changing modifiers.
  * Added support for anonymous classes.
  * Added support for removing from list nodes.
  * Improved support for changing comments.
* Added start token offsets to comments.

Version 4.0.0-alpha1 (2017-10-18)
---------------------------------

### Added

* Added experimental support for format-preserving pretty-printing. In this mode formatting will be
  preserved for parts of the code which have not been modified.
* Added `replaceNodes` option to `NameResolver`, defaulting to true. If this option is disabled,
  resolved names will be added as `resolvedName` attributes, instead of replacing the original
  names.
* Added `NodeFinder` class, which can be used to find nodes based on a callback or class name. This
  is a utility to avoid custom node visitor implementations for simple search operations.
* Added `ClassMethod::isMagic()` method.
* Added `BuilderFactory` methods: `val()` method for creating an AST for a simple value, `concat()`
  for creating concatenation trees, `args()` for preparing function arguments.
* Added `NameContext` class, which encapsulates the `NameResolver` logic independently of the actual
  AST traversal. This facilitates use in other context, such as class names in doc comments.
  Additionally it provides an API for getting the shortest representation of a name.
* Added `Node::setAttributes()` method.
* Added `JsonDecoder`. This allows conversion JSON back into an AST.
* Added `Name` methods `toLowerString()` and `isSpecialClassName()`.
* Added `Identifier` and `VarLikeIdentifier` nodes, which are used in place of simple strings in
  many places.
* Added `getComments()`, `getStartLine()`, `getEndLine()`, `getStartTokenPos()`, `getEndTokenPos()`,
  `getStartFilePos()` and `getEndFilePos()` methods to `Node`. These provide a more obvious access
  point for the already existing attributes of the same name.
* Added `ConstExprEvaluator` to evaluate constant expressions to PHP values.
* Added `Expr\BinaryOp::getOperatorSigil()`, returning `+` for `Expr\BinaryOp\Plus`, etc.

### Changed

* Many subnodes that previously held simple strings now use `Identifier` (or `VarLikeIdentifier`)
  nodes. Please see the UPGRADE-4.0 file for an exhaustive list of affected nodes and some notes on
  possible impact.
* Expression statements (`expr;`) are now represented using a `Stmt\Expression` node. Previously
  these statements were directly represented as their constituent expression.
* The `name` subnode of `Param` has been renamed to `var` and now contains a `Variable` rather than
  a plain string.
* The `name` subnode of `StaticVar` has been renamed to `var` and now contains a `Variable` rather
  than a plain string.
* The `var` subnode of `ClosureUse` now contains a `Variable` rather than a plain string.
* The `var` subnode of `Catch` now contains a `Variable` rather than a plain string.
* The `alias` subnode of `UseUse` is now `null` if no explicit alias is given. As such,
  `use Foo\Bar` and `use Foo\Bar as Bar` are now represented differently. The `getAlias()` method
  can be used to get the effective alias, even if it is not explicitly given.

### Removed

* Support for running on PHP 5 and HHVM has been removed. You can however still parse code of old
  PHP versions (such as PHP 5.2), while running on PHP 7.
* Removed `type` subnode on `Class`, `ClassMethod` and `Property` nodes. Use `flags` instead.
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

Version 3.1.5 (2018-02-28)
--------------------------

### Fixed

* Fixed duplicate comment assignment in switch statements. (#469)
* Improve compatibility with PHP-Scoper. (#477)

Version 3.1.4 (2018-01-25)
--------------------------

### Fixed

* Fixed pretty printing of `-(-$x)` and `+(+$x)`. (#459)

Version 3.1.3 (2017-12-26)
--------------------------

### Fixed

* Improve compatibility with php-scoper, by supporting prefixed namespaces in
  `NodeAbstract::getType()`.

Version 3.1.2 (2017-11-04)
--------------------------

### Fixed

* Comments on empty blocks are now preserved on a `Stmt\Nop` node. (#382)

### Added

* Added `kind` attribute for `Stmt\Namespace_` node, which is one of `KIND_SEMICOLON` or
  `KIND_BRACED`. (#417)
* Added `setDocComment()` method to namespace builder. (#437)

Version 3.1.1 (2017-09-02)
--------------------------

### Fixed

* Fixed syntax error on comment after brace-style namespace declaration. (#412)
* Added support for TraitUse statements in trait builder. (#413)

Version 3.1.0 (2017-07-28)
--------------------------

### Added

* [PHP 7.2] Added support for trailing comma in group use statements.
* [PHP 7.2] Added support for `object` type. This means `object` types will now be represented as a
  builtin type (a simple `"object"` string), rather than a class `Name`.

### Fixed

* Floating-point numbers are now printed correctly if the LC_NUMERIC locale uses a comma as decimal
  separator.

### Changed

* `Name::$parts` is no longer deprecated.

Version 3.0.6 (2017-06-28)
--------------------------

### Fixed

* Fixed the spelling of `Class_::VISIBILITY_MODIFIER_MASK`. The previous spelling of
  `Class_::VISIBILITY_MODIFER_MASK` is preserved for backwards compatibility.
* The pretty printing will now preserve comments inside array literals and function calls by
  printing the array items / function arguments on separate lines. Array literals and functions that
  do not contain comments are not affected.

### Added

* Added `Builder\Param::makeVariadic()`.

### Deprecated

* The `Node::setLine()` method has been deprecated.

Version 3.0.5 (2017-03-05)
--------------------------

### Fixed

* Name resolution of `NullableType`s is now performed earlier, so that a fully resolved signature is
  available when a function is entered. (#360)
* `Error` nodes are now considered empty, while previously they extended until the token where the
  error occurred. This made some nodes larger than expected. (#359)
* Fixed notices being thrown during error recovery in some situations. (#362)

Version 3.0.4 (2017-02-10)
--------------------------

### Fixed

* Fixed some extensibility issues in pretty printer (`pUseType()` is now public and `pPrec()` calls
  into `p()`, instead of directly dispatching to the type-specific printing method).
* Fixed notice in `bin/php-parse` script.

### Added

* Error recovery from missing semicolons is now supported in more cases.
* Error recovery from trailing commas in positions where PHP does not support them is now supported.

Version 3.0.3 (2017-02-03)
--------------------------

### Fixed

* In `"$foo[0]"` the `0` is now parsed as an `LNumber` rather than `String`. (#325)
* Ensure integers and floats are always pretty printed preserving semantics, even if the particular
  value can only be manually constructed.
* Throw a `LogicException` when trying to pretty-print an `Error` node. Previously this resulted in
  an undefined method exception or fatal error.

### Added

* [PHP 7.1] Added support for negative interpolated offsets: `"$foo[-1]"`
* Added `preserveOriginalNames` option to `NameResolver`. If this option is enabled, an
  `originalName` attribute, containing the unresolved name, will be added to each resolved name.
* Added `php-parse --with-positions` option, which dumps nodes with position information.

### Deprecated

* The XML serializer has been deprecated. In particular, the classes `Serializer\XML`,
  `Unserializer\XML`, as well as the interfaces `Serializer` and `Unserializer` are deprecated.

Version 3.0.2 (2016-12-06)
--------------------------

### Fixed

* Fixed name resolution of nullable types. (#324)
* Fixed pretty-printing of nullable types.

Version 3.0.1 (2016-12-01)
--------------------------

### Fixed

* Fixed handling of nested `list()`s: If the nested list was unkeyed, it was directly included in
  the list items. If it was keyed, it was wrapped in `ArrayItem`. Now nested `List_` nodes are
  always wrapped in `ArrayItem`s. (#321)

Version 3.0.0 (2016-11-30)
--------------------------

### Added

* Added support for dumping node positions in the NodeDumper through the `dumpPositions` option.
* Added error recovery support for `$`, `new`, `Foo::`.

Version 3.0.0-beta2 (2016-10-29)
--------------------------------

This release primarily improves our support for error recovery.

### Added

* Added `Node::setDocComment()` method.
* Added `Error::getMessageWithColumnInfo()` method.
* Added support for recovery from lexer errors.
* Added support for recovering from "special" errors (i.e. non-syntax parse errors).
* Added precise location information for lexer errors.
* Added `ErrorHandler` interface, and `ErrorHandler\Throwing` and `ErrorHandler\Collecting` as
  specific implementations. These provide a general mechanism for handling error recovery.
* Added optional `ErrorHandler` argument to `Parser::parse()`, `Lexer::startLexing()` and
  `NameResolver::__construct()`.
* The `NameResolver` now adds a `namespacedName` attribute on name nodes that cannot be statically
  resolved (unqualified unaliased function or constant names in namespaces).

### Fixed

* Fixed attribute assignment for `GroupUse` prefix and variables in interpolated strings.

### Changed

* The constants on `NameTraverserInterface` have been moved into the `NameTraverser` class.
* Due to the error handling changes, the `Parser` interface and `Lexer` API have changed.
* The emulative lexer now directly postprocesses tokens, instead of using `~__EMU__~` sequences.
  This changes the protected API of the lexer.
* The `Name::slice()` method now returns `null` for empty slices, previously `new Name([])` was
  used. `Name::concat()` now also supports concatenation with `null`.

### Removed

* Removed `Name::append()` and `Name::prepend()`. These mutable methods have been superseded by
  the immutable `Name::concat()`.
* Removed `Error::getRawLine()` and `Error::setRawLine()`. These methods have been superseded by
  `Error::getStartLine()` and `Error::setStartLine()`.
* Removed support for node cloning in the `NodeTraverser`.
* Removed `$separator` argument from `Name::toString()`.
* Removed `throw_on_error` parser option and `Parser::getErrors()` method. Use the `ErrorHandler`
  mechanism instead.

Version 3.0.0-beta1 (2016-09-16)
--------------------------------

### Added

* [7.1] Function/method and parameter builders now support PHP 7.1 type hints (void, iterable and
  nullable types).
* Nodes and Comments now implement `JsonSerializable`. The node kind is stored in a `nodeType`
  property.
* The `InlineHTML` node now has an `hasLeadingNewline` attribute, that specifies whether the
  preceding closing tag contained a newline. The pretty printer honors this attribute.
* Partial parsing of `$obj->` (with missing property name) is now supported in error recovery mode.
* The error recovery mode is now exposed in the `php-parse` script through the `--with-recovery`
  or `-r` flags.

The following changes are also part of PHP-Parser 2.1.1:

* The PHP 7 parser will now generate a parse error for `$var =& new Obj` assignments.
* Comments on free-standing code blocks will now be retained as comments on the first statement in
  the code block.

Version 3.0.0-alpha1 (2016-07-25)
---------------------------------

### Added

* [7.1] Added support for `void` and `iterable` types. These will now be represented as strings
  (instead of `Name` instances) similar to other builtin types.
* [7.1] Added support for class constant visibility. The `ClassConst` node now has a `flags` subnode
  holding the visibility modifier, as well as `isPublic()`, `isProtected()` and `isPrivate()`
  methods. The constructor changed to accept the additional subnode.
* [7.1] Added support for nullable types. These are represented using a new `NullableType` node
  with a single `type` subnode.
* [7.1] Added support for short array destructuring syntax. This means that `Array` nodes may now
  appear as the left-hand-side of assignments and foreach value targets. Additionally the array
  items may now contain `null` values if elements are skipped.
* [7.1] Added support for keys in list() destructuring. The `List` subnode `vars` has been renamed
  to `items` and now contains `ArrayItem`s instead of plain variables.
* [7.1] Added support for multi-catch. The `Catch` subnode `type` has been renamed to `types` and
  is now an array of `Name`s.
* `Name::slice()` now supports lengths and negative offsets. This brings it in line with
  `array_slice()` functionality.

### Changed

Due to PHP 7.1 support additions described above, the node structure changed as follows:

* `void` and `iterable` types are now stored as strings if the PHP 7 parser is used.
* The `ClassConst` constructor changed to accept an additional `flags` subnode.
* The `Array` subnode `items` may now contain `null` elements (destructuring).
* The `List` subnode `vars` has been renamed to `items` and now contains `ArrayItem`s instead of
  plain variables.
* The `Catch` subnode `type` has been renamed to `types` and is now an array of `Name`s.

Additionally the following changes were made:

* The `type` subnode on `Class`, `ClassMethod` and `Property` has been renamed to `flags`. The
  `type` subnode has retained for backwards compatibility and is populated to the same value as
  `flags`. However, writes to `type` will not update `flags`.
* The `TryCatch` subnode `finallyStmts` has been replaced with a `finally` subnode that holds an
  explicit `Finally` node. This allows for more accurate attribute assignment.
* The `Trait` constructor now has the same form as the `Class` and `Interface` constructors: It
  takes an array of subnodes. Unlike classes/interfaces, traits can only have a `stmts` subnode.
* The `NodeDumper` now prints class/method/property/constant modifiers, as well as the include and
  use type in a textual representation, instead of only showing the number.
* All methods on `PrettyPrinter\Standard` are now protected. Previously most of them were public.

### Removed

* Removed support for running on PHP 5.4. It is however still possible to parse PHP 5.2-5.4 code
  while running on a newer version.
* The deprecated `Comment::setLine()` and `Comment::setText()` methods have been removed.
* The deprecated `Name::set()`, `Name::setFirst()` and `Name::setLast()` methods have been removed.

Version 2.1.1 (2016-09-16)
--------------------------

### Changed

* The pretty printer will now escape all control characters in the range `\x00-\x1F` inside double
  quoted strings. If no special escape sequence is available, an octal escape will be used.
* The quality of the error recovery has been improved. In particular unterminated expressions should
  be handled more gracefully.
* The PHP 7 parser will now generate a parse error for `$var =& new Obj` assignments.
* Comments on free-standing code blocks will no be retained as comments on the first statement in
  the code block.

Version 2.1.0 (2016-04-19)
--------------------------

### Fixed

* Properly support `B""` strings (with uppercase `B`) in a number of places.
* Fixed reformatting of indented parts in a certain non-standard comment style.

### Added

* Added `dumpComments` option to node dumper, to enable dumping of comments associated with nodes.
* Added `Stmt\Nop` node, that is used to collect comments located at the end of a block or at the
  end of a file (without a following node with which they could otherwise be associated).
* Added `kind` attribute to `Expr\Exit` to distinguish between `exit` and `die`.
* Added `kind` attribute to `Scalar\LNumber` to distinguish between decimal, binary, octal and
  hexadecimal numbers.
* Added `kind` attribute to `Expr\Array` to distinguish between `array()` and `[]`.
* Added `kind` attribute to `Scalar\String` and `Scalar\Encapsed` to distinguish between
  single-quoted, double-quoted, heredoc and nowdoc string.
* Added `docLabel` attribute to `Scalar\String` and `Scalar\Encapsed`, if it is a heredoc or
  nowdoc string.
* Added start file offset information to `Comment` nodes.
* Added `setReturnType()` method to function and method builders.
* Added `-h` and `--help` options to `php-parse` script.

### Changed

* Invalid octal literals now throw a parse error in PHP 7 mode.
* The pretty printer takes all the new attributes mentioned in the previous section into account.
* The protected `AbstractPrettyPrinter::pComments()` method no longer returns a trailing newline.
* The bundled autoloader supports library files being stored in a different directory than
  `PhpParser` for easier downstream distribution.

### Deprecated

* The `Comment::setLine()` and `Comment::setText()` methods have been deprecated. Construct new
  objects instead.

### Removed

* The internal (but public) method `Scalar\LNumber::parse()` has been removed. A non-internal
  `LNumber::fromString()` method has been added instead.

Version 2.0.1 (2016-02-28)
--------------------------

### Fixed

* `declare() {}` and `declare();` are not semantically equivalent and will now result in different
  ASTs. The format case will have an empty `stmts` array, while the latter will set `stmts` to
  `null`.
* Magic constants are now supported as semi-reserved keywords.
* A shebang line like `#!/usr/bin/env php` is now allowed at the start of a namespaced file.
  Previously this generated an exception.
* The `prettyPrintFile()` method will not strip a trailing `?>` from the raw data that follows a
  `__halt_compiler()` statement.
* The `prettyPrintFile()` method will not strip an opening `<?php` if the file starts with a
  comment followed by InlineHTML.

Version 2.0.0 (2015-12-04)
--------------------------

### Changed

* String parts of encapsed strings are now represented using `Scalar\EncapsStringPart` nodes.
  Previously raw strings were used. This affects the `parts` child of `Scalar\Encaps` and
  `Expr\ShellExec`. The change has been done to allow assignment of attributes to encapsed string
  parts.

Version 2.0.0-beta1 (2015-10-21)
--------------------------------

### Fixed

* Fixed issue with too many newlines being stripped at the end of heredoc/nowdoc strings in some
  cases. (#227)

### Changed

* Update group use support to be in line with recent PHP 7.0 builds.
* Renamed `php-parse.php` to `php-parse` and registered it as a composer bin.
* Use composer PSR-4 autoloader instead of custom autoloader.
* Specify phpunit as a dev dependency.

### Added

* Added `shortArraySyntax` option to pretty printer, to print all arrays using short syntax.

Version 2.0.0-alpha1 (2015-07-14)
---------------------------------

A more detailed description of backwards incompatible changes can be found in the
[upgrading guide](UPGRADE-2.0.md).

### Removed

* Removed support for running on PHP 5.3. It is however still possible to parse PHP 5.2 and PHP 5.3
  code while running on a newer version.
* Removed legacy class name aliases. This includes the old non-namespaced class names and the old
  names for classes that were renamed for PHP 7 compatibility.
* Removed support for legacy node format. All nodes must have a `getSubNodeNames()` method now.

### Added

* Added support for remaining PHP 7 features that were not present in 1.x:
  * Group use declarations. These are represented using `Stmt\GroupUse` nodes. Furthermore a `type`
    attribute was added to `Stmt\UseUse` to handle mixed group use declarations.
  * Uniform variable syntax.
  * Generalized yield operator.
  * Scalar type declarations. These are presented using `'bool'`, `'int'`, `'float'` and `'string'`
    as the type. The PHP 5 parser also accepts these, however they'll be `Name` instances there.
  * Unicode escape sequences.
* Added `PhpParser\ParserFactory` class, which should be used to create parser instances.
* Added `Name::concat()` which concatenates two names.
* Added `Name->slice()` which takes a subslice of a name.

### Changed

* `PhpParser\Parser` is now an interface, implemented by `Parser\Php5`, `Parser\Php7` and
  `Parser\Multiple`. The `Multiple` parser will try multiple parsers, until one succeeds.
* Token constants are now defined on `PhpParser\Parser\Tokens` rather than `PhpParser\Parser`.
* The `Name->set()`, `Name->append()`, `Name->prepend()` and `Name->setFirst()` methods are
  deprecated in favor of `Name::concat()` and `Name->slice()`.
* The `NodeTraverser` no longer clones nodes by default. The old behavior can be restored by
  passing `true` to the constructor.
* The constructor for `Scalar` nodes no longer has a default value. E.g. `new LNumber()` should now
  be written as `new LNumber(0)`.

---

**This changelog only includes changes from the 2.0 series. For older changes see the
[1.x series changelog](https://github.com/nikic/PHP-Parser/blob/1.x/CHANGELOG.md) and the
[0.9 series changelog](https://github.com/nikic/PHP-Parser/blob/0.9/CHANGELOG.md).**
