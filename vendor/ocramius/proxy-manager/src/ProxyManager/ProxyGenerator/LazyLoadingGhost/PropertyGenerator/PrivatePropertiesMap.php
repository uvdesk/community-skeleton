<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\LazyLoadingGhost\PropertyGenerator;

use ProxyManager\Generator\Util\IdentifierSuffixer;
use ProxyManager\ProxyGenerator\Util\Properties;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Property that contains the initializer for a lazy object
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class PrivatePropertiesMap extends PropertyGenerator
{
    const KEY_DEFAULT_VALUE = 'defaultValue';

    /**
     * Constructor
     *
     * @param Properties $properties
     *
     * @throws \Zend\Code\Generator\Exception\InvalidArgumentException
     */
    public function __construct(Properties $properties)
    {
        parent::__construct(
            IdentifierSuffixer::getIdentifier('privateProperties')
        );

        $this->setVisibility(self::VISIBILITY_PRIVATE);
        $this->setStatic(true);
        $this->setDocBlock(
            '@var array[][] visibility and default value of defined properties, indexed by property name and class name'
        );
        $this->setDefaultValue($this->getMap($properties));
    }

    /**
     * @param Properties $properties
     *
     * @return int[][]|mixed[][]
     */
    private function getMap(Properties $properties) : array
    {
        $map = [];

        foreach ($properties->getPrivateProperties() as $property) {
            $propertyKey = & $map[$property->getName()];

            $propertyKey[$property->getDeclaringClass()->getName()] = true;
        }

        return $map;
    }
}
