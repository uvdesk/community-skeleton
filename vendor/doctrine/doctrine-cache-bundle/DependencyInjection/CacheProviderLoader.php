<?php
namespace Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Cache provider loader
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class CacheProviderLoader
{
    /**
     * @param string                                                    $name
     * @param array                                                     $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     */
    public function loadCacheProvider($name, array $config, ContainerBuilder $container)
    {
        $serviceId  = 'doctrine_cache.providers.' . $name;
        $decorator  = $this->getProviderDecorator($container, $config);
        $service    = $container->setDefinition($serviceId, $decorator);
        $type       = ($config['type'] === 'custom_provider')
            ? $config['custom_provider']['type']
            : $config['type'];

        if ($config['namespace']) {
            $service->addMethodCall('setNamespace', array($config['namespace']));
        }
        $service->setPublic(true);

        foreach ($config['aliases'] as $alias) {
            $container->setAlias($alias, new Alias($serviceId, true));
        }

        if ($this->definitionClassExists($type, $container)) {
            $this->getCacheDefinition($type, $container)->configure($name, $config, $service, $container);
        }
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     * @param array                                                     $config
     *
     * @return \Symfony\Component\DependencyInjection\DefinitionDecorator
     */
    protected function getProviderDecorator(ContainerBuilder $container, array $config)
    {
        $type = $config['type'];
        $id   = 'doctrine_cache.abstract.' . $type;

        static $childDefinition;

        if (null === $childDefinition) {
            $childDefinition = class_exists('Symfony\Component\DependencyInjection\ChildDefinition') ? 'Symfony\Component\DependencyInjection\ChildDefinition' : 'Symfony\Component\DependencyInjection\DefinitionDecorator';
        }

        if ($type === 'custom_provider') {
            $type  = $config['custom_provider']['type'];
            $param = $this->getCustomProviderParameter($type);

            if ($container->hasParameter($param)) {
                return new $childDefinition($container->getParameter($param));
            }
        }

        if ($container->hasDefinition($id)) {
            return new $childDefinition($id);
        }

        throw new \InvalidArgumentException(sprintf('"%s" is an unrecognized Doctrine cache driver.', $type));
    }

    /**
     * @param string                                                    $type
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return \Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\Definition\CacheDefinition
     */
    private function getCacheDefinition($type, ContainerBuilder $container)
    {
        $class  = $this->getDefinitionClass($type, $container);
        $object = new $class($type);

        return $object;
    }

    /**
     * @param string                                                    $type
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return boolean
     */
    private function definitionClassExists($type, ContainerBuilder $container)
    {
        if ($container->hasParameter($this->getCustomDefinitionClassParameter($type))) {
            return true;
        }

        return class_exists($this->getDefinitionClass($type, $container));
    }

    /**
     * @param string                                                    $type
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return string
     */
    protected function getDefinitionClass($type, ContainerBuilder $container)
    {
        if ($container->hasParameter($this->getCustomDefinitionClassParameter($type))) {
            return $container->getParameter($this->getCustomDefinitionClassParameter($type));
        }

        $name  = Inflector::classify($type) . 'Definition';
        $class = sprintf('%s\Definition\%s', __NAMESPACE__, $name);

        return $class;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getCustomProviderParameter($type)
    {
        return 'doctrine_cache.custom_provider.' . $type;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getCustomDefinitionClassParameter($type)
    {
        return 'doctrine_cache.custom_definition_class.' . $type;
    }
}
