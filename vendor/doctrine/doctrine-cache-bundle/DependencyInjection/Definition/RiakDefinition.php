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
 * Riak definition.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class RiakDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $riakConf  = $config['riak'];
        $bucketRef = $this->getBucketReference($name, $riakConf, $container);

        $service->setArguments(array($bucketRef));
    }

    /**
     * @param string                                                    $name
     * @param array                                                     $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return \Symfony\Component\DependencyInjection\Reference
     */
    private function getBucketReference($name, array $config, ContainerBuilder $container)
    {
        if (isset($config['bucket_id'])) {
            return new Reference($config['bucket_id']);
        }

        $bucketName  = $config['bucket_name'];
        $bucketClass = '%doctrine_cache.riak.bucket.class%';
        $bucketId    = sprintf('doctrine_cache.services.%s.bucket', $name);
        $connDef     = $this->getConnectionReference($name, $config, $container);
        $bucketDef   = new Definition($bucketClass, array($connDef, $bucketName));

        $bucketDef->setPublic(false);
        $container->setDefinition($bucketId, $bucketDef);

        if ( ! empty($config['bucket_property_list'])) {
            $this->configureBucketPropertyList($name, $config['bucket_property_list'], $bucketDef, $container);
        }

        return new Reference($bucketId);
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

        $host      = $config['host'];
        $port      = $config['port'];
        $connClass = '%doctrine_cache.riak.connection.class%';
        $connId    = sprintf('doctrine_cache.services.%s.connection', $name);
        $connDef   = new Definition($connClass, array($host, $port));

        $connDef->setPublic(false);
        $container->setDefinition($connId, $connDef);

        return new Reference($connId);
    }

    /**
     * @param string                                                    $name
     * @param array                                                     $config
     * @param \Symfony\Component\DependencyInjection\Definition         $bucketDefinition
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     */
    private function configureBucketPropertyList($name, array $config, Definition $bucketDefinition, ContainerBuilder $container)
    {
        $propertyListClass      = '%doctrine_cache.riak.bucket_property_list.class%';
        $propertyListServiceId  = sprintf('doctrine_cache.services.%s.bucket_property_list', $name);
        $propertyListReference  = new Reference($propertyListServiceId);
        $propertyListDefinition = new Definition($propertyListClass, array(
            $config['n_value'],
            $config['allow_multiple']
        ));

        $container->setDefinition($propertyListServiceId, $propertyListDefinition);
        $bucketDefinition->addMethodCall('setPropertyList', array($propertyListReference));
    }
}
