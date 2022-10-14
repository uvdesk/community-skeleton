<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\Passes;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Dashboard;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\AsideTemplate;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\SearchTemplate;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItemInterface;

class DashboardComponents implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has(Dashboard::class)) {
            $dashboardDefinition = $container->findDefinition(Dashboard::class);

            // Navigation Panel Items
            foreach ($container->findTaggedServiceIds(NavigationInterface::class) as $reference => $tags) {
                $dashboardDefinition->addMethodCall('appendNavigation', array(new Reference($reference)));
            }

            // Homepage Panel Sections
            foreach ($container->findTaggedServiceIds(HomepageSectionInterface::class) as $reference => $tags) {
                $dashboardDefinition->addMethodCall('appendHomepageSection', array(new Reference($reference)));
            }

            // Homepage Panel Section Items
            foreach ($container->findTaggedServiceIds(HomepageSectionItemInterface::class) as $reference => $tags) {
                $dashboardDefinition->addMethodCall('appendHomepageSectionItem', array(new Reference($reference)));
            }
        }

        if ($container->has(AsideTemplate::class)) {
            $panelSidebarTemplateDefinition = $container->findDefinition(AsideTemplate::class);

            // Dashboard Panel Sidebars
            foreach ($container->findTaggedServiceIds(PanelSidebarInterface::class) as $reference => $tags) {
                $panelSidebarTemplateDefinition->addMethodCall('addPanelSidebar', array(new Reference($reference)));
            }

            // Homepage Panel Sidebar Items
            foreach ($container->findTaggedServiceIds(PanelSidebarItemInterface::class) as $reference => $tags) {
                $panelSidebarTemplateDefinition->addMethodCall('addPanelSidebarItem', array(new Reference($reference)));
            }
        }

        if ($container->has(SearchTemplate::class)) {
            $searchTemplateDefinition = $container->findDefinition(SearchTemplate::class);

            // Dashboard Search Items
            foreach ($container->findTaggedServiceIds(SearchItemInterface::class) as $reference => $tags) {
                $searchTemplateDefinition->addMethodCall('appendSearchItem', array(new Reference($reference)));
            }
        }
    }
}
