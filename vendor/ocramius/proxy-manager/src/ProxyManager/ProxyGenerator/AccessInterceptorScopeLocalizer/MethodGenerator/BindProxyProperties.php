<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\AccessInterceptorScopeLocalizer\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use ProxyManager\ProxyGenerator\Util\Properties;
use ReflectionClass;
use Zend\Code\Generator\PropertyGenerator;

/**
 * The `bindProxyProperties` method implementation for access interceptor scope localizers
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class BindProxyProperties extends MethodGenerator
{
    /**
     * Constructor
     *
     * @param ReflectionClass   $originalClass
     * @param PropertyGenerator $prefixInterceptors
     * @param PropertyGenerator $suffixInterceptors
     */
    public function __construct(
        ReflectionClass $originalClass,
        PropertyGenerator $prefixInterceptors,
        PropertyGenerator $suffixInterceptors
    ) {
        parent::__construct(
            'bindProxyProperties',
            [
                new ParameterGenerator('localizedObject', $originalClass->getName()),
                new ParameterGenerator('prefixInterceptors', 'array', []),
                new ParameterGenerator('suffixInterceptors', 'array', []),
            ],
            static::FLAG_PRIVATE,
            null,
            "@override constructor to setup interceptors\n\n"
            . "@param \\" . $originalClass->getName() . " \$localizedObject\n"
            . "@param \\Closure[] \$prefixInterceptors method interceptors to be used before method logic\n"
            . "@param \\Closure[] \$suffixInterceptors method interceptors to be used before method logic"
        );

        $localizedProperties = [];

        $properties = Properties::fromReflectionClass($originalClass);

        foreach ($properties->getAccessibleProperties() as $property) {
            $propertyName = $property->getName();

            $localizedProperties[] = '$this->' . $propertyName . ' = & $localizedObject->' . $propertyName . ';';
        }

        foreach ($properties->getPrivateProperties() as $property) {
            $propertyName = $property->getName();

            $localizedProperties[] = "\\Closure::bind(function () use (\$localizedObject) {\n    "
                . '$this->' . $propertyName . ' = & $localizedObject->' . $propertyName . ";\n"
                . '}, $this, ' . var_export($property->getDeclaringClass()->getName(), true)
                . ')->__invoke();';
        }

        $this->setBody(
            ($localizedProperties ? implode("\n\n", $localizedProperties) . "\n\n" : '')
            . '$this->' . $prefixInterceptors->getName() . " = \$prefixInterceptors;\n"
            . '$this->' . $suffixInterceptors->getName() . " = \$suffixInterceptors;"
        );
    }
}
