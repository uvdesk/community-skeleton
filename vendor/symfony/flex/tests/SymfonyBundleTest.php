<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Tests;

use Composer\Package\Package;
use PHPUnit\Framework\TestCase;
use Symfony\Flex\SymfonyBundle;

class SymfonyBundleTest extends TestCase
{
    /**
     * @dataProvider getNamespaces
     */
    public function testGetClassNamesForInstall($package, $autoload, $classes, $type = null)
    {
        $config = $this->getMockBuilder('Composer\Config')->getMock();
        $config->expects($this->any())->method('get')->willReturn(__DIR__.'/Fixtures/vendor');
        $composer = $this->getMockBuilder('Composer\Composer')->getMock();
        $composer->expects($this->once())->method('getConfig')->willReturn($config);
        $package = new Package($package, '1.0', '1.0');
        $package->setAutoload($autoload);
        if ($type) {
            $package->setType($type);
        }

        $bundle = new SymfonyBundle($composer, $package, 'install');
        $this->assertSame($classes, $bundle->getClassNames());
    }

    public function getNamespaces()
    {
        return [
            [
                'symfony/debug-bundle',
                ['psr-4' => ['Symfony\\Bundle\\DebugBundle\\' => '']],
                ['Symfony\\Bundle\\DebugBundle\\DebugBundle'],
            ],
            [
                'symfony/dummy',
                ['psr-4' => ['Symfony\\Bundle\\FirstDummyBundle\\' => 'FirstDummyBundle/', 'Symfony\\Bundle\\SecondDummyBundle\\' => 'SecondDummyBundle/']],
                ['Symfony\\Bundle\\FirstDummyBundle\\FirstDummyBundle', 'Symfony\\Bundle\\SecondDummyBundle\\SecondDummyBundle'],
            ],
            [
                'doctrine/doctrine-cache-bundle',
                ['psr-4' => ['Doctrine\\Bundle\\DoctrineCacheBundle\\' => '']],
                ['Doctrine\\Bundle\\DoctrineCacheBundle\\DoctrineCacheBundle'],
            ],
            [
                'eightpoints/guzzle-bundle',
                ['psr-0' => ['EightPoints\\Bundle\\GuzzleBundle' => '']],
                ['EightPoints\\Bundle\\GuzzleBundle\\GuzzleBundle'],
            ],
            [
                'easycorp/easy-security-bundle',
                ['psr-4' => ['EasyCorp\\Bundle\\EasySecurityBundle\\' => '']],
                ['EasyCorp\\Bundle\\EasySecurityBundle\\EasySecurityBundle'],
            ],
            [
                'symfony-cmf/routing-bundle',
                ['psr-4' => ['Symfony\\Cmf\\Bundle\\RoutingBundle\\' => '']],
                ['Symfony\\Cmf\\Bundle\\RoutingBundle\\CmfRoutingBundle'],
            ],
            [
                'easycorp/easy-deploy-bundle',
                ['psr-4' => ['EasyCorp\\Bundle\\EasyDeployBundle\\' => 'src/']],
                ['EasyCorp\\Bundle\\EasyDeployBundle\\EasyDeployBundle'],
            ],
            [
                'easycorp/easy-deploy-bundle',
                ['psr-4' => ['EasyCorp\\Bundle\\EasyDeployBundle\\' => ['src', 'tests']]],
                ['EasyCorp\\Bundle\\EasyDeployBundle\\EasyDeployBundle'],
            ],
            [
                'web-token/jwt-bundle',
                ['psr-4' => ['Jose\\Bundle\\JoseFramework\\' => ['']]],
                ['Jose\\Bundle\\JoseFramework\\JoseFrameworkBundle'],
            ],
            [
                'sylius/shop-api-plugin',
                ['psr-4' => ['Sylius\\ShopApiPlugin\\' => 'src/']],
                ['Sylius\\ShopApiPlugin\\ShopApiPlugin'],
                'sylius-plugin',
            ],
            [
                'dunglas/sylius-acme-plugin',
                ['psr-4' => ['Dunglas\\SyliusAcmePlugin\\' => 'src/']],
                ['Dunglas\\SyliusAcmePlugin\\DunglasSyliusAcmePlugin'],
                'sylius-plugin',
            ],
        ];
    }
}
