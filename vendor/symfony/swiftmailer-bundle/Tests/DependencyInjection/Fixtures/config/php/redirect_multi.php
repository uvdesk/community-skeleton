<?php

$container->loadFromExtension('swiftmailer', [
    'delivery_addresses' => ['first@host.com', 'second@host.com'],
]);
