<?php
namespace Doctrine\Common\Proxy\Exception;

use Doctrine\Common\Persistence\Proxy;
use InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Proxy Invalid Argument Exception.
 *
 * @link   www.doctrine-project.org
 * @since  2.4
 * @author Marco Pivetta <ocramius@gmail.com>
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements ProxyException
{
    /**
     * @return self
     */
    public static function proxyDirectoryRequired()
    {
        return new self('You must configure a proxy directory. See docs for details');
    }

    /**
     * @param string $className
     * @param string $proxyNamespace
     *
     * @return self
     */
    public static function notProxyClass($className, $proxyNamespace)
    {
        return new self(sprintf('The class "%s" is not part of the proxy namespace "%s"', $className, $proxyNamespace));
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public static function invalidPlaceholder($name)
    {
        return new self(sprintf('Provided placeholder for "%s" must be either a string or a valid callable', $name));
    }

    /**
     * @return self
     */
    public static function proxyNamespaceRequired()
    {
        return new self('You must configure a proxy namespace');
    }

    /**
     * @param Proxy $proxy
     *
     * @return self
     */
    public static function unitializedProxyExpected(Proxy $proxy)
    {
        return new self(sprintf('Provided proxy of type "%s" must not be initialized.', get_class($proxy)));
    }

    /**
     * @param mixed $callback
     *
     * @return self
     */
    public static function invalidClassNotFoundCallback($callback)
    {
        $type = is_object($callback) ? get_class($callback) : gettype($callback);

        return new self(sprintf('Invalid \$notFoundCallback given: must be a callable, "%s" given', $type));
    }

    /**
     * @param string $className
     *
     * @return self
     */
    public static function classMustNotBeAbstract($className)
    {
        return new self(sprintf('Unable to create a proxy for an abstract class "%s".', $className));
    }

    /**
     * @param string $className
     *
     * @return self
     */
    public static function classMustNotBeFinal($className)
    {
        return new self(sprintf('Unable to create a proxy for a final class "%s".', $className));
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public static function invalidAutoGenerateMode($value) : self
    {
        return new self(sprintf('Invalid auto generate mode "%s" given.', $value));
    }
}
