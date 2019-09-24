<?php

namespace Doctrine\DBAL\Tools\Console;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Version;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Handles running the Console Tools inside Symfony Console context.
 */
class ConsoleRunner
{
    /**
     * Create a Symfony Console HelperSet
     *
     * @return HelperSet
     */
    public static function createHelperSet(Connection $connection)
    {
        return new HelperSet([
            'db' => new ConnectionHelper($connection),
        ]);
    }

    /**
     * Runs console with the given helperset.
     *
     * @param Command[] $commands
     *
     * @return void
     */
    public static function run(HelperSet $helperSet, $commands = [])
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);

        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);

        self::addCommands($cli);

        $cli->addCommands($commands);
        $cli->run();
    }

    /**
     * @return void
     */
    public static function addCommands(Application $cli)
    {
        $cli->addCommands([
            new RunSqlCommand(),
            new ImportCommand(),
            new ReservedWordsCommand(),
        ]);
    }

    /**
     * Prints the instructions to create a configuration file
     */
    public static function printCliConfigTemplate()
    {
        echo <<<'HELP'
You are missing a "cli-config.php" or "config/cli-config.php" file in your
project, which is required to get the Doctrine-DBAL Console working. You can use the
following sample as a template:

<?php
use Doctrine\DBAL\Tools\Console\ConsoleRunner;

// replace with the mechanism to retrieve DBAL connection in your app
$connection = getDBALConnection();

// You can append new commands to $commands array, if needed

return ConsoleRunner::createHelperSet($connection);

HELP;
    }
}
