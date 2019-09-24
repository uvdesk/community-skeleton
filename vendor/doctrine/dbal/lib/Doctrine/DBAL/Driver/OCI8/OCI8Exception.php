<?php

namespace Doctrine\DBAL\Driver\OCI8;

use Doctrine\DBAL\Driver\AbstractDriverException;

class OCI8Exception extends AbstractDriverException
{
    /**
     * @param mixed[] $error
     *
     * @return \Doctrine\DBAL\Driver\OCI8\OCI8Exception
     */
    public static function fromErrorInfo($error)
    {
        return new self($error['message'], null, $error['code']);
    }
}
