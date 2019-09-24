<?php

declare(strict_types=1);

namespace ProxyManager\Autoloader;

use ProxyManager\FileLocator\FileLocatorInterface;
use ProxyManager\Inflector\ClassNameInflectorInterface;

/**
 * {@inheritDoc}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class Autoloader implements AutoloaderInterface
{
    /**
     * @var \ProxyManager\FileLocator\FileLocatorInterface
     */
    protected $fileLocator;

    /**
     * @var \ProxyManager\Inflector\ClassNameInflectorInterface
     */
    protected $classNameInflector;

    /**
     * @param \ProxyManager\FileLocator\FileLocatorInterface      $fileLocator
     * @param \ProxyManager\Inflector\ClassNameInflectorInterface $classNameInflector
     */
    public function __construct(FileLocatorInterface $fileLocator, ClassNameInflectorInterface $classNameInflector)
    {
        $this->fileLocator        = $fileLocator;
        $this->classNameInflector = $classNameInflector;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(string $className) : bool
    {
        if (class_exists($className, false) || ! $this->classNameInflector->isProxyClassName($className)) {
            return false;
        }

        $file = $this->fileLocator->getProxyFileName($className);

        if (! file_exists($file)) {
            return false;
        }

        /* @noinspection PhpIncludeInspection */
        /* @noinspection UsingInclusionOnceReturnValueInspection */
        return (bool) require_once $file;
    }
}
