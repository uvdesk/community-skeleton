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

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache as CacheDriver;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ORM\Cache\CacheConfiguration;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Doctrine\ORM\Mapping\DefaultNamingStrategy;
use Doctrine\ORM\Mapping\DefaultQuoteStrategy;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\EntityListenerResolver;
use Doctrine\ORM\Mapping\NamingStrategy;
use Doctrine\ORM\Mapping\QuoteStrategy;
use Doctrine\ORM\Repository\DefaultRepositoryFactory;
use Doctrine\ORM\Repository\RepositoryFactory;

/**
 * Configuration container for all configuration options of Doctrine.
 * It combines all configuration options from DBAL & ORM.
 *
 * Internal note: When adding a new configuration option just write a getter/setter pair.
 *
 * @since 2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class Configuration extends \Doctrine\DBAL\Configuration
{
    /**
     * Sets the directory where Doctrine generates any necessary proxy class files.
     *
     * @param string $dir
     *
     * @return void
     */
    public function setProxyDir($dir)
    {
        $this->_attributes['proxyDir'] = $dir;
    }

    /**
     * Gets the directory where Doctrine generates any necessary proxy class files.
     *
     * @return string|null
     */
    public function getProxyDir()
    {
        return isset($this->_attributes['proxyDir'])
            ? $this->_attributes['proxyDir']
            : null;
    }

    /**
     * Gets the strategy for automatically generating proxy classes.
     *
     * @return int Possible values are constants of Doctrine\Common\Proxy\AbstractProxyFactory.
     */
    public function getAutoGenerateProxyClasses()
    {
        return isset($this->_attributes['autoGenerateProxyClasses'])
            ? $this->_attributes['autoGenerateProxyClasses']
            : AbstractProxyFactory::AUTOGENERATE_ALWAYS;
    }

    /**
     * Sets the strategy for automatically generating proxy classes.
     *
     * @param boolean|int $autoGenerate Possible values are constants of Doctrine\Common\Proxy\AbstractProxyFactory.
     *                                  True is converted to AUTOGENERATE_ALWAYS, false to AUTOGENERATE_NEVER.
     *
     * @return void
     */
    public function setAutoGenerateProxyClasses($autoGenerate)
    {
        $this->_attributes['autoGenerateProxyClasses'] = (int) $autoGenerate;
    }

    /**
     * Gets the namespace where proxy classes reside.
     *
     * @return string|null
     */
    public function getProxyNamespace()
    {
        return isset($this->_attributes['proxyNamespace'])
            ? $this->_attributes['proxyNamespace']
            : null;
    }

    /**
     * Sets the namespace where proxy classes reside.
     *
     * @param string $ns
     *
     * @return void
     */
    public function setProxyNamespace($ns)
    {
        $this->_attributes['proxyNamespace'] = $ns;
    }

    /**
     * Sets the cache driver implementation that is used for metadata caching.
     *
     * @param MappingDriver $driverImpl
     *
     * @return void
     *
     * @todo Force parameter to be a Closure to ensure lazy evaluation
     *       (as soon as a metadata cache is in effect, the driver never needs to initialize).
     */
    public function setMetadataDriverImpl(MappingDriver $driverImpl)
    {
        $this->_attributes['metadataDriverImpl'] = $driverImpl;
    }

    /**
     * Adds a new default annotation driver with a correctly configured annotation reader. If $useSimpleAnnotationReader
     * is true, the notation `@Entity` will work, otherwise, the notation `@ORM\Entity` will be supported.
     *
     * @param array $paths
     * @param bool  $useSimpleAnnotationReader
     *
     * @return AnnotationDriver
     */
    public function newDefaultAnnotationDriver($paths = [], $useSimpleAnnotationReader = true)
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Mapping/Driver/DoctrineAnnotations.php');

        if ($useSimpleAnnotationReader) {
            // Register the ORM Annotations in the AnnotationRegistry
            $reader = new SimpleAnnotationReader();
            $reader->addNamespace('Doctrine\ORM\Mapping');
            $cachedReader = new CachedReader($reader, new ArrayCache());

            return new AnnotationDriver($cachedReader, (array) $paths);
        }

        return new AnnotationDriver(
            new CachedReader(new AnnotationReader(), new ArrayCache()),
            (array) $paths
        );
    }

    /**
     * Adds a namespace under a certain alias.
     *
     * @param string $alias
     * @param string $namespace
     *
     * @return void
     */
    public function addEntityNamespace($alias, $namespace)
    {
        $this->_attributes['entityNamespaces'][$alias] = $namespace;
    }

    /**
     * Resolves a registered namespace alias to the full namespace.
     *
     * @param string $entityNamespaceAlias
     *
     * @return string
     *
     * @throws ORMException
     */
    public function getEntityNamespace($entityNamespaceAlias)
    {
        if ( ! isset($this->_attributes['entityNamespaces'][$entityNamespaceAlias])) {
            throw ORMException::unknownEntityNamespace($entityNamespaceAlias);
        }

        return trim($this->_attributes['entityNamespaces'][$entityNamespaceAlias], '\\');
    }

    /**
     * Sets the entity alias map.
     *
     * @param array $entityNamespaces
     *
     * @return void
     */
    public function setEntityNamespaces(array $entityNamespaces)
    {
        $this->_attributes['entityNamespaces'] = $entityNamespaces;
    }

    /**
     * Retrieves the list of registered entity namespace aliases.
     *
     * @return array
     */
    public function getEntityNamespaces()
    {
        return $this->_attributes['entityNamespaces'];
    }

    /**
     * Gets the cache driver implementation that is used for the mapping metadata.
     *
     * @return MappingDriver|null
     *
     * @throws ORMException
     */
    public function getMetadataDriverImpl()
    {
        return isset($this->_attributes['metadataDriverImpl'])
            ? $this->_attributes['metadataDriverImpl']
            : null;
    }

    /**
     * Gets the cache driver implementation that is used for the query cache (SQL cache).
     *
     * @return \Doctrine\Common\Cache\Cache|null
     */
    public function getQueryCacheImpl()
    {
        return isset($this->_attributes['queryCacheImpl'])
            ? $this->_attributes['queryCacheImpl']
            : null;
    }

    /**
     * Sets the cache driver implementation that is used for the query cache (SQL cache).
     *
     * @param \Doctrine\Common\Cache\Cache $cacheImpl
     *
     * @return void
     */
    public function setQueryCacheImpl(CacheDriver $cacheImpl)
    {
        $this->_attributes['queryCacheImpl'] = $cacheImpl;
    }

    /**
     * Gets the cache driver implementation that is used for the hydration cache (SQL cache).
     *
     * @return \Doctrine\Common\Cache\Cache|null
     */
    public function getHydrationCacheImpl()
    {
        return isset($this->_attributes['hydrationCacheImpl'])
            ? $this->_attributes['hydrationCacheImpl']
            : null;
    }

    /**
     * Sets the cache driver implementation that is used for the hydration cache (SQL cache).
     *
     * @param \Doctrine\Common\Cache\Cache $cacheImpl
     *
     * @return void
     */
    public function setHydrationCacheImpl(CacheDriver $cacheImpl)
    {
        $this->_attributes['hydrationCacheImpl'] = $cacheImpl;
    }

    /**
     * Gets the cache driver implementation that is used for metadata caching.
     *
     * @return \Doctrine\Common\Cache\Cache|null
     */
    public function getMetadataCacheImpl()
    {
        return isset($this->_attributes['metadataCacheImpl'])
            ? $this->_attributes['metadataCacheImpl']
            : null;
    }

    /**
     * Sets the cache driver implementation that is used for metadata caching.
     *
     * @param \Doctrine\Common\Cache\Cache $cacheImpl
     *
     * @return void
     */
    public function setMetadataCacheImpl(CacheDriver $cacheImpl)
    {
        $this->_attributes['metadataCacheImpl'] = $cacheImpl;
    }

    /**
     * Adds a named DQL query to the configuration.
     *
     * @param string $name The name of the query.
     * @param string $dql  The DQL query string.
     *
     * @return void
     */
    public function addNamedQuery($name, $dql)
    {
        $this->_attributes['namedQueries'][$name] = $dql;
    }

    /**
     * Gets a previously registered named DQL query.
     *
     * @param string $name The name of the query.
     *
     * @return string The DQL query.
     *
     * @throws ORMException
     */
    public function getNamedQuery($name)
    {
        if ( ! isset($this->_attributes['namedQueries'][$name])) {
            throw ORMException::namedQueryNotFound($name);
        }

        return $this->_attributes['namedQueries'][$name];
    }

    /**
     * Adds a named native query to the configuration.
     *
     * @param string                 $name The name of the query.
     * @param string                 $sql  The native SQL query string.
     * @param Query\ResultSetMapping $rsm  The ResultSetMapping used for the results of the SQL query.
     *
     * @return void
     */
    public function addNamedNativeQuery($name, $sql, Query\ResultSetMapping $rsm)
    {
        $this->_attributes['namedNativeQueries'][$name] = [$sql, $rsm];
    }

    /**
     * Gets the components of a previously registered named native query.
     *
     * @param string $name The name of the query.
     *
     * @return array A tuple with the first element being the SQL string and the second
     *               element being the ResultSetMapping.
     *
     * @throws ORMException
     */
    public function getNamedNativeQuery($name)
    {
        if ( ! isset($this->_attributes['namedNativeQueries'][$name])) {
            throw ORMException::namedNativeQueryNotFound($name);
        }

        return $this->_attributes['namedNativeQueries'][$name];
    }

    /**
     * Ensures that this Configuration instance contains settings that are
     * suitable for a production environment.
     *
     * @return void
     *
     * @throws ORMException If a configuration setting has a value that is not
     *                      suitable for a production environment.
     */
    public function ensureProductionSettings()
    {
        $queryCacheImpl = $this->getQueryCacheImpl();

        if ( ! $queryCacheImpl) {
            throw ORMException::queryCacheNotConfigured();
        }

        if ($queryCacheImpl instanceof ArrayCache) {
            throw ORMException::queryCacheUsesNonPersistentCache($queryCacheImpl);
        }

        $metadataCacheImpl = $this->getMetadataCacheImpl();

        if ( ! $metadataCacheImpl) {
            throw ORMException::metadataCacheNotConfigured();
        }

        if ($metadataCacheImpl instanceof ArrayCache) {
            throw ORMException::metadataCacheUsesNonPersistentCache($metadataCacheImpl);
        }

        if ($this->getAutoGenerateProxyClasses()) {
            throw ORMException::proxyClassesAlwaysRegenerating();
        }
    }

    /**
     * Registers a custom DQL function that produces a string value.
     * Such a function can then be used in any DQL statement in any place where string
     * functions are allowed.
     *
     * DQL function names are case-insensitive.
     *
     * @param string          $name      Function name.
     * @param string|callable $className Class name or a callable that returns the function.
     *
     * @return void
     */
    public function addCustomStringFunction($name, $className)
    {
        $this->_attributes['customStringFunctions'][strtolower($name)] = $className;
    }

    /**
     * Gets the implementation class name of a registered custom string DQL function.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getCustomStringFunction($name)
    {
        $name = strtolower($name);

        return isset($this->_attributes['customStringFunctions'][$name])
            ? $this->_attributes['customStringFunctions'][$name]
            : null;
    }

    /**
     * Sets a map of custom DQL string functions.
     *
     * Keys must be function names and values the FQCN of the implementing class.
     * The function names will be case-insensitive in DQL.
     *
     * Any previously added string functions are discarded.
     *
     * @param array $functions The map of custom DQL string functions.
     *
     * @return void
     */
    public function setCustomStringFunctions(array $functions)
    {
        foreach ($functions as $name => $className) {
            $this->addCustomStringFunction($name, $className);
        }
    }

    /**
     * Registers a custom DQL function that produces a numeric value.
     * Such a function can then be used in any DQL statement in any place where numeric
     * functions are allowed.
     *
     * DQL function names are case-insensitive.
     *
     * @param string          $name      Function name.
     * @param string|callable $className Class name or a callable that returns the function.
     *
     * @return void
     */
    public function addCustomNumericFunction($name, $className)
    {
        $this->_attributes['customNumericFunctions'][strtolower($name)] = $className;
    }

    /**
     * Gets the implementation class name of a registered custom numeric DQL function.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getCustomNumericFunction($name)
    {
        $name = strtolower($name);

        return isset($this->_attributes['customNumericFunctions'][$name])
            ? $this->_attributes['customNumericFunctions'][$name]
            : null;
    }

    /**
     * Sets a map of custom DQL numeric functions.
     *
     * Keys must be function names and values the FQCN of the implementing class.
     * The function names will be case-insensitive in DQL.
     *
     * Any previously added numeric functions are discarded.
     *
     * @param array $functions The map of custom DQL numeric functions.
     *
     * @return void
     */
    public function setCustomNumericFunctions(array $functions)
    {
        foreach ($functions as $name => $className) {
            $this->addCustomNumericFunction($name, $className);
        }
    }

    /**
     * Registers a custom DQL function that produces a date/time value.
     * Such a function can then be used in any DQL statement in any place where date/time
     * functions are allowed.
     *
     * DQL function names are case-insensitive.
     *
     * @param string          $name      Function name.
     * @param string|callable $className Class name or a callable that returns the function.
     *
     * @return void
     */
    public function addCustomDatetimeFunction($name, $className)
    {
        $this->_attributes['customDatetimeFunctions'][strtolower($name)] = $className;
    }

    /**
     * Gets the implementation class name of a registered custom date/time DQL function.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getCustomDatetimeFunction($name)
    {
        $name = strtolower($name);

        return isset($this->_attributes['customDatetimeFunctions'][$name])
            ? $this->_attributes['customDatetimeFunctions'][$name]
            : null;
    }

    /**
     * Sets a map of custom DQL date/time functions.
     *
     * Keys must be function names and values the FQCN of the implementing class.
     * The function names will be case-insensitive in DQL.
     *
     * Any previously added date/time functions are discarded.
     *
     * @param array $functions The map of custom DQL date/time functions.
     *
     * @return void
     */
    public function setCustomDatetimeFunctions(array $functions)
    {
        foreach ($functions as $name => $className) {
            $this->addCustomDatetimeFunction($name, $className);
        }
    }

    /**
     * Sets the custom hydrator modes in one pass.
     *
     * @param array $modes An array of ($modeName => $hydrator).
     *
     * @return void
     */
    public function setCustomHydrationModes($modes)
    {
        $this->_attributes['customHydrationModes'] = [];

        foreach ($modes as $modeName => $hydrator) {
            $this->addCustomHydrationMode($modeName, $hydrator);
        }
    }

    /**
     * Gets the hydrator class for the given hydration mode name.
     *
     * @param string $modeName The hydration mode name.
     *
     * @return string|null The hydrator class name.
     */
    public function getCustomHydrationMode($modeName)
    {
        return isset($this->_attributes['customHydrationModes'][$modeName])
            ? $this->_attributes['customHydrationModes'][$modeName]
            : null;
    }

    /**
     * Adds a custom hydration mode.
     *
     * @param string $modeName The hydration mode name.
     * @param string $hydrator The hydrator class name.
     *
     * @return void
     */
    public function addCustomHydrationMode($modeName, $hydrator)
    {
        $this->_attributes['customHydrationModes'][$modeName] = $hydrator;
    }

    /**
     * Sets a class metadata factory.
     *
     * @param string $cmfName
     *
     * @return void
     */
    public function setClassMetadataFactoryName($cmfName)
    {
        $this->_attributes['classMetadataFactoryName'] = $cmfName;
    }

    /**
     * @return string
     */
    public function getClassMetadataFactoryName()
    {
        if ( ! isset($this->_attributes['classMetadataFactoryName'])) {
            $this->_attributes['classMetadataFactoryName'] = ClassMetadataFactory::class;
        }

        return $this->_attributes['classMetadataFactoryName'];
    }

    /**
     * Adds a filter to the list of possible filters.
     *
     * @param string $name      The name of the filter.
     * @param string $className The class name of the filter.
     */
    public function addFilter($name, $className)
    {
        $this->_attributes['filters'][$name] = $className;
    }

    /**
     * Gets the class name for a given filter name.
     *
     * @param string $name The name of the filter.
     *
     * @return string The class name of the filter, or null if it is not
     *  defined.
     */
    public function getFilterClassName($name)
    {
        return isset($this->_attributes['filters'][$name])
            ? $this->_attributes['filters'][$name]
            : null;
    }

    /**
     * Sets default repository class.
     *
     * @since 2.2
     *
     * @param string $className
     *
     * @return void
     *
     * @throws ORMException If not is a \Doctrine\Common\Persistence\ObjectRepository
     */
    public function setDefaultRepositoryClassName($className)
    {
        $reflectionClass = new \ReflectionClass($className);

        if ( ! $reflectionClass->implementsInterface(ObjectRepository::class)) {
            throw ORMException::invalidEntityRepository($className);
        }

        $this->_attributes['defaultRepositoryClassName'] = $className;
    }

    /**
     * Get default repository class.
     *
     * @since 2.2
     *
     * @return string
     */
    public function getDefaultRepositoryClassName()
    {
        return isset($this->_attributes['defaultRepositoryClassName'])
            ? $this->_attributes['defaultRepositoryClassName']
            : EntityRepository::class;
    }

    /**
     * Sets naming strategy.
     *
     * @since 2.3
     *
     * @param NamingStrategy $namingStrategy
     *
     * @return void
     */
    public function setNamingStrategy(NamingStrategy $namingStrategy)
    {
        $this->_attributes['namingStrategy'] = $namingStrategy;
    }

    /**
     * Gets naming strategy..
     *
     * @since 2.3
     *
     * @return NamingStrategy
     */
    public function getNamingStrategy()
    {
        if ( ! isset($this->_attributes['namingStrategy'])) {
            $this->_attributes['namingStrategy'] = new DefaultNamingStrategy();
        }

        return $this->_attributes['namingStrategy'];
    }

    /**
     * Sets quote strategy.
     *
     * @since 2.3
     *
     * @param \Doctrine\ORM\Mapping\QuoteStrategy $quoteStrategy
     *
     * @return void
     */
    public function setQuoteStrategy(QuoteStrategy $quoteStrategy)
    {
        $this->_attributes['quoteStrategy'] = $quoteStrategy;
    }

    /**
     * Gets quote strategy.
     *
     * @since 2.3
     *
     * @return \Doctrine\ORM\Mapping\QuoteStrategy
     */
    public function getQuoteStrategy()
    {
        if ( ! isset($this->_attributes['quoteStrategy'])) {
            $this->_attributes['quoteStrategy'] = new DefaultQuoteStrategy();
        }

        return $this->_attributes['quoteStrategy'];
    }

    /**
     * Set the entity listener resolver.
     *
     * @since 2.4
     * @param \Doctrine\ORM\Mapping\EntityListenerResolver $resolver
     */
    public function setEntityListenerResolver(EntityListenerResolver $resolver)
    {
        $this->_attributes['entityListenerResolver'] = $resolver;
    }

    /**
     * Get the entity listener resolver.
     *
     * @since 2.4
     * @return \Doctrine\ORM\Mapping\EntityListenerResolver
     */
    public function getEntityListenerResolver()
    {
        if ( ! isset($this->_attributes['entityListenerResolver'])) {
            $this->_attributes['entityListenerResolver'] = new DefaultEntityListenerResolver();
        }

        return $this->_attributes['entityListenerResolver'];
    }

    /**
     * Set the entity repository factory.
     *
     * @since 2.4
     * @param \Doctrine\ORM\Repository\RepositoryFactory $repositoryFactory
     */
    public function setRepositoryFactory(RepositoryFactory $repositoryFactory)
    {
        $this->_attributes['repositoryFactory'] = $repositoryFactory;
    }

    /**
     * Get the entity repository factory.
     *
     * @since 2.4
     * @return \Doctrine\ORM\Repository\RepositoryFactory
     */
    public function getRepositoryFactory()
    {
        return isset($this->_attributes['repositoryFactory'])
            ? $this->_attributes['repositoryFactory']
            : new DefaultRepositoryFactory();
    }

    /**
     * @since 2.5
     *
     * @return boolean
     */
    public function isSecondLevelCacheEnabled()
    {
        return isset($this->_attributes['isSecondLevelCacheEnabled'])
            ? $this->_attributes['isSecondLevelCacheEnabled']
            : false;
    }

    /**
     * @since 2.5
     *
     * @param boolean $flag
     *
     * @return void
     */
    public function setSecondLevelCacheEnabled($flag = true)
    {
        $this->_attributes['isSecondLevelCacheEnabled'] = (boolean) $flag;
    }

    /**
     * @since 2.5
     *
     * @param \Doctrine\ORM\Cache\CacheConfiguration $cacheConfig
     *
     * @return void
     */
    public function setSecondLevelCacheConfiguration(CacheConfiguration $cacheConfig)
    {
        $this->_attributes['secondLevelCacheConfiguration'] = $cacheConfig;
    }

    /**
     * @since 2.5
     *
     * @return  \Doctrine\ORM\Cache\CacheConfiguration|null
     */
    public function getSecondLevelCacheConfiguration()
    {
        if ( ! isset($this->_attributes['secondLevelCacheConfiguration']) && $this->isSecondLevelCacheEnabled()) {
            $this->_attributes['secondLevelCacheConfiguration'] = new CacheConfiguration();
        }

        return isset($this->_attributes['secondLevelCacheConfiguration'])
            ? $this->_attributes['secondLevelCacheConfiguration']
            : null;
    }

    /**
     * Returns query hints, which will be applied to every query in application
     *
     * @since 2.5
     *
     * @return array
     */
    public function getDefaultQueryHints()
    {
        return isset($this->_attributes['defaultQueryHints']) ? $this->_attributes['defaultQueryHints'] : [];
    }

    /**
     * Sets array of query hints, which will be applied to every query in application
     *
     * @since 2.5
     *
     * @param array $defaultQueryHints
     */
    public function setDefaultQueryHints(array $defaultQueryHints)
    {
        $this->_attributes['defaultQueryHints'] = $defaultQueryHints;
    }

    /**
     * Gets the value of a default query hint. If the hint name is not recognized, FALSE is returned.
     *
     * @since 2.5
     *
     * @param string $name The name of the hint.
     *
     * @return mixed The value of the hint or FALSE, if the hint name is not recognized.
     */
    public function getDefaultQueryHint($name)
    {
        return isset($this->_attributes['defaultQueryHints'][$name])
            ? $this->_attributes['defaultQueryHints'][$name]
            : false;
    }

    /**
     * Sets a default query hint. If the hint name is not recognized, it is silently ignored.
     *
     * @since 2.5
     *
     * @param string $name  The name of the hint.
     * @param mixed  $value The value of the hint.
     */
    public function setDefaultQueryHint($name, $value)
    {
        $this->_attributes['defaultQueryHints'][$name] = $value;
    }
}
