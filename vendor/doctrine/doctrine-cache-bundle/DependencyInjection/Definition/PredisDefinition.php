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
 * Predis definition.
 *
 * @author Ivo Bathke <ivo.bathke@gmail.com>
 */
class PredisDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $redisConf = $config['predis'];
        $connRef = $this->getConnectionReference($name, $redisConf, $container);
        $service->addArgument($connRef);
    }

    /**
     * @param string                                                  $name
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return \Symfony\Component\DependencyInjection\Reference
     */
    private function getConnectionReference($name, array $config, ContainerBuilder $container)
    {
        if (isset($config['client_id'])) {
            return new Reference($config['client_id']);
        }

        $parameters = array(
            'scheme' => $config['scheme'],
            'host'   => $config['host'],
            'port'   => $config['port'],
        );

        if ($config['password']) {
            $parameters['password'] = $config['password'];
        }

        if ($config['timeout']) {
            $parameters['timeout'] = $config['timeout'];
        }

        if ($config['database']) {
            $parameters['database'] = $config['database'];
        }

        $options = null;

        if (isset($config['options'])) {
            $options = $config['options'];
        }

        $clientClass = '%doctrine_cache.predis.client.class%';
        $clientId = sprintf('doctrine_cache.services.%s_predis.client', $name);
        $clientDef = new Definition($clientClass);

        $clientDef->addArgument($parameters);
        $clientDef->addArgument($options);
        $clientDef->setPublic(false);

        $container->setDefinition($clientId, $clientDef);

        return new Reference($clientId);
    }
}
