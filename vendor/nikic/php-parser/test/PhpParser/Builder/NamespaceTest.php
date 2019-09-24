<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt;

class NamespaceTest extends \PHPUnit\Framework\TestCase
{
    protected function createNamespaceBuilder($fqn) {
        return new Namespace_($fqn);
    }

    public function testCreation() {
        $stmt1 = new Stmt\Class_('SomeClass');
        $stmt2 = new Stmt\Interface_('SomeInterface');
        $stmt3 = new Stmt\Function_('someFunction');
        $docComment = new Doc('/** Test */');
        $expected = new Stmt\Namespace_(
            new Node\Name('Name\Space'),
            [$stmt1, $stmt2, $stmt3],
            ['comments' => [$docComment]]
        );

        $node = $this->createNamespaceBuilder('Name\Space')
            ->addStmt($stmt1)
            ->addStmts([$stmt2, $stmt3])
            ->setDocComment($docComment)
            ->getNode()
        ;
        $this->assertEquals($expected, $node);

        $node = $this->createNamespaceBuilder(new Node\Name(['Name', 'Space']))
            ->setDocComment($docComment)
            ->addStmts([$stmt1, $stmt2])
            ->addStmt($stmt3)
            ->getNode()
        ;
        $this->assertEquals($expected, $node);

        $node = $this->createNamespaceBuilder(null)->getNode();
        $this->assertNull($node->name);
        $this->assertEmpty($node->stmts);
    }
}
