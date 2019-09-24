<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Node\Expr;
use PhpParser\Node\Scalar\String_;

class NodeTraverserTest extends \PHPUnit\Framework\TestCase
{
    public function testNonModifying() {
        $str1Node = new String_('Foo');
        $str2Node = new String_('Bar');
        $echoNode = new Node\Stmt\Echo_([$str1Node, $str2Node]);
        $stmts    = [$echoNode];

        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();

        $visitor->expects($this->at(0))->method('beforeTraverse')->with($stmts);
        $visitor->expects($this->at(1))->method('enterNode')->with($echoNode);
        $visitor->expects($this->at(2))->method('enterNode')->with($str1Node);
        $visitor->expects($this->at(3))->method('leaveNode')->with($str1Node);
        $visitor->expects($this->at(4))->method('enterNode')->with($str2Node);
        $visitor->expects($this->at(5))->method('leaveNode')->with($str2Node);
        $visitor->expects($this->at(6))->method('leaveNode')->with($echoNode);
        $visitor->expects($this->at(7))->method('afterTraverse')->with($stmts);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);

        $this->assertEquals($stmts, $traverser->traverse($stmts));
    }

    public function testModifying() {
        $str1Node  = new String_('Foo');
        $str2Node  = new String_('Bar');
        $printNode = new Expr\Print_($str1Node);

        // first visitor changes the node, second verifies the change
        $visitor1 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor2 = $this->getMockBuilder(NodeVisitor::class)->getMock();

        // replace empty statements with string1 node
        $visitor1->expects($this->at(0))->method('beforeTraverse')->with([])
                 ->willReturn([$str1Node]);
        $visitor2->expects($this->at(0))->method('beforeTraverse')->with([$str1Node]);

        // replace string1 node with print node
        $visitor1->expects($this->at(1))->method('enterNode')->with($str1Node)
                 ->willReturn($printNode);
        $visitor2->expects($this->at(1))->method('enterNode')->with($printNode);

        // replace string1 node with string2 node
        $visitor1->expects($this->at(2))->method('enterNode')->with($str1Node)
                 ->willReturn($str2Node);
        $visitor2->expects($this->at(2))->method('enterNode')->with($str2Node);

        // replace string2 node with string1 node again
        $visitor1->expects($this->at(3))->method('leaveNode')->with($str2Node)
                 ->willReturn($str1Node);
        $visitor2->expects($this->at(3))->method('leaveNode')->with($str1Node);

        // replace print node with string1 node again
        $visitor1->expects($this->at(4))->method('leaveNode')->with($printNode)
                 ->willReturn($str1Node);
        $visitor2->expects($this->at(4))->method('leaveNode')->with($str1Node);

        // replace string1 node with empty statements again
        $visitor1->expects($this->at(5))->method('afterTraverse')->with([$str1Node])
                 ->willReturn([]);
        $visitor2->expects($this->at(5))->method('afterTraverse')->with([]);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor1);
        $traverser->addVisitor($visitor2);

        // as all operations are reversed we end where we start
        $this->assertEquals([], $traverser->traverse([]));
    }

    public function testRemove() {
        $str1Node = new String_('Foo');
        $str2Node = new String_('Bar');

        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();

        // remove the string1 node, leave the string2 node
        $visitor->expects($this->at(2))->method('leaveNode')->with($str1Node)
                ->willReturn(NodeTraverser::REMOVE_NODE);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);

        $this->assertEquals([$str2Node], $traverser->traverse([$str1Node, $str2Node]));
    }

    public function testMerge() {
        $strStart  = new String_('Start');
        $strMiddle = new String_('End');
        $strEnd    = new String_('Middle');
        $strR1     = new String_('Replacement 1');
        $strR2     = new String_('Replacement 2');

        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();

        // replace strMiddle with strR1 and strR2 by merge
        $visitor->expects($this->at(4))->method('leaveNode')->with($strMiddle)
                ->willReturn([$strR1, $strR2]);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);

        $this->assertEquals(
            [$strStart, $strR1, $strR2, $strEnd],
            $traverser->traverse([$strStart, $strMiddle, $strEnd])
        );
    }

    public function testInvalidDeepArray() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Invalid node structure: Contains nested arrays');
        $strNode = new String_('Foo');
        $stmts = [[[$strNode]]];

        $traverser = new NodeTraverser;
        $this->assertEquals($stmts, $traverser->traverse($stmts));
    }

    public function testDontTraverseChildren() {
        $strNode = new String_('str');
        $printNode = new Expr\Print_($strNode);
        $varNode = new Expr\Variable('foo');
        $mulNode = new Expr\BinaryOp\Mul($varNode, $varNode);
        $negNode = new Expr\UnaryMinus($mulNode);
        $stmts = [$printNode, $negNode];

        $visitor1 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor2 = $this->getMockBuilder(NodeVisitor::class)->getMock();

        $visitor1->expects($this->at(1))->method('enterNode')->with($printNode)
            ->willReturn(NodeTraverser::DONT_TRAVERSE_CHILDREN);
        $visitor2->expects($this->at(1))->method('enterNode')->with($printNode);

        $visitor1->expects($this->at(2))->method('leaveNode')->with($printNode);
        $visitor2->expects($this->at(2))->method('leaveNode')->with($printNode);

        $visitor1->expects($this->at(3))->method('enterNode')->with($negNode);
        $visitor2->expects($this->at(3))->method('enterNode')->with($negNode);

        $visitor1->expects($this->at(4))->method('enterNode')->with($mulNode);
        $visitor2->expects($this->at(4))->method('enterNode')->with($mulNode)
            ->willReturn(NodeTraverser::DONT_TRAVERSE_CHILDREN);

        $visitor1->expects($this->at(5))->method('leaveNode')->with($mulNode);
        $visitor2->expects($this->at(5))->method('leaveNode')->with($mulNode);

        $visitor1->expects($this->at(6))->method('leaveNode')->with($negNode);
        $visitor2->expects($this->at(6))->method('leaveNode')->with($negNode);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor1);
        $traverser->addVisitor($visitor2);

        $this->assertEquals($stmts, $traverser->traverse($stmts));
    }

    public function testDontTraverseCurrentAndChildren() {
        // print 'str'; -($foo * $foo);
        $strNode = new String_('str');
        $printNode = new Expr\Print_($strNode);
        $varNode = new Expr\Variable('foo');
        $mulNode = new Expr\BinaryOp\Mul($varNode, $varNode);
        $divNode = new Expr\BinaryOp\Div($varNode, $varNode);
        $negNode = new Expr\UnaryMinus($mulNode);
        $stmts = [$printNode, $negNode];

        $visitor1 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor2 = $this->getMockBuilder(NodeVisitor::class)->getMock();

        $visitor1->expects($this->at(1))->method('enterNode')->with($printNode)
            ->willReturn(NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN);
        $visitor1->expects($this->at(2))->method('leaveNode')->with($printNode);

        $visitor1->expects($this->at(3))->method('enterNode')->with($negNode);
        $visitor2->expects($this->at(1))->method('enterNode')->with($negNode);

        $visitor1->expects($this->at(4))->method('enterNode')->with($mulNode)
            ->willReturn(NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN);
        $visitor1->expects($this->at(5))->method('leaveNode')->with($mulNode)->willReturn($divNode);

        $visitor1->expects($this->at(6))->method('leaveNode')->with($negNode);
        $visitor2->expects($this->at(2))->method('leaveNode')->with($negNode);

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor1);
        $traverser->addVisitor($visitor2);

        $resultStmts = $traverser->traverse($stmts);

        $this->assertInstanceOf(Expr\BinaryOp\Div::class, $resultStmts[1]->expr);
    }

    public function testStopTraversal() {
        $varNode1 = new Expr\Variable('a');
        $varNode2 = new Expr\Variable('b');
        $varNode3 = new Expr\Variable('c');
        $mulNode = new Expr\BinaryOp\Mul($varNode1, $varNode2);
        $printNode = new Expr\Print_($varNode3);
        $stmts = [$mulNode, $printNode];

        // From enterNode() with array parent
        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor->expects($this->at(1))->method('enterNode')->with($mulNode)
            ->willReturn(NodeTraverser::STOP_TRAVERSAL);
        $visitor->expects($this->at(2))->method('afterTraverse');
        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);
        $this->assertEquals($stmts, $traverser->traverse($stmts));

        // From enterNode with Node parent
        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor->expects($this->at(2))->method('enterNode')->with($varNode1)
            ->willReturn(NodeTraverser::STOP_TRAVERSAL);
        $visitor->expects($this->at(3))->method('afterTraverse');
        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);
        $this->assertEquals($stmts, $traverser->traverse($stmts));

        // From leaveNode with Node parent
        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor->expects($this->at(3))->method('leaveNode')->with($varNode1)
            ->willReturn(NodeTraverser::STOP_TRAVERSAL);
        $visitor->expects($this->at(4))->method('afterTraverse');
        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);
        $this->assertEquals($stmts, $traverser->traverse($stmts));

        // From leaveNode with array parent
        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor->expects($this->at(6))->method('leaveNode')->with($mulNode)
            ->willReturn(NodeTraverser::STOP_TRAVERSAL);
        $visitor->expects($this->at(7))->method('afterTraverse');
        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);
        $this->assertEquals($stmts, $traverser->traverse($stmts));

        // Check that pending array modifications are still carried out
        $visitor = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor->expects($this->at(6))->method('leaveNode')->with($mulNode)
            ->willReturn(NodeTraverser::REMOVE_NODE);
        $visitor->expects($this->at(7))->method('enterNode')->with($printNode)
            ->willReturn(NodeTraverser::STOP_TRAVERSAL);
        $visitor->expects($this->at(8))->method('afterTraverse');
        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor);
        $this->assertEquals([$printNode], $traverser->traverse($stmts));

    }

    public function testRemovingVisitor() {
        $visitor1 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor2 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor3 = $this->getMockBuilder(NodeVisitor::class)->getMock();

        $traverser = new NodeTraverser;
        $traverser->addVisitor($visitor1);
        $traverser->addVisitor($visitor2);
        $traverser->addVisitor($visitor3);

        $getVisitors = (function () {
            return $this->visitors;
        })->bindTo($traverser, NodeTraverser::class);

        $preExpected = [$visitor1, $visitor2, $visitor3];
        $this->assertSame($preExpected, $getVisitors());

        $traverser->removeVisitor($visitor2);

        $postExpected = [0 => $visitor1, 2 => $visitor3];
        $this->assertSame($postExpected, $getVisitors());
    }

    public function testNoCloneNodes() {
        $stmts = [new Node\Stmt\Echo_([new String_('Foo'), new String_('Bar')])];

        $traverser = new NodeTraverser;

        $this->assertSame($stmts, $traverser->traverse($stmts));
    }

    /**
     * @dataProvider provideTestInvalidReturn
     */
    public function testInvalidReturn($visitor, $message) {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage($message);

        $stmts = [new Node\Stmt\Expression(new Node\Scalar\LNumber(42))];

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($stmts);
    }

    public function provideTestInvalidReturn() {
        $visitor1 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor1->expects($this->at(1))->method('enterNode')
            ->willReturn('foobar');

        $visitor2 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor2->expects($this->at(2))->method('enterNode')
            ->willReturn('foobar');

        $visitor3 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor3->expects($this->at(3))->method('leaveNode')
            ->willReturn('foobar');

        $visitor4 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor4->expects($this->at(4))->method('leaveNode')
            ->willReturn('foobar');

        $visitor5 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor5->expects($this->at(3))->method('leaveNode')
            ->willReturn([new Node\Scalar\DNumber(42.0)]);

        $visitor6 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor6->expects($this->at(4))->method('leaveNode')
            ->willReturn(false);

        $visitor7 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor7->expects($this->at(1))->method('enterNode')
            ->willReturn(new Node\Scalar\LNumber(42));

        $visitor8 = $this->getMockBuilder(NodeVisitor::class)->getMock();
        $visitor8->expects($this->at(2))->method('enterNode')
            ->willReturn(new Node\Stmt\Return_());

        return [
            [$visitor1, 'enterNode() returned invalid value of type string'],
            [$visitor2, 'enterNode() returned invalid value of type string'],
            [$visitor3, 'leaveNode() returned invalid value of type string'],
            [$visitor4, 'leaveNode() returned invalid value of type string'],
            [$visitor5, 'leaveNode() may only return an array if the parent structure is an array'],
            [$visitor6, 'bool(false) return from leaveNode() no longer supported. Return NodeTraverser::REMOVE_NODE instead'],
            [$visitor7, 'Trying to replace statement (Stmt_Expression) with expression (Scalar_LNumber). Are you missing a Stmt_Expression wrapper?'],
            [$visitor8, 'Trying to replace expression (Scalar_LNumber) with statement (Stmt_Return)'],
        ];
    }
}
