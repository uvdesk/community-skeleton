<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;

final class NoMigrationsToExecute extends RuntimeException implements MigrationException
{
    public static function new() : self
    {
        return new self(
            'Could not find any migrations to execute.',
            4
        );
    }
}
