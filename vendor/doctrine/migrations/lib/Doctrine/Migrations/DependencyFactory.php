<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Finder\RecursiveRegexFinder;
use Doctrine\Migrations\Generator\FileBuilder;
use Doctrine\Migrations\Generator\Generator;
use Doctrine\Migrations\Generator\SqlGenerator;
use Doctrine\Migrations\Provider\LazySchemaDiffProvider;
use Doctrine\Migrations\Provider\SchemaDiffProvider;
use Doctrine\Migrations\Provider\SchemaDiffProviderInterface;
use Doctrine\Migrations\Tools\Console\Helper\MigrationStatusInfosHelper;
use Doctrine\Migrations\Tracking\TableDefinition;
use Doctrine\Migrations\Tracking\TableManipulator;
use Doctrine\Migrations\Tracking\TableStatus;
use Doctrine\Migrations\Tracking\TableUpdater;
use Doctrine\Migrations\Version\AliasResolver;
use Doctrine\Migrations\Version\Executor;
use Doctrine\Migrations\Version\Factory;
use Symfony\Component\Stopwatch\Stopwatch as SymfonyStopwatch;

/**
 * The DepenencyFactory is responsible for wiring up and managing internal class dependencies.
 *
 * @internal
 */
class DependencyFactory
{
    /** @var Configuration */
    private $configuration;

    /** @var object[] */
    private $dependencies = [];

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getEventDispatcher() : EventDispatcher
    {
        return $this->getDependency(EventDispatcher::class, function () : EventDispatcher {
            return new EventDispatcher(
                $this->configuration,
                $this->getConnection()->getEventManager()
            );
        });
    }

    public function getSchemaDumper() : SchemaDumper
    {
        return $this->getDependency(SchemaDumper::class, function () : SchemaDumper {
            return new SchemaDumper(
                $this->getConnection()->getDatabasePlatform(),
                $this->getConnection()->getSchemaManager(),
                $this->getMigrationGenerator(),
                $this->getMigrationSqlGenerator()
            );
        });
    }

    public function getSchemaDiffProvider() : SchemaDiffProviderInterface
    {
        return $this->getDependency(SchemaDiffProviderInterface::class, function () : LazySchemaDiffProvider {
            return LazySchemaDiffProvider::fromDefaultProxyFactoryConfiguration(
                new SchemaDiffProvider(
                    $this->getConnection()->getSchemaManager(),
                    $this->getConnection()->getDatabasePlatform()
                )
            );
        });
    }

    public function getFileBuilder() : FileBuilder
    {
        return $this->getDependency(FileBuilder::class, function () : FileBuilder {
            return new FileBuilder(
                $this->getConnection()->getDatabasePlatform(),
                $this->configuration->getMigrationsTableName(),
                $this->configuration->getQuotedMigrationsColumnName(),
                $this->configuration->getQuotedMigrationsExecutedAtColumnName()
            );
        });
    }

    public function getParameterFormatter() : ParameterFormatterInterface
    {
        return $this->getDependency(ParameterFormatter::class, function () : ParameterFormatter {
            return new ParameterFormatter($this->getConnection());
        });
    }

    public function getMigrationRepository() : MigrationRepository
    {
        return $this->getDependency(MigrationRepository::class, function () : MigrationRepository {
            return new MigrationRepository(
                $this->configuration,
                $this->getConnection(),
                $this->configuration->getMigrationsFinder(),
                new Factory($this->configuration, $this->getVersionExecutor())
            );
        });
    }

    public function getTrackingTableManipulator() : TableManipulator
    {
        return $this->getDependency(TableManipulator::class, function () : TableManipulator {
            return new TableManipulator(
                $this->configuration,
                $this->getConnection()->getSchemaManager(),
                $this->getTrackingTableDefinition(),
                $this->getTrackingTableStatus(),
                $this->getTrackingTableUpdater()
            );
        });
    }

    public function getTrackingTableDefinition() : TableDefinition
    {
        return $this->getDependency(TableDefinition::class, function () : TableDefinition {
            return new TableDefinition(
                $this->getConnection()->getSchemaManager(),
                $this->configuration->getMigrationsTableName(),
                $this->configuration->getMigrationsColumnName(),
                $this->configuration->getMigrationsColumnLength(),
                $this->configuration->getMigrationsExecutedAtColumnName()
            );
        });
    }

    public function getTrackingTableStatus() : TableStatus
    {
        return $this->getDependency(TableStatus::class, function () : TableStatus {
            return new TableStatus(
                $this->getConnection()->getSchemaManager(),
                $this->getTrackingTableDefinition()
            );
        });
    }

    public function getTrackingTableUpdater() : TableUpdater
    {
        return $this->getDependency(TableUpdater::class, function () : TableUpdater {
            return new TableUpdater(
                $this->getConnection(),
                $this->getConnection()->getSchemaManager(),
                $this->getTrackingTableDefinition(),
                $this->getConnection()->getDatabasePlatform()
            );
        });
    }

    public function getVersionExecutor() : Executor
    {
        return $this->getDependency(Executor::class, function () : Executor {
            return new Executor(
                $this->configuration,
                $this->getConnection(),
                $this->getSchemaDiffProvider(),
                $this->getOutputWriter(),
                $this->getParameterFormatter(),
                $this->getStopwatch()
            );
        });
    }

    public function getQueryWriter() : FileQueryWriter
    {
        return $this->getDependency(FileQueryWriter::class, function () : FileQueryWriter {
            return new FileQueryWriter(
                $this->getOutputWriter(),
                $this->getFileBuilder()
            );
        });
    }

    public function getOutputWriter() : OutputWriter
    {
        return $this->getDependency(OutputWriter::class, static function () : OutputWriter {
            return new OutputWriter();
        });
    }

    public function getVersionAliasResolver() : AliasResolver
    {
        return $this->getDependency(AliasResolver::class, function () : AliasResolver {
            return new AliasResolver(
                $this->getMigrationRepository()
            );
        });
    }

    public function getMigrationPlanCalculator() : MigrationPlanCalculator
    {
        return $this->getDependency(MigrationPlanCalculator::class, function () : MigrationPlanCalculator {
            return new MigrationPlanCalculator($this->getMigrationRepository());
        });
    }

    public function getRecursiveRegexFinder() : RecursiveRegexFinder
    {
        return $this->getDependency(RecursiveRegexFinder::class, static function () : RecursiveRegexFinder {
            return new RecursiveRegexFinder();
        });
    }

    public function getMigrationGenerator() : Generator
    {
        return $this->getDependency(Generator::class, function () : Generator {
            return new Generator($this->configuration);
        });
    }

    public function getMigrationSqlGenerator() : SqlGenerator
    {
        return $this->getDependency(SqlGenerator::class, function () : SqlGenerator {
            return new SqlGenerator(
                $this->configuration,
                $this->getConnection()->getDatabasePlatform()
            );
        });
    }

    public function getMigrationStatusInfosHelper() : MigrationStatusInfosHelper
    {
        return $this->getDependency(MigrationStatusInfosHelper::class, function () : MigrationStatusInfosHelper {
            return new MigrationStatusInfosHelper(
                $this->configuration,
                $this->getMigrationRepository()
            );
        });
    }

    public function getMigrator() : Migrator
    {
        return $this->getDependency(Migrator::class, function () : Migrator {
            return new Migrator(
                $this->configuration,
                $this->getMigrationRepository(),
                $this->getOutputWriter(),
                $this->getStopwatch()
            );
        });
    }

    public function getStopwatch() : Stopwatch
    {
        return $this->getDependency(Stopwatch::class, static function () : Stopwatch {
            $symfonyStopwatch = new SymfonyStopwatch(true);

            return new Stopwatch($symfonyStopwatch);
        });
    }

    public function getRollup() : Rollup
    {
        return $this->getDependency(Rollup::class, function () : Rollup {
            return new Rollup(
                $this->configuration,
                $this->getConnection(),
                $this->getMigrationRepository()
            );
        });
    }

    /**
     * @return mixed
     */
    private function getDependency(string $className, callable $callback)
    {
        if (! isset($this->dependencies[$className])) {
            $this->dependencies[$className] = $callback();
        }

        return $this->dependencies[$className];
    }

    private function getConnection() : Connection
    {
        return $this->configuration->getConnection();
    }
}
