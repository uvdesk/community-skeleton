<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Node\Expr;

class NodeFinderTest extends \PHPUnit\Framework\TestCase
{
    private function getStmtsAndVars() {
        $assign = new Expr\Assign(new Expr\Variable('a'), new Expr\BinaryOp\Concat(
            new Expr\Variable('b'), new Expr\Variable('c')
        ));
        $stmts = [new Node\Stmt\Expression($assign)];
        $vars = [$assign->var, $assign->expr->left, $assign->expr->right];
        return [$stmts, $vars];
    }

    public function testFind() {
        $finder = new NodeFinder;
        list($stmts, $vars) = $this->getStmtsAndVars();
        $varFilter = function(Node $node) {
            return $node instanceof Expr\Variable;
        };
        $this->assertSame($vars, $finder->find($stmts, $varFilter));
        $this->assertSame($vars, $finder->find($stmts[0], $varFilter));

        $noneFilter = function () { return false; };
        $this->assertSame([], $finder->find($stmts, $noneFilter));
    }

    public function testFindInstanceOf() {
        $finder = new NodeFinder;
        list($stmts, $vars) = $this->getStmtsAndVars();
        $this->assertSame($vars, $finder->findInstanceOf($stmts, Expr\Variable::class));
        $this->assertSame($vars, $finder->findInstanceOf($stmts[0], Expr\Variable::class));
        $this->assertSame([], $finder->findInstanceOf($stmts, Expr\BinaryOp\Mul::class));
    }

    public function testFindFirst() {
        $finder = new NodeFinder;
        list($stmts, $vars) = $this->getStmtsAndVars();
        $varFilter = function(Node $node) {
            return $node instanceof Expr\Variable;
        };
        $this->assertSame($vars[0], $finder->findFirst($stmts, $varFilter));
        $this->assertSame($vars[0], $finder->findFirst($stmts[0], $varFilter));

        $noneFilter = function () { return false; };
        $this->assertNull($finder->findFirst($stmts, $noneFilter));
    }

    public function testFindFirstInstanceOf() {
        $finder = new NodeFinder;
        list($stmts, $vars) = $this->getStmtsAndVars();
        $this->assertSame($vars[0], $finder->findFirstInstanceOf($stmts, Expr\Variable::class));
        $this->assertSame($vars[0], $finder->findFirstInstanceOf($stmts[0], Expr\Variable::class));
        $this->assertNull($finder->findFirstInstanceOf($stmts, Expr\BinaryOp\Mul::class));
    }
}
