<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Connections\MasterSlaveConnection;
use Doctrine\Migrations\Configuration\Exception\MigrationsNamespaceRequired;
use Doctrine\Migrations\Configuration\Exception\ParameterIncompatibleWithFinder;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Exception\MigrationException;
use Doctrine\Migrations\Exception\MigrationsDirectoryRequired;
use Doctrine\Migrations\Finder\MigrationDeepFinder;
use Doctrine\Migrations\Finder\MigrationFinder;
use Doctrine\Migrations\OutputWriter;
use Doctrine\Migrations\QueryWriter;
use Doctrine\Migrations\Version\Version;
use function str_replace;
use function strlen;

/**
 * The Configuration class is responsible for defining migration configuration information.
 */
class Configuration
{
    public const VERSIONS_ORGANIZATION_BY_YEAR = 'year';

    public const VERSIONS_ORGANIZATION_BY_YEAR_AND_MONTH = 'year_and_month';

    public const VERSION_FORMAT = 'YmdHis';

    /** @var string|null */
    private $name;

    /** @var string */
    private $migrationsTableName = 'doctrine_migration_versions';

    /** @var string */
    private $migrationsColumnName = 'version';

    /** @var int */
    private $migrationsColumnLength;

    /** @var string */
    private $migrationsExecutedAtColumnName = 'executed_at';

    /** @var string|null */
    private $migrationsDirectory;

    /** @var string|null */
    private $migrationsNamespace;

    /** @var bool */
    private $migrationsAreOrganizedByYear = false;

    /** @var bool */
    private $migrationsAreOrganizedByYearAndMonth = false;

    /** @var string|null */
    private $customTemplate;

    /** @var bool */
    private $isDryRun = false;

    /** @var bool */
    private $allOrNothing = false;

    /** @var Connection */
    private $connection;

    /** @var OutputWriter|null */
    private $outputWriter;

    /** @var MigrationFinder|null */
    private $migrationFinder;

    /** @var QueryWriter|null */
    private $queryWriter;

    /** @var DependencyFactory|null */
    private $dependencyFactory;

    /** @var bool */
    private $checkDbPlatform = true;

    public function __construct(
        Connection $connection,
        ?OutputWriter $outputWriter = null,
        ?MigrationFinder $migrationFinder = null,
        ?QueryWriter $queryWriter = null,
        ?DependencyFactory $dependencyFactory = null
    ) {
        $this->connection             = $connection;
        $this->outputWriter           = $outputWriter;
        $this->migrationFinder        = $migrationFinder;
        $this->queryWriter            = $queryWriter;
        $this->dependencyFactory      = $dependencyFactory;
        $this->migrationsColumnLength = strlen($this->createDateTime()->format(self::VERSION_FORMAT));
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getConnection() : Connection
    {
        return $this->connection;
    }

    public function setMigrationsTableName(string $tableName) : void
    {
        $this->migrationsTableName = $tableName;
    }

    public function getMigrationsTableName() : string
    {
        return $this->migrationsTableName;
    }

    public function setMigrationsColumnName(string $columnName) : void
    {
        $this->migrationsColumnName = $columnName;
    }

    public function getMigrationsColumnName() : string
    {
        return $this->migrationsColumnName;
    }

    public function getQuotedMigrationsColumnName() : string
    {
        return $this->getDependencyFactory()
            ->getTrackingTableDefinition()
            ->getMigrationsColumn()
            ->getQuotedName($this->connection->getDatabasePlatform());
    }

    public function setMigrationsColumnLength(int $columnLength) : void
    {
        $this->migrationsColumnLength = $columnLength;
    }

    public function getMigrationsColumnLength() : int
    {
        return $this->migrationsColumnLength;
    }

    public function setMigrationsExecutedAtColumnName(string $migrationsExecutedAtColumnName) : void
    {
        $this->migrationsExecutedAtColumnName = $migrationsExecutedAtColumnName;
    }

    public function getMigrationsExecutedAtColumnName() : string
    {
        return $this->migrationsExecutedAtColumnName;
    }

    public function getQuotedMigrationsExecutedAtColumnName() : string
    {
        return $this->getDependencyFactory()
            ->getTrackingTableDefinition()
            ->getExecutedAtColumn()
            ->getQuotedName($this->connection->getDatabasePlatform());
    }

    public function setMigrationsDirectory(string $migrationsDirectory) : void
    {
        $this->migrationsDirectory = $migrationsDirectory;
    }

    public function getMigrationsDirectory() : ?string
    {
        return $this->migrationsDirectory;
    }

    public function setMigrationsNamespace(string $migrationsNamespace) : void
    {
        $this->migrationsNamespace = $migrationsNamespace;
    }

    public function getMigrationsNamespace() : ?string
    {
        return $this->migrationsNamespace;
    }

    public function setCustomTemplate(?string $customTemplate) : void
    {
        $this->customTemplate = $customTemplate;
    }

    public function getCustomTemplate() : ?string
    {
        return $this->customTemplate;
    }

    public function areMigrationsOrganizedByYear() : bool
    {
        return $this->migrationsAreOrganizedByYear;
    }

    /**
     * @throws MigrationException
     */
    public function setMigrationsAreOrganizedByYear(
        bool $migrationsAreOrganizedByYear = true
    ) : void {
        $this->ensureOrganizeMigrationsIsCompatibleWithFinder();

        $this->migrationsAreOrganizedByYear = $migrationsAreOrganizedByYear;
    }

    /**
     * @throws MigrationException
     */
    public function setMigrationsAreOrganizedByYearAndMonth(
        bool $migrationsAreOrganizedByYearAndMonth = true
    ) : void {
        $this->ensureOrganizeMigrationsIsCompatibleWithFinder();

        $this->migrationsAreOrganizedByYear         = $migrationsAreOrganizedByYearAndMonth;
        $this->migrationsAreOrganizedByYearAndMonth = $migrationsAreOrganizedByYearAndMonth;
    }

    public function areMigrationsOrganizedByYearAndMonth() : bool
    {
        return $this->migrationsAreOrganizedByYearAndMonth;
    }

    /** @throws MigrationException */
    public function setMigrationsFinder(MigrationFinder $migrationFinder) : void
    {
        if (($this->migrationsAreOrganizedByYear || $this->migrationsAreOrganizedByYearAndMonth)
            && ! ($migrationFinder instanceof MigrationDeepFinder)) {
            throw ParameterIncompatibleWithFinder::new(
                'organize-migrations',
                $migrationFinder
            );
        }

        $this->migrationFinder = $migrationFinder;
    }

    public function getMigrationsFinder() : MigrationFinder
    {
        if ($this->migrationFinder === null) {
            $this->migrationFinder = $this->getDependencyFactory()->getRecursiveRegexFinder();
        }

        return $this->migrationFinder;
    }

    /** @throws MigrationException */
    public function validate() : void
    {
        if ($this->migrationsNamespace === null) {
            throw MigrationsNamespaceRequired::new();
        }

        if ($this->migrationsDirectory === null) {
            throw MigrationsDirectoryRequired::new();
        }
    }

    public function hasVersionMigrated(Version $version) : bool
    {
        return $this->getDependencyFactory()->getMigrationRepository()->hasVersionMigrated($version);
    }

    /**
     * @return mixed[]
     */
    public function getVersionData(Version $version) : ?array
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getVersionData($version);
    }

    public function resolveVersionAlias(string $alias) : ?string
    {
        return $this->getDependencyFactory()->getVersionAliasResolver()->resolveVersionAlias($alias);
    }

    public function setIsDryRun(bool $isDryRun) : void
    {
        $this->isDryRun = $isDryRun;
    }

    public function isDryRun() : bool
    {
        return $this->isDryRun;
    }

    public function setAllOrNothing(bool $allOrNothing) : void
    {
        $this->allOrNothing = $allOrNothing;
    }

    public function isAllOrNothing() : bool
    {
        return $this->allOrNothing;
    }

    public function setCheckDatabasePlatform(bool $checkDbPlatform) : void
    {
        $this->checkDbPlatform = $checkDbPlatform;
    }

    public function isDatabasePlatformChecked() : bool
    {
        return $this->checkDbPlatform;
    }

    public function isMigrationTableCreated() : bool
    {
        return $this->getDependencyFactory()->getTrackingTableStatus()->isCreated();
    }

    public function createMigrationTable() : bool
    {
        return $this->getDependencyFactory()->getTrackingTableManipulator()->createMigrationTable();
    }

    public function getDateTime(string $version) : string
    {
        $datetime = str_replace('Version', '', $version);
        $datetime = DateTimeImmutable::createFromFormat(self::VERSION_FORMAT, $datetime);

        if ($datetime === false) {
            return '';
        }

        return $datetime->format('Y-m-d H:i:s');
    }

    public function generateVersionNumber(?DateTimeInterface $now = null) : string
    {
        $now = $now ?: $this->createDateTime();

        return $now->format(self::VERSION_FORMAT);
    }

    /**
     * Explicitely opens the database connection. This is done to play nice
     * with DBAL's MasterSlaveConnection. Which, in some cases, connects to a
     * follower when fetching the executed migrations. If a follower is lagging
     * significantly behind that means the migrations system may see unexecuted
     * migrations that were actually executed earlier.
     */
    public function connect() : bool
    {
        if ($this->connection instanceof MasterSlaveConnection) {
            return $this->connection->connect('master');
        }

        return $this->connection->connect();
    }

    public function dispatchMigrationEvent(string $eventName, string $direction, bool $dryRun) : void
    {
        $this->getDependencyFactory()->getEventDispatcher()->dispatchMigrationEvent(
            $eventName,
            $direction,
            $dryRun
        );
    }

    public function dispatchVersionEvent(
        Version $version,
        string $eventName,
        string $direction,
        bool $dryRun
    ) : void {
        $this->getDependencyFactory()->getEventDispatcher()->dispatchVersionEvent(
            $version,
            $eventName,
            $direction,
            $dryRun
        );
    }

    public function dispatchEvent(string $eventName, ?EventArgs $args = null) : void
    {
        $this->getDependencyFactory()->getEventDispatcher()->dispatchEvent(
            $eventName,
            $args
        );
    }

    public function getNumberOfExecutedMigrations() : int
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getNumberOfExecutedMigrations();
    }

    public function getNumberOfAvailableMigrations() : int
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getNumberOfAvailableMigrations();
    }

    public function getLatestVersion() : string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getLatestVersion();
    }

    /** @return string[] */
    public function getMigratedVersions() : array
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getMigratedVersions();
    }

    /** @return string[] */
    public function getAvailableVersions() : array
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getAvailableVersions();
    }

    public function getCurrentVersion() : string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getCurrentVersion();
    }

    /** @return Version[] */
    public function registerMigrationsFromDirectory(string $path) : array
    {
        $this->validate();

        return $this->getDependencyFactory()->getMigrationRepository()->registerMigrationsFromDirectory($path);
    }

    /** @throws MigrationException */
    public function registerMigration(string $version, string $class) : Version
    {
        return $this->getDependencyFactory()->getMigrationRepository()->registerMigration($version, $class);
    }

    /**
     * @param string[] $migrations
     *
     * @return Version[]
     */
    public function registerMigrations(array $migrations) : array
    {
        return $this->getDependencyFactory()->getMigrationRepository()->registerMigrations($migrations);
    }

    /**
     * @return Version[]
     */
    public function getMigrations() : array
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getMigrations();
    }

    public function getVersion(string $version) : Version
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getVersion($version);
    }

    public function hasVersion(string $version) : bool
    {
        return $this->getDependencyFactory()->getMigrationRepository()->hasVersion($version);
    }

    /** @return Version[] */
    public function getMigrationsToExecute(string $direction, string $to) : array
    {
        return $this->getDependencyFactory()->getMigrationPlanCalculator()->getMigrationsToExecute($direction, $to);
    }

    public function getPrevVersion() : ?string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getPrevVersion();
    }

    public function getNextVersion() : ?string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getNextVersion();
    }

    public function getRelativeVersion(string $version, int $delta) : ?string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getRelativeVersion($version, $delta);
    }

    public function getDeltaVersion(string $delta) : ?string
    {
        return $this->getDependencyFactory()->getMigrationRepository()->getDeltaVersion($delta);
    }

    public function setOutputWriter(OutputWriter $outputWriter) : void
    {
        $this->outputWriter = $outputWriter;
    }

    public function getOutputWriter() : OutputWriter
    {
        if ($this->outputWriter === null) {
            $this->outputWriter = $this->getDependencyFactory()->getOutputWriter();
        }

        return $this->outputWriter;
    }

    public function getQueryWriter() : QueryWriter
    {
        if ($this->queryWriter === null) {
            $this->queryWriter = $this->getDependencyFactory()->getQueryWriter();
        }

        return $this->queryWriter;
    }

    public function getDependencyFactory() : DependencyFactory
    {
        if ($this->dependencyFactory === null) {
            $this->dependencyFactory = new DependencyFactory($this);
        }

        return $this->dependencyFactory;
    }

    /**
     * @throws MigrationException
     */
    private function ensureOrganizeMigrationsIsCompatibleWithFinder() : void
    {
        if (! ($this->getMigrationsFinder() instanceof MigrationDeepFinder)) {
            throw ParameterIncompatibleWithFinder::new(
                'organize-migrations',
                $this->getMigrationsFinder()
            );
        }
    }

    private function createDateTime() : DateTimeImmutable
    {
        return new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
