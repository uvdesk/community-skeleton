<?php declare(strict_types=1);

namespace PhpParser\Node\Stmt;

use PhpParser\Node;

class InterfaceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetMethods() {
        $methods = [
            new ClassMethod('foo'),
            new ClassMethod('bar'),
        ];
        $interface = new Class_('Foo', [
            'stmts' => [
                new Node\Stmt\ClassConst([new Node\Const_('C1', new Node\Scalar\String_('C1'))]),
                $methods[0],
                new Node\Stmt\ClassConst([new Node\Const_('C2', new Node\Scalar\String_('C2'))]),
                $methods[1],
                new Node\Stmt\ClassConst([new Node\Const_('C3', new Node\Scalar\String_('C3'))]),
            ]
        ]);

        $this->assertSame($methods, $interface->getMethods());
    }
}
