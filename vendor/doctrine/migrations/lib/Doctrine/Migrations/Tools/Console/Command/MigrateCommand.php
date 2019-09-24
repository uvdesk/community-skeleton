<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use Doctrine\Migrations\Migrator;
use Doctrine\Migrations\MigratorConfiguration;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function count;
use function getcwd;
use function sprintf;
use function substr;

/**
 * The MigrateCommand class is responsible for executing a migration from the current version to another
 * version up or down. It will calculate all the migration versions that need to be executed and execute them.
 */
class MigrateCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this
            ->setName('migrations:migrate')
            ->setAliases(['migrate'])
            ->setDescription(
                'Execute a migration to a specified version or the latest available version.'
            )
            ->addArgument(
                'version',
                InputArgument::OPTIONAL,
                'The version number (YYYYMMDDHHMMSS) or alias (first, prev, next, latest) to migrate to.',
                'latest'
            )
            ->addOption(
                'write-sql',
                null,
                InputOption::VALUE_OPTIONAL,
                'The path to output the migration SQL file instead of executing it. Defaults to current working directory.',
                false
            )
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration as a dry run.'
            )
            ->addOption(
                'query-time',
                null,
                InputOption::VALUE_NONE,
                'Time all the queries individually.'
            )
            ->addOption(
                'allow-no-migration',
                null,
                InputOption::VALUE_NONE,
                'Don\'t throw an exception if no migration is available (CI).'
            )
            ->addOption(
                'all-or-nothing',
                null,
                InputOption::VALUE_OPTIONAL,
                'Wrap the entire migration in a transaction.',
                false
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command executes a migration to a specified version or the latest available version:

    <info>%command.full_name%</info>

You can optionally manually specify the version you wish to migrate to:

    <info>%command.full_name% YYYYMMDDHHMMSS</info>

You can specify the version you wish to migrate to using an alias:

    <info>%command.full_name% prev</info>
    <info>These alias are defined : first, latest, prev, current and next</info>

You can specify the version you wish to migrate to using an number against the current version:

    <info>%command.full_name% current+3</info>

You can also execute the migration as a <comment>--dry-run</comment>:

    <info>%command.full_name% YYYYMMDDHHMMSS --dry-run</info>

You can output the would be executed SQL statements to a file with <comment>--write-sql</comment>:

    <info>%command.full_name% YYYYMMDDHHMMSS --write-sql</info>

Or you can also execute the migration without a warning message which you need to interact with:

    <info>%command.full_name% --no-interaction</info>

You can also time all the different queries if you wanna know which one is taking so long:

    <info>%command.full_name% --query-time</info>

Use the --all-or-nothing option to wrap the entire migration in a transaction.
EOT
        );

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output) : ?int
    {
        $this->outputHeader($output);

        $version          = (string) $input->getArgument('version');
        $path             = $input->getOption('write-sql');
        $allowNoMigration = (bool) $input->getOption('allow-no-migration');
        $timeAllQueries   = (bool) $input->getOption('query-time');
        $dryRun           = (bool) $input->getOption('dry-run');
        $allOrNothing     = $this->getAllOrNothing($input->getOption('all-or-nothing'));

        $this->configuration->setIsDryRun($dryRun);

        $version = $this->getVersionNameFromAlias(
            $version,
            $output
        );

        if ($version === '') {
            return 1;
        }

        if ($this->checkExecutedUnavailableMigrations($input, $output) === 1) {
            return 1;
        }

        $migrator = $this->createMigrator();

        if ($path !== false) {
            $path = $path ?? getcwd();

            $migrator->writeSqlFile($path, $version);

            return 0;
        }

        $question = 'WARNING! You are about to execute a database migration that could result in schema changes and data loss. Are you sure you wish to continue? (y/n)';

        if (! $dryRun && ! $this->canExecute($question, $input, $output)) {
            $output->writeln('<error>Migration cancelled!</error>');

            return 1;
        }

        $migratorConfiguration = (new MigratorConfiguration())
            ->setDryRun($dryRun)
            ->setTimeAllQueries($timeAllQueries)
            ->setNoMigrationException($allowNoMigration)
            ->setAllOrNothing($allOrNothing);

        $migrator->migrate($version, $migratorConfiguration);

        return 0;
    }

    protected function createMigrator() : Migrator
    {
        return $this->dependencyFactory->getMigrator();
    }

    private function checkExecutedUnavailableMigrations(
        InputInterface $input,
        OutputInterface $output
    ) : int {
        $executedUnavailableMigrations = $this->migrationRepository->getExecutedUnavailableMigrations();

        if (count($executedUnavailableMigrations) !== 0) {
            $output->writeln(sprintf(
                '<error>WARNING! You have %s previously executed migrations in the database that are not registered migrations.</error>',
                count($executedUnavailableMigrations)
            ));

            foreach ($executedUnavailableMigrations as $executedUnavailableMigration) {
                $output->writeln(sprintf(
                    '    <comment>>></comment> %s (<comment>%s</comment>)',
                    $this->configuration->getDateTime($executedUnavailableMigration),
                    $executedUnavailableMigration
                ));
            }

            $question = 'Are you sure you wish to continue? (y/n)';

            if (! $this->canExecute($question, $input, $output)) {
                $output->writeln('<error>Migration cancelled!</error>');

                return 1;
            }
        }

        return 0;
    }

    private function getVersionNameFromAlias(
        string $versionAlias,
        OutputInterface $output
    ) : string {
        $version = $this->configuration->resolveVersionAlias($versionAlias);

        if ($version !== null) {
            return $version;
        }

        if ($versionAlias === 'prev') {
            $output->writeln('<error>Already at first version.</error>');

            return '';
        }

        if ($versionAlias === 'next') {
            $output->writeln('<error>Already at latest version.</error>');

            return '';
        }

        if (substr($versionAlias, 0, 7) === 'current') {
            $output->writeln('<error>The delta couldn\'t be reached.</error>');

            return '';
        }

        $output->writeln(sprintf(
            '<error>Unknown version: %s</error>',
            OutputFormatter::escape($versionAlias)
        ));

        return '';
    }

    /**
     * @param mixed $allOrNothing
     */
    private function getAllOrNothing($allOrNothing) : bool
    {
        if ($allOrNothing !== false) {
            return $allOrNothing !== null
                ? (bool) $allOrNothing
                : true;
        }

        return $this->configuration->isAllOrNothing();
    }
}
