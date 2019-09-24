<?php
namespace Doctrine\Common\Proxy\Exception;

use UnexpectedValueException as BaseUnexpectedValueException;

/**
 * Proxy Unexpected Value Exception.
 *
 * @link   www.doctrine-project.org
 * @since  2.4
 * @author Marco Pivetta <ocramius@gmail.com>
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
class UnexpectedValueException extends BaseUnexpectedValueException implements ProxyException
{
    /**
     * @param string $proxyDirectory
     *
     * @return self
     */
    public static function proxyDirectoryNotWritable($proxyDirectory)
    {
        return new self(sprintf('Your proxy directory "%s" must be writable', $proxyDirectory));
    }

    /**
     * @param string          $className
     * @param string          $methodName
     * @param string          $parameterName
     * @param \Exception|null $previous
     *
     * @return self
     */
    public static function invalidParameterTypeHint(
        $className,
        $methodName,
        $parameterName,
        \Exception $previous = null
    ) {
        return new self(
            sprintf(
                'The type hint of parameter "%s" in method "%s" in class "%s" is invalid.',
                $parameterName,
                $methodName,
                $className
            ),
            0,
            $previous
        );
    }

    /**
     * @param $className
     * @param $methodName
     * @param \Exception|null $previous
     *
     * @return self
     */
    public static function invalidReturnTypeHint($className, $methodName, \Exception $previous = null)
    {
        return new self(
            sprintf(
                'The return type of method "%s" in class "%s" is invalid.',
                $methodName,
                $className
            ),
            0,
            $previous
        );
    }
}
