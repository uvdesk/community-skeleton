<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Exception;

use InvalidArgumentException;

final class InvalidOptionUsage extends InvalidArgumentException implements ConsoleException
{
    public static function new(string $explanation) : self
    {
        return new self($explanation);
    }
}
