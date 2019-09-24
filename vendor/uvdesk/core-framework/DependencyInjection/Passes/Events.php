<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\Passes;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\EventDispatcher;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class Events implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has(EventDispatcher::class)) {
            $eventDispatcherDefinition = $container->findDefinition(EventDispatcher::class);
            $taggedEventListeners = $container->findTaggedServiceIds('uvdesk.event_listener');
            
            foreach ($taggedEventListeners as $serviceId => $serviceTags) {
                $eventDispatcherDefinition->addMethodCall('addEventListener', array(new Reference($serviceId), $serviceTags));
            }
        }
    }
}
