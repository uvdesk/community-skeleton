<?php

namespace Doctrine\Common\Reflection;

use const DIRECTORY_SEPARATOR;
use function is_file;
use function str_replace;
use function strpos;
use function strrpos;
use function substr;

/**
 * Finds a class in a PSR-0 structure.
 */
class Psr0FindFile implements ClassFinderInterface
{
    /**
     * The PSR-0 prefixes.
     *
     * @var string[][]
     */
    protected $prefixes;

    /**
     * @param string[][] $prefixes An array of prefixes. Each key is a PHP namespace and each value is
     *                        a list of directories.
     */
    public function __construct($prefixes)
    {
        $this->prefixes = $prefixes;
    }

    /**
     * {@inheritDoc}
     */
    public function findFile($class)
    {
        if ($class[0] === '\\') {
            $class = substr($class, 1);
        }

        $lastNsPos = strrpos($class, '\\');

        if ($lastNsPos !== false) {
            // namespaced class name
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 0, $lastNsPos)) . DIRECTORY_SEPARATOR;
            $className = substr($class, $lastNsPos + 1);
        } else {
            // PEAR-like class name
            $classPath = null;
            $className = $class;
        }

        $classPath .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        foreach ($this->prefixes as $prefix => $dirs) {
            if (strpos($class, $prefix) !== 0) {
                continue;
            }

            foreach ($dirs as $dir) {
                if (is_file($dir . DIRECTORY_SEPARATOR . $classPath)) {
                    return $dir . DIRECTORY_SEPARATOR . $classPath;
                }
            }
        }

        return null;
    }
}
