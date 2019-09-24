<?php

$container->loadFromExtension('swiftmailer', [
    'spool' => ['type' => 'service', 'id' => 'custom_service_id'],
]);
