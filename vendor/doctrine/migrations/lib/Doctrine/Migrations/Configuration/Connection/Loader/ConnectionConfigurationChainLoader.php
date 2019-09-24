<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Connection\Loader;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoaderInterface;
use Doctrine\Migrations\Configuration\Connection\Loader\Exception\InvalidConfiguration;

/**
 * The ConnectionConfigurationChainLoader class is responsible for loading a Doctrine\DBAL\Connection from an array of
 * loaders. The first one to return a Connection is used.
 *
 * @internal
 */
final class ConnectionConfigurationChainLoader implements ConnectionLoaderInterface
{
    /** @var ConnectionLoaderInterface[] */
    private $loaders = [];

    /**
     * @param ConnectionLoaderInterface[] $loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = $loaders;
    }

    /**
     * Read the input and return a Configuration, returns null if the config
     * is not supported.
     *
     * @throws InvalidConfiguration
     */
    public function chosen() : ?Connection
    {
        foreach ($this->loaders as $loader) {
            $confObj = $loader->chosen();

            if ($confObj !== null) {
                return $confObj;
            }
        }

        return null;
    }
}
