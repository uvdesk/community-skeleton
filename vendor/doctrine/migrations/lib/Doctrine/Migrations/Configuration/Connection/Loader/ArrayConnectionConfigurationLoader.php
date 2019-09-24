<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Connection\Loader;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoaderInterface;
use Doctrine\Migrations\Configuration\Connection\Loader\Exception\InvalidConfiguration;
use function file_exists;
use function is_array;

/**
 * The ArrayConnectionConfigurationLoader class is responsible for loading a Doctrine\DBAL\Connection from a PHP file
 * that returns an array of connection information which is used to instantiate a connection with DriverManager::getConnection()
 *
 * @internal
 */
class ArrayConnectionConfigurationLoader implements ConnectionLoaderInterface
{
    /** @var string|null */
    private $filename;

    public function __construct(?string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Read the input and return a Configuration, returns null if the config
     * is not supported.
     *
     * @throws InvalidConfiguration
     */
    public function chosen() : ?Connection
    {
        if ($this->filename === null) {
            return null;
        }

        if (! file_exists($this->filename)) {
            return null;
        }

        $params = include $this->filename;

        if (! is_array($params)) {
            throw InvalidConfiguration::invalidArrayConfiguration();
        }

        return DriverManager::getConnection($params);
    }
}
