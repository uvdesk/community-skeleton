<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use LogicException;

final class JsonNotValid extends LogicException implements ConfigurationException
{
    public static function new() : self
    {
        return new self('Configuration is not valid JSON.', 10);
    }
}
