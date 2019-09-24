<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Generator\Exception;

use RuntimeException;

final class NoChangesDetected extends RuntimeException implements GeneratorException
{
    public static function new() : self
    {
        return new self('No changes detected in your mapping information.');
    }
}
