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

use Composer\Composer;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Flex\Configurator\CopyFromPackageConfigurator;
use Symfony\Flex\Lock;
use Symfony\Flex\Options;
use Symfony\Flex\Recipe;

class CopyFromPackageConfiguratorTest extends TestCase
{
    private $sourceFile;
    private $sourceDirectory;
    private $sourceFileRelativePath;
    private $targetFile;
    private $targetFileRelativePath;
    private $targetDirectory;
    private $io;
    private $recipe;

    public function testNoFilesCopied()
    {
        if (!file_exists($this->targetDirectory)) {
            mkdir($this->targetDirectory);
        }
        file_put_contents($this->targetFile, '');
        $this->io->expects($this->exactly(1))->method('writeError')->with(['    Setting configuration and copying files']);
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $this->createConfigurator()->configure($this->recipe, [$this->sourceFileRelativePath => $this->targetFileRelativePath], $lock);
    }

    public function testConfigureAndOverwriteFiles()
    {
        if (!file_exists($this->targetDirectory)) {
            mkdir($this->targetDirectory);
        }
        if (!file_exists($this->sourceDirectory)) {
            mkdir($this->sourceDirectory);
        }
        file_put_contents($this->sourceFile, 'somecontent');
        file_put_contents($this->targetFile, '-');
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();

        $this->io->expects($this->at(0))->method('writeError')->with(['    Setting configuration and copying files']);
        $this->io->expects($this->at(2))->method('writeError')->with(['    Created <fg=green>"./public/file"</>']);
        $this->io->method('askConfirmation')->with('File "build/public/file" has uncommitted changes, overwrite? [y/N] ')->willReturn(true);

        $this->assertFileExists($this->targetFile);
        $this->createConfigurator()->configure(
            $this->recipe,
            [$this->sourceFileRelativePath => $this->targetFileRelativePath],
            $lock,
            ['force' => true]
        );
        $this->assertFileExists($this->targetFile);
        $this->assertFileEquals($this->sourceFile, $this->targetFile);
    }

    public function testSourceFileNotExist()
    {
        $this->io->expects($this->at(0))->method('writeError')->with(['    Setting configuration and copying files']);
        $this->io->expects($this->at(1))->method('writeError')->with(['    Created <fg=green>"./public/"</>']);
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(sprintf('File "%s" does not exist!', $this->sourceFile));
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $this->createConfigurator()->configure($this->recipe, [$this->sourceFileRelativePath => $this->targetFileRelativePath], $lock);
    }

    public function testConfigure()
    {
        if (!is_dir($this->sourceDirectory)) {
            mkdir($this->sourceDirectory);
        }
        if (!file_exists($this->sourceFile)) {
            file_put_contents($this->sourceFile, '');
        }

        $this->io->expects($this->at(0))->method('writeError')->with(['    Setting configuration and copying files']);
        $this->io->expects($this->at(1))->method('writeError')->with(['    Created <fg=green>"./public/"</>']);
        $this->io->expects($this->at(2))->method('writeError')->with(['    Created <fg=green>"./public/file"</>']);

        $this->assertFileNotExists($this->targetFile);
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $this->createConfigurator()->configure($this->recipe, [$this->sourceFileRelativePath => $this->targetFileRelativePath], $lock);
        $this->assertFileExists($this->targetFile);
    }

    public function testUnconfigure()
    {
        $this->io->expects($this->at(0))->method('writeError')->with(['    Removing configuration and files']);
        $this->io->expects($this->at(1))->method('writeError')->with(['    Removed <fg=green>"./public/file"</>']);

        if (!file_exists($this->targetDirectory)) {
            mkdir($this->targetDirectory);
        }
        file_put_contents($this->targetFile, '');
        $this->assertFileExists($this->targetFile);
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $this->createConfigurator()->unconfigure($this->recipe, [$this->sourceFileRelativePath => $this->targetFileRelativePath], $lock);
        $this->assertFileNotExists($this->targetFile);
    }

    public function testNoFilesRemoved()
    {
        $this->assertFileNotExists($this->targetFile);
        $this->io->expects($this->exactly(1))->method('writeError')->with(['    Removing configuration and files']);
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $this->createConfigurator()->unconfigure($this->recipe, [$this->sourceFileRelativePath => $this->targetFileRelativePath], $lock);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->sourceDirectory = FLEX_TEST_DIR.'/package';
        $this->sourceFileRelativePath = 'package/file';
        $this->sourceFile = $this->sourceDirectory.'/file';

        $this->targetDirectory = FLEX_TEST_DIR.'/public';
        $this->targetFileRelativePath = 'public/file';
        $this->targetFile = $this->targetDirectory.'/file';

        $this->io = $this->getMockBuilder(IOInterface::class)->getMock();

        $package = $this->getMockBuilder(PackageInterface::class)->getMock();
        $this->recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $this->recipe->expects($this->exactly(1))->method('getPackage')->willReturn($package);

        $installationManager = $this->getMockBuilder(InstallationManager::class)->getMock();
        $installationManager->expects($this->exactly(1))
            ->method('getInstallPath')
            ->with($package)
            ->willReturn(FLEX_TEST_DIR)
        ;
        $this->composer = $this->getMockBuilder(Composer::class)->getMock();
        $this->composer->expects($this->exactly(1))
            ->method('getInstallationManager')
            ->willReturn($installationManager)
        ;

        $this->cleanUpTargetFiles();
    }

    protected function tearDown()
    {
        parent::tearDown();

        @unlink($this->sourceFile);
        $this->cleanUpTargetFiles();
    }

    private function createConfigurator(): CopyFromPackageConfigurator
    {
        return new CopyFromPackageConfigurator($this->composer, $this->io, new Options(['root-dir' => FLEX_TEST_DIR], $this->io));
    }

    private function cleanUpTargetFiles()
    {
        @unlink($this->targetFile);
        @rmdir(FLEX_TEST_DIR.'/package');
        @rmdir(FLEX_TEST_DIR.'/public');
    }
}
