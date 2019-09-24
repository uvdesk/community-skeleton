<?php

namespace Doctrine\Bundle\DoctrineCacheBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Get stats from cache provider.
 *
 * @author Alan Doucette <dragonwize@gmail.com>
 */
class StatsCommand extends CacheCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('doctrine:cache:stats')
            ->setDescription('Get stats on a given cache provider')
            ->addArgument('cache-name', InputArgument::REQUIRED, 'For which cache provider would you like to get stats?');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cacheName     = $input->getArgument('cache-name');
        $cacheProvider = $this->getCacheProvider($cacheName);
        $cacheProviderName = get_class($cacheProvider);

        $stats = $cacheProvider->getStats();

        if ($stats === null) {
            $output->writeln(sprintf('Stats were not provided for the <info>%s</info> provider of type <info>%s</info>', $cacheName, $cacheProviderName, true));

            return;
        }

        $formatter = $this->getHelperSet()->get('formatter');

        $lines = array();
        foreach ($stats as $key => $stat) {
            $lines[] = $formatter->formatSection($key, $stat);
        }

        $output->writeln(sprintf('Stats for the <info>%s</info> provider of type <info>%s</info>:', $cacheName, $cacheProviderName, true));
        $output->writeln($lines);
    }
}
