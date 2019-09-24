<?php

namespace Knp\Bundle\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

final class PaginatorConfigurationPass implements CompilerPassInterface
{
    /**
     * Populate the listener service ids.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        // use main symfony dispatcher
        if (!$container->hasDefinition('event_dispatcher') && !$container->hasAlias('event_dispatcher')) {
            return;
        }

        $pass = new RegisterListenersPass('event_dispatcher', 'knp_paginator.listener', 'knp_paginator.subscriber');
        $pass->process($container);
    }
}
