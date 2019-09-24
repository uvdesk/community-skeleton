Upgrading from PHP-Parser 0.9 to 1.0
====================================

### PHP version requirements

PHP-Parser now requires PHP 5.3 or newer to run. It is however still possible to *parse* PHP 5.2 source code, while
running on a newer version.

### Move to namespaced names

The library has been moved to use namespaces with the `PhpParser` vendor prefix. However, the old names using
underscores are still available as aliases, as such most code should continue running on the new version without
further changes.

Old (still works, but discouraged):

```php
$parser = new \PHPParser_Parser(new \PHPParser_Lexer_Emulative);
$prettyPrinter = new \PHPParser_PrettyPrinter_Default;
```

New:

```php
$parser = new \PhpParser\Parser(new PhpParser\Lexer\Emulative);
$prettyPrinter = new \PhpParser\PrettyPrinter\Standard;
```

Note that the `PHPParser` prefix was changed to `PhpParser`. While PHP class names are technically case-insensitive,
the autoloader will not be able to load `PHPParser\Parser` or other case variants.

Due to conflicts with reserved keywords, some class names now end with an underscore, e.g. `PHPParser_Node_Stmt_Class`
is now `PhpParser\Node\Stmt\Class_`. (But as usual, the old name is still available.)

### Changes to `Node::getType()`

The `Node::getType()` method continues to return names using underscores instead of namespace separators and also does
not contain the trailing underscore that may be present in the class name. As such its output will not change in many
cases.

However, some node classes have been moved to a different namespace or renamed, which will result in a different
`Node::getType()` output:

```
Expr_AssignBitwiseAnd => Expr_AssignOp_BitwiseAnd
Expr_AssignBitwiseOr  => Expr_AssignOp_BitwiseOr
Expr_AssignBitwiseXor => Expr_AssignOp_BitwiseXor
Expr_AssignConcat     => Expr_AssignOp_Concat
Expr_AssignDiv        => Expr_AssignOp_Div
Expr_AssignMinus      => Expr_AssignOp_Minus
Expr_AssignMod        => Expr_AssignOp_Mod
Expr_AssignMul        => Expr_AssignOp_Mul
Expr_AssignPlus       => Expr_AssignOp_Plus
Expr_AssignShiftLeft  => Expr_AssignOp_ShiftLeft
Expr_AssignShiftRight => Expr_AssignOp_ShiftRight

Expr_BitwiseAnd       => Expr_BinaryOp_BitwiseAnd
Expr_BitwiseOr        => Expr_BinaryOp_BitwiseOr
Expr_BitwiseXor       => Expr_BinaryOp_BitwiseXor
Expr_BooleanAnd       => Expr_BinaryOp_BooleanAnd
Expr_BooleanOr        => Expr_BinaryOp_BooleanOr
Expr_Concat           => Expr_BinaryOp_Concat
Expr_Div              => Expr_BinaryOp_Div
Expr_Equal            => Expr_BinaryOp_Equal
Expr_Greater          => Expr_BinaryOp_Greater
Expr_GreaterOrEqual   => Expr_BinaryOp_GreaterOrEqual
Expr_Identical        => Expr_BinaryOp_Identical
Expr_LogicalAnd       => Expr_BinaryOp_LogicalAnd
Expr_LogicalOr        => Expr_BinaryOp_LogicalOr
Expr_LogicalXor       => Expr_BinaryOp_LogicalXor
Expr_Minus            => Expr_BinaryOp_Minus
Expr_Mod              => Expr_BinaryOp_Mod
Expr_Mul              => Expr_BinaryOp_Mul
Expr_NotEqual         => Expr_BinaryOp_NotEqual
Expr_NotIdentical     => Expr_BinaryOp_NotIdentical
Expr_Plus             => Expr_BinaryOp_Plus
Expr_ShiftLeft        => Expr_BinaryOp_ShiftLeft
Expr_ShiftRight       => Expr_BinaryOp_ShiftRight
Expr_Smaller          => Expr_BinaryOp_Smaller
Expr_SmallerOrEqual   => Expr_BinaryOp_SmallerOrEqual

Scalar_ClassConst     => Scalar_MagicConst_Class
Scalar_DirConst       => Scalar_MagicConst_Dir
Scalar_FileConst      => Scalar_MagicConst_File
Scalar_FuncConst      => Scalar_MagicConst_Function
Scalar_LineConst      => Scalar_MagicConst_Line
Scalar_MethodConst    => Scalar_MagicConst_Method
Scalar_NSConst        => Scalar_MagicConst_Namespace
Scalar_TraitConst     => Scalar_MagicConst_Trait
```

These changes may affect custom pretty printers and code comparing the return value of `Node::getType()` to specific
strings.

### Miscellaneous

  * The classes `Template` and `TemplateLoader` have been removed. You should use some other [code generation][code_gen]
    project built on top of PHP-Parser instead.

  * The `PrettyPrinterAbstract::pStmts()` method now emits a leading newline if the statement list is not empty.
    Custom pretty printers should remove the explicit newline before `pStmts()` calls.

    Old:

    ```php
    public function pStmt_Trait(PHPParser_Node_Stmt_Trait $node) {
        return 'trait ' . $node->name
             . "\n" . '{' . "\n" . $this->pStmts($node->stmts) . "\n" . '}';
    }
    ```

    New:

    ```php
    public function pStmt_Trait(Stmt\Trait_ $node) {
        return 'trait ' . $node->name
             . "\n" . '{' . $this->pStmts($node->stmts) . "\n" . '}';
    }
    ```

  [code_gen]: https://github.com/nikic/PHP-Parser/wiki/Projects-using-the-PHP-Parser#code-generation