<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Exception;

use LogicException;

final class YamlNotAvailable extends LogicException implements ConfigurationException
{
    public static function new() : self
    {
        return new self(
            'Unable to load yaml configuration files, please run '
            . '`composer require symfony/yaml` to load yaml configuration files.'
        );
    }
}
