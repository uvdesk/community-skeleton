<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Exception;

use InvalidArgumentException;

final class FileTypeNotSupported extends InvalidArgumentException implements ConsoleException
{
    public static function new() : self
    {
        return new self('Given config file type is not supported');
    }
}
