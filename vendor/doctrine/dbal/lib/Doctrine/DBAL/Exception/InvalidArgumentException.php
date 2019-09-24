<?php

namespace Doctrine\DBAL\Exception;

use Doctrine\DBAL\DBALException;

/**
 * Exception to be thrown when invalid arguments are passed to any DBAL API
 */
class InvalidArgumentException extends DBALException
{
    /**
     * @return self
     */
    public static function fromEmptyCriteria()
    {
        return new self('Empty criteria was used, expected non-empty criteria');
    }
}
