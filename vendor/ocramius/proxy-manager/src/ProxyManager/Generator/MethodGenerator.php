<?php

declare(strict_types=1);

namespace ProxyManager\Generator;

use Zend\Code\Generator\MethodGenerator as ZendMethodGenerator;
use Zend\Code\Reflection\MethodReflection;

/**
 * Method generator that fixes minor quirks in ZF2's method generator
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class MethodGenerator extends ZendMethodGenerator
{
    /**
     * {@inheritDoc}
     */
    public static function fromReflectionWithoutBodyAndDocBlock(MethodReflection $reflectionMethod) : self
    {
        /* @var $method self */
        $method = parent::copyMethodSignature($reflectionMethod);

        $method->setInterface(false);

        return $method;
    }
}
