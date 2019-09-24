<?php

namespace Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler;

use Symfony\Bridge\Doctrine\DependencyInjection\CompilerPass\RegisterMappingsPass;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class for Symfony bundles to configure mappings for model classes not in the
 * auto-mapped folder.
 *
 * NOTE: alias is only supported by Symfony 2.6+ and will be ignored with older versions.
 */
class DoctrineOrmMappingsPass extends RegisterMappingsPass
{
    /**
     * You should not directly instantiate this class but use one of the
     * factory methods.
     *
     * @param Definition|Reference $driver            Driver DI definition or reference.
     * @param array                $namespaces        List of namespaces handled by $driver.
     * @param string[]             $managerParameters Ordered list of container parameters that
     *                                                could hold the manager name.
     *                                                doctrine.default_entity_manager is appended
     *                                                automatically.
     * @param string|false         $enabledParameter  If specified, the compiler pass only executes
     *                                                if this parameter is defined in the service
     *                                                container.
     * @param array                $aliasMap          Map of alias to namespace.
     */
    public function __construct($driver, array $namespaces, array $managerParameters, $enabledParameter = false, array $aliasMap = [])
    {
        $managerParameters[] = 'doctrine.default_entity_manager';
        parent::__construct(
            $driver,
            $namespaces,
            $managerParameters,
            'doctrine.orm.%s_metadata_driver',
            $enabledParameter,
            'doctrine.orm.%s_configuration',
            'addEntityNamespace',
            $aliasMap
        );
    }

    /**
     * @param array        $namespaces        Hashmap of directory path to namespace.
     * @param string[]     $managerParameters List of parameters that could which object manager name
     *                                        your bundle uses. This compiler pass will automatically
     *                                        append the parameter name for the default entity manager
     *                                        to this list.
     * @param string|false $enabledParameter  Service container parameter that must be present to
     *                                        enable the mapping. Set to false to not do any check,
     *                                        optional.
     * @param string[]     $aliasMap          Map of alias to namespace.
     *
     * @return self
     */
    public static function createXmlMappingDriver(array $namespaces, array $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator', [$namespaces, '.orm.xml']);
        $driver  = new Definition('Doctrine\ORM\Mapping\Driver\XmlDriver', [$locator]);

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }

    /**
     * @param array        $namespaces        Hashmap of directory path to namespace
     * @param string[]     $managerParameters List of parameters that could which object manager name
     *                                        your bundle uses. This compiler pass will automatically
     *                                        append the parameter name for the default entity manager
     *                                        to this list.
     * @param string|false $enabledParameter  Service container parameter that must be present to
     *                                        enable the mapping. Set to false to not do any check,
     *                                        optional.
     * @param string[]     $aliasMap          Map of alias to namespace.
     *
     * @return self
     */
    public static function createYamlMappingDriver(array $namespaces, array $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator', [$namespaces, '.orm.yml']);
        $driver  = new Definition('Doctrine\ORM\Mapping\Driver\YamlDriver', [$locator]);

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }

    /**
     * @param array        $namespaces        Hashmap of directory path to namespace
     * @param string[]     $managerParameters List of parameters that could which object manager name
     *                                        your bundle uses. This compiler pass will automatically
     *                                        append the parameter name for the default entity manager
     *                                        to this list.
     * @param string|false $enabledParameter  Service container parameter that must be present to
     *                                        enable the mapping. Set to false to not do any check,
     *                                        optional.
     * @param string[]     $aliasMap          Map of alias to namespace.
     *
     * @return self
     */
    public static function createPhpMappingDriver(array $namespaces, array $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator', [$namespaces, '.php']);
        $driver  = new Definition('Doctrine\Common\Persistence\Mapping\Driver\PHPDriver', [$locator]);

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }

    /**
     * @param array        $namespaces        List of namespaces that are handled with annotation mapping
     * @param array        $directories       List of directories to look for annotated classes
     * @param string[]     $managerParameters List of parameters that could which object manager name
     *                                        your bundle uses. This compiler pass will automatically
     *                                        append the parameter name for the default entity manager
     *                                        to this list.
     * @param string|false $enabledParameter  Service container parameter that must be present to
     *                                        enable the mapping. Set to false to not do any check,
     *                                        optional.
     * @param string[]     $aliasMap          Map of alias to namespace.
     *
     * @return self
     */
    public static function createAnnotationMappingDriver(array $namespaces, array $directories, array $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        $reader = new Reference('annotation_reader');
        $driver = new Definition('Doctrine\ORM\Mapping\Driver\AnnotationDriver', [$reader, $directories]);

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }

    /**
     * @param array        $namespaces        List of namespaces that are handled with static php mapping
     * @param array        $directories       List of directories to look for static php mapping files
     * @param string[]     $managerParameters List of parameters that could which object manager name
     *                                        your bundle uses. This compiler pass will automatically
     *                                        append the parameter name for the default entity manager
     *                                        to this list.
     * @param string|false $enabledParameter  Service container parameter that must be present to
     *                                        enable the mapping. Set to false to not do any check,
     *                                        optional.
     * @param string[]     $aliasMap          Map of alias to namespace.
     *
     * @return self
     */
    public static function createStaticPhpMappingDriver(array $namespaces, array $directories, array $managerParameters = [], $enabledParameter = false, array $aliasMap = [])
    {
        $driver = new Definition('Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver', [$directories]);

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter, $aliasMap);
    }
}
