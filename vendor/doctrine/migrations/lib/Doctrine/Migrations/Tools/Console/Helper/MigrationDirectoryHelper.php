<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Helper;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Exception\DirectoryDoesNotExist;
use const DIRECTORY_SEPARATOR;
use function assert;
use function date;
use function file_exists;
use function getcwd;
use function mkdir;
use function rtrim;

/**
 * The MigrationDirectoryHelper class is responsible for returning the directory that migrations are stored in.
 *
 * @internal
 */
class MigrationDirectoryHelper
{
    /** @var Configuration */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @throws DirectoryDoesNotExist
     */
    public function getMigrationDirectory() : string
    {
        $dir = $this->configuration->getMigrationsDirectory();
        $dir = $dir ?? getcwd();

        assert($dir !== false, 'Unable to determine current working directory.');

        $dir = rtrim($dir, '/');

        if (! file_exists($dir)) {
            throw DirectoryDoesNotExist::new($dir);
        }

        if ($this->configuration->areMigrationsOrganizedByYear()) {
            $dir .= $this->appendDir(date('Y'));
        }

        if ($this->configuration->areMigrationsOrganizedByYearAndMonth()) {
            $dir .= $this->appendDir(date('m'));
        }

        $this->createDirIfNotExists($dir);

        return $dir;
    }

    private function appendDir(string $dir) : string
    {
        return DIRECTORY_SEPARATOR . $dir;
    }

    private function createDirIfNotExists(string $dir) : void
    {
        if (file_exists($dir)) {
            return;
        }

        mkdir($dir, 0755, true);
    }
}
