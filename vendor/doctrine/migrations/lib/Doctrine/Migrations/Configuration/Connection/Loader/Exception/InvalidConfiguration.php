<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration\Connection\Loader\Exception;

use InvalidArgumentException;

final class InvalidConfiguration extends InvalidArgumentException implements LoaderException
{
    public static function invalidArrayConfiguration() : self
    {
        return new self('The connection file has to return an array with database configuration parameters.');
    }
}
