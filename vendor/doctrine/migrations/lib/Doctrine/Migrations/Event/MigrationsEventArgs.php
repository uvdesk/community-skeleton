<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Event;

use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;

/**
 * The MigrationEventsArgs class is passed to events not related to a single migration version.
 */
class MigrationsEventArgs extends EventArgs
{
    /** @var Configuration */
    private $config;

    /** @var string */
    private $direction;

    /** @var bool */
    private $dryRun;

    public function __construct(Configuration $config, string $direction, bool $dryRun)
    {
        $this->config    = $config;
        $this->direction = $direction;
        $this->dryRun    = $dryRun;
    }

    public function getConfiguration() : Configuration
    {
        return $this->config;
    }

    public function getConnection() : Connection
    {
        return $this->config->getConnection();
    }

    public function getDirection() : string
    {
        return $this->direction;
    }

    public function isDryRun() : bool
    {
        return $this->dryRun;
    }
}
