<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser\Builder;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;

class UseTest extends \PHPUnit\Framework\TestCase
{
    protected function createUseBuilder($name, $type = Stmt\Use_::TYPE_NORMAL) {
        return new Builder\Use_($name, $type);
    }

    public function testCreation() {
        $node = $this->createUseBuilder('Foo\Bar')->getNode();
        $this->assertEquals(new Stmt\Use_([
            new Stmt\UseUse(new Name('Foo\Bar'), null)
        ]), $node);

        $node = $this->createUseBuilder(new Name('Foo\Bar'))->as('XYZ')->getNode();
        $this->assertEquals(new Stmt\Use_([
            new Stmt\UseUse(new Name('Foo\Bar'), 'XYZ')
        ]), $node);

        $node = $this->createUseBuilder('foo\bar', Stmt\Use_::TYPE_FUNCTION)->as('foo')->getNode();
        $this->assertEquals(new Stmt\Use_([
            new Stmt\UseUse(new Name('foo\bar'), 'foo')
        ], Stmt\Use_::TYPE_FUNCTION), $node);

        $node = $this->createUseBuilder('foo\BAR', Stmt\Use_::TYPE_CONSTANT)->as('FOO')->getNode();
        $this->assertEquals(new Stmt\Use_([
            new Stmt\UseUse(new Name('foo\BAR'), 'FOO')
        ], Stmt\Use_::TYPE_CONSTANT), $node);
    }
}
