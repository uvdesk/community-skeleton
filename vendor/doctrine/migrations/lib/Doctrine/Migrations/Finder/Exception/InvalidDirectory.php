<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Finder\Exception;

use InvalidArgumentException;
use function sprintf;

final class InvalidDirectory extends InvalidArgumentException implements FinderException
{
    public static function new(string $directory) : self
    {
        return new self(sprintf('Cannot load migrations from "%s" because it is not a valid directory', $directory));
    }
}
