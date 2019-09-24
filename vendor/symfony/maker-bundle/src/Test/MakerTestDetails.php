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

use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\MakerInterface;

final class MakerTestDetails
{
    private $maker;

    private $inputs;

    private $fixtureFilesPath;

    private $deletedFiles = [];

    private $replacements = [];

    private $postMakeReplacements = [];

    private $preMakeCommands = [];

    private $postMakeCommands = [];

    private $assert;

    private $extraDependencies = [];

    private $argumentsString = '';

    private $commandAllowedToFail = false;

    private $rootNamespace = 'App';

    private $requiredPhpVersion;

    private $guardAuthenticators = [];

    /**
     * @param MakerInterface $maker
     * @param array          $inputs
     *
     * @return static
     */
    public static function createTest(MakerInterface $maker, array $inputs)
    {
        return new static($maker, $inputs);
    }

    private function __construct(MakerInterface $maker, array $inputs)
    {
        $this->inputs = $inputs;
        $this->maker = $maker;
    }

    public function setFixtureFilesPath(string $fixtureFilesPath): self
    {
        $this->fixtureFilesPath = $fixtureFilesPath;

        return $this;
    }

    public function getRootNamespace()
    {
        return $this->rootNamespace;
    }

    public function changeRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = trim($rootNamespace, '\\');

        return $this;
    }

    public function addPreMakeCommand(string $preMakeCommand): self
    {
        $this->preMakeCommands[] = $preMakeCommand;

        return $this;
    }

    public function addPostMakeCommand(string $postMakeCommand): self
    {
        $this->postMakeCommands[] = $postMakeCommand;

        return $this;
    }

    public function deleteFile(string $filename): self
    {
        $this->deletedFiles[] = $filename;

        return $this;
    }

    public function getFilesToDelete(): array
    {
        return $this->deletedFiles;
    }

    public function addReplacement(string $filename, string $find, string $replace): self
    {
        $this->replacements[] = [
            'filename' => $filename,
            'find' => $find,
            'replace' => $replace,
        ];

        return $this;
    }

    public function addPostMakeReplacement(string $filename, string $find, string $replace): self
    {
        $this->postMakeReplacements[] = [
            'filename' => $filename,
            'find' => $find,
            'replace' => $replace,
        ];

        return $this;
    }

    public function configureDatabase(bool $createSchema = true): self
    {
        // currently, we need to replace this in *both* files so we can also
        // run bin/console commands
        $this
            ->addReplacement(
                '.env',
                'mysql://db_user:db_password@127.0.0.1:3306/db_name',
                getenv('TEST_DATABASE_DSN')
            )
        ;

        // use MySQL 5.6, which is what's currently available on Travis
        $this->addReplacement(
            'config/packages/doctrine.yaml',
            "server_version: '5.7'",
            "server_version: '5.6'"
        );

        // this looks silly, but it's the only way to drop the database *for sure*,
        // as doctrine:database:drop will error if there is no database
        // also, skip for SQLITE, as it does not support --if-not-exists
        if (0 !== strpos(getenv('TEST_DATABASE_DSN'), 'sqlite://')) {
            $this->addPreMakeCommand('php bin/console doctrine:database:create --env=test --if-not-exists');
        }
        $this->addPreMakeCommand('php bin/console doctrine:database:drop --env=test --force');

        $this->addPreMakeCommand('php bin/console doctrine:database:create --env=test');
        if ($createSchema) {
            $this->addPreMakeCommand('php bin/console doctrine:schema:create --env=test');
        }

        return $this;
    }

    public function updateSchemaAfterCommand(): self
    {
        $this->addPostMakeCommand('php bin/console doctrine:schema:update --env=test --force');

        return $this;
    }

    /**
     * Pass a callable that will be called after the maker command has been run.
     *
     *      $test->assert(function(string $output, string $directory) {
     *          // $output is the command output text
     *          // $directory is the directory where the project lives
     *      })
     *
     * @param callable $assert
     *
     * @return MakerTestDetails
     */
    public function assert($assert): self
    {
        $this->assert = $assert;

        return $this;
    }

    public function addExtraDependencies(string $packageName): self
    {
        $this->extraDependencies[] = $packageName;

        return $this;
    }

    public function setArgumentsString(string $argumentsString): self
    {
        $this->argumentsString = $argumentsString;

        return $this;
    }

    public function setCommandAllowedToFail(bool $commandAllowedToFail): self
    {
        $this->commandAllowedToFail = $commandAllowedToFail;

        return $this;
    }

    public function setRequiredPhpVersion(int $version): self
    {
        $this->requiredPhpVersion = $version;

        return $this;
    }

    public function setGuardAuthenticator(string $firewallName, string $id): self
    {
        $this->guardAuthenticators[$firewallName] = $id;

        return $this;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function getFixtureFilesPath()
    {
        return $this->fixtureFilesPath;
    }

    public function getUniqueCacheDirectoryName(): string
    {
        // for cache purposes, only the dependencies are important!
        // You can change it ONLY if you don't have another way to implement it
        return 'maker_'.strtolower($this->getRootNamespace()).'_'.md5(serialize($this->getDependencies()));
    }

    public function getPreMakeCommands(): array
    {
        return $this->preMakeCommands;
    }

    public function getPostMakeCommands(): array
    {
        return $this->postMakeCommands;
    }

    public function getReplacements(): array
    {
        return $this->replacements;
    }

    public function getPostMakeReplacements(): array
    {
        return $this->postMakeReplacements;
    }

    public function getMaker(): MakerInterface
    {
        return $this->maker;
    }

    /**
     * @return callable
     */
    public function getAssert()
    {
        return $this->assert;
    }

    public function getDependencies()
    {
        $depBuilder = $this->getDependencyBuilder();

        return array_merge(
            $depBuilder->getAllRequiredDependencies(),
            $depBuilder->getAllRequiredDevDependencies(),
            $this->extraDependencies
        );
    }

    public function getExtraDependencies()
    {
        return $this->extraDependencies;
    }

    public function getDependencyBuilder(): DependencyBuilder
    {
        $depBuilder = new DependencyBuilder();
        $this->maker->configureDependencies($depBuilder);

        return $depBuilder;
    }

    public function getArgumentsString(): string
    {
        return $this->argumentsString;
    }

    public function isCommandAllowedToFail(): bool
    {
        return $this->commandAllowedToFail;
    }

    public function isSupportedByCurrentPhpVersion(): bool
    {
        return null === $this->requiredPhpVersion || \PHP_VERSION_ID >= $this->requiredPhpVersion;
    }

    public function getGuardAuthenticators(): array
    {
        return $this->guardAuthenticators;
    }
}
