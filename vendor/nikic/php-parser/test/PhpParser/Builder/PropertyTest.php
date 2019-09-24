<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Comment;
use PhpParser\Node\Expr;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt;

class PropertyTest extends \PHPUnit\Framework\TestCase
{
    public function createPropertyBuilder($name) {
        return new Property($name);
    }

    public function testModifiers() {
        $node = $this->createPropertyBuilder('test')
            ->makePrivate()
            ->makeStatic()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Property(
                Stmt\Class_::MODIFIER_PRIVATE
              | Stmt\Class_::MODIFIER_STATIC,
                [
                    new Stmt\PropertyProperty('test')
                ]
            ),
            $node
        );

        $node = $this->createPropertyBuilder('test')
            ->makeProtected()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Property(
                Stmt\Class_::MODIFIER_PROTECTED,
                [
                    new Stmt\PropertyProperty('test')
                ]
            ),
            $node
        );

        $node = $this->createPropertyBuilder('test')
            ->makePublic()
            ->getNode()
        ;

        $this->assertEquals(
            new Stmt\Property(
                Stmt\Class_::MODIFIER_PUBLIC,
                [
                    new Stmt\PropertyProperty('test')
                ]
            ),
            $node
        );
    }

    public function testDocComment() {
        $node = $this->createPropertyBuilder('test')
            ->setDocComment('/** Test */')
            ->getNode();

        $this->assertEquals(new Stmt\Property(
            Stmt\Class_::MODIFIER_PUBLIC,
            [
                new Stmt\PropertyProperty('test')
            ],
            [
                'comments' => [new Comment\Doc('/** Test */')]
            ]
        ), $node);
    }

    /**
     * @dataProvider provideTestDefaultValues
     */
    public function testDefaultValues($value, $expectedValueNode) {
        $node = $this->createPropertyBuilder('test')
            ->setDefault($value)
            ->getNode()
        ;

        $this->assertEquals($expectedValueNode, $node->props[0]->default);
    }

    public function provideTestDefaultValues() {
        return [
            [
                null,
                new Expr\ConstFetch(new Name('null'))
            ],
            [
                true,
                new Expr\ConstFetch(new Name('true'))
            ],
            [
                false,
                new Expr\ConstFetch(new Name('false'))
            ],
            [
                31415,
                new Scalar\LNumber(31415)
            ],
            [
                3.1415,
                new Scalar\DNumber(3.1415)
            ],
            [
                'Hallo World',
                new Scalar\String_('Hallo World')
            ],
            [
                [1, 2, 3],
                new Expr\Array_([
                    new Expr\ArrayItem(new Scalar\LNumber(1)),
                    new Expr\ArrayItem(new Scalar\LNumber(2)),
                    new Expr\ArrayItem(new Scalar\LNumber(3)),
                ])
            ],
            [
                ['foo' => 'bar', 'bar' => 'foo'],
                new Expr\Array_([
                    new Expr\ArrayItem(
                        new Scalar\String_('bar'),
                        new Scalar\String_('foo')
                    ),
                    new Expr\ArrayItem(
                        new Scalar\String_('foo'),
                        new Scalar\String_('bar')
                    ),
                ])
            ],
            [
                new Scalar\MagicConst\Dir,
                new Scalar\MagicConst\Dir
            ]
        ];
    }
}
