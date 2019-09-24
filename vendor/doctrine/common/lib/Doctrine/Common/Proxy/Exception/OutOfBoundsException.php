<?php
namespace Doctrine\Common\Proxy\Exception;

use OutOfBoundsException as BaseOutOfBoundsException;

/**
 * Proxy Invalid Argument Exception.
 *
 * @link   www.doctrine-project.org
 * @author Fredrik Wendel <fredrik_w@users.sourceforge.net>
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
class OutOfBoundsException extends BaseOutOfBoundsException implements ProxyException
{
    /**
     * @param string $className
     * @param string $idField
     *
     * @return self
     */
    public static function missingPrimaryKeyValue($className, $idField)
    {
        return new self(sprintf("Missing value for primary key %s on %s", $idField, $className));
    }
}
