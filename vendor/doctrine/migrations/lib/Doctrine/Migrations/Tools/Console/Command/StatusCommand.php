<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use DateTimeImmutable;
use Doctrine\Migrations\Version\Version;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function assert;
use function count;
use function is_string;
use function max;
use function sprintf;
use function str_repeat;
use function strlen;

/**
 * The StatusCommand class is responsible for outputting what the current state is of all your migrations. It shows
 * what your current version is, how many new versions you have to execute, etc. and details about each of your migrations.
 */
class StatusCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this
            ->setName('migrations:status')
            ->setAliases(['status'])
            ->setDescription('View the status of a set of migrations.')
            ->addOption(
                'show-versions',
                null,
                InputOption::VALUE_NONE,
                'This will display a list of all available migrations and their status'
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command outputs the status of a set of migrations:

    <info>%command.full_name%</info>

You can output a list of all available migrations and their status with <comment>--show-versions</comment>:

    <info>%command.full_name% --show-versions</info>
EOT
        );

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output) : ?int
    {
        $output->writeln("\n <info>==</info> Configuration\n");

        $infos = $this->dependencyFactory->getMigrationStatusInfosHelper();

        foreach ($infos->getMigrationsInfos() as $name => $value) {
            assert(is_string($name));

            $string = (string) $value;

            if ($name === 'New Migrations') {
                $string = $value > 0 ? '<question>' . $value . '</question>' : '0';
            }

            if ($name === 'Executed Unavailable Migrations') {
                $string = $value > 0 ? '<error>' . $value . '</error>' : '0';
            }

            $this->writeStatusInfosLineAligned($output, $name, $string);
        }

        if ($input->getOption('show-versions') === false) {
            return 0;
        }

        $versions                      = $this->migrationRepository->getMigrations();
        $executedUnavailableMigrations = $this->migrationRepository->getExecutedUnavailableMigrations();

        if (count($versions) !== 0) {
            $output->writeln("\n <info>==</info> Available Migration Versions\n");

            $this->showVersions($versions, $output);
        }

        if (count($executedUnavailableMigrations) === 0) {
            return 0;
        }

        $output->writeln(
            "\n <info>==</info> Previously Executed Unavailable Migration Versions\n"
        );

        foreach ($executedUnavailableMigrations as $executedUnavailableMigration) {
            $output->writeln(
                sprintf(
                    '    <comment>>></comment> %s (<comment>%s</comment>)',
                    $this->configuration->getDateTime($executedUnavailableMigration),
                    $executedUnavailableMigration
                )
            );
        }

        return 0;
    }

    private function writeStatusInfosLineAligned(OutputInterface $output, string $title, ?string $value) : void
    {
        $output->writeln(sprintf(
            '    <comment>>></comment> %s: %s%s',
            $title,
            str_repeat(' ', 50 - strlen($title)),
            $value
        ));
    }

    /**
     * @param Version[] $versions
     */
    private function showVersions(
        array $versions,
        OutputInterface $output
    ) : void {
        foreach ($versions as $version) {
            $executedAt = $version->getExecutedAt();

            $status = $version->isMigrated() ? '<info>migrated</info>' : '<error>not migrated</error>';

            $executedAtStatus = $executedAt instanceof DateTimeImmutable
                ? sprintf(' (executed at %s)', $executedAt->format('Y-m-d H:i:s'))
                : '';

            $migration   = $version->getMigration();
            $description = $migration->getDescription();

            $migrationDescription = $description !== ''
                ? str_repeat(' ', 5) . $description
                : '';

            $versionName      = $version->getVersion();
            $formattedVersion = $version->getDateTime();

            $output->writeln(sprintf(
                '    <comment>>></comment> %s (<comment>%s</comment>)%s%s%s%s',
                $formattedVersion,
                $versionName,
                str_repeat(' ', max(1, 49 - strlen($formattedVersion) - strlen($versionName))),
                $status,
                $executedAtStatus,
                $migrationDescription
            ));
        }
    }
}
