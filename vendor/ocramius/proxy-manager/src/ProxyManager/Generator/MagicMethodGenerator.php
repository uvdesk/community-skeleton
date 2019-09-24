<?php

declare(strict_types=1);

namespace ProxyManager\Generator;

use ReflectionClass;

/**
 * Method generator for magic methods
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class MagicMethodGenerator extends MethodGenerator
{
    /**
     * @param ReflectionClass $originalClass
     * @param string          $name
     * @param array           $parameters
     */
    public function __construct(ReflectionClass $originalClass, string $name, array $parameters = [])
    {
        parent::__construct(
            $name,
            $parameters,
            static::FLAG_PUBLIC
        );

        $this->setReturnsReference(strtolower($name) === '__get');

        if ($originalClass->hasMethod($name)) {
            $this->setReturnsReference($originalClass->getMethod($name)->returnsReference());
        }
    }
}
