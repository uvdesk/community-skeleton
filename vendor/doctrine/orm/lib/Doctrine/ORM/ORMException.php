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

namespace Doctrine\ORM;

use Doctrine\Common\Cache\Cache as CacheDriver;
use Exception;

/**
 * Base exception class for all ORM exceptions.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 */
class ORMException extends Exception
{
    /**
     * @return ORMException
     */
    public static function missingMappingDriverImpl()
    {
        return new self("It's a requirement to specify a Metadata Driver and pass it ".
            "to Doctrine\\ORM\\Configuration::setMetadataDriverImpl().");
    }

    /**
     * @param string $queryName
     *
     * @return ORMException
     */
    public static function namedQueryNotFound($queryName)
    {
        return new self('Could not find a named query by the name "' . $queryName . '"');
    }

    /**
     * @param string $nativeQueryName
     *
     * @return ORMException
     */
    public static function namedNativeQueryNotFound($nativeQueryName)
    {
        return new self('Could not find a named native query by the name "' . $nativeQueryName . '"');
    }

    /**
     * @param object $entity
     * @param object $relatedEntity
     *
     * @return ORMException
     */
    public static function entityMissingForeignAssignedId($entity, $relatedEntity)
    {
        return new self(
            "Entity of type " . get_class($entity) . " has identity through a foreign entity " . get_class($relatedEntity) . ", " .
            "however this entity has no identity itself. You have to call EntityManager#persist() on the related entity " .
            "and make sure that an identifier was generated before trying to persist '" . get_class($entity) . "'. In case " .
            "of Post Insert ID Generation (such as MySQL Auto-Increment) this means you have to call " .
            "EntityManager#flush() between both persist operations."
        );
    }

    /**
     * @param object $entity
     * @param string $field
     *
     * @return ORMException
     */
    public static function entityMissingAssignedIdForField($entity, $field)
    {
        return new self("Entity of type " . get_class($entity) . " is missing an assigned ID for field  '" . $field . "'. " .
            "The identifier generation strategy for this entity requires the ID field to be populated before ".
            "EntityManager#persist() is called. If you want automatically generated identifiers instead " .
            "you need to adjust the metadata mapping accordingly."
        );
    }

    /**
     * @param string $field
     *
     * @return ORMException
     */
    public static function unrecognizedField($field)
    {
        return new self("Unrecognized field: $field");
    }

    /**
     *
     * @param string $class
     * @param string $association
     * @param string $given
     * @param string $expected
     *
     * @return \Doctrine\ORM\ORMInvalidArgumentException
     */
    public static function unexpectedAssociationValue($class, $association, $given, $expected)
    {
        return new self(sprintf('Found entity of type %s on association %s#%s, but expecting %s', $given, $class, $association, $expected));
    }

    /**
     * @param string $className
     * @param string $field
     *
     * @return ORMException
     */
    public static function invalidOrientation($className, $field)
    {
        return new self("Invalid order by orientation specified for " . $className . "#" . $field);
    }

    /**
     * @param string $mode
     *
     * @return ORMException
     */
    public static function invalidFlushMode($mode)
    {
        return new self("'$mode' is an invalid flush mode.");
    }

    /**
     * @return ORMException
     */
    public static function entityManagerClosed()
    {
        return new self("The EntityManager is closed.");
    }

    /**
     * @param string $mode
     *
     * @return ORMException
     */
    public static function invalidHydrationMode($mode)
    {
        return new self("'$mode' is an invalid hydration mode.");
    }

    /**
     * @return ORMException
     */
    public static function mismatchedEventManager()
    {
        return new self("Cannot use different EventManager instances for EntityManager and Connection.");
    }

    /**
     * @param string $methodName
     *
     * @return ORMException
     */
    public static function findByRequiresParameter($methodName)
    {
        return new self("You need to pass a parameter to '".$methodName."'");
    }

    /**
     * @param string $entityName
     * @param string $fieldName
     * @param string $method
     *
     * @return ORMException
     */
    public static function invalidFindByCall($entityName, $fieldName, $method)
    {
        return new self(
            "Entity '".$entityName."' has no field '".$fieldName."'. ".
            "You can therefore not call '".$method."' on the entities' repository"
        );
    }

    /**
     * @param string $entityName
     * @param string $fieldName
     * @param string $method
     *
     * @return ORMException
     */
    public static function invalidMagicCall($entityName, $fieldName, $method)
    {
        return new self(
            "Entity '".$entityName."' has no field '".$fieldName."'. ".
            "You can therefore not call '".$method."' on the entities' repository"
        );
    }

    /**
     * @param string $entityName
     * @param string $associationFieldName
     *
     * @return ORMException
     */
    public static function invalidFindByInverseAssociation($entityName, $associationFieldName)
    {
        return new self(
            "You cannot search for the association field '".$entityName."#".$associationFieldName."', ".
            "because it is the inverse side of an association. Find methods only work on owning side associations."
        );
    }

    /**
     * @return ORMException
     */
    public static function invalidResultCacheDriver()
    {
        return new self("Invalid result cache driver; it must implement Doctrine\\Common\\Cache\\Cache.");
    }

    /**
     * @return ORMException
     */
    public static function notSupported()
    {
        return new self("This behaviour is (currently) not supported by Doctrine 2");
    }

    /**
     * @return ORMException
     */
    public static function queryCacheNotConfigured()
    {
        return new self('Query Cache is not configured.');
    }

    /**
     * @return ORMException
     */
    public static function metadataCacheNotConfigured()
    {
        return new self('Class Metadata Cache is not configured.');
    }

    /**
     * @param \Doctrine\Common\Cache\Cache $cache
     *
     * @return ORMException
     */
    public static function queryCacheUsesNonPersistentCache(CacheDriver $cache)
    {
        return new self('Query Cache uses a non-persistent cache driver, ' . get_class($cache) . '.');
    }

    /**
     * @param \Doctrine\Common\Cache\Cache $cache
     *
     * @return ORMException
     */
    public static function metadataCacheUsesNonPersistentCache(CacheDriver $cache)
    {
        return new self('Metadata Cache uses a non-persistent cache driver, ' . get_class($cache) . '.');
    }

    /**
     * @return ORMException
     */
    public static function proxyClassesAlwaysRegenerating()
    {
        return new self('Proxy Classes are always regenerating.');
    }

    /**
     * @param string $entityNamespaceAlias
     *
     * @return ORMException
     */
    public static function unknownEntityNamespace($entityNamespaceAlias)
    {
        return new self(
            "Unknown Entity namespace alias '$entityNamespaceAlias'."
        );
    }

    /**
     * @param string $className
     *
     * @return ORMException
     */
    public static function invalidEntityRepository($className)
    {
        return new self("Invalid repository class '".$className."'. It must be a Doctrine\Common\Persistence\ObjectRepository.");
    }

    /**
     * @param string $className
     * @param string $fieldName
     *
     * @return ORMException
     */
    public static function missingIdentifierField($className, $fieldName)
    {
        return new self("The identifier $fieldName is missing for a query of " . $className);
    }

    /**
     * @param string $className
     * @param string[] $fieldNames
     *
     * @return ORMException
     */
    public static function unrecognizedIdentifierFields($className, $fieldNames)
    {
        return new self(
            "Unrecognized identifier fields: '" . implode("', '", $fieldNames) . "' " .
            "are not present on class '" . $className . "'."
        );
    }

    /**
     * @return ORMException
     */
    public static function cantUseInOperatorOnCompositeKeys()
    {
        return new self("Can't use IN operator on entities that have composite keys.");
    }
}
