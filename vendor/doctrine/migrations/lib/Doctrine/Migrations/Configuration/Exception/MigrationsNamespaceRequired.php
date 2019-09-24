<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use LogicException;

final class MigrationsNamespaceRequired extends LogicException implements ConfigurationException
{
    public static function new() : self
    {
        return new self(
            'Migrations namespace must be configured in order to use Doctrine migrations.',
            2
        );
    }
}
