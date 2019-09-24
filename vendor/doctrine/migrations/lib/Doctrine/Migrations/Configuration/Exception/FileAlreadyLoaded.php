<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use LogicException;

final class FileAlreadyLoaded extends LogicException implements ConfigurationException
{
    public static function new() : self
    {
        return new self('Migrations configuration file already loaded', 8);
    }
}
