<?php declare(strict_types=1);

namespace PhpParser\Node\Stmt;

class ClassConstTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideModifiers
     */
    public function testModifiers($modifier) {
        $node = new ClassConst(
            [], // invalid
            constant('PhpParser\Node\Stmt\Class_::MODIFIER_' . strtoupper($modifier))
        );

        $this->assertTrue($node->{'is' . $modifier}());
    }

    public function testNoModifiers() {
        $node = new ClassConst([], 0);

        $this->assertTrue($node->isPublic());
        $this->assertFalse($node->isProtected());
        $this->assertFalse($node->isPrivate());
    }

    public function provideModifiers() {
        return [
            ['public'],
            ['protected'],
            ['private'],
        ];
    }
}
