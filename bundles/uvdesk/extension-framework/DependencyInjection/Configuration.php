<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('knp_doctrine_behaviors');
        $treeBuilder->getRootNode('uvdesk_extensions')
            ->children()
                ->node('dir', 'scalar')->defaultValue('%kernel.project_dir%/apps')->end()
            ->end();

        return $treeBuilder;
    }
}