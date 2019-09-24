<?php

require __DIR__.'/../vendor/autoload.php';

define('FLEX_TEST_DIR', dirname(__DIR__).'/build');

if (is_dir($buildDir = FLEX_TEST_DIR)) {
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($buildDir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        ($fileinfo->isDir() ? 'rmdir' : 'unlink')($fileinfo->getRealPath());
    }

    rmdir($buildDir);
}
