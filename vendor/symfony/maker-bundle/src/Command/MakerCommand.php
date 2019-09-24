<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Command;

use Symfony\Bundle\MakerBundle\ApplicationAwareMakerInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\MakerInterface;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Used as the Command class for the makers.
 *
 * @internal
 */
final class MakerCommand extends Command
{
    private $maker;
    private $fileManager;
    private $inputConfig;
    /** @var ConsoleStyle */
    private $io;
    private $checkDependencies = true;
    private $generator;

    public function __construct(MakerInterface $maker, FileManager $fileManager, Generator $generator)
    {
        $this->maker = $maker;
        $this->fileManager = $fileManager;
        $this->inputConfig = new InputConfiguration();
        $this->generator = $generator;

        parent::__construct();
    }

    protected function configure()
    {
        $this->maker->configureCommand($this, $this->inputConfig);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new ConsoleStyle($input, $output);
        $this->fileManager->setIO($this->io);

        if ($this->checkDependencies) {
            $dependencies = new DependencyBuilder();
            $this->maker->configureDependencies($dependencies, $input);

            if (!$dependencies->isPhpVersionSatisfied()) {
                throw new RuntimeCommandException('The make:entity command requires that you use PHP 7.1 or higher.');
            }

            if ($missingPackagesMessage = $dependencies->getMissingPackagesMessage($this->getName())) {
                throw new RuntimeCommandException($missingPackagesMessage);
            }
        }
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$this->fileManager->isNamespaceConfiguredToAutoload($this->generator->getRootNamespace())) {
            $this->io->note([
                sprintf('It looks like your app may be using a namespace other than "%s".', $this->generator->getRootNamespace()),
                'To configure this and make your life easier, see: https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html#configuration',
            ]);
        }

        foreach ($this->getDefinition()->getArguments() as $argument) {
            if ($input->getArgument($argument->getName())) {
                continue;
            }

            if (\in_array($argument->getName(), $this->inputConfig->getNonInteractiveArguments(), true)) {
                continue;
            }

            $value = $this->io->ask($argument->getDescription(), $argument->getDefault(), [Validator::class, 'notBlank']);
            $input->setArgument($argument->getName(), $value);
        }

        $this->maker->interact($input, $this->io, $this);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->maker->generate($input, $this->io, $this->generator);

        // sanity check for custom makers
        if ($this->generator->hasPendingOperations()) {
            throw new \LogicException('Make sure to call the writeChanges() method on the generator.');
        }
    }

    public function setApplication(Application $application = null)
    {
        parent::setApplication($application);

        if ($this->maker instanceof ApplicationAwareMakerInterface) {
            if (null === $application) {
                throw new \RuntimeException('Application cannot be null.');
            }

            $this->maker->setApplication($application);
        }
    }

    /**
     * @internal Used for testing commands
     */
    public function setCheckDependencies(bool $checkDeps)
    {
        $this->checkDependencies = $checkDeps;
    }
}
