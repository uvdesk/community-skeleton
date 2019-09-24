<?php

namespace Doctrine\Common\Persistence\Mapping;

use function strpos;
use function strrev;
use function strrpos;
use function substr;

/**
 * PHP Runtime Reflection Service.
 */
class StaticReflectionService implements ReflectionService
{
    /**
     * {@inheritDoc}
     */
    public function getParentClasses($class)
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getClassShortName($className)
    {
        if (strpos($className, '\\') !== false) {
            $className = substr($className, strrpos($className, '\\') + 1);
        }
        return $className;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassNamespace($className)
    {
        $namespace = '';
        if (strpos($className, '\\') !== false) {
            $namespace = strrev(substr(strrev($className), strpos(strrev($className), '\\') + 1));
        }
        return $namespace;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass($class)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getAccessibleProperty($class, $property)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPublicMethod($class, $method)
    {
        return true;
    }
}
