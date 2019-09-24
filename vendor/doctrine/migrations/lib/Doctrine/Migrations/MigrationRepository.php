<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Exception\DuplicateMigrationVersion;
use Doctrine\Migrations\Exception\MigrationClassNotFound;
use Doctrine\Migrations\Exception\MigrationException;
use Doctrine\Migrations\Exception\UnknownMigrationVersion;
use Doctrine\Migrations\Finder\MigrationFinder;
use Doctrine\Migrations\Version\Factory;
use Doctrine\Migrations\Version\Version;
use const SORT_STRING;
use function array_diff;
use function array_keys;
use function array_map;
use function array_search;
use function array_unshift;
use function class_exists;
use function count;
use function end;
use function get_class;
use function implode;
use function is_array;
use function ksort;
use function sprintf;
use function substr;

/**
 * The MigrationRepository class is responsible for retrieving migrations, determing what the current migration
 * version, etc.
 *
 * @internal
 */
class MigrationRepository
{
    /** @var Configuration */
    private $configuration;

    /** @var Connection */
    private $connection;

    /** @var MigrationFinder */
    private $migrationFinder;

    /** @var Factory */
    private $versionFactory;

    /** @var Version[] */
    private $versions = [];

    public function __construct(
        Configuration $configuration,
        Connection $connection,
        MigrationFinder $migrationFinder,
        Factory $versionFactory
    ) {
        $this->configuration   = $configuration;
        $this->connection      = $connection;
        $this->migrationFinder = $migrationFinder;
        $this->versionFactory  = $versionFactory;
    }

    /**
     * @return string[]
     */
    public function findMigrations(string $path) : array
    {
        return $this->migrationFinder->findMigrations(
            $path,
            $this->configuration->getMigrationsNamespace()
        );
    }

    /** @return Version[] */
    public function registerMigrationsFromDirectory(string $path) : array
    {
        return $this->registerMigrations($this->findMigrations($path));
    }

    public function addVersion(Version $version) : void
    {
        $this->versions[$version->getVersion()] = $version;

        ksort($this->versions, SORT_STRING);
    }

    /**
     * @param Version[] $versions
     */
    public function addVersions(array $versions) : void
    {
        foreach ($versions as $version) {
            $this->addVersion($version);
        }
    }

    public function removeMigrationVersionFromDatabase(string $version) : void
    {
        $this->connection->delete(
            $this->configuration->getMigrationsTableName(),
            [$this->configuration->getMigrationsColumnName() => $version]
        );
    }

    /** @throws MigrationException */
    public function registerMigration(string $version, string $migrationClassName) : Version
    {
        $this->ensureMigrationClassExists($migrationClassName);

        if (isset($this->versions[$version])) {
            throw DuplicateMigrationVersion::new(
                $version,
                get_class($this->versions[$version])
            );
        }

        $version = $this->versionFactory->createVersion($version, $migrationClassName);

        $this->addVersion($version);

        return $version;
    }

    /**
     * @param string[] $migrations
     *
     * @return Version[]
     */
    public function registerMigrations(array $migrations) : array
    {
        $versions = [];

        foreach ($migrations as $version => $class) {
            $versions[] = $this->registerMigration((string) $version, $class);
        }

        return $versions;
    }

    public function getCurrentVersion() : string
    {
        $this->configuration->createMigrationTable();

        if (! $this->configuration->isMigrationTableCreated() && $this->configuration->isDryRun()) {
            return '0';
        }

        $this->configuration->connect();

        $this->loadMigrationsFromDirectory();

        $where = null;

        if (count($this->versions) !== 0) {
            $migratedVersions = [];

            foreach ($this->versions as $migration) {
                $migratedVersions[] = sprintf("'%s'", $migration->getVersion());
            }

            $where = sprintf(
                ' WHERE %s IN (%s)',
                $this->configuration->getQuotedMigrationsColumnName(),
                implode(', ', $migratedVersions)
            );
        }

        $sql = sprintf(
            'SELECT %s FROM %s%s ORDER BY %s DESC',
            $this->configuration->getQuotedMigrationsColumnName(),
            $this->configuration->getMigrationsTableName(),
            $where,
            $this->configuration->getQuotedMigrationsColumnName()
        );

        $sql    = $this->connection->getDatabasePlatform()->modifyLimitQuery($sql, 1);
        $result = $this->connection->fetchColumn($sql);

        return $result !== false ? (string) $result : '0';
    }

    /**
     * @return Version[]
     */
    public function getVersions() : array
    {
        $this->loadMigrationsFromDirectory();

        return $this->versions;
    }

    public function clearVersions() : void
    {
        $this->versions = [];
    }

    public function getVersion(string $version) : Version
    {
        $this->loadMigrationsFromDirectory();

        if (! isset($this->versions[$version])) {
            throw UnknownMigrationVersion::new($version);
        }

        return $this->versions[$version];
    }

    public function hasVersion(string $version) : bool
    {
        $this->loadMigrationsFromDirectory();

        return isset($this->versions[$version]);
    }

    public function hasVersionMigrated(Version $version) : bool
    {
        return $this->getVersionData($version) !== null;
    }

    /**
     * @return mixed[]|null
     */
    public function getVersionData(Version $version) : ?array
    {
        $this->configuration->connect();
        $this->configuration->createMigrationTable();

        $sql = sprintf(
            'SELECT %s, %s FROM %s WHERE %s = ?',
            $this->configuration->getQuotedMigrationsColumnName(),
            $this->configuration->getQuotedMigrationsExecutedAtColumnName(),
            $this->configuration->getMigrationsTableName(),
            $this->configuration->getQuotedMigrationsColumnName()
        );

        $data = $this->connection->fetchAssoc($sql, [$version->getVersion()]);

        return is_array($data) ? $data : null;
    }

    /**
     * @return Version[]
     */
    public function getMigrations() : array
    {
        $this->loadMigrationsFromDirectory();

        return $this->versions;
    }

    /** @return string[] */
    public function getAvailableVersions() : array
    {
        $availableVersions = [];

        $this->loadMigrationsFromDirectory();

        foreach ($this->versions as $migration) {
            $availableVersions[] = $migration->getVersion();
        }

        return $availableVersions;
    }

    /** @return string[] */
    public function getNewVersions() : array
    {
        $availableMigrations = $this->getAvailableVersions();
        $executedMigrations  = $this->getMigratedVersions();

        return array_diff($availableMigrations, $executedMigrations);
    }

    /** @return string[] */
    public function getMigratedVersions() : array
    {
        $this->configuration->createMigrationTable();

        if (! $this->configuration->isMigrationTableCreated() && $this->configuration->isDryRun()) {
            return [];
        }

        $this->configuration->connect();

        $sql = sprintf(
            'SELECT %s FROM %s',
            $this->configuration->getQuotedMigrationsColumnName(),
            $this->configuration->getMigrationsTableName()
        );

        $result = $this->connection->fetchAll($sql);

        return array_map('current', $result);
    }

    /**
     * @return string[]
     */
    public function getExecutedUnavailableMigrations() : array
    {
        $executedMigrations  = $this->getMigratedVersions();
        $availableMigrations = $this->getAvailableVersions();

        return array_diff($executedMigrations, $availableMigrations);
    }

    public function getNumberOfAvailableMigrations() : int
    {
        $this->loadMigrationsFromDirectory();

        return count($this->versions);
    }

    public function getLatestVersion() : string
    {
        $this->loadMigrationsFromDirectory();

        $versions = array_keys($this->versions);
        $latest   = end($versions);

        return $latest !== false ? (string) $latest : '0';
    }

    public function getNumberOfExecutedMigrations() : int
    {
        $this->configuration->connect();
        $this->configuration->createMigrationTable();

        $sql = sprintf(
            'SELECT COUNT(%s) FROM %s',
            $this->configuration->getQuotedMigrationsColumnName(),
            $this->configuration->getMigrationsTableName()
        );

        $result = $this->connection->fetchColumn($sql);

        return $result !== false ? (int) $result : 0;
    }

    public function getRelativeVersion(string $version, int $delta) : ?string
    {
        $this->loadMigrationsFromDirectory();

        $versions = array_map('strval', array_keys($this->versions));

        array_unshift($versions, '0');

        $offset = array_search($version, $versions, true);

        if ($offset === false) {
            return null;
        }

        $relativeVersion = ((int) $offset) + $delta;

        if (! isset($versions[$relativeVersion])) {
            // Unknown version or delta out of bounds.
            return null;
        }

        return $versions[$relativeVersion];
    }

    public function getDeltaVersion(string $delta) : ?string
    {
        $symbol = substr($delta, 0, 1);
        $number = (int) substr($delta, 1);

        if ($number <= 0) {
            return null;
        }

        if ($symbol === '+' || $symbol === '-') {
            return $this->getRelativeVersion($this->getCurrentVersion(), (int) $delta);
        }

        return null;
    }

    public function getPrevVersion() : ?string
    {
        return $this->getRelativeVersion($this->getCurrentVersion(), -1);
    }

    public function getNextVersion() : ?string
    {
        return $this->getRelativeVersion($this->getCurrentVersion(), 1);
    }

    private function loadMigrationsFromDirectory() : void
    {
        $migrationsDirectory = $this->configuration->getMigrationsDirectory();

        if (count($this->versions) !== 0 || $migrationsDirectory === null) {
            return;
        }

        $this->registerMigrationsFromDirectory($migrationsDirectory);
    }

    /** @throws MigrationException */
    private function ensureMigrationClassExists(string $class) : void
    {
        if (! class_exists($class)) {
            throw MigrationClassNotFound::new(
                $class,
                $this->configuration->getMigrationsNamespace()
            );
        }
    }
}
