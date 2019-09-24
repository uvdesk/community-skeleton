<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Test;

use PHPUnit\Framework\TestCase;

class MakerTestCase extends TestCase
{
    protected function executeMakerCommand(MakerTestDetails $testDetails)
    {
        if (!$testDetails->isSupportedByCurrentPhpVersion()) {
            $this->markTestSkipped();
        }

        $testEnv = MakerTestEnvironment::create($testDetails);

        // prepare environment to test
        $testEnv->prepare();

        // run tests
        $makerTestProcess = $testEnv->runMaker();
        $files = $testEnv->getGeneratedFilesFromOutputText();

        foreach ($files as $file) {
            $this->assertTrue($testEnv->fileExists($file));

            if ('.php' === substr($file, -4)) {
                $csProcess = $testEnv->runPhpCSFixer($file);

                $this->assertTrue($csProcess->isSuccessful(), sprintf(
                    "File '%s' has a php-cs problem: %s\n\n%s",
                    $file,
                    $csProcess->getErrorOutput(),
                    file_get_contents($testEnv->getPath().'/'.$file)
                ));
            }

            if ('.twig' === substr($file, -5)) {
                $csProcess = $testEnv->runTwigCSLint($file);

                $this->assertTrue($csProcess->isSuccessful(), sprintf('File "%s" has a twig-cs problem: %s', $file, $csProcess->getOutput()));
            }
        }

        // run internal tests
        $internalTestProcess = $testEnv->runInternalTests();
        if (null !== $internalTestProcess) {
            $this->assertTrue($internalTestProcess->isSuccessful(), sprintf("Error while running the PHPUnit tests *in* the project: \n\n %s \n\n Command Output: %s", $internalTestProcess->getOutput(), $makerTestProcess->getOutput()));
        }

        // checkout user asserts
        if (null === $testDetails->getAssert()) {
            $this->assertContains('Success', $makerTestProcess->getOutput(), $makerTestProcess->getErrorOutput());
        } else {
            ($testDetails->getAssert())($makerTestProcess->getOutput(), $testEnv->getPath());
        }
    }

    protected function assertContainsCount(string $needle, string $haystack, int $count)
    {
        $this->assertEquals(1, substr_count($haystack, $needle), sprintf('Found more than %d occurrences of "%s" in "%s"', $count, $needle, $haystack));
    }
}
