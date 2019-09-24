<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Provider\Exception;

use UnexpectedValueException;

final class NoMappingFound extends UnexpectedValueException implements ProviderException
{
    public static function new() : self
    {
        return new self('No mapping information to process');
    }
}
