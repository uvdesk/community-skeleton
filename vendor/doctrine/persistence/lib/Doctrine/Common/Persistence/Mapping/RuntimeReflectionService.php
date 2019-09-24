<?php

namespace Doctrine\Common\Persistence\Mapping;

use Doctrine\Common\Reflection\RuntimePublicReflectionProperty;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;
use function class_exists;
use function class_parents;

/**
 * PHP Runtime Reflection Service.
 */
class RuntimeReflectionService implements ReflectionService
{
    /**
     * {@inheritDoc}
     */
    public function getParentClasses($class)
    {
        if (! class_exists($class)) {
            throw MappingException::nonExistingClass($class);
        }

        return class_parents($class);
    }

    /**
     * {@inheritDoc}
     */
    public function getClassShortName($class)
    {
        $reflectionClass = new ReflectionClass($class);

        return $reflectionClass->getShortName();
    }

    /**
     * {@inheritDoc}
     */
    public function getClassNamespace($class)
    {
        $reflectionClass = new ReflectionClass($class);

        return $reflectionClass->getNamespaceName();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass($class)
    {
        return new ReflectionClass($class);
    }

    /**
     * {@inheritDoc}
     */
    public function getAccessibleProperty($class, $property)
    {
        $reflectionProperty = new ReflectionProperty($class, $property);

        if ($reflectionProperty->isPublic()) {
            $reflectionProperty = new RuntimePublicReflectionProperty($class, $property);
        }

        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPublicMethod($class, $method)
    {
        try {
            $reflectionMethod = new ReflectionMethod($class, $method);
        } catch (ReflectionException $e) {
            return false;
        }

        return $reflectionMethod->isPublic();
    }
}
