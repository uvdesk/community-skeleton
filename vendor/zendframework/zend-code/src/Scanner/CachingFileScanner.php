<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Exception;
use Zend\Code\NameInformation;

use function file_exists;
use function md5;
use function realpath;
use function spl_object_hash;
use function sprintf;

class CachingFileScanner extends FileScanner
{
    /**
     * @var array
     */
    protected static $cache = [];

    /**
     * @var null|FileScanner
     */
    protected $fileScanner;

    /**
     * @param  string $file
     * @param  AnnotationManager $annotationManager
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($file, AnnotationManager $annotationManager = null)
    {
        if (! file_exists($file)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'File "%s" not found',
                $file
            ));
        }

        $file = realpath($file);

        $cacheId = md5($file) . '/' . (isset($annotationManager)
            ? spl_object_hash($annotationManager)
            : 'no-annotation');

        if (isset(static::$cache[$cacheId])) {
            $this->fileScanner = static::$cache[$cacheId];
        } else {
            $this->fileScanner       = new FileScanner($file, $annotationManager);
            static::$cache[$cacheId] = $this->fileScanner;
        }
    }

    /**
     * @return void
     */
    public static function clearCache()
    {
        static::$cache = [];
    }

    /**
     * @return AnnotationManager
     */
    public function getAnnotationManager()
    {
        return $this->fileScanner->getAnnotationManager();
    }

    /**
     * @return array|null|string
     */
    public function getFile()
    {
        return $this->fileScanner->getFile();
    }

    /**
     * @return null|string
     */
    public function getDocComment()
    {
        return $this->fileScanner->getDocComment();
    }

    /**
     * @return array
     */
    public function getNamespaces()
    {
        return $this->fileScanner->getNamespaces();
    }

    /**
     * @param  null|string $namespace
     * @return array|null
     */
    public function getUses($namespace = null)
    {
        return $this->fileScanner->getUses($namespace);
    }

    /**
     * @return array
     */
    public function getIncludes()
    {
        return $this->fileScanner->getIncludes();
    }

    /**
     * @return array
     */
    public function getClassNames()
    {
        return $this->fileScanner->getClassNames();
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return $this->fileScanner->getClasses();
    }

    /**
     * @param  int|string $className
     * @return ClassScanner
     */
    public function getClass($className)
    {
        return $this->fileScanner->getClass($className);
    }

    /**
     * @param  string $className
     * @return bool|null|NameInformation
     */
    public function getClassNameInformation($className)
    {
        return $this->fileScanner->getClassNameInformation($className);
    }

    /**
     * @return array
     */
    public function getFunctionNames()
    {
        return $this->fileScanner->getFunctionNames();
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return $this->fileScanner->getFunctions();
    }
}
