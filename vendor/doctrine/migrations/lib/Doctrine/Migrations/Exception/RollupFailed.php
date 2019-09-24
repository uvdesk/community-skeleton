<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class RollupFailed extends RuntimeException implements MigrationException
{
    public static function noMigrationsFound() : self
    {
        return new self('No migrations found.');
    }

    public static function tooManyMigrations() : self
    {
        return new self('Too many migrations.');
    }
}
