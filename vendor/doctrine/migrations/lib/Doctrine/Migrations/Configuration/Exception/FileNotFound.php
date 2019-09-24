<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use InvalidArgumentException;

final class FileNotFound extends InvalidArgumentException implements ConfigurationException
{
    public static function new() : self
    {
        return new self('Given config file does not exist');
    }
}
