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
 * Redis definition.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class RedisDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $redisConf = $config['redis'];
        $connRef   = $this->getConnectionReference($name, $redisConf, $container);

        $service->addMethodCall('setRedis', array($connRef));
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

        $host       = $config['host'];
        $port       = $config['port'];
        $connClass  = '%doctrine_cache.redis.connection.class%';
        $connId     = sprintf('doctrine_cache.services.%s_redis.connection', $name);
        $connDef    = new Definition($connClass);
        $connParams = array($host, $port);

        if (isset($config['timeout'])) {
            $connParams[] = $config['timeout'];
        }

        $connMethod = 'connect';

        if (isset($config['persistent']) && $config['persistent']) {
            $connMethod = 'pconnect';
        }

        $connDef->setPublic(false);
        $connDef->addMethodCall($connMethod, $connParams);

        if (isset($config['password'])) {
            $password = $config['password'];
            $connDef->addMethodCall('auth', array($password));
        }

        if (isset($config['database'])) {
            $database = (int) $config['database'];
            $connDef->addMethodCall('select', array($database));
        }

        $container->setDefinition($connId, $connDef);

        return new Reference($connId);
    }
}
