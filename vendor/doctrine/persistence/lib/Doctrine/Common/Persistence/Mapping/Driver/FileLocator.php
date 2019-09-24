<?php

namespace Doctrine\Common\Persistence\Mapping\Driver;

/**
 * Locates the file that contains the metadata information for a given class name.
 *
 * This behavior is independent of the actual content of the file. It just detects
 * the file which is responsible for the given class name.
 */
interface FileLocator
{
    /**
     * Locates mapping file for the given class name.
     *
     * @param string $className
     *
     * @return string
     */
    public function findMappingFile($className);

    /**
     * Gets all class names that are found with this file locator.
     *
     * @param string $globalBasename Passed to allow excluding the basename.
     *
     * @return string[]
     */
    public function getAllClassNames($globalBasename);

    /**
     * Checks if a file can be found for this class name.
     *
     * @param string $className
     *
     * @return bool
     */
    public function fileExists($className);

    /**
     * Gets all the paths that this file locator looks for mapping files.
     *
     * @return string[]
     */
    public function getPaths();

    /**
     * Gets the file extension that mapping files are suffixed with.
     *
     * @return string
     */
    public function getFileExtension();
}
