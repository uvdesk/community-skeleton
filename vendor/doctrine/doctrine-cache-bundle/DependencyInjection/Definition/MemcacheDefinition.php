<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Memcache definition.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class MemcacheDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $memcacheConf = $config['memcache'];
        $connRef      = $this->getConnectionReference($name, $memcacheConf, $container);

        $service->addMethodCall('setMemcache', array($connRef));
    }

    /**
     * @param string                                                    $name
     * @param array                                                     $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return \Symfony\Component\DependencyInjection\Reference
     */
    private function getConnectionReference($name, array $config, ContainerBuilder $container)
    {
        if (isset($config['connection_id'])) {
            return new Reference($config['connection_id']);
        }

        $connClass  = '%doctrine_cache.memcache.connection.class%';
        $connId     = sprintf('doctrine_cache.services.%s.connection', $name);
        $connDef    = new Definition($connClass);

        foreach ($config['servers'] as $host => $server) {
            $connDef->addMethodCall('addServer', array($host, $server['port']));
        }

        $connDef->setPublic(false);
        $container->setDefinition($connId, $connDef);

        return new Reference($connId);
    }
}
