<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Helper;

use Doctrine\Migrations\Configuration\AbstractFileConfiguration;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\MigrationRepository;
use function count;
use function sprintf;

/**
 * The MigrationStatusInfosHelper class is responsible for building the array of information used when displaying
 * the status of your migrations.
 *
 * @internal
 *
 * @see Doctrine\Migrations\Tools\Console\Command\StatusCommand
 */
class MigrationStatusInfosHelper
{
    /** @var Configuration  */
    private $configuration;

    /** @var MigrationRepository  */
    private $migrationRepository;

    public function __construct(
        Configuration $configuration,
        MigrationRepository $migrationRepository
    ) {
        $this->configuration       = $configuration;
        $this->migrationRepository = $migrationRepository;
    }

    /** @return string[]|int[]|null[] */
    public function getMigrationsInfos() : array
    {
        $executedMigrations            = $this->migrationRepository->getMigratedVersions();
        $availableMigrations           = $this->migrationRepository->getAvailableVersions();
        $newMigrations                 = $this->migrationRepository->getNewVersions();
        $executedUnavailableMigrations = $this->migrationRepository->getExecutedUnavailableMigrations();

        return [
            'Name'                              => $this->configuration->getName() ?? 'Doctrine Database Migrations',
            'Database Driver'                   => $this->configuration->getConnection()->getDriver()->getName(),
            'Database Host'                     => $this->configuration->getConnection()->getHost(),
            'Database Name'                     => $this->configuration->getConnection()->getDatabase(),
            'Configuration Source'              => $this->configuration instanceof AbstractFileConfiguration ? $this->configuration->getFile() : 'manually configured',
            'Version Table Name'                => $this->configuration->getMigrationsTableName(),
            'Version Column Name'               => $this->configuration->getMigrationsColumnName(),
            'Migrations Namespace'              => $this->configuration->getMigrationsNamespace(),
            'Migrations Directory'              => $this->configuration->getMigrationsDirectory(),
            'Previous Version'                  => $this->getFormattedVersionAlias('prev'),
            'Current Version'                   => $this->getFormattedVersionAlias('current'),
            'Next Version'                      => $this->getFormattedVersionAlias('next'),
            'Latest Version'                    => $this->getFormattedVersionAlias('latest'),
            'Executed Migrations'               => count($executedMigrations),
            'Executed Unavailable Migrations'   => count($executedUnavailableMigrations),
            'Available Migrations'              => count($availableMigrations),
            'New Migrations'                    => count($newMigrations),
        ];
    }

    private function getFormattedVersionAlias(string $alias) : string
    {
        $version = $this->configuration->resolveVersionAlias($alias);

        // No version found
        if ($version === null) {
            if ($alias === 'next') {
                return 'Already at latest version';
            }

            if ($alias === 'prev') {
                return 'Already at first version';
            }
        }

        // Before first version "virtual" version number
        if ($version === '0') {
            return '<comment>0</comment>';
        }

        // Show normal version number
        return sprintf(
            '%s (<comment>%s</comment>)',
            $this->configuration->getDateTime((string) $version),
            $version
        );
    }
}
