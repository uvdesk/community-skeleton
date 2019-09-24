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

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Factory;
use Composer\Installer\PackageEvent;
use Composer\IO\BufferIO;
use Composer\Package\Link;
use Composer\Package\Locker;
use Composer\Package\Package;
use Composer\Package\RootPackageInterface;
use Composer\Repository\RepositoryManager;
use Composer\Repository\WritableRepositoryInterface;
use Composer\Script\Event;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Flex\Configurator;
use Symfony\Flex\Downloader;
use Symfony\Flex\Flex;
use Symfony\Flex\Lock;
use Symfony\Flex\Options;
use Symfony\Flex\Recipe;
use Symfony\Flex\Response;

class FlexTest extends TestCase
{
    public function testPostInstall()
    {
        $package = new Package('dummy/dummy', '1.0.0', '1.0.0');
        $event = $this->getMockBuilder(PackageEvent::class)->disableOriginalConstructor()->getMock();
        $event->expects($this->any())->method('getOperation')->willReturn(new InstallOperation($package));

        $data = [
            'manifests' => [
                'dummy/dummy' => [
                    'manifest' => [
                        'post-install-output' => ['line 1 %CONFIG_DIR%', 'line 2 %VAR_DIR%'],
                        'bundles' => [
                            'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle' => ['all'],
                        ],
                    ],
                    'origin' => 'dummy/dummy:1.0@github.com/symfony/recipes:master',
                ],
            ],
        ];

        $configurator = $this->getMockBuilder(Configurator::class)->disableOriginalConstructor()->getMock();
        $configurator->expects($this->once())->method('install')->with($this->equalTo(new Recipe($package, 'dummy/dummy', 'install', $data['manifests']['dummy/dummy'])));

        $downloader = $this->getMockBuilder(Downloader::class)->disableOriginalConstructor()->getMock();
        $downloader->expects($this->once())->method('getRecipes')->willReturn($data);
        $downloader->expects($this->once())->method('isEnabled')->willReturn(true);

        $io = new BufferIO('', OutputInterface::VERBOSITY_VERBOSE);
        $locker = $this->getMockBuilder(Locker::class)->disableOriginalConstructor()->getMock();
        $locker->expects($this->any())->method('getLockData')->willReturn(['content-hash' => 'random']);

        $package = $this->getMockBuilder(RootPackageInterface::class)->disableOriginalConstructor()->getMock();
        $package->expects($this->any())->method('getExtra')->willReturn(['symfony' => ['allow-contrib' => true]]);

        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $lock->expects($this->any())->method('has')->willReturn(false);

        $flex = \Closure::bind(function () use ($configurator, $downloader, $io, $locker, $package, $lock) {
            $flex = new Flex();
            $flex->composer = new Composer();
            $flex->composer->setLocker($locker);
            $flex->composer->setPackage($package);
            $flex->io = $io;
            $flex->configurator = $configurator;
            $flex->downloader = $downloader;
            $flex->runningCommand = function () {
            };
            $flex->options = new Options(['config-dir' => 'config', 'var-dir' => 'var']);
            $flex->lock = $lock;

            return $flex;
        }, null, Flex::class)->__invoke();
        $flex->record($event);
        $flex->install($this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock());

        $expected = [
            '',
            '<info>Some files may have been created or updated to configure your new packages.</>',
            'Please <comment>review</>, <comment>edit</> and <comment>commit</> them: these files are <comment>yours</>.',
            '',
            'line 1 config',
            'line 2 var',
            '',
        ];
        $postInstallOutput = \Closure::bind(function () {
            return $this->postInstallOutput;
        }, $flex, Flex::class)->__invoke();
        $this->assertSame($expected, $postInstallOutput);

        $this->assertSame(
            <<<EOF
Symfony operations: 1 recipe ()
  - Configuring dummy/dummy (>=1.0): From github.com/symfony/recipes:master

EOF
            ,
            str_replace("\r\n", "\n", $io->getOutput())
        );
    }

    public function testActivateLoadsClasses()
    {
        $io = new BufferIO('', OutputInterface::VERBOSITY_VERBOSE);
        $composer = new Composer();
        $composer->setConfig(Factory::createConfig($io));
        $package = $this->getMockBuilder(RootPackageInterface::class)->disableOriginalConstructor()->getMock();
        $package->method('getExtra')->willReturn(['symfony' => ['allow-contrib' => true]]);
        $package->method('getRequires')->willReturn([new Link('dummy', 'symfony/flex')]);
        $composer->setPackage($package);
        $localRepo = $this->getMockBuilder(WritableRepositoryInterface::class)->disableOriginalConstructor()->getMock();
        $manager = $this->getMockBuilder(RepositoryManager::class)->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())
            ->method('getLocalRepository')
            ->willReturn($localRepo);
        $composer->setRepositoryManager($manager);

        $flex = new Flex();
        $flex->activate($composer, $io);

        $this->assertTrue(class_exists(Response::class, false));
    }
}
