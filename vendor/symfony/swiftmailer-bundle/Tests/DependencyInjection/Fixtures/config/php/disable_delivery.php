<?php

$container->loadFromExtension('swiftmailer', [
    'default_mailer' => 'mailer_on',
    'mailers' => [
        'mailer_on' => null,
        'mailer_off' => ['disable_delivery' => true],
    ],
]);
