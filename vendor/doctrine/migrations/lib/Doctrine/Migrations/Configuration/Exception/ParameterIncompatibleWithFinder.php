<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use Doctrine\Migrations\Finder\MigrationFinder;
use LogicException;
use function get_class;
use function sprintf;

final class ParameterIncompatibleWithFinder extends LogicException implements ConfigurationException
{
    public static function new(string $configurationParameterName, MigrationFinder $finder) : self
    {
        return new self(
            sprintf(
                'Configuration-parameter "%s" cannot be used with finder of type "%s"',
                $configurationParameterName,
                get_class($finder)
            ),
            9
        );
    }
}
