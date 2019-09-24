<?php

namespace Doctrine\Common\Persistence\Mapping;

use Exception;
use function implode;
use function sprintf;

/**
 * A MappingException indicates that something is wrong with the mapping setup.
 */
class MappingException extends Exception
{
    /**
     * @param string   $className
     * @param string[] $namespaces
     *
     * @return self
     */
    public static function classNotFoundInNamespaces($className, $namespaces)
    {
        return new self(sprintf(
            "The class '%s' was not found in the chain configured namespaces %s",
            $className,
            implode(', ', $namespaces)
        ));
    }

    /**
     * @return self
     */
    public static function pathRequired()
    {
        return new self('Specifying the paths to your entities is required ' .
            'in the AnnotationDriver to retrieve all class names.');
    }

    /**
     * @param string|null $path
     *
     * @return self
     */
    public static function fileMappingDriversRequireConfiguredDirectoryPath($path = null)
    {
        if (! empty($path)) {
            $path = '[' . $path . ']';
        }

        return new self(sprintf(
            'File mapping drivers must have a valid directory path, ' .
            'however the given path %s seems to be incorrect!',
            $path
        ));
    }

    /**
     * @param string $entityName
     * @param string $fileName
     *
     * @return self
     */
    public static function mappingFileNotFound($entityName, $fileName)
    {
        return new self(sprintf(
            "No mapping file found named '%s' for class '%s'.",
            $fileName,
            $entityName
        ));
    }

    /**
     * @param string $entityName
     * @param string $fileName
     *
     * @return self
     */
    public static function invalidMappingFile($entityName, $fileName)
    {
        return new self(sprintf(
            "Invalid mapping file '%s' for class '%s'.",
            $fileName,
            $entityName
        ));
    }

    /**
     * @param string $className
     *
     * @return self
     */
    public static function nonExistingClass($className)
    {
        return new self(sprintf("Class '%s' does not exist", $className));
    }
}
