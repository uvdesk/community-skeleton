<?php

namespace App\Console\Wizard;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
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

class ConfigureHelpdesk extends Command
{
    private $container;
    private $projectDir;
    private $logFilePath;
    private $questionHelper;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->projectDir = $this->container->get('kernel')->getProjectDir();
        $this->logFilePath = $this->projectDir . '/var/log/dev.log';

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

    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('dev' !== $this->container->get('kernel')->getEnvironment()) {
            
            return ;
        }
        
        $output->write("\033[2J"); // MOVE_CURSOR_HOME
        $output->write("\033[H"); // CLEAR_SCREEN

        // Clearing the cache for the dev environment with debug true
        $this->clearCache($output);

        $output->writeln("\n<comment>  Examining helpdesk setup for any configuration issues:</comment>\n");

        // Check 1: Verify database connection
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $database = $entityManager->getConnection()->getDatabase();

        while(true) {
            $output->writeln("\n  [-] Establishing a connection with the <comment>$database</comment> database.");
            if (!$this->isDatabaseConfigurationValid($entityManager)) {
                $output->writeln([
                    "<fg=red;>  [x]</> Failed to establish a connection with the <comment>$database</comment> database.</>",
                ]);
                $interactiveQuestion = new Question("\n      <comment>Reconfigure your Database Connection? [Y/N]</comment> ", 'Y');
                if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                    $entityManager =$this->configureDatabase($input, $output, $entityManager);
                    $this->createDatabase(new NullOutput());
                } else {
                    $output->writeln([
                        "\n      Please ensure that you have correctly configured the <comment>DATABASE_URL</comment> variable defined inside your <fg=blue;options=bold>.env</> environment file.",
                        "\n  Exiting evaluation process.\n",
                    ]);
                    return;
                }
            } else {
                $output->writeln("  <info>[v]</info> Successfully established a connection with the <info>$database</info> database.\n");
                break;
            }
            $database = $entityManager->getConnection()->getDatabase();
        }
        
        // Check 2: Ensure entities have been loaded
        $output->writeln("  [-] Comparing the <info>$database</info> database schema with the current mapping metadata.");

        // Get the current database migration version
        $currentMigrationVersion = $this->getLatestMigrationVersion(new BufferedOutput());
        $this->versionMigrations(new NullOutput());

        // Compare the current database migration version against database 
        // and create a new migration version accordingly.
        $latestMigrationVersion = $this
            ->compareMigrations($output)
            ->getLatestMigrationVersion(new BufferedOutput());
        
        if ($currentMigrationVersion != $latestMigrationVersion) {
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
            // Database is up-to-date. Do nothing.
            $output->writeln("  <info>[v]</info> The current database schema is up-to-date with the current mapping metdata.\n");
        }

        // Check 3: Check if super admin account exists
        $output->writeln("  [-] Checking if an active super admin account exists");
        $supperAdminUserInstance = $entityManager->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy([
            'isActive' => true,
            'supportRole' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_SUPER_ADMIN'),
        ]);
        
        if (empty($supperAdminUserInstance)) {
            $output->writeln("  <comment>[!]</comment> No active user account found with super admin privileges.");
            $interactiveQuestion = new Question("\n      <comment>Create a new user account with super admin privileges? [Y/N]</comment> ", 'Y');
            $output->writeln("");

            if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                $returnCode = $this->createSuperAdmin($output);

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
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console doctrine:migrations:version --add --all --quiet --no-interaction 2>>' . $this->logFilePath; 
        exec($command, $commandOutput);         
        $consoleOutput->writeln($commandOutput);

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
        // @TODO: Refactor using Symfony Process Component

        $compareMigrationsCommand = 'php ' . $this->projectDir . '/bin/console doctrine:migrations:diff --quiet 2>>' . $this->logFilePath; 
        exec($compareMigrationsCommand, $commandOutput);
        $consoleOutput->writeln($commandOutput);
        unset($commandOutput);

        $viewMigrationStatusCommand = 'php ' . $this->projectDir . '/bin/console doctrine:migrations:status --quiet 2>>' . $this->logFilePath; 
        exec($viewMigrationStatusCommand, $commandOutput);
        $consoleOutput->writeln($commandOutput);
            
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
        $command = 'php ' . $this->projectDir . '/bin/console doctrine:migrations:latest 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $bufferedOutput->writeln($commandOutput);
        $version = trim($bufferedOutput->fetch());

        return !empty($version) ? $version : 0;
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
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console doctrine:migrations:migrate --no-interaction 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $consoleOutput->writeln($commandOutput);

        return $this;
    }

    /**
     * @param OutputInterface   $consoleOutput
     * 
     * @return UpdateDatabaseSchema
    */
    private function runDataFixtures(OutputInterface $consoleOutput)
    {   
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console doctrine:fixtures:load --append 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $consoleOutput->writeln($commandOutput);

        return $this;
    }

    private function isDatabaseConfigurationValid(EntityManagerInterface $entityManager)
    {
        $databaseConnection = $entityManager->getConnection();

        if (false === $databaseConnection->isConnected()) {
            try {    
                $databaseConnection->connect();
            } catch (DBALException $e) {
                return false;
            }
        }

        return true;
    }

    private function createDatabase(OutputInterface $consoleOutput)
    {   
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console doctrine:database:create --if-not-exists --quiet --no-interaction 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $consoleOutput->writeln($commandOutput);

        return $this;
    }

    private function clearCache(OutputInterface $consoleOutput)
    {   
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console cache:clear --no-warmup 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $consoleOutput->writeln($commandOutput);

        return $this;
    }

    private function saveDatabaseConfiguration(OutputInterface $consoleOutput, string $databaseURL)
    {   
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console uvdesk_wizard:env:update DATABASE_URL ';
        $command .= $databaseURL;
        $command .= ' 2>>' . $this->logFilePath;
        exec($command, $commandOutput);
        $consoleOutput->writeln($commandOutput);

        return $this;
    }

    private function configureDatabase(InputInterface $input, OutputInterface $output, EntityManagerInterface $entityManager) {
        
        $dbParams = $entityManager->getConnection()->getParams();

        // Host
        $question = new Question("\n      <info>Host:</info> ", $dbParams['host']);
        $question->setAutocompleterValues(['127.0.0.1', 'localhost']);
        $host = trim($this->questionHelper->ask($input, $output, $question));
        
        // Port
        $question = new Question("\n      <info>Port:</info> ", $dbParams['port']);
        $question->setAutocompleterValues(['3306']);
        $port = trim($this->questionHelper->ask($input, $output, $question));
        
        // User
        $question = new Question("\n      <info>Username:</info> ", $dbParams['user']);
        $question->setAutocompleterValues(['root']);
        $user = trim($this->questionHelper->ask($input, $output, $question));
        
        // Password
        $question = new Question("\n      <info>Password:</info> ", '');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $this->questionHelper->ask($input, $output, $question);
        $password = !empty($password) ? $password : '';
    
        // Database
        $question = new Question("\n      <info>Database:</info> ", $dbParams['dbname']);
        $question->setAutocompleterValues(['helpdesk', 'uvdesk']);
        $database = trim($this->questionHelper->ask($input, $output, $question));

        $databaseURL = sprintf("mysql://%s:%s@%s:%s/%s", $user, $password, $host, $port, $database);
        $this->saveDatabaseConfiguration(new NullOutput(), $databaseURL);
        $entityManager = EntityManager::create(['url' => $databaseURL], $entityManager->getConfiguration());
        
        return $entityManager;
    }

    private function createSuperAdmin(OutputInterface $consoleOutput) 
    {
        // @TODO: Refactor using Symfony Process Component

        $command = 'php ' . $this->projectDir . '/bin/console uvdesk_wizard:defaults:create-user ROLE_SUPER_ADMIN';
        exec($command, $commandOutput, $statusCode);
        $consoleOutput->writeln($commandOutput);

        return $statusCode;
    }

    private function isDatabaseExists(EntityManagerInterface $enityManger, string $database): bool {
        $schemaManager = $entityManager->getConnection()->getSchemaManager();
        $databaseList = $schemaManager->listDatabases();

        return in_array($database, $databaseList);
    }

}
