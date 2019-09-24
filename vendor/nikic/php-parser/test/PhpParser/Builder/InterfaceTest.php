<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Stmt;

class InterfaceTest extends \PHPUnit\Framework\TestCase
{
    protected function createInterfaceBuilder() {
        return new Interface_('Contract');
    }

    private function dump($node) {
        $pp = new \PhpParser\PrettyPrinter\Standard;
        return $pp->prettyPrint([$node]);
    }

    public function testEmpty() {
        $contract = $this->createInterfaceBuilder()->getNode();
        $this->assertInstanceOf(Stmt\Interface_::class, $contract);
        $this->assertEquals(new Node\Identifier('Contract'), $contract->name);
    }

    public function testExtending() {
        $contract = $this->createInterfaceBuilder()
            ->extend('Space\Root1', 'Root2')->getNode();
        $this->assertEquals(
            new Stmt\Interface_('Contract', [
                'extends' => [
                    new Node\Name('Space\Root1'),
                    new Node\Name('Root2')
                ],
            ]), $contract
        );
    }

    public function testAddMethod() {
        $method = new Stmt\ClassMethod('doSomething');
        $contract = $this->createInterfaceBuilder()->addStmt($method)->getNode();
        $this->assertSame([$method], $contract->stmts);
    }

    public function testAddConst() {
        $const = new Stmt\ClassConst([
            new Node\Const_('SPEED_OF_LIGHT', new DNumber(299792458.0))
        ]);
        $contract = $this->createInterfaceBuilder()->addStmt($const)->getNode();
        $this->assertSame(299792458.0, $contract->stmts[0]->consts[0]->value->value);
    }

    public function testOrder() {
        $const = new Stmt\ClassConst([
            new Node\Const_('SPEED_OF_LIGHT', new DNumber(299792458))
        ]);
        $method = new Stmt\ClassMethod('doSomething');
        $contract = $this->createInterfaceBuilder()
            ->addStmt($method)
            ->addStmt($const)
            ->getNode()
        ;

        $this->assertInstanceOf(Stmt\ClassConst::class, $contract->stmts[0]);
        $this->assertInstanceOf(Stmt\ClassMethod::class, $contract->stmts[1]);
    }

    public function testDocComment() {
        $node = $this->createInterfaceBuilder()
            ->setDocComment('/** Test */')
            ->getNode();

        $this->assertEquals(new Stmt\Interface_('Contract', [], [
            'comments' => [new Comment\Doc('/** Test */')]
        ]), $node);
    }

    public function testInvalidStmtError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unexpected node of type "Stmt_PropertyProperty"');
        $this->createInterfaceBuilder()->addStmt(new Stmt\PropertyProperty('invalid'));
    }

    public function testFullFunctional() {
        $const = new Stmt\ClassConst([
            new Node\Const_('SPEED_OF_LIGHT', new DNumber(299792458))
        ]);
        $method = new Stmt\ClassMethod('doSomething');
        $contract = $this->createInterfaceBuilder()
            ->addStmt($method)
            ->addStmt($const)
            ->getNode()
        ;

        eval($this->dump($contract));

        $this->assertTrue(interface_exists('Contract', false));
    }
}
