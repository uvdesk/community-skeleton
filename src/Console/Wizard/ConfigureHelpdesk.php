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

class ConfigureHelpdesk extends Command
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
        $this->setName('uvdesk:configure-helpdesk');
        $this->setDescription('Scans through your helpdesk setup to check for any mis-configurations.');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');
    }

    /**
     * @TODO: Enable this command only on development mode.
     * @TODO: Clear Cache.
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write("\033[2J"); // MOVE_CURSOR_HOME
        $output->write("\033[H"); // CLEAR_SCREEN

        // Clearing the cache for the dev environment with debug true
        $output->writeln("\n<comment>  Examining helpdesk setup for any configuration issues:</comment>\n");

        // Check 1: Verify database connection
        $database = $this->entityManager->getConnection()->getDatabase();
        $output->writeln("  [-] Establishing a connection with the <comment>$database</comment> database.");

        if (false == $this->isDatabaseConfigurationValid()) {
            $output->writeln([
                "<fg=red;>  [x]</> Failed to establish a connection with the <comment>$database</comment> database.</>",
                "\n      Please ensure that you have correctly configured the <comment>DATABASE_URL</comment> variable defined inside your <fg=blue;options=bold>.env</> environment file.",
                "\n  Exiting evaluation process.\n",
            ]);

            return;
        } else {
            $output->writeln("  <info>[v]</info> Successfully established a connection with the <info>$database</info> database.\n");
        }

        // Check 2: Ensure entities have been loaded
        $output->writeln("  [-] Comparing the <info>$database</info> database schema with the current mapping metadata.");

        $currentMigrationVersion = $this->getLatestMigrationVersion(new BufferedOutput());
        $latestMigrationVersion = $this
            ->versionMigrations($output)
            ->compareMigrations($output)
            ->getLatestMigrationVersion(new BufferedOutput());
        
        if (('0' != $currentMigrationVersion && $currentMigrationVersion != $latestMigrationVersion) || ($currentMigrationVersion != $latestMigrationVersion)) {
            $output->writeln("  <comment>[!]</comment> The current database schema is not up-to-date with the current mapping metadata.");
            $interactiveQuestion = new Question("\n      <comment>Update your database schema to the current mapping metadata? [Y/N]</comment> ", 'Y');

            if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                $output->writeln([
                    "",
                    "      Please wait while your database is being migrated from version <comment>$currentMigrationVersion</comment> to <info>$latestMigrationVersion</info>.",
                    "      This could take up to a few minutes.\n",
                ]);

                $this->migrateDatabaseToLatestVersion(new NullOutput())->runDataFixtures(new NullOutput());
                $output->writeln("  <info>[v]</info> Database successfully migrated to the latest migration version <comment>$latestMigrationVersion</comment> to <info>$latestMigrationVersion</info>.\n");
            } else {
                $output->writeln([
                    "\n  <fg=red;>[x]</> There are entities that have not been updated to the <info>$database</info> database yet.",
                    "\n  Exiting evaluation process.\n"
                ]);

                return;
            }
        } else {
            $output->writeln("  <info>[v]</info> The current database schema is up-to-date with the current mapping metdata.\n");
        }

        // Check 3: Check if super admin account exists
        $output->writeln("  [-] Checking if an active super admin account exists");
        $supperAdminUserInstance = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy([
            'isActive' => true,
            'supportRole' => $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_SUPER_ADMIN'),
        ]);
        
        if (empty($supperAdminUserInstance)) {
            $output->writeln("  <comment>[!]</comment> No active user account found with super admin privileges.");
            $interactiveQuestion = new Question("\n      <comment>Create a new user account with super admin privileges? [Y/N]</comment> ", 'Y');

            if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                $generateUserInstanceCommand = $this->getApplication()->find('uvdesk_wizard:defaults:create-user');
                $generateUserInstanceCommandOptions = new ConsoleOptions([
                    'command' => 'defaults:create-user',
                    'role' => 'ROLE_SUPER_ADMIN',
                ]);

                $returnCode = $generateUserInstanceCommand->run($generateUserInstanceCommandOptions, $output);

                switch ($returnCode) {
                    case 2:
                        $output->writeln([
                            "  <fg=red;>[x]</> An unexpected error occurred while creating the user account.\n",
                            "\n  Exiting evaluation process.\n"
                        ]);
                        break;
                    default:
                        $output->writeln("  <info>[v]</info> User account created successfully.\n");
                        break;
                }
            } else {
                $output->writeln("\n  <comment>[!]</comment> Skipping creation of a super admin account.");
            }
        } else {
            $output->writeln("  <info>[v]</info> An account with support role <comment>SUPER_ADMIN</comment> exists.\n");
        }

        $output->writeln("  Exiting evaluation process.\n");
    }

    /**
     * Syncronize migration versions entries in the version table.
     * 
     * @param OutputInterface   $consoleOutput
     * 
     * @return UpdateDatabaseSchema
    */
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

    /**
     * Compare current schema mapping information and generate a new migration class 
     * if any mappings are not correctly syncronized.
     * 
     * @param OutputInterface   $consoleOutput
     * 
     * @return UpdateDatabaseSchema
    */
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

    /**
     * Retrieve the latest migration version.
     * 
     * @param OutputInterface   $bufferedOutput
     * 
     * @return string
    */
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

    /**
     * Migrate database to the latest migration version.
     * 
     * @param OutputInterface   $consoleOutput
     * 
     * @return UpdateDatabaseSchema
    */
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

    /**
     * Seed core entities with default datasets.
     * 
     * @param OutputInterface   $consoleOutput
     * 
     * @return UpdateDatabaseSchema
    */
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
