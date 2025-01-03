<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // Function to check if we're running inside a Docker container
    function isRunningInDocker(): bool {
        return (
            file_exists('/.dockerenv') || // Check for Docker environment file
            (getenv('DOCKER_CONTAINER') !== false) || // Check for Docker environment variable
            strpos(file_get_contents('/proc/1/cgroup'), 'docker') !== false // Check cgroup
        );
    }

    // Only attempt to set permissions if we're NOT in Docker
    if (! isRunningInDocker()) {
        $basePath = dirname(__DIR__);
        $files = [
            'env'        => $basePath . '/.env',
            'var'        => $basePath . '/var',
            'config'     => $basePath . '/config',
            'public'     => $basePath . '/public',
            'migrations' => $basePath . '/migrations',
        ];

        foreach ($files as $key => $file) {
            if (file_exists($file)) {
                try {
                    chmod($file, 0775);
                } catch (\Exception $e) {
                    // Log the error if you have a logger configured
                    error_log("Failed to set permissions for {$key}: " . $e->getMessage());
                }
            }
        }
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};