<?php

namespace Webkul\UVDesk\AutomationBundle\DependencyInjection\Compilers;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\AutomationBundle\EventListener\WorkflowListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class WorkflowPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(WorkflowListener::class)) {
            return;
        }

        $workflowDefinition = $container->findDefinition(WorkflowListener::class);

        // Register Workflow Event
        $taggedWorkflowEvents = $container->findTaggedServiceIds('uvdesk.automations.workflow.events');
        
        foreach ($taggedWorkflowEvents as $serviceId => $serviceTags) {
            $workflowDefinition->addMethodCall('registerWorkflowEvent', array(new Reference($serviceId)));
        }

        // Register Workflow Actions
        $workflowTaggedServices = $container->findTaggedServiceIds('uvdesk.automations.workflow.actions');
        
        foreach ($workflowTaggedServices as $serviceId => $serviceTags) {
            $workflowDefinition->addMethodCall('registerWorkflowAction', array(new Reference($serviceId)));
        }
    }
}
