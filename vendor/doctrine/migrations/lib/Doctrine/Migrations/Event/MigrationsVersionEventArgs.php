<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Event;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Version\Version;

/**
 * The MigrationsVersionEventArgs class is passed to events related to a single migration version.
 */
class MigrationsVersionEventArgs extends MigrationsEventArgs
{
    /** @var Version */
    private $version;

    public function __construct(
        Version $version,
        Configuration $config,
        string $direction,
        bool $dryRun
    ) {
        parent::__construct($config, $direction, $dryRun);

        $this->version = $version;
    }

    public function getVersion() : Version
    {
        return $this->version;
    }
}
