<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\Version\Direction;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function getcwd;

/**
 * The ExecutCommand class is responsible for executing a single migration version up or down.
 */
class ExecuteCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this
            ->setName('migrations:execute')
            ->setAliases(['execute'])
            ->setDescription(
                'Execute a single migration version up or down manually.'
            )
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'The version to execute.',
                null
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
                'up',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration up.'
            )
            ->addOption(
                'down',
                null,
                InputOption::VALUE_NONE,
                'Execute the migration down.'
            )
            ->addOption(
                'query-time',
                null,
                InputOption::VALUE_NONE,
                'Time all the queries individually.'
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command executes a single migration version up or down manually:

    <info>%command.full_name% YYYYMMDDHHMMSS</info>

If no <comment>--up</comment> or <comment>--down</comment> option is specified it defaults to up:

    <info>%command.full_name% YYYYMMDDHHMMSS --down</info>

You can also execute the migration as a <comment>--dry-run</comment>:

    <info>%command.full_name% YYYYMMDDHHMMSS --dry-run</info>

You can output the would be executed SQL statements to a file with <comment>--write-sql</comment>:

    <info>%command.full_name% YYYYMMDDHHMMSS --write-sql</info>

Or you can also execute the migration without a warning message which you need to interact with:

    <info>%command.full_name% YYYYMMDDHHMMSS --no-interaction</info>
EOT
        );

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output) : ?int
    {
        $version        = $input->getArgument('version');
        $timeAllQueries = (bool) $input->getOption('query-time');
        $dryRun         = (bool) $input->getOption('dry-run');
        $path           = $input->getOption('write-sql');
        $direction      = $input->getOption('down') !== false
            ? Direction::DOWN
            : Direction::UP;

        $version = $this->migrationRepository->getVersion($version);

        if ($path !== false) {
            $path = $path ?? getcwd();

            $version->writeSqlFile($path, $direction);

            return 0;
        }

        $question = 'WARNING! You are about to execute a database migration that could result in schema changes and data lost. Are you sure you wish to continue? (y/n)';

        if (! $dryRun && ! $this->canExecute($question, $input, $output)) {
            $output->writeln('<error>Migration cancelled!</error>');

            return 1;
        }

        $migratorConfiguration = (new MigratorConfiguration())
            ->setDryRun($dryRun)
            ->setTimeAllQueries($timeAllQueries);

        $version->execute($direction, $migratorConfiguration);

        return 0;
    }
}
