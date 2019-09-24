<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;

class ParamTest extends \PHPUnit\Framework\TestCase
{
    public function createParamBuilder($name) {
        return new Param($name);
    }

    /**
     * @dataProvider provideTestDefaultValues
     */
    public function testDefaultValues($value, $expectedValueNode) {
        $node = $this->createParamBuilder('test')
            ->setDefault($value)
            ->getNode()
        ;

        $this->assertEquals($expectedValueNode, $node->default);
    }

    public function provideTestDefaultValues() {
        return [
            [
                null,
                new Expr\ConstFetch(new Node\Name('null'))
            ],
            [
                true,
                new Expr\ConstFetch(new Node\Name('true'))
            ],
            [
                false,
                new Expr\ConstFetch(new Node\Name('false'))
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

    /**
     * @dataProvider provideTestTypes
     */
    public function testTypes($typeHint, $expectedType) {
        $node = $this->createParamBuilder('test')
            ->setTypeHint($typeHint)
            ->getNode()
        ;
        $type = $node->type;

        /* Manually implement comparison to avoid __toString stupidity */
        if ($expectedType instanceof Node\NullableType) {
            $this->assertInstanceOf(get_class($expectedType), $type);
            $expectedType = $expectedType->type;
            $type = $type->type;
        }

        $this->assertInstanceOf(get_class($expectedType), $type);
        $this->assertEquals($expectedType, $type);
    }

    public function provideTestTypes() {
        return [
            ['array', new Node\Identifier('array')],
            ['callable', new Node\Identifier('callable')],
            ['bool', new Node\Identifier('bool')],
            ['int', new Node\Identifier('int')],
            ['float', new Node\Identifier('float')],
            ['string', new Node\Identifier('string')],
            ['iterable', new Node\Identifier('iterable')],
            ['object', new Node\Identifier('object')],
            ['Array', new Node\Identifier('array')],
            ['CALLABLE', new Node\Identifier('callable')],
            ['Some\Class', new Node\Name('Some\Class')],
            ['\Foo', new Node\Name\FullyQualified('Foo')],
            ['self', new Node\Name('self')],
            ['?array', new Node\NullableType(new Node\Identifier('array'))],
            ['?Some\Class', new Node\NullableType(new Node\Name('Some\Class'))],
            [new Node\Name('Some\Class'), new Node\Name('Some\Class')],
            [
                new Node\NullableType(new Node\Identifier('int')),
                new Node\NullableType(new Node\Identifier('int'))
            ],
            [
                new Node\NullableType(new Node\Name('Some\Class')),
                new Node\NullableType(new Node\Name('Some\Class'))
            ],
        ];
    }

    public function testVoidTypeError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Parameter type cannot be void');
        $this->createParamBuilder('test')->setType('void');
    }

    public function testInvalidTypeError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Type must be a string, or an instance of Name, Identifier or NullableType');
        $this->createParamBuilder('test')->setType(new \stdClass);
    }

    public function testByRef() {
        $node = $this->createParamBuilder('test')
            ->makeByRef()
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param(new Expr\Variable('test'), null, null, true),
            $node
        );
    }

    public function testVariadic() {
        $node = $this->createParamBuilder('test')
            ->makeVariadic()
            ->getNode()
        ;

        $this->assertEquals(
            new Node\Param(new Expr\Variable('test'), null, null, false, true),
            $node
        );
    }
}
