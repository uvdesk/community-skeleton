<?php declare(strict_types=1);

namespace PhpParser\Node\Stmt;

class PropertyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideModifiers
     */
    public function testModifiers($modifier) {
        $node = new Property(
            constant('PhpParser\Node\Stmt\Class_::MODIFIER_' . strtoupper($modifier)),
            [] // invalid
        );

        $this->assertTrue($node->{'is' . $modifier}());
    }

    public function testNoModifiers() {
        $node = new Property(0, []);

        $this->assertTrue($node->isPublic());
        $this->assertFalse($node->isProtected());
        $this->assertFalse($node->isPrivate());
        $this->assertFalse($node->isStatic());
    }

    public function testStaticImplicitlyPublic() {
        $node = new Property(Class_::MODIFIER_STATIC, []);
        $this->assertTrue($node->isPublic());
        $this->assertFalse($node->isProtected());
        $this->assertFalse($node->isPrivate());
        $this->assertTrue($node->isStatic());
    }

    public function provideModifiers() {
        return [
            ['public'],
            ['protected'],
            ['private'],
            ['static'],
        ];
    }
}
