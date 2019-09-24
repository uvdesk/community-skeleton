<?php

namespace Knp\Bundle\PaginatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class KnpPaginatorExtension extends Extension
{
    /**
     * Build the extension services.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('paginator.xml');

        if ($container->hasParameter('templating.engines')) {
            if (\in_array('php', $container->getParameter('templating.engines'), true)) {
                $loader->load('templating_php.xml');
            }
        }

        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('knp_paginator.template.pagination', $config['template']['pagination']);
        $container->setParameter('knp_paginator.template.filtration', $config['template']['filtration']);
        $container->setParameter('knp_paginator.template.sortable', $config['template']['sortable']);
        $container->setParameter('knp_paginator.page_range', $config['page_range']);

        $paginatorDef = $container->getDefinition('knp_paginator');
        $paginatorDef->addMethodCall('setDefaultPaginatorOptions', [[
            'pageParameterName' => $config['default_options']['page_name'],
            'sortFieldParameterName' => $config['default_options']['sort_field_name'],
            'sortDirectionParameterName' => $config['default_options']['sort_direction_name'],
            'filterFieldParameterName' => $config['default_options']['filter_field_name'],
            'filterValueParameterName' => $config['default_options']['filter_value_name'],
            'distinct' => $config['default_options']['distinct'],
        ]]);

        $paginatorDef->setLazy(true);
    }
}
