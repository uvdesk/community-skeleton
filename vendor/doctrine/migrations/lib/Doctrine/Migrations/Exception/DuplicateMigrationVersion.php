<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Exception;

use RuntimeException;
use function sprintf;

final class DuplicateMigrationVersion extends RuntimeException implements MigrationException
{
    public static function new(string $version, string $class) : self
    {
        return new self(
            sprintf(
                'Migration version %s already registered with class %s',
                $version,
                $class
            ),
            7
        );
    }
}
