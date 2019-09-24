<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\LazyLoadingValueHolder\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
use ProxyManager\Generator\Util\ProxiedMethodReturnExpression;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Reflection\MethodReflection;

/**
 * Method decorator for lazy loading value holder objects
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class LazyLoadingMethodInterceptor extends MethodGenerator
{
    /**
     * @throws \Zend\Code\Generator\Exception\InvalidArgumentException
     */
    public static function generateMethod(
        MethodReflection $originalMethod,
        PropertyGenerator $initializerProperty,
        PropertyGenerator $valueHolderProperty
    ) : self {
        /* @var $method self */
        $method            = static::fromReflectionWithoutBodyAndDocBlock($originalMethod);
        $initializerName   = $initializerProperty->getName();
        $valueHolderName   = $valueHolderProperty->getName();
        $parameters        = $originalMethod->getParameters();
        $methodName        = $originalMethod->getName();
        $initializerParams = [];
        $forwardedParams   = [];

        foreach ($parameters as $parameter) {
            $parameterName       = $parameter->getName();
            $variadicPrefix      = $parameter->isVariadic() ? '...' : '';
            $initializerParams[] = var_export($parameterName, true) . ' => $' . $parameterName;
            $forwardedParams[]   = $variadicPrefix . '$' . $parameterName;
        }

        $method->setBody(
            '$this->' . $initializerName
            . ' && $this->' . $initializerName
            . '->__invoke($this->' . $valueHolderName . ', $this, ' . var_export($methodName, true)
            . ', array(' . implode(', ', $initializerParams) .  '), $this->' . $initializerName . ");\n\n"
            . ProxiedMethodReturnExpression::generate(
                '$this->' . $valueHolderName . '->' . $methodName . '(' . implode(', ', $forwardedParams) . ')',
                $originalMethod
            )
        );

        return $method;
    }
}
