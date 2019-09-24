<?php
namespace Doctrine\Common\Proxy;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 * Special Autoloader for Proxy classes, which are not PSR-0 compliant.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 *
 * @internal
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
class Autoloader
{
    /**
     * Resolves proxy class name to a filename based on the following pattern.
     *
     * 1. Remove Proxy namespace from class name.
     * 2. Remove namespace separators from remaining class name.
     * 3. Return PHP filename from proxy-dir with the result from 2.
     *
     * @param string $proxyDir
     * @param string $proxyNamespace
     * @param string $className
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function resolveFile($proxyDir, $proxyNamespace, $className)
    {
        if (0 !== strpos($className, $proxyNamespace)) {
            throw InvalidArgumentException::notProxyClass($className, $proxyNamespace);
        }

        // remove proxy namespace from class name
        $classNameRelativeToProxyNamespace = substr($className, strlen($proxyNamespace));

        // remove namespace separators from remaining class name
        $fileName = str_replace('\\', '', $classNameRelativeToProxyNamespace);

        return $proxyDir . DIRECTORY_SEPARATOR . $fileName . '.php';
    }

    /**
     * Registers and returns autoloader callback for the given proxy dir and namespace.
     *
     * @param string        $proxyDir
     * @param string        $proxyNamespace
     * @param callable|null $notFoundCallback Invoked when the proxy file is not found.
     *
     * @return \Closure
     *
     * @throws InvalidArgumentException
     */
    public static function register($proxyDir, $proxyNamespace, $notFoundCallback = null)
    {
        $proxyNamespace = ltrim($proxyNamespace, '\\');

        if ( ! (null === $notFoundCallback || is_callable($notFoundCallback))) {
            throw InvalidArgumentException::invalidClassNotFoundCallback($notFoundCallback);
        }

        $autoloader = function ($className) use ($proxyDir, $proxyNamespace, $notFoundCallback) {
            if (0 === strpos($className, $proxyNamespace)) {
                $file = Autoloader::resolveFile($proxyDir, $proxyNamespace, $className);

                if ($notFoundCallback && ! file_exists($file)) {
                    call_user_func($notFoundCallback, $proxyDir, $proxyNamespace, $className);
                }

                require $file;
            }
        };

        spl_autoload_register($autoloader);

        return $autoloader;
    }
}
