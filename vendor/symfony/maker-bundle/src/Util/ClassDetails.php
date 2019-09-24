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

/**
 * @internal
 */
final class ClassDetails
{
    private $fullClassName;

    public function __construct(string $fullClassName)
    {
        $this->fullClassName = $fullClassName;
    }

    /**
     * Get list of property names except "id" for use in a make:form context.
     */
    public function getFormFields(): array
    {
        $properties = $this->getProperties();

        $fields = array_diff($properties, ['id']);

        $fieldsWithTypes = [];
        foreach ($fields as $field) {
            $fieldsWithTypes[$field] = null;
        }

        return $fieldsWithTypes;
    }

    private function getProperties(): array
    {
        $reflect = new \ReflectionClass($this->fullClassName);
        $props = $reflect->getProperties();

        $propertiesList = [];

        foreach ($props as $prop) {
            $propertiesList[] = $prop->getName();
        }

        return $propertiesList;
    }

    public function getPath(): string
    {
        return (new \ReflectionClass($this->fullClassName))->getFileName();
    }

    /**
     * An imperfect, but simple way to check for the presence of an annotation.
     *
     * @param string $annotation The annotation - e.g. @UniqueEntity
     */
    public function doesDocBlockContainAnnotation(string $annotation): bool
    {
        $docComment = (new \ReflectionClass($this->fullClassName))->getDocComment();

        if (false === $docComment) {
            return false;
        }

        return false !== strpos($docComment, $annotation);
    }
}
