<?php

namespace App\Console\Wizard;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput as ConsoleOptions;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MigrateDatabase extends Command
{
    private $container;
    private $entityManager;

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
            ->setDescription('Migrate or initialize database depending on schema status.')
            ->setHidden(true);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->isDatabaseConfigurationValid()) {
            $output->writeln('<error>Invalid database configuration.</error>');

            return Command::FAILURE;
        }

        $connection = $this->entityManager->getConnection();
        $schemaManager = method_exists($connection, 'createSchemaManager')
            ? $connection->createSchemaManager() // DBAL 3
            : $connection->getSchemaManager();   // DBAL 2

        $tables = $schemaManager->listTableNames();

        if (empty($tables)) {
            // ✅ FRESH INSTALL - Generate schema & load fixtures
            $output->writeln('<info>Fresh database detected. Creating schema...</info>');

            // Create schema
            $this->runCommand('doctrine:schema:create', ['--no-interaction' => true], $output);

            // Load fixtures
            $output->writeln('<info>Loading default fixtures...</info>');
            $this->runCommand('doctrine:fixtures:load', ['--no-interaction' => true, '--quiet' => true], $output);

            $output->writeln('<info>Fresh installation complete.</info>');

            return Command::SUCCESS;
        }

        // ✅ EXISTING DB - Proceed with normal migration flow
        $this->runCommand('doctrine:migrations:sync-metadata-storage', ['--quiet' => true], new NullOutput());

        try {
            $currentVersion = $this->getLatestMigrationVersion(new BufferedOutput());
        } catch (\Exception $e) {
            $currentVersion = '0';
        }

        // Create migration version if needed
        $this->versionMigrations($output);

        try {
            $latestVersion = $this
                ->compareMigrations($output)
                ->getLatestMigrationVersion(new BufferedOutput());

            if ($currentVersion !== $latestVersion) {
                $this->migrateDatabaseToLatestVersion(new NullOutput());
                $output->writeln('<info>Database migrated to latest version.</info>');
            } else {
                $output->writeln('<info>Database is already up to date.</info>');
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Error during migration: ' . $e->getMessage() . '</error>');
        }

        return Command::SUCCESS;
    }

    private function versionMigrations(OutputInterface $output)
    {
        $this->runCommand('doctrine:migrations:version', [
            '--add' => true,
            '--all' => true,
            '--quiet' => true
        ], $output);
    }

    private function compareMigrations(OutputInterface $output)
    {
        $this->runCommand('doctrine:migrations:diff', ['--quiet' => true], new NullOutput());
        $this->runCommand('doctrine:migrations:status', ['--quiet' => true], new NullOutput());
        return $this;
    }

    private function getLatestMigrationVersion(OutputInterface $output)
    {
        $cmd = $this->getApplication()->find('doctrine:migrations:latest');
        $cmd->mergeApplicationDefinition();
        $cmd->run(new ConsoleOptions(['command' => 'migrations:latest']), $output);
        return trim($output->fetch());
    }

    private function migrateDatabaseToLatestVersion(OutputInterface $output)
    {
        $this->runCommand('doctrine:migrations:migrate', ['--no-interaction' => true], $output);
    }

    private function runCommand(string $commandName, array $options, OutputInterface $output)
    {
        $command = $this->getApplication()->find($commandName);
        $input = new ConsoleOptions(array_merge(['command' => $commandName], $options));
        $input->setInteractive(false);
        $command->run($input, $output);
    }

    private function isDatabaseConfigurationValid()
    {
        $connection = $this->entityManager->getConnection();

        if (!$connection->isConnected()) {
            try {
                $connection->connect();
            } catch (DBALException $e) {
                return false;
            }
        }

        return true;
    }
}
