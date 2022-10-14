<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Webkul\UVDesk\CoreFrameworkBundle\Definition\RouterInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Definition\RoutingResourceInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;

use Webkul\UVDesk\CoreFrameworkBundle\Tickets\WidgetInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Tickets\QuickActionButtonInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;

class CoreFramework extends Extension
{
    public function getAlias()
    {
        return 'uvdesk';
    }

    public function getConfiguration(array $configs, ContainerBuilder $container)
    {
        return new BundleConfiguration();
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $services = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));

        $services->load('core.yaml');
        $services->load('public.yaml');

        // Register automations conditionally if AutomationBundle has been added as an dependency.
        if (array_key_exists('UVDeskAutomationBundle', $container->getParameter('kernel.bundles'))) {
            $services->load('automations.yaml');
        }

        // Load bundle configurations
        $configuration = $this->getConfiguration($configs, $container);
        foreach ($this->processConfiguration($configuration, $configs) as $param => $value) {
            switch ($param) {
                case 'support_email':
                case 'upload_manager':
                    foreach ($value as $field => $fieldValue) {
                        $container->setParameter("uvdesk.$param.$field", $fieldValue);
                    }
                    break;
                case 'default':
                    foreach ($value as $defaultItem => $defaultItemValue) {
                        switch ($defaultItem) {
                            case 'templates':
                                foreach ($defaultItemValue as $template => $templateValue) {
                                    $container->setParameter("uvdesk.default.templates.$template", $templateValue);
                                }
                                break;
                            case 'ticket':
                                foreach ($defaultItemValue as $option => $optionValue) {
                                    $container->setParameter("uvdesk.default.ticket.$option", $optionValue);
                                }
                                break;
                            default:
                                $container->setParameter("uvdesk.default.$defaultItem", $defaultItemValue);
                                break;
                        }
                    }
                    break;
                default:
                    $container->setParameter("uvdesk.$param", $value);
                    break;
            }
        }

        $container->registerForAutoconfiguration(RouterInterface::class)->addTag('routing.loader');
        $container->registerForAutoconfiguration(WidgetInterface::class)->addTag(WidgetInterface::class);
        $container->registerForAutoconfiguration(QuickActionButtonInterface::class)->addTag(QuickActionButtonInterface::class);

        $container->registerForAutoconfiguration(RoutingResourceInterface::class)->addTag(RoutingResourceInterface::class);
        $container->registerForAutoconfiguration(ExtendableComponentInterface::class)->addTag(ExtendableComponentInterface::class);

        // $container->registerForAutoconfiguration(EmbeddableResourceInterface::class)->addTag(EmbeddableResourceInterface::class);

        $container->registerForAutoconfiguration(SearchItemInterface::class)->addTag(SearchItemInterface::class);
        $container->registerForAutoconfiguration(NavigationInterface::class)->addTag(NavigationInterface::class);
        $container->registerForAutoconfiguration(HomepageSectionInterface::class)->addTag(HomepageSectionInterface::class);
        $container->registerForAutoconfiguration(HomepageSectionItemInterface::class)->addTag(HomepageSectionItemInterface::class);
        $container->registerForAutoconfiguration(PanelSidebarInterface::class)->addTag(PanelSidebarInterface::class);
        $container->registerForAutoconfiguration(PanelSidebarItemInterface::class)->addTag(PanelSidebarItemInterface::class);
    }
}
