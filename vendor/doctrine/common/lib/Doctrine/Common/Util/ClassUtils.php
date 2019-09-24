<?php
namespace Doctrine\Common\Util;

use Doctrine\Common\Persistence\Proxy;

/**
 * Class and reflection related functionality for objects that
 * might or not be proxy objects at the moment.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Johannes Schmitt <schmittjoh@gmail.com>
 *
 * @deprecated The ClassUtils class is deprecated.
 */
class ClassUtils
{
    /**
     * Gets the real class name of a class name that could be a proxy.
     *
     * @param string $class
     *
     * @return string
     */
    public static function getRealClass($class)
    {
        if (false === $pos = strrpos($class, '\\' . Proxy::MARKER . '\\')) {
            return $class;
        }

        return substr($class, $pos + Proxy::MARKER_LENGTH + 2);
    }

    /**
     * Gets the real class name of an object (even if its a proxy).
     *
     * @param object $object
     *
     * @return string
     */
    public static function getClass($object)
    {
        return self::getRealClass(get_class($object));
    }

    /**
     * Gets the real parent class name of a class or object.
     *
     * @param string $className
     *
     * @return string
     */
    public static function getParentClass($className)
    {
        return get_parent_class(self::getRealClass($className));
    }

    /**
     * Creates a new reflection class.
     *
     * @param string $class
     *
     * @return \ReflectionClass
     */
    public static function newReflectionClass($class)
    {
        return new \ReflectionClass(self::getRealClass($class));
    }

    /**
     * Creates a new reflection object.
     *
     * @param object $object
     *
     * @return \ReflectionClass
     */
    public static function newReflectionObject($object)
    {
        return self::newReflectionClass(self::getClass($object));
    }

    /**
     * Given a class name and a proxy namespace returns the proxy name.
     *
     * @param string $className
     * @param string $proxyNamespace
     *
     * @return string
     */
    public static function generateProxyClassName($className, $proxyNamespace)
    {
        return rtrim($proxyNamespace, '\\') . '\\' . Proxy::MARKER . '\\' . ltrim($className, '\\');
    }
}
