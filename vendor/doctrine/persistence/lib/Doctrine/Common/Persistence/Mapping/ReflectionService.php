<?php

namespace Doctrine\Common\Persistence\Mapping;

use ReflectionClass;
use ReflectionProperty;

/**
 * Very simple reflection service abstraction.
 *
 * This is required inside metadata layers that may require either
 * static or runtime reflection.
 */
interface ReflectionService
{
    /**
     * Returns an array of the parent classes (not interfaces) for the given class.
     *
     * @param string $class
     *
     * @return string[]
     *
     * @throws MappingException
     */
    public function getParentClasses($class);

    /**
     * Returns the shortname of a class.
     *
     * @param string $class
     *
     * @return string
     */
    public function getClassShortName($class);

    /**
     * @param string $class
     *
     * @return string
     */
    public function getClassNamespace($class);

    /**
     * Returns a reflection class instance or null.
     *
     * @param string $class
     *
     * @return ReflectionClass|null
     */
    public function getClass($class);

    /**
     * Returns an accessible property (setAccessible(true)) or null.
     *
     * @param string $class
     * @param string $property
     *
     * @return ReflectionProperty|null
     */
    public function getAccessibleProperty($class, $property);

    /**
     * Checks if the class have a public method with the given name.
     *
     * @param mixed $class
     * @param mixed $method
     *
     * @return bool
     */
    public function hasPublicMethod($class, $method);
}
