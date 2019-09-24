<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use LogicException;
use function sprintf;

final class InvalidConfigurationKey extends LogicException implements ConfigurationException
{
    public static function new(string $key) : self
    {
        return new self(sprintf('Migrations configuration key "%s" does not exist.', $key), 10);
    }
}
