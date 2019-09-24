<?php

namespace App\Console\Wizard;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Question\Question;
use Doctrine\DBAL\Migrations\MigrationException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Input\ArrayInput as ConsoleOptions;
use Doctrine\Migrations\Exception\UnknownMigrationVersion;
use Doctrine\Migrations\Generator\Exception\NoChangesDetected;

class MigrateDatabase extends Command
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
        $this
            ->setName('uvdesk_wizard:database:migrate')
            ->setDescription('Migrate your database to the latest schema version.')
            ->setHidden(true);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Check 1: Verify database connection
        $database = $this->entityManager->getConnection()->getDatabase();

        if (false == $this->isDatabaseConfigurationValid()) {
            return;
        }

        // Get the current database migration version
        try {
            $currentMigrationVersion = $this->getLatestMigrationVersion(new BufferedOutput());
        } catch (UnknownMigrationVersion $e) {
            // Fresh setup. No initial migration version defined.
            $currentMigrationVersion = 0;
        }

        $this->versionMigrations($output);

        // Compare the current database migration version against database 
        // and create a new migration version accordingly.
        try {
            $latestMigrationVersion = $this
                ->compareMigrations($output)
                ->getLatestMigrationVersion(new BufferedOutput());
            
            if (('0' != $currentMigrationVersion && $currentMigrationVersion != $latestMigrationVersion) || ($currentMigrationVersion != $latestMigrationVersion)) {
                $this->migrateDatabaseToLatestVersion(new NullOutput());
            }
        } catch (NoChangesDetected $e) {
            // Do nothing ...
        }
    }

    private function versionMigrations(OutputInterface $consoleOutput)
    {
        $command = $this->getApplication()->find('doctrine:migrations:version');
        ($consoleOptions = new ConsoleOptions([
            'command' => 'migrations:version',
            '--add' => true,
            '--all' => true,
            '--quiet' => true
        ]))->setInteractive(false);

        // Execute command
        $command->run($consoleOptions, $consoleOutput);

        return $this;
    }

    private function compareMigrations(OutputInterface $consoleOutput)
    {
        $compareMigrationsCommand = $this->getApplication()->find('doctrine:migrations:diff');
        $compareMigrationsCommandOptions = new ConsoleOptions([
            'command' => 'migrations:diff',
            '--quiet' => true
        ]);
        
        $viewMigrationStatusCommand = $this->getApplication()->find('doctrine:migrations:status');
        $viewMigrationStatusCommandOptions = new ConsoleOptions([
            'command' => 'migrations:status',
            '--quiet' => true
        ]);
            
        // Execute command
        $compareMigrationsCommand->run($compareMigrationsCommandOptions, new NullOutput());
        $viewMigrationStatusCommand->run($viewMigrationStatusCommandOptions, new NullOutput());

        return $this;
    }

    private function getLatestMigrationVersion(OutputInterface $bufferedOutput)
    {
        $command = $this->getApplication()->find('doctrine:migrations:latest');
        $commandOptions = new ConsoleOptions([
            'command' => 'migrations:latest'
        ]);

        // To avoid issues through same instance
        $command->mergeApplicationDefinition();
        $command = clone $command;

        // Execute command
        $command->run($commandOptions, $bufferedOutput);

        return trim($bufferedOutput->fetch());
    }

    private function migrateDatabaseToLatestVersion(OutputInterface $consoleOutput)
    {
        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        ($commandOptions = new ConsoleOptions([
            'command' => 'migrations:migrate',
        ]))->setInteractive(false);
        
        // Execute Command
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
