<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Tests\Configurator;

use PHPUnit\Framework\TestCase;
use Symfony\Flex\Configurator\BundlesConfigurator;
use Symfony\Flex\Lock;
use Symfony\Flex\Options;
use Symfony\Flex\Recipe;

class BundlesConfiguratorTest extends TestCase
{
    public function testConfigure()
    {
        $config = FLEX_TEST_DIR.'/config/bundles.php';

        $configurator = new BundlesConfigurator(
            $this->getMockBuilder('Composer\Composer')->getMock(),
            $this->getMockBuilder('Composer\IO\IOInterface')->getMock(),
            new Options(['config-dir' => 'config', 'root-dir' => FLEX_TEST_DIR])
        );

        $recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();

        @unlink($config);
        $configurator->configure($recipe, [
            'FooBundle' => ['dev', 'test'],
            'Symfony\Bundle\FrameworkBundle\FrameworkBundle' => ['all'],
        ], $lock);
        $this->assertEquals(<<<EOF
<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    FooBundle::class => ['dev' => true, 'test' => true],
];

EOF
        , file_get_contents($config));
    }

    public function testConfigureWhenBundlesAlreayExists()
    {
        $config = FLEX_TEST_DIR.'/config/bundles.php';
        file_put_contents($config, <<<EOF
<?php

return [
    BarBundle::class => ['prod' => false, 'all' => true],
];
EOF
        );

        $configurator = new BundlesConfigurator(
            $this->getMockBuilder('Composer\Composer')->getMock(),
            $this->getMockBuilder('Composer\IO\IOInterface')->getMock(),
            new Options(['config-dir' => 'config', 'root-dir' => FLEX_TEST_DIR])
        );

        $recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();

        $configurator->configure($recipe, [
            'FooBundle' => ['dev', 'test'],
            'Symfony\Bundle\FrameworkBundle\FrameworkBundle' => ['all'],
        ], $lock);
        $this->assertEquals(<<<EOF
<?php

return [
    BarBundle::class => ['prod' => false, 'all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    FooBundle::class => ['dev' => true, 'test' => true],
];

EOF
        , file_get_contents($config));
    }
}
