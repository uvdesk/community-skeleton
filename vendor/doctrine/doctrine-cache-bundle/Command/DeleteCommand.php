<?php

namespace Doctrine\Bundle\DoctrineCacheBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Delete cache entries.
 *
 * @author Alan Doucette <dragonwize@gmail.com>
 */
class DeleteCommand extends CacheCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('doctrine:cache:delete')
            ->setDescription('Delete a cache entry')
            ->addArgument('cache-name', InputArgument::REQUIRED, 'Which cache provider to use?')
            ->addArgument('cache-id', InputArgument::OPTIONAL, 'Which cache ID to delete?')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'Delete all cache entries in provider');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cacheName     = $input->getArgument('cache-name');
        $cacheProvider = $this->getCacheProvider($cacheName);
        $cacheId       = $input->getArgument('cache-id');
        $all           = $input->getOption('all');

        if ($all && ! method_exists($cacheProvider, 'deleteAll')) {
            throw new \RuntimeException('Cache provider does not implement a deleteAll method.');
        }

        if ( ! $all && ! $cacheId) {
            throw new \InvalidArgumentException('Missing cache ID');
        }

        $success = $all ? $cacheProvider->deleteAll() : $cacheProvider->delete($cacheId);
        $color   = $success ? 'info' : 'error';
        $success = $success ? 'succeeded' : 'failed';
        $message = null;

        if ( ! $all) {
            $message = "Deletion of <$color>%s</$color> in <$color>%s</$color> has <$color>%s</$color>";
            $message = sprintf($message, $cacheId, $cacheName, $success, true);
        }

        if ($all) {
            $message = "Deletion of <$color>all</$color> entries in <$color>%s</$color> has <$color>%s</$color>";
            $message = sprintf($message, $cacheName, $success, true);
        }

        $output->writeln($message);
    }
}
