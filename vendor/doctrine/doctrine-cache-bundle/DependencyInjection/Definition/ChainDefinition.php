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
 * Chain definition.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ChainDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $providersConf = $config['chain'];
        $providers     = $this->getProviders($name, $providersConf, $container);

        $service->setArguments(array($providers));
    }

    /**
     * @param string                                                    $name
     * @param array                                                     $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder   $container
     *
     * @return array
     */
    private function getProviders($name, array $config, ContainerBuilder $container)
    {
        $providers = array();

        foreach ($config['providers'] as $provider) {
            if (strpos($provider, 'doctrine_cache.providers.') === false) {
                $provider = sprintf('doctrine_cache.providers.%s', $provider);
            }

            $providers[] = new Reference($provider);
        }

        return $providers;
    }
}
