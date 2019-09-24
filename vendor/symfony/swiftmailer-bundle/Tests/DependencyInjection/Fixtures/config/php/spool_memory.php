<?php

$container->loadFromExtension('swiftmailer', [
    'spool' => ['type' => 'memory'],
]);
