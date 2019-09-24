#!/usr/bin/env php
<?php

if (!file_exists(dirname(__DIR__).'/vendor/symfony/phpunit-bridge/bin/simple-phpunit.php')) {
    echo "Unable to find the `simple-phpunit.php` script in `vendor/symfony/phpunit-bridge/bin/`.\n";
    exit(1);
}

if (false === getenv('SYMFONY_PHPUNIT_DIR')) {
    putenv('SYMFONY_PHPUNIT_DIR='.__DIR__.'/.phpunit');
}

require dirname(__DIR__).'/vendor/symfony/phpunit-bridge/bin/simple-phpunit.php';
