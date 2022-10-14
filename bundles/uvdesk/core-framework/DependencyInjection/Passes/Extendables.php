<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\Passes;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentManager;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class Extendables implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has(ExtendableComponentManager::class)) {
            $extendableComponentManagerDefinition = $container->findDefinition(ExtendableComponentManager::class);

            foreach ($container->findTaggedServiceIds(ExtendableComponentInterface::class) as $component => $tags) {
                $extendableComponentManagerDefinition->addMethodCall('addComponent', array(new Reference($component)));
            }
        }
    }
}
