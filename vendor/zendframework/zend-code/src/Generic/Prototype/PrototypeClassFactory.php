<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generic\Prototype;

use Zend\Code\Reflection\Exception;

use function str_replace;

/**
 * This is a factory for classes which are identified by name.
 *
 * All classes that this factory can supply need to
 * be registered before (prototypes). This prototypes need to implement
 * an interface which ensures every prototype has a name.
 *
 * If the factory can not supply the class someone is asking for
 * it tries to fallback on a generic default prototype, which would
 * have need to be set before.
 */
class PrototypeClassFactory
{
    /**
     * @var array
     */
    protected $prototypes = [];

    /**
     * @var PrototypeGenericInterface
     */
    protected $genericPrototype;

    /**
     * @param PrototypeInterface[] $prototypes
     * @param PrototypeGenericInterface $genericPrototype
     */
    public function __construct($prototypes = [], PrototypeGenericInterface $genericPrototype = null)
    {
        foreach ((array) $prototypes as $prototype) {
            $this->addPrototype($prototype);
        }

        if ($genericPrototype) {
            $this->setGenericPrototype($genericPrototype);
        }
    }

    /**
     * @param PrototypeInterface $prototype
     * @throws Exception\InvalidArgumentException
     */
    public function addPrototype(PrototypeInterface $prototype)
    {
        $prototypeName = $this->normalizeName($prototype->getName());

        if (isset($this->prototypes[$prototypeName])) {
            throw new Exception\InvalidArgumentException('A prototype with this name already exists in this manager');
        }

        $this->prototypes[$prototypeName] = $prototype;
    }

    /**
     * @param PrototypeGenericInterface $prototype
     * @throws Exception\InvalidArgumentException
     */
    public function setGenericPrototype(PrototypeGenericInterface $prototype)
    {
        if (isset($this->genericPrototype)) {
            throw new Exception\InvalidArgumentException('A default prototype is already set');
        }

        $this->genericPrototype = $prototype;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeName($name)
    {
        return str_replace(['-', '_'], '', $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasPrototype($name)
    {
        $name = $this->normalizeName($name);
        return isset($this->prototypes[$name]);
    }

    /**
     * @param  string $prototypeName
     * @return PrototypeInterface
     * @throws Exception\RuntimeException
     */
    public function getClonedPrototype($prototypeName)
    {
        $prototypeName = $this->normalizeName($prototypeName);

        if (! $this->hasPrototype($prototypeName) && ! isset($this->genericPrototype)) {
            throw new Exception\RuntimeException('This tag name is not supported by this tag manager');
        }

        if (! $this->hasPrototype($prototypeName)) {
            $newPrototype = clone $this->genericPrototype;
            $newPrototype->setName($prototypeName);
        } else {
            $newPrototype = clone $this->prototypes[$prototypeName];
        }

        return $newPrototype;
    }
}
