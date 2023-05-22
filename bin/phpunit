#!/usr/bin/env php
<?php

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

if (is_file(dirname(__DIR__).'/vendor/phpunit/phpunit/phpunit')) {
    define('PHPUNIT_COMPOSER_INSTALL', dirname(__DIR__).'/vendor/autoload.php');
    require PHPUNIT_COMPOSER_INSTALL;
    PHPUnit\TextUI\Command::main();
} else {
    if (!is_file(dirname(__DIR__).'/vendor/symfony/phpunit-bridge/bin/simple-phpunit.php')) {
        echo "Unable to find the `simple-phpunit.php` script in `vendor/symfony/phpunit-bridge/bin/`.\n";
        exit(1);
    }

    require dirname(__DIR__).'/vendor/symfony/phpunit-bridge/bin/simple-phpunit.php';
}
