<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $env = dirname(__DIR__).'/.env';
    $var = dirname(__DIR__).'/var';
    $config = dirname(__DIR__).'/config';
    $public = dirname(__DIR__).'/public';
    $migrations = dirname(__DIR__).'/migrations';
    
    $files = [
        'env' => $env,
        'var' => $var,
        'config' => $config,
        'public' => $public,
        'migrations' => $migrations
    ];
    
    foreach ($files as $file) {
        if (file_exists($file)) {
            chmod($file, 0775);
        }
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
