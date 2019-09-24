Walking the AST
===============

The most common way to work with the AST is by using a node traverser and one or more node visitors.
As a basic example, the following code changes all literal integers in the AST into strings (e.g.,
`42` becomes `'42'`.)

```php
use PhpParser\{Node, NodeTraverser, NodeVisitorAbstract};

$traverser = new NodeTraverser;
$traverser->addVisitor(new class extends NodeVisitorAbstract {
    public function leaveNode(Node $node) {
        if ($node instanceof Node\Scalar\LNumber) {
            return new Node\Scalar\String_((string) $node->value);
        }
    }
});

$stmts = ...;
$modifiedStmts = $traverser->traverse($stmts);
```

Node visitors
-------------

Each node visitor implements an interface with following four methods:

```php
interface NodeVisitor {
    public function beforeTraverse(array $nodes);
    public function enterNode(Node $node);
    public function leaveNode(Node $node);
    public function afterTraverse(array $nodes);
}
```

The `beforeTraverse()` and `afterTraverse()` methods are called before and after the traversal
respectively, and are passed the entire AST. They can be used to perform any necessary state
setup or cleanup.

The `enterNode()` method is called when a node is first encountered, before its children are
processed ("preorder"). The `leaveNode()` method is called after all children have been visited
("postorder").

For example, if we have the following excerpt of an AST

```
Expr_FuncCall(
    name: Name(
        parts: array(
            0: printLine
        )
    )
    args: array(
        0: Arg(
            value: Scalar_String(
                value: Hello World!!!
            )
            byRef: false
            unpack: false
        )
    )
)
```

then the enter/leave methods will be called in the following order:

```
enterNode(Expr_FuncCall)
enterNode(Name)
leaveNode(Name)
enterNode(Arg)
enterNode(Scalar_String)
leaveNode(Scalar_String)
leaveNode(Arg)
leaveNode(Expr_FuncCall)
```

A common pattern is that `enterNode` is used to collect some information and then `leaveNode`
performs modifications based on that. At the time when `leaveNode` is called, all the code inside
the node will have already been visited and necessary information collected.

As you usually do not want to implement all four methods, it is recommended that you extend
`NodeVisitorAbstract` instead of implementing the interface directly. The abstract class provides
empty default implementations.

Modifying the AST
-----------------

There are a number of ways in which the AST can be modified from inside a node visitor. The first
and simplest is to simply change AST properties inside the visitor:

```php
public function leaveNode(Node $node) {
    if ($node instanceof Node\Scalar\LNumber) {
        // increment all integer literals
        $node->value++;
    }
}
```

The second is to replace a node entirely by returning a new node:

```php
public function leaveNode(Node $node) {
    if ($node instanceof Node\Expr\BinaryOp\BooleanAnd) {
        // Convert all $a && $b expressions into !($a && $b)
        return new Node\Expr\BooleanNot($node);
    }
}
```

Doing this is supported both inside enterNode and leaveNode. However, you have to be mindful about
where you perform the replacement: If a node is replaced in enterNode, then the recursive traversal
will also consider the children of the new node. If you aren't careful, this can lead to infinite
recursion. For example, let's take the previous code sample and use enterNode instead:

```php
public function enterNode(Node $node) {
    if ($node instanceof Node\Expr\BinaryOp\BooleanAnd) {
        // Convert all $a && $b expressions into !($a && $b)
        return new Node\Expr\BooleanNot($node);
    }
}
```

Now `$a && $b` will be replaced by `!($a && $b)`. Then the traverser will go into the first (and
only) child of `!($a && $b)`, which is `$a && $b`. The transformation applies again and we end up
with `!!($a && $b)`. This will continue until PHP hits the memory limit.

Finally, two special replacement types are supported only by leaveNode. The first is removal of a
node:

```php
public function leaveNode(Node $node) {
    if ($node instanceof Node\Stmt\Return_) {
        // Remove all return statements
        return NodeTraverser::REMOVE_NODE;
    }
}
```

Node removal only works if the parent structure is an array. This means that usually it only makes
sense to remove nodes of type `Node\Stmt`, as they always occur inside statement lists (and a few
more node types like `Arg` or `Expr\ArrayItem`, which are also always part of lists).

On the other hand, removing a `Node\Expr` does not make sense: If you have `$a * $b`, there is no
meaningful way in which the `$a` part could be removed. If you want to remove an expression, you
generally want to remove it together with a surrounding expression statement:

```php
public function leaveNode(Node $node) {
    if ($node instanceof Node\Stmt\Expression
        && $node->expr instanceof Node\Expr\FuncCall
        && $node->expr->name instanceof Node\Name
        && $node->expr->name->toString() === 'var_dump'
    ) {
        return NodeTraverser::REMOVE_NODE;
    }
}
```

This example will remove all calls to `var_dump()` which occur as expression statements. This means
that `var_dump($a);` will be removed, but `if (var_dump($a))` will not be removed (and there is no
obvious way in which it can be removed).

Next to removing nodes, it is also possible to replace one node with multiple nodes. Again, this
only works inside leaveNode and only if the parent structure is an array.

```php
public function leaveNode(Node $node) {
    if ($node instanceof Node\Stmt\Return_ && $node->expr !== null) {
        // Convert "return foo();" into "$retval = foo(); return $retval;"
        $var = new Node\Expr\Variable('retval');
        return [
            new Node\Stmt\Expression(new Node\Expr\Assign($var, $node->expr)),
            new Node\Stmt\Return_($var),
        ];
    }
}
```

Short-circuiting traversal
--------------------------

An AST can easily contain thousands of nodes, and traversing over all of them may be slow,
especially if you have more than one visitor. In some cases, it is possible to avoid a full
traversal.

If you are looking for all class declarations in a file (and assuming you're not interested in
anonymous classes), you know that once you've seen a class declaration, there is no point in also
checking all it's child nodes, because PHP does not allow nesting classes. In this case, you can
instruct the traverser to not recurse into the class node:

```
private $classes = [];
public function enterNode(Node $node) {
    if ($node instanceof Node\Stmt\Class_) {
        $this->classes[] = $node;
        return NodeTraverser::DONT_TRAVERSE_CHILDREN;
    }
}
```

Of course, this option is only available in enterNode, because it's already too late by the time
leaveNode is reached.

If you are only looking for one specific node, it is also possible to abort the traversal entirely
after finding it. For example, if you are looking for the node of a class with a certain name (and
discounting exotic cases like conditionally defining a class two times), you can stop traversal
once you found it:

```
private $class = null;
public function enterNode(Node $node) {
    if ($node instanceof Node\Stmt\Class_ &&
        $node->namespacedName->toString() === 'Foo\Bar\Baz'
    ) {
        $this->class = $node;
        return NodeTraverser::STOP_TRAVERSAL;
    }
}
```

This works both in enterNode and leaveNode. Note that this particular case can also be more easily
handled using a NodeFinder, which will be introduced below.

Multiple visitors
-----------------

A single traverser can be used with multiple visitors:

```php
$traverser = new NodeTraverser;
$traverser->addVisitor($visitorA);
$traverser->addVisitor($visitorB);
$stmts = $traverser->traverse($stmts);
```

It is important to understand that if a traverser is run with multiple visitors, the visitors will
be interleaved. Given the following AST excerpt

```
Stmt_Return(
    expr: Expr_Variable(
        name: foobar
    )
)
```

the following method calls will be performed:

```
$visitorA->enterNode(Stmt_Return)
$visitorB->enterNode(Stmt_Return)
$visitorA->enterNode(Expr_Variable)
$visitorB->enterNode(Expr_Variable)
$visitorA->leaveNode(Expr_Variable)
$visitorB->leaveNode(Expr_Variable)
$visitorA->leaveNode(Stmt_Return)
$visitorB->leaveNode(Stmt_Return)
```

That is, when visiting a node, enterNode and leaveNode will always be called for all visitors.
Running multiple visitors in parallel improves performance, as the AST only has to be traversed
once. However, it is not always possible to write visitors in a way that allows interleaved
execution. In this case, you can always fall back to performing multiple traversals:

```php
$traverserA = new NodeTraverser;
$traverserA->addVisitor($visitorA);
$traverserB = new NodeTraverser;
$traverserB->addVisitor($visitorB);
$stmts = $traverserA->traverser($stmts);
$stmts = $traverserB->traverser($stmts);
```

When using multiple visitors, it is important to understand how they interact with the various
special enterNode/leaveNode return values:

 * If *any* visitor returns `DONT_TRAVERSE_CHILDREN`, the children will be skipped for *all*
   visitors.
 * If *any* visitor returns `DONT_TRAVERSE_CURRENT_AND_CHILDREN`, the children will be skipped for *all*
   visitors, and all *subsequent* visitors will not visit the current node.
 * If *any* visitor returns `STOP_TRAVERSAL`, traversal is stopped for *all* visitors.
 * If a visitor returns a replacement node, subsequent visitors will be passed the replacement node,
   not the original one.
 * If a visitor returns `REMOVE_NODE`, subsequent visitors will not see this node.
 * If a visitor returns an array of replacement nodes, subsequent visitors will see neither the node
   that was replaced, nor the replacement nodes.

Simple node finding
-------------------

While the node visitor mechanism is very flexible, creating a node visitor can be overly cumbersome
for minor tasks. For this reason a `NodeFinder` is provided, which can find AST nodes that either
satisfy a certain callback, or which are instanced of a certain node type. A couple of examples are
shown in the following:

```php
use PhpParser\{Node, NodeFinder};

$nodeFinder = new NodeFinder;

// Find all class nodes.
$classes = $nodeFinder->findInstanceOf($stmts, Node\Stmt\Class_::class);

// Find all classes that extend another class
$extendingClasses = $nodeFinder->find($stmts, function(Node $node) {
    return $node instanceof Node\Stmt\Class_
        && $node->extends !== null;
});

// Find first class occurring in the AST. Returns null if no class exists.
$class = $nodeFinder->findFirstInstanceOf($stmts, Node\Stmt\Class_::class);

// Find first class that has name $name
$class = $nodeFinder->findFirst($stmts, function(Node $node) use ($name) {
    return $node instanceof Node\Stmt\Class_
        && $node->resolvedName->toString() === $name;
});
```

Internally, the `NodeFinder` also uses a node traverser. It only simplifies the interface for a
common use case.

Parent and sibling references
-----------------------------

The node visitor mechanism is somewhat rigid, in that it prescribes an order in which nodes should
be accessed: From parents to children. However, it can often be convenient to operate in the
reverse direction: When working on a node, you might want to check if the parent node satisfies a
certain property.

PHP-Parser does not add parent (or sibling) references to nodes by itself, but you can easily
emulate this with a visitor. See the [FAQ](FAQ.markdown) for more information.
