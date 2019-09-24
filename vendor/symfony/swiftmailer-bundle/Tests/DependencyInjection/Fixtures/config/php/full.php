<?php

$container->loadFromExtension('swiftmailer', [
    'transport' => 'smtp',
    'username' => 'user',
    'password' => 'pass',
    'host' => 'example.org',
    'port' => '12345',
    'encryption' => 'tls',
    'auth-mode' => 'login',
    'timeout' => '1000',
    'source_ip' => '127.0.0.1',
    'local_domain' => 'local.example.com',
    'logging' => true,
    'spool' => ['type' => 'memory'],
    'delivery_addresses' => ['single@host.com'],
    'delivery_whitelist' => ['/foo@.*/', '/.*@bar.com$/'],
]);
