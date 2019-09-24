<?php
namespace Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\Config\FileLocator;

/**
 * Symfony bridge adpter
 *
 * @author Kinn Coelho Julião <kinncj@php.net>
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class SymfonyBridgeAdapter
{
    /**
     * @var \Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\CacheProviderLoader
     */
    private $cacheProviderLoader;

    /**
     * @var string
     */
    protected $objectManagerName;

    /**
     * @var string
     */
    protected $mappingResourceName;

    /**
     * @param \Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\CacheProviderLoader  $cacheProviderLoader
     * @param string                                                                        $objectManagerName
     * @param string                                                                        $mappingResourceName
     */
    public function __construct(CacheProviderLoader $cacheProviderLoader, $objectManagerName, $mappingResourceName)
    {
        $this->cacheProviderLoader  = $cacheProviderLoader;
        $this->objectManagerName    = $objectManagerName;
        $this->mappingResourceName  = $mappingResourceName;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function loadServicesConfiguration(ContainerBuilder $container)
    {
        $locator = new FileLocator(__DIR__ . '/../Resources/config/');
        $loader  = new XmlFileLoader($container, $locator);

        $loader->load('services.xml');
    }

    /**
     * @param string                                                    $cacheName
     * @param string                                                    $objectManagerName
     * @param array                                                     $cacheDriver
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return string
     */
    public function loadCacheDriver($cacheName, $objectManagerName, array $cacheDriver, ContainerBuilder $container)
    {
        $id       = $this->getObjectManagerElementName($objectManagerName . '_' . $cacheName);
        $host     = isset($cacheDriver['host']) ? $cacheDriver['host'] : null;
        $port     = isset($cacheDriver['port']) ? $cacheDriver['port'] : null;
        $password = isset($cacheDriver['password']) ? $cacheDriver['password'] : null;
        $database = isset($cacheDriver['database']) ? $cacheDriver['database'] : null;
        $type     = $cacheDriver['type'];

        if ($type == 'service') {
            $container->setAlias($id, new Alias($cacheDriver['id'], false));

            return $id;
        }

        $config = array(
            'aliases'   => array($id),
            $type       => array(),
            'type'      => $type,
            'namespace' => null,
        );

        if ( ! isset($cacheDriver['namespace'])) {
            // generate a unique namespace for the given application
            $seed = '_'.$container->getParameter('kernel.root_dir');

            if ($container->hasParameter('cache.prefix.seed')) {
                $seed = '.'.$container->getParameterBag()->resolveValue($container->getParameter('cache.prefix.seed'));
            }

            $seed .= '.'.$container->getParameter('kernel.name').'.'.$container->getParameter('kernel.environment');
            $hash      = hash('sha256', $seed);
            $namespace = 'sf_' . $this->mappingResourceName .'_' . $objectManagerName . '_' . $hash;

            $cacheDriver['namespace'] = $namespace;
        }
        
        $config['namespace'] = $cacheDriver['namespace'];

        if (in_array($type, array('memcache', 'memcached'))) {
            $host = !empty($host) ? $host : 'localhost';
            $config[$type]['servers'][$host] = array(
                'host' => $host,
                'port' => !empty($port) ? $port : 11211,
            );
        }

        if ($type === 'redis') {
            $config[$type] = array(
                'host' => !empty($host) ? $host : 'localhost',
                'port' => !empty($port) ? $port : 6379,
                'password' => !empty($password) ? $password : null,
                'database' => !empty($database) ? $database : 0
            );
        }

        if ($type === 'predis') {
            $config[$type] = array(
                'scheme' => 'tcp',
                'host' => !empty($host) ? $host : 'localhost',
                'port' => !empty($port) ? $port : 6379,
                'password' => !empty($password) ? $password : null,
                'database' => !empty($database) ? $database : 0,
                'timeout' => null,
            );
        }

        $this->cacheProviderLoader->loadCacheProvider($id, $config, $container);

        return $id;
    }

    /**
     * @param array                                                     $objectManager
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     * @param string                                                    $cacheName
     */
    public function loadObjectManagerCacheDriver(array $objectManager, ContainerBuilder $container, $cacheName)
    {
        $this->loadCacheDriver($cacheName, $objectManager['name'], $objectManager[$cacheName.'_driver'], $container);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getObjectManagerElementName($name)
    {
        return $this->objectManagerName . '.' . $name;
    }
}
