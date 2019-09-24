<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\Passes\Ticket;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Tickets\QuickActionButtonInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Tickets\QuickActionButtonCollection;

class QuickActionButtons implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has(QuickActionButtonCollection::class)) {
            $quickActionButtonCollectionDefinition = $container->findDefinition(QuickActionButtonCollection::class);

            foreach ($container->findTaggedServiceIds(QuickActionButtonInterface::class) as $id => $tags) {
                $quickActionButtonCollectionDefinition->addMethodCall('add', array(new Reference($id), $tags));
            }
        }
    }
}
