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
use Composer\IO\IOInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Flex\Configurator\GitignoreConfigurator;
use Symfony\Flex\Lock;
use Symfony\Flex\Options;
use Symfony\Flex\Recipe;

class GitignoreConfiguratorTest extends TestCase
{
    public function testConfigure()
    {
        $configurator = new GitignoreConfigurator(
            $this->getMockBuilder(Composer::class)->getMock(),
            $this->getMockBuilder(IOInterface::class)->getMock(),
            new Options(['public-dir' => 'public', 'root-dir' => FLEX_TEST_DIR])
        );
        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();

        $recipe1 = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $recipe1->expects($this->any())->method('getName')->willReturn('FooBundle');

        $recipe2 = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $recipe2->expects($this->any())->method('getName')->willReturn('BarBundle');

        $gitignore = FLEX_TEST_DIR.'/.gitignore';
        @unlink($gitignore);
        touch($gitignore);

        $vars1 = [
            '.env',
            '/%PUBLIC_DIR%/bundles/',
        ];
        $vars2 = [
            '/var/',
            '/vendor/',
        ];

        $gitignoreContents1 = <<<EOF
###> FooBundle ###
.env
/public/bundles/
###< FooBundle ###
EOF;
        $gitignoreContents2 = <<<EOF
###> BarBundle ###
/var/
/vendor/
###< BarBundle ###
EOF;

        $configurator->configure($recipe1, $vars1, $lock);
        $this->assertStringEqualsFile($gitignore, "\n".$gitignoreContents1."\n");

        $configurator->configure($recipe2, $vars2, $lock);
        $this->assertStringEqualsFile($gitignore, "\n".$gitignoreContents1."\n\n".$gitignoreContents2."\n");

        $configurator->configure($recipe1, $vars1, $lock);
        $configurator->configure($recipe2, $vars2, $lock);
        $this->assertStringEqualsFile($gitignore, "\n".$gitignoreContents1."\n\n".$gitignoreContents2."\n");

        $configurator->unconfigure($recipe1, $vars1, $lock);
        $this->assertStringEqualsFile($gitignore, $gitignoreContents2."\n");

        $configurator->unconfigure($recipe2, $vars2, $lock);
        $this->assertStringEqualsFile($gitignore, '');

        @unlink($gitignore);
    }

    public function testConfigureForce()
    {
        $configurator = new GitignoreConfigurator(
            $this->getMockBuilder(Composer::class)->getMock(),
            $this->getMockBuilder(IOInterface::class)->getMock(),
            new Options(['public-dir' => 'public', 'root-dir' => FLEX_TEST_DIR])
        );

        $recipe = $this->getMockBuilder(Recipe::class)->disableOriginalConstructor()->getMock();
        $recipe->expects($this->any())->method('getName')->willReturn('FooBundle');

        $gitignore = FLEX_TEST_DIR.'/.gitignore';
        @unlink($gitignore);
        touch($gitignore);
        file_put_contents($gitignore, "# preexisting content\n");

        $contentsConfigure = <<<EOF
# preexisting content

###> FooBundle ###
.env
###< FooBundle ###

# new content
EOF;
        $contentsForce = <<<EOF
# preexisting content

###> FooBundle ###
.env
.env.test
###< FooBundle ###

# new content
EOF;

        $lock = $this->getMockBuilder(Lock::class)->disableOriginalConstructor()->getMock();
        $configurator->configure($recipe, [
            '.env',
        ], $lock);
        file_put_contents($gitignore, "\n# new content", \FILE_APPEND);
        $this->assertStringEqualsFile($gitignore, $contentsConfigure);

        $configurator->configure($recipe, [
            '.env',
            '.env.test',
        ], $lock, [
            'force' => true,
        ]);
        $this->assertStringEqualsFile($gitignore, $contentsForce);

        @unlink($gitignore);
    }
}
