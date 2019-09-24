<?php
namespace Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

/**
 * Cache Bundle Configuration
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @param array $parameters
     *
     * @return string
     */
    public function getProviderParameters(array $parameters)
    {
        if (isset($parameters['type'])) {
            unset($parameters['type']);
        }

        if (isset($parameters['aliases'])) {
            unset($parameters['aliases']);
        }

        if (isset($parameters['namespace'])) {
            unset($parameters['namespace']);
        }

        return $parameters;
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    public function resolveNodeType(array $parameters)
    {
        $values = $this->getProviderParameters($parameters);
        $type   = key($values);

        return $type;
    }

    /**
     * @param \Symfony\Component\Config\Definition\NodeInterface $tree
     *
     * @return array
     */
    public function getProviderNames(NodeInterface $tree)
    {
        foreach ($tree->getChildren() as $providers) {
            if ($providers->getName() !== 'providers') {
                continue;
            }

            $children  = $providers->getPrototype()->getChildren();
            $providers =  array_diff(array_keys($children), array('type', 'aliases', 'namespace'));

            return $providers;
        }

        return array();
    }

    /**
     * @param string                                                $type
     * @param \Symfony\Component\Config\Definition\NodeInterface    $tree
     *
     * @return boolean
     */
    public function isCustomProvider($type, NodeInterface $tree)
    {
        return ( ! in_array($type, $this->getProviderNames($tree)));
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $self            = $this;
        $builder         = new TreeBuilder('doctrine_cache');
        $node            = $this->getRootNode($builder, 'doctrine_cache');
        $normalization   = function ($conf) use ($self, $builder) {
            $conf['type'] = isset($conf['type'])
                ? $conf['type']
                : $self->resolveNodeType($conf);

            if ($self->isCustomProvider($conf['type'], $builder->buildTree())) {
                $params  = $self->getProviderParameters($conf);
                $options = reset($params);
                $conf    = array(
                    'type'            => 'custom_provider',
                    'namespace' => isset($conf['namespace']) ? $conf['namespace'] : null ,
                    'custom_provider' => array(
                        'type'      => $conf['type'],
                        'options'   => $options ?: null,
                    )
                );
            }

            return $conf;
        };

        $node
            ->children()
                ->arrayNode('acl_cache')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($id) {
                            return array('id' => $id);
                        })
                    ->end()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('id')->end()
                    ->end()
                ->end()
            ->end()
            ->fixXmlConfig('custom_provider')
            ->children()
                ->arrayNode('custom_providers')
                ->useAttributeAsKey('type')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('prototype')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('definition_class')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->fixXmlConfig('alias', 'aliases')
            ->children()
                ->arrayNode('aliases')
                ->useAttributeAsKey('key')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
            ->fixXmlConfig('provider')
            ->children()
                ->arrayNode('providers')
                ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function ($v) use ($self, $builder) {
                                return ( ! isset($v['type']) || ! $self->isCustomProvider($v['type'], $builder->buildTree()));
                            })
                            ->then($normalization)
                        ->end()
                        ->children()
                            ->scalarNode('namespace')->defaultNull()->end()
                            ->scalarNode('type')->defaultNull()->end()
                            ->append($this->addBasicProviderNode('apc'))
                            ->append($this->addBasicProviderNode('apcu'))
                            ->append($this->addBasicProviderNode('array'))
                            ->append($this->addBasicProviderNode('void'))
                            ->append($this->addBasicProviderNode('wincache'))
                            ->append($this->addBasicProviderNode('xcache'))
                            ->append($this->addBasicProviderNode('zenddata'))
                            ->append($this->addCustomProviderNode())
                            ->append($this->addCouchbaseNode())
                            ->append($this->addChainNode())
                            ->append($this->addMemcachedNode())
                            ->append($this->addMemcacheNode())
                            ->append($this->addFileSystemNode())
                            ->append($this->addPhpFileNode())
                            ->append($this->addMongoNode())
                            ->append($this->addRedisNode())
                            ->append($this->addPredisNode())
                            ->append($this->addRiakNode())
                            ->append($this->addSqlite3Node())
                        ->end()
                        ->fixXmlConfig('alias', 'aliases')
                        ->children()
                            ->arrayNode('aliases')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }

    /**
     * @param string $name
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addBasicProviderNode($name)
    {
        $builder = new TreeBuilder($name);
        $node    = $this->getRootNode($builder, $name);

        return $node;
    }

    /**
     * Build custom node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addCustomProviderNode()
    {
        $builder = new TreeBuilder('custom_provider');
        $node    = $this->getRootNode($builder, 'custom_provider');

        $node
            ->children()
                ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('options')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build chain node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addChainNode()
    {
        $builder = new TreeBuilder('chain');
        $node    = $this->getRootNode($builder, 'chain');

        $node
            ->fixXmlConfig('provider')
            ->children()
                ->arrayNode('providers')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build memcache node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addMemcacheNode()
    {
        $builder = new TreeBuilder('memcache');
        $node    = $this->getRootNode($builder, 'memcache');
        $host    = '%doctrine_cache.memcache.host%';
        $port    = '%doctrine_cache.memcache.port%';

        $node
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('server')
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->arrayNode('servers')
                ->useAttributeAsKey('host')
                ->normalizeKeys(false)
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function ($v) {
                                return is_scalar($v);
                            })
                            ->then(function ($val) {
                                return array('port' => $val);
                            })
                        ->end()
                        ->children()
                            ->scalarNode('host')->defaultValue($host)->end()
                            ->scalarNode('port')->defaultValue($port)->end()
                        ->end()
                    ->end()
                    ->defaultValue(array($host => array(
                        'host' => $host,
                        'port' => $port
                    )))
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build memcached node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addMemcachedNode()
    {
        $builder = new TreeBuilder('memcached');
        $node    = $this->getRootNode($builder, 'memcached');
        $host    = '%doctrine_cache.memcached.host%';
        $port    = '%doctrine_cache.memcached.port%';

        $node
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('server')
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->scalarNode('persistent_id')->defaultNull()->end()
                ->arrayNode('servers')
                ->useAttributeAsKey('host')
                ->normalizeKeys(false)
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function ($v) {
                                return is_scalar($v);
                            })
                            ->then(function ($val) {
                                return array('port' => $val);
                            })
                        ->end()
                        ->children()
                            ->scalarNode('host')->defaultValue($host)->end()
                            ->scalarNode('port')->defaultValue($port)->end()
                        ->end()
                    ->end()
                    ->defaultValue(array($host => array(
                        'host' => $host,
                        'port' => $port
                    )))
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build redis node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addRedisNode()
    {
        $builder = new TreeBuilder('redis');
        $node    = $this->getRootNode($builder, 'redis');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->scalarNode('host')->defaultValue('%doctrine_cache.redis.host%')->end()
                ->scalarNode('port')->defaultValue('%doctrine_cache.redis.port%')->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('timeout')->defaultNull()->end()
                ->scalarNode('database')->defaultNull()->end()
                ->booleanNode('persistent')->defaultFalse()->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build predis node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addPredisNode()
    {
        $builder = new TreeBuilder('predis');
        $node    = $this->getRootNode($builder, 'predis');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('client_id')->defaultNull()->end()
                ->scalarNode('scheme')->defaultValue('tcp')->end()
                ->scalarNode('host')->defaultValue('%doctrine_cache.redis.host%')->end()
                ->scalarNode('port')->defaultValue('%doctrine_cache.redis.port%')->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('timeout')->defaultNull()->end()
                ->scalarNode('database')->defaultNull()->end()
                ->arrayNode('options')
                  ->useAttributeAsKey('name')
                  ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build riak node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addRiakNode()
    {
        $builder = new TreeBuilder('riak');
        $node    = $this->getRootNode($builder, 'riak');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('host')->defaultValue('%doctrine_cache.riak.host%')->end()
                ->scalarNode('port')->defaultValue('%doctrine_cache.riak.port%')->end()
                ->scalarNode('bucket_name')->defaultValue('doctrine_cache')->end()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->scalarNode('bucket_id')->defaultNull()->end()
                ->arrayNode('bucket_property_list')
                    ->children()
                        ->scalarNode('allow_multiple')->defaultNull()->end()
                        ->scalarNode('n_value')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build couchbase node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addCouchbaseNode()
    {
        $builder = new TreeBuilder('couchbase');
        $node    = $this->getRootNode($builder, 'couchbase');

        $node
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('hostname')
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->arrayNode('hostnames')
                    ->prototype('scalar')->end()
                    ->defaultValue(array('%doctrine_cache.couchbase.hostnames%'))
                ->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('bucket_name')->defaultValue('doctrine_cache')->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build mongodb node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addMongoNode()
    {
        $builder = new TreeBuilder('mongodb');
        $node    = $this->getRootNode($builder, 'mongodb');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->scalarNode('collection_id')->defaultNull()->end()
                ->scalarNode('database_name')->defaultValue('doctrine_cache')->end()
                ->scalarNode('collection_name')->defaultValue('doctrine_cache')->end()
                ->scalarNode('server')->defaultValue('%doctrine_cache.mongodb.server%')->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build php_file node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addPhpFileNode()
    {
        $builder = new TreeBuilder('php_file');
        $node    = $this->getRootNode($builder, 'php_file');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('directory')->defaultValue('%kernel.cache_dir%/doctrine/cache/phpfile')->end()
                ->scalarNode('extension')->defaultNull()->end()
                ->integerNode('umask')->defaultValue(0002)->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build file_system node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addFileSystemNode()
    {
        $builder = new TreeBuilder('file_system');
        $node    = $this->getRootNode($builder, 'file_system');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('directory')->defaultValue('%kernel.cache_dir%/doctrine/cache/file_system')->end()
                ->scalarNode('extension')->defaultNull()->end()
                ->integerNode('umask')->defaultValue(0002)->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Build sqlite3 node configuration definition
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    private function addSqlite3Node()
    {
        $builder = new TreeBuilder('sqlite3');
        $node    = $this->getRootNode($builder, 'sqlite3');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('connection_id')->defaultNull()->end()
                ->scalarNode('file_name')->defaultNull()->end()
                ->scalarNode('table_name')->defaultNull()->end()
            ->end()
        ;

        return $node;
    }

    private function getRootNode(TreeBuilder $treeBuilder, $name)
    {
        // BC layer for symfony/config 4.1 and older
        if ( ! \method_exists($treeBuilder, 'getRootNode')) {
            return $treeBuilder->root($name);
        }

        return $treeBuilder->getRootNode();
    }
}
