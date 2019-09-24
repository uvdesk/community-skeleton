<?php declare(strict_types=1);

namespace PhpParser\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\NodeTraverser;

class FindingVisitorTest extends \PHPUnit\Framework\TestCase
{
    public function testFindVariables() {
        $traverser = new NodeTraverser();
        $visitor = new FindingVisitor(function(Node $node) {
            return $node instanceof Node\Expr\Variable;
        });
        $traverser->addVisitor($visitor);

        $assign = new Expr\Assign(new Expr\Variable('a'), new Expr\BinaryOp\Concat(
            new Expr\Variable('b'), new Expr\Variable('c')
        ));
        $stmts = [new Node\Stmt\Expression($assign)];

        $traverser->traverse($stmts);
        $this->assertSame([
            $assign->var,
            $assign->expr->left,
            $assign->expr->right,
        ], $visitor->getFoundNodes());
    }

    public function testFindAll() {
        $traverser = new NodeTraverser();
        $visitor = new FindingVisitor(function(Node $node) {
            return true; // All nodes
        });
        $traverser->addVisitor($visitor);

        $assign = new Expr\Assign(new Expr\Variable('a'), new Expr\BinaryOp\Concat(
            new Expr\Variable('b'), new Expr\Variable('c')
        ));
        $stmts = [new Node\Stmt\Expression($assign)];

        $traverser->traverse($stmts);
        $this->assertSame([
            $stmts[0],
            $assign,
            $assign->var,
            $assign->expr,
            $assign->expr->left,
            $assign->expr->right,
        ], $visitor->getFoundNodes());
    }
}
