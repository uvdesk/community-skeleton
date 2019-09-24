<?php

$container->loadFromExtension('swiftmailer', [
    'default_mailer' => 'smtp_mailer',
    'mailers' => [
        'smtp_mailer' => [
            'url' => 'smtp://example.com:12345?username=&password=&encryption=&auth_mode=',
        ],
    ],
]);
