<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class MigrationsDirectoryRequired extends RuntimeException implements MigrationException
{
    public static function new() : self
    {
        return new self(
            'Migrations directory must be configured in order to use Doctrine migrations.',
            3
        );
    }
}
