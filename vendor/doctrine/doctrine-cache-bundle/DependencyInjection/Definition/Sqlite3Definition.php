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
 * Sqlite3 definition.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class Sqlite3Definition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $sqlite3Conf   = $config['sqlite3'];
        $tableName     = $sqlite3Conf['table_name'];
        $connectionRef = $this->getConnectionReference($name, $sqlite3Conf, $container);

        $service->setArguments(array($connectionRef, $tableName));
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

        $fileName  = $config['file_name'];
        $connClass = '%doctrine_cache.sqlite3.connection.class%';
        $connId    = sprintf('doctrine_cache.services.%s.connection', $name);
        $connDef   = new Definition($connClass, array($fileName, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE));

        $connDef->setPublic(false);
        $container->setDefinition($connId, $connDef);

        return new Reference($connId);
    }
}
