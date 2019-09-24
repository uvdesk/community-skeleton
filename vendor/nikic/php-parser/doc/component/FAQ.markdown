Frequently Asked Questions
==========================

 * [How can the parent of a node be obtained?](#how-can-the-parent-of-a-node-be-obtained)
 * [How can the next/previous sibling of a node be obtained?](#how-can-the-nextprevious-sibling-of-a-node-be-obtained)

How can the parent of a node be obtained?
-----

The AST does not store parent nodes by default. However, it is easy to add a custom parent node
attribute using a custom node visitor:

```php
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class ParentConnector extends NodeVisitorAbstract {
    private $stack;
    public function beforeTraverse(array $nodes) {
        $this->stack = [];
    }
    public function enterNode(Node $node) {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[count($this->stack)-1]);
        }
        $this->stack[] = $node;
    }
    public function leaveNode(Node $node) {
        array_pop($this->stack);
    }
}
```

After running this visitor, the parent node can be obtained through `$node->getAttribute('parent')`.

How can the next/previous sibling of a node be obtained?
-----

Again, siblings are not stored by default, but the visitor from the previous entry can be easily
extended to store the previous / next node with a common parent as well:

```php
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class NodeConnector extends NodeVisitorAbstract {
    private $stack;
    private $prev;
    public function beforeTraverse(array $nodes) {
        $this->stack = [];
        $this->prev = null;
    }
    public function enterNode(Node $node) {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[count($this->stack)-1]);
        }
        if ($this->prev && $this->prev->getAttribute('parent') == $node->getAttribute('parent')) {
            $node->setAttribute('prev', $this->prev);
            $this->prev->setAttribute('next', $node);
        }
        $this->stack[] = $node;
    }
    public function leaveNode(Node $node) {
        $this->prev = $node;
        array_pop($this->stack);
    }
}
```
