<?php

declare(strict_types=1);

namespace Doctrine\Bundle\MigrationsBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand as BaseCommand;
use Doctrine\Migrations\Configuration\AbstractFileConfiguration;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Version\Version;
use ErrorException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use function error_get_last;
use function is_dir;
use function method_exists;
use function mkdir;
use function preg_match;
use function sprintf;
use function str_replace;

/**
 * Base class for Doctrine console commands to extend from.
 */
abstract class DoctrineCommand extends BaseCommand
{
    public static function configureMigrations(ContainerInterface $container, Configuration $configuration) : void
    {
        $dir = $configuration->getMigrationsDirectory();

        if (empty($dir)) {
            $dir = $container->getParameter('doctrine_migrations.dir_name');

            if (! is_dir($dir) && ! @mkdir($dir, 0777, true) && ! is_dir($dir)) {
                $error = error_get_last();

                throw new ErrorException(sprintf(
                    'Failed to create directory "%s" with message "%s"',
                    $dir,
                    $error['message']
                ));
            }

            $configuration->setMigrationsDirectory($dir);
        } else {
            // class Kernel has method getKernelParameters with some of the important path parameters
            $pathPlaceholderArray = ['kernel.root_dir', 'kernel.cache_dir', 'kernel.logs_dir'];

            foreach ($pathPlaceholderArray as $pathPlaceholder) {
                if (! $container->hasParameter($pathPlaceholder) || ! preg_match('/\%' . $pathPlaceholder . '\%/', $dir)) {
                    continue;
                }

                $dir = str_replace('%' . $pathPlaceholder . '%', $container->getParameter($pathPlaceholder), $dir);
            }

            if (! is_dir($dir) && ! @mkdir($dir, 0777, true) && ! is_dir($dir)) {
                $error = error_get_last();

                throw new ErrorException(sprintf(
                    'Failed to create directory "%s" with message "%s"',
                    $dir,
                    $error['message']
                ));
            }

            $configuration->setMigrationsDirectory($dir);
        }

        if (empty($configuration->getMigrationsNamespace())) {
            $configuration->setMigrationsNamespace($container->getParameter('doctrine_migrations.namespace'));
        }

        if (empty($configuration->getName())) {
            $configuration->setName($container->getParameter('doctrine_migrations.name'));
        }

        // For backward compatibility, need use a table from parameters for overwrite the default configuration
        if (! ($configuration instanceof AbstractFileConfiguration) || empty($configuration->getMigrationsTableName())) {
            $configuration->setMigrationsTableName($container->getParameter('doctrine_migrations.table_name'));
        }

        $configuration->setMigrationsColumnName($container->getParameter('doctrine_migrations.column_name'));
        $configuration->setMigrationsColumnLength($container->getParameter('doctrine_migrations.column_length'));
        $configuration->setMigrationsExecutedAtColumnName($container->getParameter('doctrine_migrations.executed_at_column_name'));
        $configuration->setAllOrNothing($container->getParameter('doctrine_migrations.all_or_nothing'));

        // Migrations is not register from configuration loader
        if (! ($configuration instanceof AbstractFileConfiguration)) {
            $migrationsDirectory = $configuration->getMigrationsDirectory();

            if ($migrationsDirectory !== null) {
                $configuration->registerMigrationsFromDirectory($migrationsDirectory);
            }
        }

        if (method_exists($configuration, 'getCustomTemplate') && empty($configuration->getCustomTemplate())) {
            $configuration->setCustomTemplate($container->getParameter('doctrine_migrations.custom_template'));
        }

        $organizeMigrations = $container->getParameter('doctrine_migrations.organize_migrations');

        switch ($organizeMigrations) {
            case Configuration::VERSIONS_ORGANIZATION_BY_YEAR:
                $configuration->setMigrationsAreOrganizedByYear(true);
                break;

            case Configuration::VERSIONS_ORGANIZATION_BY_YEAR_AND_MONTH:
                $configuration->setMigrationsAreOrganizedByYearAndMonth(true);
                break;

            case false:
                break;

            default:
                throw new InvalidArgumentException('Invalid value for "doctrine_migrations.organize_migrations" parameter.');
        }

        self::injectContainerToMigrations($container, $configuration->getMigrations());
    }

    /**
     * @param Version[] $versions
     *
     * Injects the container to migrations aware of it
     */
    private static function injectContainerToMigrations(ContainerInterface $container, array $versions) : void
    {
        foreach ($versions as $version) {
            $migration = $version->getMigration();
            if (! ($migration instanceof ContainerAwareInterface)) {
                continue;
            }

            $migration->setContainer($container);
        }
    }
}
