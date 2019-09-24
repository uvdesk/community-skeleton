<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator;

use ReflectionClass;
use Zend\Code\Generator\ClassGenerator;

/**
 * Base interface for proxy generators - describes how a proxy generator should use
 * reflection classes to modify given class generators
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface ProxyGeneratorInterface
{
    /**
     * Apply modifications to the provided $classGenerator to proxy logic from $originalClass
     *
     * @param \ReflectionClass                    $originalClass
     * @param \Zend\Code\Generator\ClassGenerator $classGenerator
     *
     * @return void
     */
    public function generate(ReflectionClass $originalClass, ClassGenerator $classGenerator);
}
