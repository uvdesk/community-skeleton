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

use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\InputStream;

/**
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 * @author Nicolas Philippe <nikophil@gmail.com>
 *
 * @internal
 */
final class MakerTestEnvironment
{
    private $testDetails;
    private $fs;
    private $rootPath;
    private $cachePath;
    private $flexPath;
    private $path;
    private $targetFlexVersion;

    /**
     * @var MakerTestProcess
     */
    private $runnedMakerProcess;

    private function __construct(MakerTestDetails $testDetails)
    {
        $this->testDetails = $testDetails;
        $this->fs = new Filesystem();

        $this->rootPath = realpath(__DIR__.'/../../');

        $cachePath = $this->rootPath.'/tests/tmp/cache';

        if (!$this->fs->exists($cachePath)) {
            $this->fs->mkdir($cachePath);
        }

        $this->cachePath = realpath($cachePath);
        $targetVersion = $this->getTargetFlexVersion();
        $this->flexPath = $this->cachePath.'/flex_project'.$targetVersion;

        $this->path = $this->cachePath.\DIRECTORY_SEPARATOR.$testDetails->getUniqueCacheDirectoryName().$targetVersion;
    }

    public static function create(MakerTestDetails $testDetails): self
    {
        return new self($testDetails);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    private function changeRootNamespaceIfNeeded()
    {
        if ('App' === ($rootNamespace = $this->testDetails->getRootNamespace())) {
            return;
        }

        $replacements = [
            [
                'filename' => 'composer.json',
                'find' => '"App\\\\": "src/"',
                'replace' => '"'.$rootNamespace.'\\\\": "src/"',
            ],
            [
                'filename' => 'src/Kernel.php',
                'find' => 'namespace App',
                'replace' => 'namespace '.$rootNamespace,
            ],
            [
                'filename' => 'bin/console',
                'find' => 'use App\\Kernel',
                'replace' => 'use '.$rootNamespace.'\\Kernel',
            ],
            [
                'filename' => 'public/index.php',
                'find' => 'use App\\Kernel',
                'replace' => 'use '.$rootNamespace.'\\Kernel',
            ],
            [
                'filename' => 'config/services.yaml',
                'find' => 'App\\',
                'replace' => $rootNamespace.'\\',
            ],
            [
                'filename' => '.env.test',
                'find' => 'KERNEL_CLASS=\'App\Kernel\'',
                'replace' => 'KERNEL_CLASS=\''.$rootNamespace.'\Kernel\'',
            ],
        ];

        if ($this->fs->exists($this->path.'/config/packages/doctrine.yaml')) {
            $replacements[] = [
                    'filename' => 'config/packages/doctrine.yaml',
                    'find' => 'App',
                    'replace' => $rootNamespace,
                ];
        }

        $this->processReplacements($replacements, $this->path);
    }

    public function prepare()
    {
        if (!$this->fs->exists($this->flexPath)) {
            $this->buildFlexSkeleton();
        }

        if (!$this->fs->exists($this->path)) {
            try {
                // lets do some magic here git is faster than copy
                MakerTestProcess::create(
                    '\\' === \DIRECTORY_SEPARATOR ? 'git clone %FLEX_PATH% %APP_PATH%' : 'git clone "$FLEX_PATH" "$APP_PATH"',
                    \dirname($this->flexPath),
                    [
                        'FLEX_PATH' => $this->flexPath,
                        'APP_PATH' => $this->path,
                    ]
                )
                    ->run();

                // install any missing dependencies
                $dependencies = $this->determineMissingDependencies();
                if ($dependencies) {
                    MakerTestProcess::create(sprintf('composer require %s', implode(' ', $dependencies)), $this->path)
                        ->run();
                }

                $this->changeRootNamespaceIfNeeded();

                file_put_contents($this->path.'/.gitignore', "var/cache/\nvendor/\n");

                MakerTestProcess::create('git diff --quiet || ( git config user.name "symfony" && git config user.email "test@symfony.com" && git add . && git commit -a -m "second commit" )',
                    $this->path
                )->run();
            } catch (ProcessFailedException $e) {
                $this->fs->remove($this->path);

                throw $e;
            }
        } else {
            MakerTestProcess::create('git reset --hard && git clean -fd', $this->path)->run();
        }

        if (null !== $this->testDetails->getFixtureFilesPath()) {
            // move fixture files into directory
            $finder = new Finder();
            $finder->in($this->testDetails->getFixtureFilesPath())->files();

            foreach ($finder as $file) {
                if ($file->getPath() === $this->testDetails->getFixtureFilesPath()) {
                    continue;
                }

                $this->fs->copy($file->getPathname(), $this->path.'/'.$file->getRelativePathname(), true);
            }
        }

        $this->processReplacements($this->testDetails->getReplacements(), $this->path);

        if ($ignoredFiles = $this->testDetails->getFilesToDelete()) {
            foreach ($ignoredFiles as $file) {
                if (file_exists($this->path.'/'.$file)) {
                    $this->fs->remove($this->path.'/'.$file);
                }
            }
        }

        MakerTestProcess::create('composer dump-autoload', $this->path)
            ->run();
    }

    private function preMake()
    {
        foreach ($this->testDetails->getPreMakeCommands() as $preCommand) {
            MakerTestProcess::create($preCommand, $this->path)
                            ->run();
        }
    }

    public function runMaker()
    {
        $this->preMake();

        // Lets remove cache
        $this->fs->remove($this->path.'/var/cache');

        // We don't need ansi coloring in tests!
        $testProcess = MakerTestProcess::create(
            sprintf('php bin/console %s %s --no-ansi', $this->testDetails->getMaker()::getCommandName(), $this->testDetails->getArgumentsString()),
            $this->path,
            [
                'SHELL_INTERACTIVE' => '1',
            ],
            10
        );

        if ($userInputs = $this->testDetails->getInputs()) {
            $inputStream = new InputStream();

            // start the command with some input
            $inputStream->write(current($userInputs)."\n");

            $inputStream->onEmpty(function () use ($inputStream, &$userInputs) {
                $nextInput = next($userInputs);
                if (false === $nextInput) {
                    $inputStream->close();
                } else {
                    $inputStream->write($nextInput."\n");
                }
            });

            $testProcess->setInput($inputStream);
        }

        $this->runnedMakerProcess = $testProcess->run($this->testDetails->isCommandAllowedToFail());

        $this->postMake();

        return $this->runnedMakerProcess;
    }

    public function getGeneratedFilesFromOutputText()
    {
        $output = $this->runnedMakerProcess->getOutput();

        $matches = [];

        preg_match_all('#(created|updated): (.*)\n#iu', $output, $matches, PREG_PATTERN_ORDER);

        return array_map('trim', $matches[2]);
    }

    public function fileExists(string $file)
    {
        return $this->fs->exists($this->path.'/'.$file);
    }

    public function runPhpCSFixer(string $file)
    {
        return MakerTestProcess::create(sprintf('php vendor/bin/php-cs-fixer --config=%s fix --dry-run --diff %s', __DIR__.'/../Resources/test/.php_cs.test', $this->path.'/'.$file), $this->rootPath)
                               ->run(true);
    }

    public function runTwigCSLint(string $file)
    {
        return MakerTestProcess::create(sprintf('php vendor/bin/twigcs lint %s', $this->path.'/'.$file), $this->rootPath)
                               ->run(true);
    }

    public function runInternalTests()
    {
        $finder = new Finder();
        $finder->in($this->path.'/tests')->files();
        if ($finder->count() > 0) {
            // execute the tests that were moved into the project!
            return MakerTestProcess::create(sprintf('php %s', $this->rootPath.'/vendor/bin/simple-phpunit'), $this->path)
                                   ->run(true);
        }

        return null;
    }

    private function postMake()
    {
        $this->processReplacements($this->testDetails->getPostMakeReplacements(), $this->path);

        $guardAuthenticators = $this->testDetails->getGuardAuthenticators();
        if (!empty($guardAuthenticators)) {
            $yaml = file_get_contents($this->path.'/config/packages/security.yaml');
            $manipulator = new YamlSourceManipulator($yaml);
            $data = $manipulator->getData();
            foreach ($guardAuthenticators as $firewallName => $id) {
                if (!isset($data['security']['firewalls'][$firewallName])) {
                    throw new \Exception(sprintf('Could not find firewall "%s"', $firewallName));
                }

                $data['security']['firewalls'][$firewallName]['guard'] = [
                    'authenticators' => [$id],
                ];
            }
            $manipulator->setData($data);
            file_put_contents($this->path.'/config/packages/security.yaml', $manipulator->getContents());
        }

        foreach ($this->testDetails->getPostMakeCommands() as $postCommand) {
            MakerTestProcess::create($postCommand, $this->path)
                            ->run();
        }
    }

    private function buildFlexSkeleton()
    {
        $targetVersion = $this->getTargetFlexVersion();
        $versionString = $targetVersion ? sprintf(':%s', $targetVersion) : '';

        MakerTestProcess::create(
            sprintf('composer create-project symfony/skeleton%s flex_project%s --prefer-dist --no-progress', $versionString, $targetVersion),
            $this->cachePath
        )->run();

        $rootPath = str_replace('\\', '\\\\', realpath(__DIR__.'/../..'));

        // allow dev dependencies
        if (false !== strpos($targetVersion, 'dev')) {
            MakerTestProcess::create('composer config minimum-stability dev', $this->flexPath)
                ->run();
        }

        // processes any changes needed to the Flex project
        $replacements = [
            [
                'filename' => 'config/bundles.php',
                'find' => "Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],",
                'replace' => "Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],\n    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],",
            ],
            [
                // ugly way to autoload Maker & any other vendor libs needed in the command
                'filename' => 'composer.json',
                'find' => '"App\\\Tests\\\": "tests/"',
                'replace' => sprintf(
                    '"App\\\Tests\\\": "tests/",'."\n".'            "Symfony\\\Bundle\\\MakerBundle\\\": "%s/src/",'."\n".'            "PhpParser\\\": "%s/vendor/nikic/php-parser/lib/PhpParser/"',
                    // escape \ for Windows
                    $rootPath,
                    $rootPath
                ),
            ],
        ];
        $this->processReplacements($replacements, $this->flexPath);

        // fetch a few packages needed for testing
        MakerTestProcess::create('composer require phpunit browser-kit symfony/css-selector --prefer-dist --no-progress --no-suggest', $this->flexPath)
                        ->run();

        // temporarily ignoring indirect deprecations - see #237
        $replacements = [
            [
                'filename' => '.env.test',
                'find' => 'SYMFONY_DEPRECATIONS_HELPER=999999',
                'replace' => 'SYMFONY_DEPRECATIONS_HELPER=weak_vendors',
            ],
        ];
        $this->processReplacements($replacements, $this->flexPath);
        // end of temp code

        file_put_contents($this->flexPath.'/.gitignore', "var/cache/\n");

        MakerTestProcess::create('git init && git config user.name "symfony" && git config user.email "test@symfony.com" && git add . && git commit -a -m "first commit"',
            $this->flexPath
        )->run();
    }

    private function processReplacements(array $replacements, $rootDir)
    {
        foreach ($replacements as $replacement) {
            $path = realpath($rootDir.'/'.$replacement['filename']);

            if (!$this->fs->exists($path)) {
                throw new \Exception(sprintf('Could not find file "%s" to process replacements inside "%s"', $replacement['filename'], $rootDir));
            }

            $contents = file_get_contents($path);
            if (false === strpos($contents, $replacement['find'])) {
                throw new \Exception(sprintf('Could not find "%s" inside "%s"', $replacement['find'], $replacement['filename']));
            }

            file_put_contents($path, str_replace($replacement['find'], $replacement['replace'], $contents));
        }
    }

    /**
     * Executes the DependencyBuilder for the Maker command inside the
     * actual project, so we know exactly what dependencies we need or
     * don't need.
     */
    private function determineMissingDependencies(): array
    {
        $depBuilder = $this->testDetails->getDependencyBuilder();
        file_put_contents($this->path.'/dep_builder', serialize($depBuilder));
        file_put_contents($this->path.'/dep_runner.php', '<?php

require __DIR__."/vendor/autoload.php";
$depBuilder = unserialize(file_get_contents("dep_builder"));
$missingDependencies = array_merge(
    $depBuilder->getMissingDependencies(),
    $depBuilder->getMissingDevDependencies()
);
echo json_encode($missingDependencies);
        ');

        $process = MakerTestProcess::create('php dep_runner.php', $this->path)->run();
        $data = json_decode($process->getOutput(), true);
        if (null === $data) {
            throw new \Exception('Could not determine dependencies');
        }

        unlink($this->path.'/dep_builder');
        unlink($this->path.'/dep_runner.php');

        return array_merge($data, $this->testDetails->getExtraDependencies());
    }

    private function getTargetFlexVersion(): string
    {
        if (null === $this->targetFlexVersion) {
            $targetVersion = $_SERVER['MAKER_TEST_VERSION'] ?? 'stable';

            if ('stable' === $targetVersion) {
                $this->targetFlexVersion = '';

                return $this->targetFlexVersion;
            }

            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', 'https://symfony.com/versions.json');
            $data = $response->toArray();

            switch ($targetVersion) {
                case 'stable-dev':
                    $version = $data['latest'];
                    $parts = explode('.', $version);

                    $this->targetFlexVersion = sprintf('%s.%s.x-dev', $parts[0], $parts[1]);

                    break;
                case 'dev':
                    $version = $data['dev'];
                    $parts = explode('.', $version);

                    $this->targetFlexVersion = sprintf('%s.%s.x-dev', $parts[0], $parts[1]);

                    break;
                default:
                    throw new \Exception('Invalid target version');
            }
        }

        return $this->targetFlexVersion;
    }
}
