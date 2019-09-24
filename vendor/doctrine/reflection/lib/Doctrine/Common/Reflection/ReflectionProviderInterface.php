<?php

namespace Doctrine\Common\Reflection;

interface ReflectionProviderInterface
{
    /**
     * Gets the ReflectionClass equivalent for this class.
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass();

    /**
     * Gets the ReflectionMethod equivalent for this class.
     *
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    public function getReflectionMethod($name);

    /**
     * Gets the ReflectionProperty equivalent for this class.
     *
     * @param string $name
     *
     * @return \ReflectionProperty
     */
    public function getReflectionProperty($name);
}
