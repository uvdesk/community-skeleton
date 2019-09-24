<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Connection\Loader;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoaderInterface;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * The ConnectionHelperLoader is responsible for loading a Doctrine\DBAL\Connection from a Symfony Console HelperSet.
 *
 * @internal
 */
class ConnectionHelperLoader implements ConnectionLoaderInterface
{
    /** @var string */
    private $helperName;

    /** @var  HelperSet */
    private $helperSet;

    public function __construct(?HelperSet $helperSet = null, string $helperName)
    {
        $this->helperName = $helperName;

        if ($helperSet === null) {
            $helperSet = new HelperSet();
        }

        $this->helperSet = $helperSet;
    }

    /**
     * Read the input and return a Configuration, returns null if the config
     * is not supported.
     */
    public function chosen() : ?Connection
    {
        if ($this->helperSet->has($this->helperName)) {
            $connectionHelper = $this->helperSet->get($this->helperName);

            if ($connectionHelper instanceof ConnectionHelper) {
                return $connectionHelper->getConnection();
            }
        }

        return null;
    }
}
