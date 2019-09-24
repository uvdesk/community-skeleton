<?php

namespace Doctrine\Bundle\DoctrineBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use ReflectionClass;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use function array_key_exists;
use function is_array;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 */
class Configuration implements ConfigurationInterface
{
    /** @var bool */
    private $debug;

    /**
     * @param bool $debug Whether to use the debug mode
     */
    public function __construct($debug)
    {
        $this->debug = (bool) $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('doctrine');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('doctrine');
        }

        $this->addDbalSection($rootNode);
        $this->addOrmSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add DBAL section to configuration tree
     */
    private function addDbalSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('dbal')
                ->beforeNormalization()
                    ->ifTrue(static function ($v) {
                        return is_array($v) && ! array_key_exists('connections', $v) && ! array_key_exists('connection', $v);
                    })
                    ->then(static function ($v) {
                        // Key that should not be rewritten to the connection config
                        $excludedKeys = ['default_connection' => true, 'types' => true, 'type' => true];
                        $connection   = [];
                        foreach ($v as $key => $value) {
                            if (isset($excludedKeys[$key])) {
                                continue;
                            }
                            $connection[$key] = $v[$key];
                            unset($v[$key]);
                        }
                        $v['default_connection'] = isset($v['default_connection']) ? (string) $v['default_connection'] : 'default';
                        $v['connections']        = [$v['default_connection'] => $connection];

                        return $v;
                    })
                ->end()
                ->children()
                    ->scalarNode('default_connection')->end()
                ->end()
                ->fixXmlConfig('type')
                ->children()
                    ->arrayNode('types')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(static function ($v) {
                                    return ['class' => $v];
                                })
                            ->end()
                            ->children()
                                ->scalarNode('class')->isRequired()->end()
                                ->booleanNode('commented')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->fixXmlConfig('connection')
                ->append($this->getDbalConnectionsNode())
            ->end();
    }

    /**
     * Return the dbal connections node
     *
     * @return ArrayNodeDefinition
     */
    private function getDbalConnectionsNode()
    {
        $treeBuilder = new TreeBuilder('connections');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $node = $treeBuilder->root('connections');
        }

        /** @var ArrayNodeDefinition $connectionNode */
        $connectionNode = $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array');

        $this->configureDbalDriverNode($connectionNode);

        $connectionNode
            ->fixXmlConfig('option')
            ->fixXmlConfig('mapping_type')
            ->fixXmlConfig('slave')
            ->fixXmlConfig('shard')
            ->fixXmlConfig('default_table_option')
            ->children()
                ->scalarNode('driver')->defaultValue('pdo_mysql')->end()
                ->scalarNode('platform_service')->end()
                ->booleanNode('auto_commit')->end()
                ->scalarNode('schema_filter')->end()
                ->booleanNode('logging')->defaultValue($this->debug)->end()
                ->booleanNode('profiling')->defaultValue($this->debug)->end()
                ->booleanNode('profiling_collect_backtrace')
                    ->defaultValue(false)
                    ->info('Enables collecting backtraces when profiling is enabled')
                ->end()
                ->scalarNode('server_version')->end()
                ->scalarNode('driver_class')->end()
                ->scalarNode('wrapper_class')->end()
                ->scalarNode('shard_manager_class')->end()
                ->scalarNode('shard_choser')->end()
                ->scalarNode('shard_choser_service')->end()
                ->booleanNode('keep_slave')->end()
                ->arrayNode('options')
                    ->useAttributeAsKey('key')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('mapping_types')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('default_table_options')
                    ->info("This option is used by the schema-tool and affects generated SQL. Possible keys include 'charset','collate', and 'engine'.")
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        $slaveNode = $connectionNode
            ->children()
                ->arrayNode('slaves')
                    ->useAttributeAsKey('name')
                    ->prototype('array');
        $this->configureDbalDriverNode($slaveNode);

        $shardNode = $connectionNode
            ->children()
                ->arrayNode('shards')
                    ->prototype('array')
                    ->children()
                        ->integerNode('id')
                            ->min(1)
                            ->isRequired()
                        ->end()
                    ->end();
        $this->configureDbalDriverNode($shardNode);

        return $node;
    }

    /**
     * Adds config keys related to params processed by the DBAL drivers
     *
     * These keys are available for slave configurations too.
     */
    private function configureDbalDriverNode(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('url')->info('A URL with connection information; any parameter value parsed from this string will override explicitly set parameters')->end()
                ->scalarNode('dbname')->end()
                ->scalarNode('host')->defaultValue('localhost')->end()
                ->scalarNode('port')->defaultNull()->end()
                ->scalarNode('user')->defaultValue('root')->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('application_name')->end()
                ->scalarNode('charset')->end()
                ->scalarNode('path')->end()
                ->booleanNode('memory')->end()
                ->scalarNode('unix_socket')->info('The unix socket to use for MySQL')->end()
                ->booleanNode('persistent')->info('True to use as persistent connection for the ibm_db2 driver')->end()
                ->scalarNode('protocol')->info('The protocol to use for the ibm_db2 driver (default to TCPIP if ommited)')->end()
                ->booleanNode('service')
                    ->info('True to use SERVICE_NAME as connection parameter instead of SID for Oracle')
                ->end()
                ->scalarNode('servicename')
                    ->info(
                        'Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter ' .
                        'for Oracle depending on the service parameter.'
                    )
                ->end()
                ->scalarNode('sessionMode')
                    ->info('The session mode to use for the oci8 driver')
                ->end()
                ->scalarNode('server')
                    ->info('The name of a running database server to connect to for SQL Anywhere.')
                ->end()
                ->scalarNode('default_dbname')
                    ->info(
                        'Override the default database (postgres) to connect to for PostgreSQL connexion.'
                    )
                ->end()
                ->scalarNode('sslmode')
                    ->info(
                        'Determines whether or with what priority a SSL TCP/IP connection will be negotiated with ' .
                        'the server for PostgreSQL.'
                    )
                ->end()
                ->scalarNode('sslrootcert')
                    ->info(
                        'The name of a file containing SSL certificate authority (CA) certificate(s). ' .
                        'If the file exists, the server\'s certificate will be verified to be signed by one of these authorities.'
                    )
                ->end()
                ->scalarNode('sslcert')
                    ->info(
                        'The path to the SSL client certificate file for PostgreSQL.'
                    )
                ->end()
                ->scalarNode('sslkey')
                    ->info(
                        'The path to the SSL client key file for PostgreSQL.'
                    )
                ->end()
                ->scalarNode('sslcrl')
                    ->info(
                        'The file name of the SSL certificate revocation list for PostgreSQL.'
                    )
                ->end()
                ->booleanNode('pooled')->info('True to use a pooled server with the oci8/pdo_oracle driver')->end()
                ->booleanNode('MultipleActiveResultSets')->info('Configuring MultipleActiveResultSets for the pdo_sqlsrv driver')->end()
                ->booleanNode('use_savepoints')->info('Use savepoints for nested transactions')->end()
                ->scalarNode('instancename')
                ->info(
                    'Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection.' .
                    ' It is generally used to connect to an Oracle RAC server to select the name' .
                    ' of a particular instance.'
                )
                ->end()
                ->scalarNode('connectstring')
                ->info(
                    'Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.' .
                    'When using this option, you will still need to provide the user and password parameters, but the other ' .
                    'parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods' .
                    ' from Doctrine\DBAL\Connection will no longer function as expected.'
                )
                ->end()
            ->end()
            ->beforeNormalization()
                ->ifTrue(static function ($v) {
                    return ! isset($v['sessionMode']) && isset($v['session_mode']);
                })
                ->then(static function ($v) {
                    $v['sessionMode'] = $v['session_mode'];
                    unset($v['session_mode']);

                    return $v;
                })
            ->end()
            ->beforeNormalization()
                ->ifTrue(static function ($v) {
                    return ! isset($v['MultipleActiveResultSets']) && isset($v['multiple_active_result_sets']);
                })
                ->then(static function ($v) {
                    $v['MultipleActiveResultSets'] = $v['multiple_active_result_sets'];
                    unset($v['multiple_active_result_sets']);

                    return $v;
                })
            ->end();
    }

    /**
     * Add the ORM section to configuration tree
     */
    private function addOrmSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('orm')
                    ->beforeNormalization()
                        ->ifTrue(static function ($v) {
                            if (! empty($v) && ! class_exists(EntityManager::class)) {
                                throw new LogicException('The doctrine/orm package is required when the doctrine.orm config is set.');
                            }

                            return $v === null || (is_array($v) && ! array_key_exists('entity_managers', $v) && ! array_key_exists('entity_manager', $v));
                        })
                        ->then(static function ($v) {
                            $v = (array) $v;
                            // Key that should not be rewritten to the connection config
                            $excludedKeys  = [
                                'default_entity_manager' => true,
                                'auto_generate_proxy_classes' => true,
                                'proxy_dir' => true,
                                'proxy_namespace' => true,
                                'resolve_target_entities' => true,
                                'resolve_target_entity' => true,
                            ];
                            $entityManager = [];
                            foreach ($v as $key => $value) {
                                if (isset($excludedKeys[$key])) {
                                    continue;
                                }
                                $entityManager[$key] = $v[$key];
                                unset($v[$key]);
                            }
                            $v['default_entity_manager'] = isset($v['default_entity_manager']) ? (string) $v['default_entity_manager'] : 'default';
                            $v['entity_managers']        = [$v['default_entity_manager'] => $entityManager];

                            return $v;
                        })
                    ->end()
                    ->children()
                        ->scalarNode('default_entity_manager')->end()
                        ->scalarNode('auto_generate_proxy_classes')->defaultValue(false)
                            ->info('Auto generate mode possible values are: "NEVER", "ALWAYS", "FILE_NOT_EXISTS", "EVAL"')
                            ->validate()
                                ->ifTrue(function ($v) {
                                    $generationModes = $this->getAutoGenerateModes();

                                    if (is_int($v) && in_array($v, $generationModes['values']/*array(0, 1, 2, 3)*/)) {
                                        return false;
                                    }
                                    if (is_bool($v)) {
                                        return false;
                                    }
                                    if (is_string($v)) {
                                        if (in_array(strtoupper($v), $generationModes['names']/*array('NEVER', 'ALWAYS', 'FILE_NOT_EXISTS', 'EVAL')*/)) {
                                            return false;
                                        }
                                    }

                                    return true;
                                })
                                ->thenInvalid('Invalid auto generate mode value %s')
                            ->end()
                            ->validate()
                                ->ifString()
                                ->then(static function ($v) {
                                    return constant('Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_' . strtoupper($v));
                                })
                            ->end()
                        ->end()
                        ->scalarNode('proxy_dir')->defaultValue('%kernel.cache_dir%/doctrine/orm/Proxies')->end()
                        ->scalarNode('proxy_namespace')->defaultValue('Proxies')->end()
                    ->end()
                    ->fixXmlConfig('entity_manager')
                    ->append($this->getOrmEntityManagersNode())
                    ->fixXmlConfig('resolve_target_entity', 'resolve_target_entities')
                    ->append($this->getOrmTargetEntityResolverNode())
                ->end()
            ->end();
    }

    /**
     * Return ORM target entity resolver node
     *
     * @return NodeDefinition
     */
    private function getOrmTargetEntityResolverNode()
    {
        $treeBuilder = new TreeBuilder('resolve_target_entities');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $node = $treeBuilder->root('resolve_target_entities');
        }

        $node
            ->useAttributeAsKey('interface')
            ->prototype('scalar')
                ->cannotBeEmpty()
            ->end();

        return $node;
    }

    /**
     * Return ORM entity listener node
     *
     * @return NodeDefinition
     */
    private function getOrmEntityListenersNode()
    {
        $treeBuilder = new TreeBuilder('entity_listeners');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $node = $treeBuilder->root('entity_listeners');
        }

        $normalizer = static function ($mappings) {
            $entities = [];

            foreach ($mappings as $entityClass => $mapping) {
                $listeners = [];

                foreach ($mapping as $listenerClass => $listenerEvent) {
                    $events = [];

                    foreach ($listenerEvent as $eventType => $eventMapping) {
                        if ($eventMapping === null) {
                            $eventMapping = [null];
                        }

                        foreach ($eventMapping as $method) {
                            $events[] = [
                                'type' => $eventType,
                                'method' => $method,
                            ];
                        }
                    }

                    $listeners[] = [
                        'class' => $listenerClass,
                        'event' => $events,
                    ];
                }

                $entities[] = [
                    'class' => $entityClass,
                    'listener' => $listeners,
                ];
            }

            return ['entities' => $entities];
        };

        $node
            ->beforeNormalization()
                // Yaml normalization
                ->ifTrue(static function ($v) {
                    return is_array(reset($v)) && is_string(key(reset($v)));
                })
                ->then($normalizer)
            ->end()
            ->fixXmlConfig('entity', 'entities')
            ->children()
                ->arrayNode('entities')
                    ->useAttributeAsKey('class')
                    ->prototype('array')
                        ->fixXmlConfig('listener')
                        ->children()
                            ->arrayNode('listeners')
                                ->useAttributeAsKey('class')
                                ->prototype('array')
                                    ->fixXmlConfig('event')
                                    ->children()
                                        ->arrayNode('events')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('type')->end()
                                                    ->scalarNode('method')->defaultNull()->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $node;
    }

    /**
     * Return ORM entity manager node
     *
     * @return ArrayNodeDefinition
     */
    private function getOrmEntityManagersNode()
    {
        $treeBuilder = new TreeBuilder('entity_managers');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $node = $treeBuilder->root('entity_managers');
        }

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->addDefaultsIfNotSet()
                ->append($this->getOrmCacheDriverNode('query_cache_driver'))
                ->append($this->getOrmCacheDriverNode('metadata_cache_driver'))
                ->append($this->getOrmCacheDriverNode('result_cache_driver'))
                ->append($this->getOrmEntityListenersNode())
                ->children()
                    ->scalarNode('connection')->end()
                    ->scalarNode('class_metadata_factory_name')->defaultValue('Doctrine\ORM\Mapping\ClassMetadataFactory')->end()
                    ->scalarNode('default_repository_class')->defaultValue('Doctrine\ORM\EntityRepository')->end()
                    ->scalarNode('auto_mapping')->defaultFalse()->end()
                    ->scalarNode('naming_strategy')->defaultValue('doctrine.orm.naming_strategy.default')->end()
                    ->scalarNode('quote_strategy')->defaultValue('doctrine.orm.quote_strategy.default')->end()
                    ->scalarNode('entity_listener_resolver')->defaultNull()->end()
                    ->scalarNode('repository_factory')->defaultValue('doctrine.orm.container_repository_factory')->end()
                ->end()
                ->children()
                    ->arrayNode('second_level_cache')
                        ->children()
                            ->append($this->getOrmCacheDriverNode('region_cache_driver'))
                            ->scalarNode('region_lock_lifetime')->defaultValue(60)->end()
                            ->booleanNode('log_enabled')->defaultValue($this->debug)->end()
                            ->scalarNode('region_lifetime')->defaultValue(0)->end()
                            ->booleanNode('enabled')->defaultValue(true)->end()
                            ->scalarNode('factory')->end()
                        ->end()
                        ->fixXmlConfig('region')
                        ->children()
                            ->arrayNode('regions')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->append($this->getOrmCacheDriverNode('cache_driver'))
                                        ->scalarNode('lock_path')->defaultValue('%kernel.cache_dir%/doctrine/orm/slc/filelock')->end()
                                        ->scalarNode('lock_lifetime')->defaultValue(60)->end()
                                        ->scalarNode('type')->defaultValue('default')->end()
                                        ->scalarNode('lifetime')->defaultValue(0)->end()
                                        ->scalarNode('service')->end()
                                        ->scalarNode('name')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->fixXmlConfig('logger')
                        ->children()
                            ->arrayNode('loggers')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('service')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->fixXmlConfig('hydrator')
                ->children()
                    ->arrayNode('hydrators')
                        ->useAttributeAsKey('name')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
                ->fixXmlConfig('mapping')
                ->children()
                    ->arrayNode('mappings')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(static function ($v) {
                                    return ['type' => $v];
                                })
                            ->end()
                            ->treatNullLike([])
                            ->treatFalseLike(['mapping' => false])
                            ->performNoDeepMerging()
                            ->children()
                                ->scalarNode('mapping')->defaultValue(true)->end()
                                ->scalarNode('type')->end()
                                ->scalarNode('dir')->end()
                                ->scalarNode('alias')->end()
                                ->scalarNode('prefix')->end()
                                ->booleanNode('is_bundle')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('dql')
                        ->fixXmlConfig('string_function')
                        ->fixXmlConfig('numeric_function')
                        ->fixXmlConfig('datetime_function')
                        ->children()
                            ->arrayNode('string_functions')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('numeric_functions')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('datetime_functions')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->fixXmlConfig('filter')
                ->children()
                    ->arrayNode('filters')
                        ->info('Register SQL Filters in the entity manager')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(static function ($v) {
                                    return ['class' => $v];
                                })
                            ->end()
                            ->beforeNormalization()
                                // The content of the XML node is returned as the "value" key so we need to rename it
                                ->ifTrue(static function ($v) {
                                    return is_array($v) && isset($v['value']);
                                })
                                ->then(static function ($v) {
                                    $v['class'] = $v['value'];
                                    unset($v['value']);

                                    return $v;
                                })
                            ->end()
                            ->fixXmlConfig('parameter')
                            ->children()
                                ->scalarNode('class')->isRequired()->end()
                                ->booleanNode('enabled')->defaultFalse()->end()
                                ->arrayNode('parameters')
                                    ->useAttributeAsKey('name')
                                    ->prototype('variable')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $node;
    }

    /**
     * Return a ORM cache driver node for an given entity manager
     *
     * @param string $name
     *
     * @return ArrayNodeDefinition
     */
    private function getOrmCacheDriverNode($name)
    {
        $treeBuilder = new TreeBuilder($name);

        if (method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $node = $treeBuilder->root($name);
        }

        $node
            ->addDefaultsIfNotSet()
            ->beforeNormalization()
                ->ifString()
                ->then(static function ($v) : array {
                    return ['type' => $v];
                })
            ->end()
            ->beforeNormalization()
                ->ifTrue(static function ($v) : bool {
                    return is_array($v) && array_key_exists('cache_provider', $v);
                })
                ->then(static function ($v) : array {
                    return ['type' => 'provider'] + $v;
                })
            ->end()
            ->children()
                ->scalarNode('type')->defaultValue('array')->end()
                ->scalarNode('id')->end()
                ->scalarNode('pool')->end()
                ->scalarNode('host')->end()
                ->scalarNode('port')->end()
                ->scalarNode('database')->end()
                ->scalarNode('instance_class')->end()
                ->scalarNode('class')->end()
                ->scalarNode('namespace')->defaultNull()->end()
                ->scalarNode('cache_provider')->defaultNull()->end()
            ->end();

        return $node;
    }

    /**
     * Find proxy auto generate modes for their names and int values
     *
     * @return array
     */
    private function getAutoGenerateModes()
    {
        $constPrefix = 'AUTOGENERATE_';
        $prefixLen   = strlen($constPrefix);
        $refClass    = new ReflectionClass('Doctrine\Common\Proxy\AbstractProxyFactory');
        $constsArray = $refClass->getConstants();
        $namesArray  = [];
        $valuesArray = [];

        foreach ($constsArray as $key => $value) {
            if (strpos($key, $constPrefix) !== 0) {
                continue;
            }

            $namesArray[]  = substr($key, $prefixLen);
            $valuesArray[] = (int) $value;
        }

        return [
            'names' => $namesArray,
            'values' => $valuesArray,
        ];
    }
}
