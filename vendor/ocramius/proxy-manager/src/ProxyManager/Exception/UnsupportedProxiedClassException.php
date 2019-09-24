<?php

declare(strict_types=1);

namespace ProxyManager\Exception;

use LogicException;
use ReflectionProperty;

/**
 * Exception for invalid proxied classes
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class UnsupportedProxiedClassException extends LogicException implements ExceptionInterface
{
    public static function unsupportedLocalizedReflectionProperty(ReflectionProperty $property) : self
    {
        return new self(
            sprintf(
                'Provided reflection property "%s" of class "%s" is private and cannot be localized in PHP 5.3',
                $property->getName(),
                $property->getDeclaringClass()->getName()
            )
        );
    }
}
