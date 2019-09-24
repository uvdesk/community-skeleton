<?php

$container->loadFromExtension('swiftmailer', [
    'default_mailer' => 'failover',
    'mailers' => [
        'failover' => null,
    ],
]);
