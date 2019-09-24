<?php

namespace Doctrine\Bundle\DoctrineCacheBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Flush a cache provider.
 *
 * @author Alan Doucette <dragonwize@gmail.com>
 */
class FlushCommand extends CacheCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('doctrine:cache:flush')
            ->setAliases(array('doctrine:cache:clear'))
            ->setDescription('Flush a given cache')
            ->addArgument('cache-name', InputArgument::REQUIRED, 'Which cache provider to flush?');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cacheName     = $input->getArgument('cache-name');
        $cacheProvider = $this->getCacheProvider($cacheName);

        if ( ! method_exists($cacheProvider, 'flushAll')) {
            throw new \RuntimeException('Cache provider does not implement a flushAll method.');
        }

        $cacheProviderName = get_class($cacheProvider);
        $output->writeln(sprintf('Clearing the cache for the <info>%s</info> provider of type <info>%s</info>', $cacheName, $cacheProviderName, true));
        $cacheProvider->flushAll();
    }
}
