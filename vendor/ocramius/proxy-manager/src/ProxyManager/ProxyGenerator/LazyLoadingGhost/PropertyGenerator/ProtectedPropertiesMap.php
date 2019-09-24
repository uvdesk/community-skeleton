<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\LazyLoadingGhost\PropertyGenerator;

use ProxyManager\Generator\Util\IdentifierSuffixer;
use ProxyManager\ProxyGenerator\Util\Properties;
use Zend\Code\Generator\PropertyGenerator;

/**
 * Property that contains the protected instance lazy-loadable properties of an object
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class ProtectedPropertiesMap extends PropertyGenerator
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
            IdentifierSuffixer::getIdentifier('protectedProperties')
        );

        $this->setVisibility(self::VISIBILITY_PRIVATE);
        $this->setStatic(true);
        $this->setDocBlock(
            '@var string[][] declaring class name of defined protected properties, indexed by property name'
        );
        $this->setDefaultValue($this->getMap($properties));
    }

    /**
     *
     * @param Properties $properties
     *
     * @return int[][]|mixed[][]
     */
    private function getMap(Properties $properties) : array
    {
        $map = [];

        foreach ($properties->getProtectedProperties() as $property) {
            $map[$property->getName()] = $property->getDeclaringClass()->getName();
        }

        return $map;
    }
}
