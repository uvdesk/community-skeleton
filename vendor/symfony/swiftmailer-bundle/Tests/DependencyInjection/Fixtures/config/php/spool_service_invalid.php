<?php

$container->loadFromExtension('swiftmailer', [
    'spool' => ['type' => 'service'],
]);
