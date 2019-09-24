<?php

use Doctrine\DBAL\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\HelperSet;

$files       = [__DIR__ . '/../vendor/autoload.php', __DIR__ . '/../../../autoload.php'];
$loader      = null;
$cwd         = getcwd();
$directories = [$cwd, $cwd . DIRECTORY_SEPARATOR . 'config'];
$configFile  = null;

foreach ($files as $file) {
    if (file_exists($file)) {
        $loader = require $file;

        break;
    }
}

if (! $loader) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

foreach ($directories as $directory) {
    $configFile = $directory . DIRECTORY_SEPARATOR . 'cli-config.php';

    if (file_exists($configFile)) {
        break;
    }
}

if (! file_exists($configFile)) {
    ConsoleRunner::printCliConfigTemplate();

    exit(1);
}

if (! is_readable($configFile)) {
    echo 'Configuration file [' . $configFile . '] does not have read permission.' . PHP_EOL;

    exit(1);
}

$commands  = [];
$helperSet = require $configFile;

if (! $helperSet instanceof HelperSet) {
    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof HelperSet) {
            $helperSet = $helperSetCandidate;

            break;
        }
    }
}

ConsoleRunner::run($helperSet, $commands);
