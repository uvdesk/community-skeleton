<?php

$container->loadFromExtension('swiftmailer', [
    'transport' => 'sendmail',
    'url' => '%env(SWIFTMAILER_URL)%',
]);
