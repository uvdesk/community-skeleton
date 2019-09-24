<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr\Print_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;

class FunctionTest extends \PHPUnit\Framework\TestCase
{
    public function createFunctionBuilder($name) {
        return new Function_($name);
    }

    public function testReturnByRef() {
        $node = $this->createFunctionBuilder('test')
            ->makeReturnByRef()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Function_('test', [
                'byRef' => true
            ]),
            $node
        );
    }

    public function testParams() {
        $param1 = new Node\Param(new Variable('test1'));
        $param2 = new Node\Param(new Variable('test2'));
        $param3 = new Node\Param(new Variable('test3'));

        $node = $this->createFunctionBuilder('test')
            ->addParam($param1)
            ->addParams([$param2, $param3])
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Function_('test', [
                'params' => [$param1, $param2, $param3]
            ]),
            $node
        );
    }

    public function testStmts() {
        $stmt1 = new Print_(new String_('test1'));
        $stmt2 = new Print_(new String_('test2'));
        $stmt3 = new Print_(new String_('test3'));

        $node = $this->createFunctionBuilder('test')
            ->addStmt($stmt1)
            ->addStmts([$stmt2, $stmt3])
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Function_('test', [
                'stmts' => [
                    new Stmt\Expression($stmt1),
                    new Stmt\Expression($stmt2),
                    new Stmt\Expression($stmt3),
                ]
            ]),
            $node
        );
    }

    public function testDocComment() {
        $node = $this->createFunctionBuilder('test')
            ->setDocComment('/** Test */')
            ->getNode();

        $this->assertEquals(new Stmt\Function_('test', [], [
            'comments' => [new Comment\Doc('/** Test */')]
        ]), $node);
    }

    public function testReturnType() {
        $node = $this->createFunctionBuilder('test')
            ->setReturnType('void')
            ->getNode();

        $this->assertEquals(new Stmt\Function_('test', [
            'returnType' => 'void'
        ], []), $node);
    }

    public function testInvalidNullableVoidType() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('void type cannot be nullable');
        $this->createFunctionBuilder('test')->setReturnType('?void');
    }

    public function testInvalidParamError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Expected parameter node, got "Name"');
        $this->createFunctionBuilder('test')
            ->addParam(new Node\Name('foo'))
        ;
    }

    public function testAddNonStmt() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Expected statement or expression node');
        $this->createFunctionBuilder('test')
            ->addStmt(new Node\Name('Test'));
    }
}
