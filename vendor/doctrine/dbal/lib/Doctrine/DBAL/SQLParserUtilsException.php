<?php

namespace Doctrine\DBAL;

use function sprintf;

/**
 * Doctrine\DBAL\ConnectionException
 */
class SQLParserUtilsException extends DBALException
{
    /**
     * @param string $paramName
     *
     * @return \Doctrine\DBAL\SQLParserUtilsException
     */
    public static function missingParam($paramName)
    {
        return new self(sprintf('Value for :%1$s not found in params array. Params array key should be "%1$s"', $paramName));
    }

    /**
     * @param string $typeName
     *
     * @return \Doctrine\DBAL\SQLParserUtilsException
     */
    public static function missingType($typeName)
    {
        return new self(sprintf('Value for :%1$s not found in types array. Types array key should be "%1$s"', $typeName));
    }
}
