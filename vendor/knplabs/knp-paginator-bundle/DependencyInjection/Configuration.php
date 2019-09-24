<?php

namespace Knp\Bundle\PaginatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('knp_paginator');
        // BC layer for symfony/config < 4.2
        $rootNode = \method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('knp_paginator');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('default_options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('sort_field_name')->defaultValue('sort')->end()
                        ->scalarNode('sort_direction_name')->defaultValue('direction')->end()
                        ->scalarNode('filter_field_name')->defaultValue('filterField')->end()
                        ->scalarNode('filter_value_name')->defaultValue('filterValue')->end()
                        ->scalarNode('page_name')->defaultValue('page')->end()
                        ->booleanNode('distinct')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('pagination')
                        ->defaultValue('@KnpPaginator/Pagination/sliding.html.twig')
                        ->end()
                        ->scalarNode('filtration')
                        ->defaultValue('@KnpPaginator/Pagination/filtration.html.twig')
                        ->end()
                        ->scalarNode('sortable')
                        ->defaultValue('@KnpPaginator/Pagination/sortable_link.html.twig')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('page_range')
                ->defaultValue(5)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
