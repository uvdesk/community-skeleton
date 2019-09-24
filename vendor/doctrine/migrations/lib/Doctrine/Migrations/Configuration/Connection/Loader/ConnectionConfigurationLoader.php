<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Connection\Loader;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoaderInterface;

/**
 * The ConnectionConfigurationLoader class is responsible for loading a Doctrine\DBAL\Connection from the Migrations
 * Doctrine\Migrations\Configuration\Configuration::getConnection() method.
 *
 * @internal
 */
class ConnectionConfigurationLoader implements ConnectionLoaderInterface
{
    /** @var Configuration|null */
    private $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        $this->configuration = $configuration;
    }

    /**
     * Read the input and return a Configuration, returns null if the config
     * is not supported.
     */
    public function chosen() : ?Connection
    {
        if ($this->configuration !== null) {
            return $this->configuration->getConnection();
        }

        return null;
    }
}
