<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Version;

use Doctrine\Migrations\Configuration\Configuration;

/**
 * The Factory class is responsible for creating instances of the Version class for a version number
 * and a migration class name.
 *
 * @var internal
 */
class Factory
{
    /** @var Configuration */
    private $configuration;

    /** @var ExecutorInterface */
    private $versionExecutor;

    public function __construct(Configuration $configuration, ExecutorInterface $versionExecutor)
    {
        $this->configuration   = $configuration;
        $this->versionExecutor = $versionExecutor;
    }

    public function createVersion(string $version, string $migrationClassName) : Version
    {
        return new Version(
            $this->configuration,
            $version,
            $migrationClassName,
            $this->versionExecutor
        );
    }
}
