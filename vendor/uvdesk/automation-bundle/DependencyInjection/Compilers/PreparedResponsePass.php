<?php

namespace Webkul\UVDesk\AutomationBundle\DependencyInjection\Compilers;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\AutomationBundle\EventListener\PreparedResponseListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PreparedResponsePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(PreparedResponseListener::class)) {
            return;
        }
        $preparedResponseDefinition = $container->findDefinition(PreparedResponseListener::class);
        
        // Register Prepared Response Actions
        $preparedResponseTaggedServices = $container->findTaggedServiceIds('uvdesk.automations.prepared_response.actions');
        
        foreach ($preparedResponseTaggedServices as $serviceId => $serviceTags) {
            $preparedResponseDefinition->addMethodCall('registerPreparedResponseAction', array(new Reference($serviceId)));
        }
    }
}
