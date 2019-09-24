<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Exception\RollupFailed;
use Doctrine\Migrations\Version\Version;
use function count;
use function current;
use function sprintf;

/**
 * The Rollup class is responsible for deleting all previously executed migrations from the versions table
 * and marking the freshly dumped schema migration (that was created with SchemaDumper) as migrated.
 *
 * @internal
 *
 * @see Doctrine\Migrations\SchemaDumper
 */
class Rollup
{
    /** @var Configuration */
    private $configuration;

    /** @var Connection */
    private $connection;

    /** @var MigrationRepository */
    private $migrationRepository;

    public function __construct(
        Configuration $configuration,
        Connection $connection,
        MigrationRepository $migrationRepository
    ) {
        $this->configuration       = $configuration;
        $this->connection          = $connection;
        $this->migrationRepository = $migrationRepository;
    }

    /**
     * @throws RollupFailed
     */
    public function rollup() : Version
    {
        $versions = $this->migrationRepository->getVersions();

        if (count($versions) === 0) {
            throw RollupFailed::noMigrationsFound();
        }

        if (count($versions) > 1) {
            throw RollupFailed::tooManyMigrations();
        }

        $sql = sprintf(
            'DELETE FROM %s',
            $this->configuration->getMigrationsTableName()
        );

        $this->connection->executeQuery($sql);

        $version = current($versions);

        $version->markMigrated();

        return $version;
    }
}
