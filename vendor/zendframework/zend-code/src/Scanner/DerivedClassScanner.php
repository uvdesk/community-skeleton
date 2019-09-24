<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use Zend\Code\Exception;

use function array_keys;
use function array_merge;
use function sprintf;
use function trigger_error;

class DerivedClassScanner extends ClassScanner
{
    /**
     * @var DirectoryScanner
     */
    protected $directoryScanner;

    /**
     * @var ClassScanner
     */
    protected $classScanner;

    /**
     * @var array
     */
    protected $parentClassScanners = [];

    /**
     * @var array
     */
    protected $interfaceClassScanners = [];

    /**
     * @param ClassScanner $classScanner
     * @param DirectoryScanner $directoryScanner
     */
    public function __construct(ClassScanner $classScanner, DirectoryScanner $directoryScanner)
    {
        $this->classScanner     = $classScanner;
        $this->directoryScanner = $directoryScanner;

        $currentScannerClass = $classScanner;

        while ($currentScannerClass && $currentScannerClass->hasParentClass()) {
            $currentParentClassName = $currentScannerClass->getParentClass();
            if ($directoryScanner->hasClass($currentParentClassName)) {
                $currentParentClass = $directoryScanner->getClass($currentParentClassName);
                $this->parentClassScanners[$currentParentClassName] = $currentParentClass;
                $currentScannerClass = $currentParentClass;
            } else {
                $currentScannerClass = false;
            }
        }

        foreach ($interfaces = $this->classScanner->getInterfaces() as $iName) {
            if ($directoryScanner->hasClass($iName)) {
                $this->interfaceClassScanners[$iName] = $directoryScanner->getClass($iName);
            }
        }
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->classScanner->getName();
    }

    /**
     * @return null|string
     */
    public function getShortName()
    {
        return $this->classScanner->getShortName();
    }

    /**
     * @return bool
     */
    public function isInstantiable()
    {
        return $this->classScanner->isInstantiable();
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return $this->classScanner->isFinal();
    }

    /**
     * @return bool
     */
    public function isAbstract()
    {
        return $this->classScanner->isAbstract();
    }

    /**
     * @return bool
     */
    public function isInterface()
    {
        return $this->classScanner->isInterface();
    }

    /**
     * @return array
     */
    public function getParentClasses()
    {
        return array_keys($this->parentClassScanners);
    }

    /**
     * @return bool
     */
    public function hasParentClass()
    {
        return $this->classScanner->getParentClass() !== null;
    }

    /**
     * @return null|string
     */
    public function getParentClass()
    {
        return $this->classScanner->getParentClass();
    }

    /**
     * @param  bool $returnClassScanners
     * @return array
     */
    public function getInterfaces($returnClassScanners = false)
    {
        if ($returnClassScanners) {
            return $this->interfaceClassScanners;
        }

        $interfaces = $this->classScanner->getInterfaces();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $interfaces = array_merge($interfaces, $pClassScanner->getInterfaces());
        }

        return $interfaces;
    }

    /**
     * Return a list of constant names
     *
     * @return array
     */
    public function getConstantNames()
    {
        $constants = $this->classScanner->getConstantNames();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $constants = array_merge($constants, $pClassScanner->getConstantNames());
        }

        return $constants;
    }

    /**
     * Return a list of constants
     *
     * @param  bool $namesOnly Set false to return instances of ConstantScanner
     * @return array|ConstantScanner[]
     */
    public function getConstants($namesOnly = true)
    {
        if (true === $namesOnly) {
            trigger_error('Use method getConstantNames() instead', E_USER_DEPRECATED);
            return $this->getConstantNames();
        }

        $constants = $this->classScanner->getConstants();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $constants = array_merge($constants, $pClassScanner->getConstants($namesOnly));
        }

        return $constants;
    }

    /**
     * Return a single constant by given name or index of info
     *
     * @param  string|int $constantNameOrInfoIndex
     * @throws Exception\InvalidArgumentException
     * @return bool|ConstantScanner
     */
    public function getConstant($constantNameOrInfoIndex)
    {
        if ($this->classScanner->hasConstant($constantNameOrInfoIndex)) {
            return $this->classScanner->getConstant($constantNameOrInfoIndex);
        }

        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasConstant($constantNameOrInfoIndex)) {
                return $pClassScanner->getConstant($constantNameOrInfoIndex);
            }
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Constant %s not found in %s',
            $constantNameOrInfoIndex,
            $this->classScanner->getName()
        ));
    }

    /**
     * Verify if class or parent class has constant
     *
     * @param  string $name
     * @return bool
     */
    public function hasConstant($name)
    {
        if ($this->classScanner->hasConstant($name)) {
            return true;
        }
        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasConstant($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return a list of property names
     *
     * @return array
     */
    public function getPropertyNames()
    {
        $properties = $this->classScanner->getPropertyNames();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $properties = array_merge($properties, $pClassScanner->getPropertyNames());
        }

        return $properties;
    }

    /**
     * @param  bool $returnScannerProperty
     * @return array
     */
    public function getProperties($returnScannerProperty = false)
    {
        $properties = $this->classScanner->getProperties($returnScannerProperty);
        foreach ($this->parentClassScanners as $pClassScanner) {
            $properties = array_merge($properties, $pClassScanner->getProperties($returnScannerProperty));
        }

        return $properties;
    }

    /**
     * Return a single property by given name or index of info
     *
     * @param  string|int $propertyNameOrInfoIndex
     * @throws Exception\InvalidArgumentException
     * @return bool|PropertyScanner
     */
    public function getProperty($propertyNameOrInfoIndex)
    {
        if ($this->classScanner->hasProperty($propertyNameOrInfoIndex)) {
            return $this->classScanner->getProperty($propertyNameOrInfoIndex);
        }

        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasProperty($propertyNameOrInfoIndex)) {
                return $pClassScanner->getProperty($propertyNameOrInfoIndex);
            }
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Property %s not found in %s',
            $propertyNameOrInfoIndex,
            $this->classScanner->getName()
        ));
    }

    /**
     * Verify if class or parent class has property
     *
     * @param  string $name
     * @return bool
     */
    public function hasProperty($name)
    {
        if ($this->classScanner->hasProperty($name)) {
            return true;
        }
        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasProperty($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getMethodNames()
    {
        $methods = $this->classScanner->getMethodNames();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $methods = array_merge($methods, $pClassScanner->getMethodNames());
        }

        return $methods;
    }

    /**
     * @return MethodScanner[]
     */
    public function getMethods()
    {
        $methods = $this->classScanner->getMethods();
        foreach ($this->parentClassScanners as $pClassScanner) {
            $methods = array_merge($methods, $pClassScanner->getMethods());
        }

        return $methods;
    }

    /**
     * @param  int|string $methodNameOrInfoIndex
     * @return MethodScanner
     * @throws Exception\InvalidArgumentException
     */
    public function getMethod($methodNameOrInfoIndex)
    {
        if ($this->classScanner->hasMethod($methodNameOrInfoIndex)) {
            return $this->classScanner->getMethod($methodNameOrInfoIndex);
        }

        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasMethod($methodNameOrInfoIndex)) {
                return $pClassScanner->getMethod($methodNameOrInfoIndex);
            }
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Method %s not found in %s',
            $methodNameOrInfoIndex,
            $this->classScanner->getName()
        ));
    }

    /**
     * Verify if class or parent class has method by given name
     *
     * @param  string $name
     * @return bool
     */
    public function hasMethod($name)
    {
        if ($this->classScanner->hasMethod($name)) {
            return true;
        }
        foreach ($this->parentClassScanners as $pClassScanner) {
            if ($pClassScanner->hasMethod($name)) {
                return true;
            }
        }

        return false;
    }
}
