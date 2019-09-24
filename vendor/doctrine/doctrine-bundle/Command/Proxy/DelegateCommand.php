<?php

namespace Doctrine\Bundle\DoctrineBundle\Command\Proxy;

use Doctrine\ORM\Version;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command Delegate.
 */
abstract class DelegateCommand extends Command
{
    /** @var Command */
    protected $command;

    /**
     * @return Command
     */
    abstract protected function createCommand();

    /**
     * @return string
     */
    protected function getMinimalVersion()
    {
        return '2.3.0-DEV';
    }

    /**
     * @return bool
     */
    private function isVersionCompatible()
    {
        return version_compare(Version::VERSION, $this->getMinimalVersion()) >= 0;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled()
    {
        return $this->isVersionCompatible();
    }

    /**
     * @param string $entityManagerName
     *
     * @return Command
     */
    protected function wrapCommand($entityManagerName)
    {
        if (! $this->isVersionCompatible()) {
            throw new RuntimeException(sprintf('"%s" requires doctrine-orm "%s" or newer', $this->getName(), $this->getMinimalVersion()));
        }

        DoctrineCommandHelper::setApplicationEntityManager($this->getApplication(), $entityManagerName);
        $this->command->setApplication($this->getApplication());

        return $this->command;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        if ($this->isVersionCompatible()) {
            $this->command = $this->createCommand();

            $this->setHelp($this->command->getHelp());
            $this->setDefinition($this->command->getDefinition());
            $this->setDescription($this->command->getDescription());
        }

        $this->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->wrapCommand($input->getOption('em'))->execute($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->wrapCommand($input->getOption('em'))->interact($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->wrapCommand($input->getOption('em'))->initialize($input, $output);
    }
}
