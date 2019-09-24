<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Exception;

use Doctrine\Migrations\Version\Version;
use InvalidArgumentException;
use function sprintf;

final class VersionAlreadyExists extends InvalidArgumentException implements ConsoleException
{
    public static function new(Version $version) : self
    {
        return new self(sprintf('The version "%s" already exists in the version table.', $version->getVersion()));
    }
}
