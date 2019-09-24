<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;

class ClassTest extends \PHPUnit\Framework\TestCase
{
    protected function createClassBuilder($class) {
        return new Class_($class);
    }

    public function testExtendsImplements() {
        $node = $this->createClassBuilder('SomeLogger')
            ->extend('BaseLogger')
            ->implement('Namespaced\Logger', new Name('SomeInterface'))
            ->implement('\Fully\Qualified', 'namespace\NamespaceRelative')
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Class_('SomeLogger', [
                'extends' => new Name('BaseLogger'),
                'implements' => [
                    new Name('Namespaced\Logger'),
                    new Name('SomeInterface'),
                    new Name\FullyQualified('Fully\Qualified'),
                    new Name\Relative('NamespaceRelative'),
                ],
            ]),
            $node
        );
    }

    public function testAbstract() {
        $node = $this->createClassBuilder('Test')
            ->makeAbstract()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Class_('Test', [
                'flags' => Stmt\Class_::MODIFIER_ABSTRACT
            ]),
            $node
        );
    }

    public function testFinal() {
        $node = $this->createClassBuilder('Test')
            ->makeFinal()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Class_('Test', [
                'flags' => Stmt\Class_::MODIFIER_FINAL
            ]),
            $node
        );
    }

    public function testStatementOrder() {
        $method = new Stmt\ClassMethod('testMethod');
        $property = new Stmt\Property(
            Stmt\Class_::MODIFIER_PUBLIC,
            [new Stmt\PropertyProperty('testProperty')]
        );
        $const = new Stmt\ClassConst([
            new Node\Const_('TEST_CONST', new Node\Scalar\String_('ABC'))
        ]);
        $use = new Stmt\TraitUse([new Name('SomeTrait')]);

        $node = $this->createClassBuilder('Test')
            ->addStmt($method)
            ->addStmt($property)
            ->addStmts([$const, $use])
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Class_('Test', [
                'stmts' => [$use, $const, $property, $method]
            ]),
            $node
        );
    }

    public function testDocComment() {
        $docComment = <<<'DOC'
/**
 * Test
 */
DOC;
        $class = $this->createClassBuilder('Test')
            ->setDocComment($docComment)
            ->getNode();

        $this->assertEquals(
            new Stmt\Class_('Test', [], [
                'comments' => [
                    new Comment\Doc($docComment)
                ]
            ]),
            $class
        );

        $class = $this->createClassBuilder('Test')
            ->setDocComment(new Comment\Doc($docComment))
            ->getNode();

        $this->assertEquals(
            new Stmt\Class_('Test', [], [
                'comments' => [
                    new Comment\Doc($docComment)
                ]
            ]),
            $class
        );
    }

    public function testInvalidStmtError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unexpected node of type "Stmt_Echo"');
        $this->createClassBuilder('Test')
            ->addStmt(new Stmt\Echo_([]))
        ;
    }

    public function testInvalidDocComment() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Doc comment must be a string or an instance of PhpParser\Comment\Doc');
        $this->createClassBuilder('Test')
            ->setDocComment(new Comment('Test'));
    }

    public function testEmptyName() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        $this->createClassBuilder('Test')
            ->extend('');
    }

    public function testInvalidName() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Name must be a string or an instance of Node\Name');
        $this->createClassBuilder('Test')
            ->extend(['Foo']);
    }
}
