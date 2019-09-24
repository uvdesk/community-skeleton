<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoaderInterface;
use Doctrine\Migrations\Configuration\Connection\Loader\ArrayConnectionConfigurationLoader;
use Doctrine\Migrations\Configuration\Connection\Loader\ConnectionConfigurationChainLoader;
use Doctrine\Migrations\Configuration\Connection\Loader\ConnectionConfigurationLoader;
use Doctrine\Migrations\Configuration\Connection\Loader\ConnectionHelperLoader;
use Doctrine\Migrations\Tools\Console\Exception\ConnectionNotSpecified;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;

/**
 * The ConnectionLoader class is responsible for loading the Doctrine\DBAL\Connection instance to use for migrations.
 *
 * @internal
 */
class ConnectionLoader
{
    /** @var Configuration|null */
    private $configuration;

    public function __construct(?Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConnection(InputInterface $input, HelperSet $helperSet) : Connection
    {
        $connection = $this->createConnectionConfigurationChainLoader($input, $helperSet)
            ->chosen();

        if ($connection !== null) {
            return $connection;
        }

        throw ConnectionNotSpecified::new();
    }

    protected function createConnectionConfigurationChainLoader(
        InputInterface $input,
        HelperSet $helperSet
    ) : ConnectionLoaderInterface {
        return new ConnectionConfigurationChainLoader([
            new ArrayConnectionConfigurationLoader($input->getOption('db-configuration')),
            new ArrayConnectionConfigurationLoader('migrations-db.php'),
            new ConnectionHelperLoader($helperSet, 'connection'),
            new ConnectionConfigurationLoader($this->configuration),
        ]);
    }
}
