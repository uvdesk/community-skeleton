<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;

class NameContextTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideTestGetPossibleNames
     */
    public function testGetPossibleNames($type, $name, $expectedPossibleNames) {
        $nameContext = new NameContext(new ErrorHandler\Throwing());
        $nameContext->startNamespace(new Name('NS'));
        $nameContext->addAlias(new Name('Foo'), 'Foo', Use_::TYPE_NORMAL);
        $nameContext->addAlias(new Name('Foo\Bar'), 'Alias', Use_::TYPE_NORMAL);
        $nameContext->addAlias(new Name('Foo\fn'), 'fn', Use_::TYPE_FUNCTION);
        $nameContext->addAlias(new Name('Foo\CN'), 'CN', Use_::TYPE_CONSTANT);

        $possibleNames = $nameContext->getPossibleNames($name, $type);
        $possibleNames = array_map(function (Name $name) {
            return $name->toCodeString();
        }, $possibleNames);

        $this->assertSame($expectedPossibleNames, $possibleNames);

        // Here the last name is always the shortest one
        $expectedShortName = $expectedPossibleNames[count($expectedPossibleNames) - 1];
        $this->assertSame(
            $expectedShortName,
            $nameContext->getShortName($name, $type)->toCodeString()
        );
    }

    public function provideTestGetPossibleNames() {
        return [
            [Use_::TYPE_NORMAL, 'Test', ['\Test']],
            [Use_::TYPE_NORMAL, 'Test\Namespaced', ['\Test\Namespaced']],
            [Use_::TYPE_NORMAL, 'NS\Test', ['\NS\Test', 'Test']],
            [Use_::TYPE_NORMAL, 'ns\Test', ['\ns\Test', 'Test']],
            [Use_::TYPE_NORMAL, 'NS\Foo\Bar', ['\NS\Foo\Bar']],
            [Use_::TYPE_NORMAL, 'ns\foo\Bar', ['\ns\foo\Bar']],
            [Use_::TYPE_NORMAL, 'Foo', ['\Foo', 'Foo']],
            [Use_::TYPE_NORMAL, 'Foo\Bar', ['\Foo\Bar', 'Foo\Bar', 'Alias']],
            [Use_::TYPE_NORMAL, 'Foo\Bar\Baz', ['\Foo\Bar\Baz', 'Foo\Bar\Baz', 'Alias\Baz']],
            [Use_::TYPE_NORMAL, 'Foo\fn\Bar', ['\Foo\fn\Bar', 'Foo\fn\Bar']],
            [Use_::TYPE_FUNCTION, 'Foo\fn\bar', ['\Foo\fn\bar', 'Foo\fn\bar']],
            [Use_::TYPE_FUNCTION, 'Foo\fn', ['\Foo\fn', 'Foo\fn', 'fn']],
            [Use_::TYPE_FUNCTION, 'Foo\FN', ['\Foo\FN', 'Foo\FN', 'fn']],
            [Use_::TYPE_CONSTANT, 'Foo\CN\BAR', ['\Foo\CN\BAR', 'Foo\CN\BAR']],
            [Use_::TYPE_CONSTANT, 'Foo\CN', ['\Foo\CN', 'Foo\CN', 'CN']],
            [Use_::TYPE_CONSTANT, 'foo\CN', ['\foo\CN', 'Foo\CN', 'CN']],
            [Use_::TYPE_CONSTANT, 'foo\cn', ['\foo\cn', 'Foo\cn']],
            // self/parent/static must not be fully qualified
            [Use_::TYPE_NORMAL, 'self', ['self']],
            [Use_::TYPE_NORMAL, 'parent', ['parent']],
            [Use_::TYPE_NORMAL, 'static', ['static']],
            // true/false/null do not need to be fully qualified, even in namespaces
            [Use_::TYPE_CONSTANT, 'true', ['\true', 'true']],
            [Use_::TYPE_CONSTANT, 'false', ['\false', 'false']],
            [Use_::TYPE_CONSTANT, 'null', ['\null', 'null']],
        ];
    }
}
