<?php declare(strict_types=1);

namespace PhpParser\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\NodeTraverser;

class FirstFindingVisitorTest extends \PHPUnit\Framework\TestCase
{
    public function testFindFirstVariable() {
        $traverser = new NodeTraverser();
        $visitor = new FirstFindingVisitor(function(Node $node) {
            return $node instanceof Node\Expr\Variable;
        });
        $traverser->addVisitor($visitor);

        $assign = new Expr\Assign(new Expr\Variable('a'), new Expr\Variable('b'));
        $stmts = [new Node\Stmt\Expression($assign)];

        $traverser->traverse($stmts);
        $this->assertSame($assign->var, $visitor->getFoundNode());
    }

    public function testFindNone() {
        $traverser = new NodeTraverser();
        $visitor = new FirstFindingVisitor(function(Node $node) {
            return $node instanceof Node\Expr\BinaryOp;
        });
        $traverser->addVisitor($visitor);

        $assign = new Expr\Assign(new Expr\Variable('a'), new Expr\Variable('b'));
        $stmts = [new Node\Stmt\Expression($assign)];

        $traverser->traverse($stmts);
        $this->assertNull($visitor->getFoundNode());
    }
}
