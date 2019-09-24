<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Utility;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\QueryException;

/**
 * The PersisterHelper contains logic to infer binding types which is used in
 * several persisters.
 *
 * @link   www.doctrine-project.org
 * @since  2.5
 * @author Jasper N. Brouwer <jasper@nerdsweide.nl>
 */
class PersisterHelper
{
    /**
     * @param string                 $fieldName
     * @param ClassMetadata          $class
     * @param EntityManagerInterface $em
     *
     * @return array
     *
     * @throws QueryException
     */
    public static function getTypeOfField($fieldName, ClassMetadata $class, EntityManagerInterface $em)
    {
        if (isset($class->fieldMappings[$fieldName])) {
            return [$class->fieldMappings[$fieldName]['type']];
        }

        if ( ! isset($class->associationMappings[$fieldName])) {
            return [];
        }

        $assoc = $class->associationMappings[$fieldName];

        if (! $assoc['isOwningSide']) {
            return self::getTypeOfField($assoc['mappedBy'], $em->getClassMetadata($assoc['targetEntity']), $em);
        }

        if ($assoc['type'] & ClassMetadata::MANY_TO_MANY) {
            $joinData = $assoc['joinTable'];
        } else {
            $joinData = $assoc;
        }

        $types       = [];
        $targetClass = $em->getClassMetadata($assoc['targetEntity']);

        foreach ($joinData['joinColumns'] as $joinColumn) {
            $types[] = self::getTypeOfColumn($joinColumn['referencedColumnName'], $targetClass, $em);
        }

        return $types;
    }

    /**
     * @param string                 $columnName
     * @param ClassMetadata          $class
     * @param EntityManagerInterface $em
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function getTypeOfColumn($columnName, ClassMetadata $class, EntityManagerInterface $em)
    {
        if (isset($class->fieldNames[$columnName])) {
            $fieldName = $class->fieldNames[$columnName];

            if (isset($class->fieldMappings[$fieldName])) {
                return $class->fieldMappings[$fieldName]['type'];
            }
        }

        // iterate over to-one association mappings
        foreach ($class->associationMappings as $assoc) {
            if ( ! isset($assoc['joinColumns'])) {
                continue;
            }

            foreach ($assoc['joinColumns'] as $joinColumn) {
                if ($joinColumn['name'] == $columnName) {
                    $targetColumnName = $joinColumn['referencedColumnName'];
                    $targetClass      = $em->getClassMetadata($assoc['targetEntity']);

                    return self::getTypeOfColumn($targetColumnName, $targetClass, $em);
                }
            }
        }

        // iterate over to-many association mappings
        foreach ($class->associationMappings as $assoc) {
            if ( ! (isset($assoc['joinTable']) && isset($assoc['joinTable']['joinColumns']))) {
                continue;
            }

            foreach ($assoc['joinTable']['joinColumns'] as $joinColumn) {
                if ($joinColumn['name'] == $columnName) {
                    $targetColumnName = $joinColumn['referencedColumnName'];
                    $targetClass      = $em->getClassMetadata($assoc['targetEntity']);

                    return self::getTypeOfColumn($targetColumnName, $targetClass, $em);
                }
            }
        }

        throw new \RuntimeException(sprintf(
            'Could not resolve type of column "%s" of class "%s"',
            $columnName,
            $class->getName()
        ));
    }
}
