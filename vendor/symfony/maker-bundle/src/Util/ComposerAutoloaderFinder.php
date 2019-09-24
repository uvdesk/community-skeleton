<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use Composer\Autoload\ClassLoader;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\ErrorHandler\DebugClassLoader as ErrorHandlerDebugClassLoader;

/**
 * @internal
 */
class ComposerAutoloaderFinder
{
    private $rootNamespace;

    /**
     * @var ClassLoader|null
     */
    private $classLoader = null;

    public function __construct(string $rootNamespace)
    {
        $this->rootNamespace = [
            'psr0' => rtrim($rootNamespace, '\\'),
            'psr4' => rtrim($rootNamespace, '\\').'\\',
        ];
    }

    public function getClassLoader(): ClassLoader
    {
        if (null === $this->classLoader) {
            $this->classLoader = $this->findComposerClassLoader();
        }

        if (null === $this->classLoader) {
            throw new \Exception("Could not find a Composer autoloader that autoloads from '{$this->rootNamespace['psr4']}'");
        }

        return $this->classLoader;
    }

    /**
     * @return ClassLoader|null
     */
    private function findComposerClassLoader()
    {
        $autoloadFunctions = spl_autoload_functions();

        foreach ($autoloadFunctions as $autoloader) {
            if (!\is_array($autoloader)) {
                continue;
            }

            $classLoader = $this->extractComposerClassLoader($autoloader);
            if (null === $classLoader) {
                continue;
            }

            $finalClassLoader = $this->locateMatchingClassLoader($classLoader);
            if (null !== $finalClassLoader) {
                return $finalClassLoader;
            }
        }

        return null;
    }

    /**
     * @return ClassLoader|null
     */
    private function extractComposerClassLoader(array $autoloader)
    {
        if (isset($autoloader[0]) && \is_object($autoloader[0])) {
            if ($autoloader[0] instanceof ClassLoader) {
                return $autoloader[0];
            }
            if (
                ($autoloader[0] instanceof DebugClassLoader
                    || $autoloader[0] instanceof ErrorHandlerDebugClassLoader)
                && \is_array($autoloader[0]->getClassLoader())
                && $autoloader[0]->getClassLoader()[0] instanceof ClassLoader) {
                return $autoloader[0]->getClassLoader()[0];
            }
        }

        return null;
    }

    /**
     * @return ClassLoader|null
     */
    private function locateMatchingClassLoader(ClassLoader $classLoader)
    {
        $makerClassLoader = null;
        foreach ($classLoader->getPrefixesPsr4() as $prefix => $paths) {
            if ('Symfony\\Bundle\\MakerBundle\\' === $prefix) {
                $makerClassLoader = $classLoader;
            }
            if (0 === strpos($this->rootNamespace['psr4'], $prefix)) {
                return $classLoader;
            }
        }

        foreach ($classLoader->getPrefixes() as $prefix => $paths) {
            if (0 === strpos($this->rootNamespace['psr0'], $prefix)) {
                return $classLoader;
            }
        }

        // Nothing found? Try the class loader where we found MakerBundle
        return $makerClassLoader;
    }
}
