<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function sprintf;

/**
 * The LatestCommand class is responsible for outputting what your latest version is.
 */
class LatestCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this
            ->setName('migrations:latest')
            ->setAliases(['latest'])
            ->setDescription('Outputs the latest version number');

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output) : ?int
    {
        $latestVersion = $this->migrationRepository->getLatestVersion();
        $version       = $this->migrationRepository->getVersion($latestVersion);
        $description   = $version->getMigration()->getDescription();

        $output->writeln(sprintf(
            '<info>%s</info>%s',
            $latestVersion,
            $description !== '' ? ' - ' . $description : ''
        ));

        return 0;
    }
}
