<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function count;
use function sprintf;

/**
 * The UpToDateCommand class outputs if your database is up to date or if there are new migrations
 * that need to be executed.
 */
class UpToDateCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this
            ->setName('migrations:up-to-date')
            ->setAliases(['up-to-date'])
            ->setDescription('Tells you if your schema is up-to-date.')
            ->addOption('fail-on-unregistered', 'u', InputOption::VALUE_NONE, 'Whether to fail when there are unregistered extra migrations found')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command tells you if your schema is up-to-date:

    <info>%command.full_name%</info>
EOT
            );

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output) : ?int
    {
        $migrations          = count($this->migrationRepository->getMigrations());
        $migratedVersions    = count($this->migrationRepository->getMigratedVersions());
        $availableMigrations = $migrations - $migratedVersions;

        if ($availableMigrations === 0) {
            $output->writeln('<comment>Up-to-date! No migrations to execute.</comment>');

            return 0;
        }

        if ($availableMigrations > 0) {
            $output->writeln(sprintf(
                '<error>Out-of-date! %u migration%s available to execute.</error>',
                $availableMigrations,
                $availableMigrations > 1 ? 's are' : ' is'
            ));

            return 1;
        }

        // negative number means that there are unregistered migrations in the database

        $extraMigrations = -$availableMigrations;
        $output->writeln(sprintf(
            '<error>You have %1$u previously executed migration%3$s in the database that %2$s registered migration%3$s.</error>',
            $extraMigrations,
            $extraMigrations > 1 ? 'are not' : 'is not a',
            $extraMigrations > 1 ? 's' : ''
        ));

        return $input->getOption('fail-on-unregistered') === true ? 2 : 0;
    }
}
