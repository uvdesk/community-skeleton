<?php

$container->loadFromExtension('swiftmailer', [
    'delivery_addresses' => ['single@host.com'],
    'delivery_whitelist' => ['/foo@.*/', '/.*@bar.com$/'],
]);
