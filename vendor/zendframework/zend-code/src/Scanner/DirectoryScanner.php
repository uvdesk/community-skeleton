<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Zend\Code\Exception;

use function array_keys;
use function array_merge;
use function is_array;
use function is_dir;
use function is_string;
use function pathinfo;
use function realpath;
use function sprintf;

class DirectoryScanner implements ScannerInterface
{
    /**
     * @var bool
     */
    protected $isScanned = false;

    /**
     * @var string[]|DirectoryScanner[]
     */
    protected $directories = [];

    /**
     * @var FileScanner[]
     */
    protected $fileScanners = [];

    /**
     * @var array
     */
    protected $classToFileScanner;

    /**
     * @param null|string|array $directory
     */
    public function __construct($directory = null)
    {
        if ($directory) {
            if (is_string($directory)) {
                $this->addDirectory($directory);
            } elseif (is_array($directory)) {
                foreach ($directory as $d) {
                    $this->addDirectory($d);
                }
            }
        }
    }

    /**
     * @param  DirectoryScanner|string $directory
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function addDirectory($directory)
    {
        if ($directory instanceof DirectoryScanner) {
            $this->directories[] = $directory;
        } elseif (is_string($directory)) {
            $realDir = realpath($directory);
            if (! $realDir || ! is_dir($realDir)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Directory "%s" does not exist',
                    $realDir
                ));
            }
            $this->directories[] = $realDir;
        } else {
            throw new Exception\InvalidArgumentException(
                'The argument provided was neither a DirectoryScanner or directory path'
            );
        }
    }

    /**
     * @param  DirectoryScanner $directoryScanner
     * @return void
     */
    public function addDirectoryScanner(DirectoryScanner $directoryScanner)
    {
        $this->addDirectory($directoryScanner);
    }

    /**
     * @param  FileScanner $fileScanner
     * @return void
     */
    public function addFileScanner(FileScanner $fileScanner)
    {
        $this->fileScanners[] = $fileScanner;
    }

    /**
     * @return void
     */
    protected function scan()
    {
        if ($this->isScanned) {
            return;
        }

        // iterate directories creating file scanners
        foreach ($this->directories as $directory) {
            if ($directory instanceof DirectoryScanner) {
                $directory->scan();
                if ($directory->fileScanners) {
                    $this->fileScanners = array_merge($this->fileScanners, $directory->fileScanners);
                }
            } else {
                $rdi = new RecursiveDirectoryIterator($directory);
                foreach (new RecursiveIteratorIterator($rdi) as $item) {
                    if ($item->isFile() && pathinfo($item->getRealPath(), PATHINFO_EXTENSION) == 'php') {
                        $this->fileScanners[] = new FileScanner($item->getRealPath());
                    }
                }
            }
        }

        $this->isScanned = true;
    }

    /**
     * @todo implement method
     */
    public function getNamespaces()
    {
        // @todo
    }

    /**
     * @param  bool $returnFileScanners
     * @return array
     */
    public function getFiles($returnFileScanners = false)
    {
        $this->scan();

        $return = [];
        foreach ($this->fileScanners as $fileScanner) {
            $return[] = $returnFileScanners ? $fileScanner : $fileScanner->getFile();
        }

        return $return;
    }

    /**
     * @return array
     */
    public function getClassNames()
    {
        $this->scan();

        if ($this->classToFileScanner === null) {
            $this->createClassToFileScannerCache();
        }

        return array_keys($this->classToFileScanner);
    }

    /**
     * @param  bool  $returnDerivedScannerClass
     * @return array
     */
    public function getClasses($returnDerivedScannerClass = false)
    {
        $this->scan();

        if ($this->classToFileScanner === null) {
            $this->createClassToFileScannerCache();
        }

        $returnClasses = [];
        foreach ($this->classToFileScanner as $className => $fsIndex) {
            $classScanner = $this->fileScanners[$fsIndex]->getClass($className);
            if ($returnDerivedScannerClass) {
                $classScanner = new DerivedClassScanner($classScanner, $this);
            }
            $returnClasses[] = $classScanner;
        }

        return $returnClasses;
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function hasClass($class)
    {
        $this->scan();

        if ($this->classToFileScanner === null) {
            $this->createClassToFileScannerCache();
        }

        return isset($this->classToFileScanner[$class]);
    }

    /**
     * @param  string $class
     * @param  bool $returnDerivedScannerClass
     * @return ClassScanner|DerivedClassScanner
     * @throws Exception\InvalidArgumentException
     */
    public function getClass($class, $returnDerivedScannerClass = false)
    {
        $this->scan();

        if ($this->classToFileScanner === null) {
            $this->createClassToFileScannerCache();
        }

        if (! isset($this->classToFileScanner[$class])) {
            throw new Exception\InvalidArgumentException('Class not found.');
        }

        /** @var FileScanner $fs */
        $fs          = $this->fileScanners[$this->classToFileScanner[$class]];
        $returnClass = $fs->getClass($class);

        if ($returnClass instanceof ClassScanner && $returnDerivedScannerClass) {
            return new DerivedClassScanner($returnClass, $this);
        }

        return $returnClass;
    }

    /**
     * Create class to file scanner cache
     *
     * @return void
     */
    protected function createClassToFileScannerCache()
    {
        if ($this->classToFileScanner !== null) {
            return;
        }

        $this->classToFileScanner = [];

        /** @var FileScanner $fileScanner */
        foreach ($this->fileScanners as $fsIndex => $fileScanner) {
            $fsClasses = $fileScanner->getClassNames();
            foreach ($fsClasses as $fsClassName) {
                $this->classToFileScanner[$fsClassName] = $fsIndex;
            }
        }
    }

    /**
     * Export
     *
     * @todo implement method
     */
    public static function export()
    {
        // @todo
    }

    /**
     * __ToString
     *
     * @todo implement method
     */
    public function __toString()
    {
        // @todo
    }
}
