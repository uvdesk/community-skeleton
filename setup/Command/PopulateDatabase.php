<?php

namespace Webkul\UVDesk\Setup\Command;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Input\ArrayInput as ConsoleOptions;

class PopulateDatabase extends Command
{
    private $container;
    private $entityManager;
    private $questionHelper;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('uvdesk-wizard:populate-database');
        $this->setDescription('Migrate your database to the latest schema version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Check 1: Verify database connection
        $database = $this->entityManager->getConnection()->getDatabase();

        if ($this->isDatabaseConfigurationValid()) {
            $this->runDataFixtures(new NullOutput());
        }

        return 0;
    }

    private function runDataFixtures(OutputInterface $consoleOutput)
    {
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $commandOptions = new ConsoleOptions([
            'command' => 'fixtures:load',
            '--append' => true,
        ]);

        $command->run($commandOptions, $consoleOutput);

        return $this;
    }

    private function isDatabaseConfigurationValid()
    {
        $databaseConnection = $this->entityManager->getConnection();

        if (false === $databaseConnection->isConnected()) {
            try {    
                $databaseConnection->connect();
            } catch (DBALException $e) {
                return false;
            }
        }

        return true;
    }
}
