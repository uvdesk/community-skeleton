<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Helper;

use Doctrine\Migrations\Configuration\Configuration;
use Symfony\Component\Console\Input\InputInterface;

/**
 * The ConfigurationHelperInterface defines the interface for getting the Configuration instance to be used for migrations.
 */
interface ConfigurationHelperInterface
{
    public function getMigrationConfig(
        InputInterface $input
    ) : Configuration;
}
