<?php

namespace Doctrine\Bundle\DoctrineCacheBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Cache\Cache;

/**
 * Base cache command.
 *
 * @author Alan Doucette <dragonwize@gmail.com>
 */
abstract class CacheCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Get the requested cache provider service.
     *
     * @param string $cacheName
     *
     * @return \Doctrine\Common\Cache\Cache
     *
     * @throws \InvalidArgumentException
     */
    protected function getCacheProvider($cacheName)
    {
        $container = $this->getContainer();

        // Try to use user input as cache service alias.
        $cacheProvider = $container->get($cacheName, ContainerInterface::NULL_ON_INVALID_REFERENCE);

        // If cache provider was not found try the service provider name.
        if ( ! $cacheProvider instanceof Cache) {
            $cacheProvider = $container->get('doctrine_cache.providers.' . $cacheName, ContainerInterface::NULL_ON_INVALID_REFERENCE);
        }
        // Cache provider was not found.
        if ( ! $cacheProvider instanceof Cache) {
            throw new \InvalidArgumentException('Cache provider not found.');
        }

        return $cacheProvider;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
