<?php

namespace Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler;

use Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver;
use Doctrine\Bundle\DoctrineBundle\Mapping\EntityListenerServiceResolver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class for Symfony bundles to register entity listeners
 */
class EntityListenerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resolvers = $container->findTaggedServiceIds('doctrine.orm.entity_listener');

        $lazyServiceReferencesByResolver = [];

        foreach ($resolvers as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $name          = isset($attributes['entity_manager']) ? $attributes['entity_manager'] : $container->getParameter('doctrine.default_entity_manager');
                $entityManager = sprintf('doctrine.orm.%s_entity_manager', $name);

                if (! $container->hasDefinition($entityManager)) {
                    continue;
                }

                $resolverId = sprintf('doctrine.orm.%s_entity_listener_resolver', $name);

                if (! $container->has($resolverId)) {
                    continue;
                }

                $resolver = $container->findDefinition($resolverId);
                $resolver->setPublic(true);

                if (isset($attributes['entity']) && isset($attributes['event'])) {
                    $this->attachToListener($container, $name, $id, $attributes);
                }

                $resolverClass                 = $this->getResolverClass($resolver, $container);
                $resolverSupportsLazyListeners = is_a($resolverClass, EntityListenerServiceResolver::class, true);

                $lazyByAttribute = isset($attributes['lazy']) && $attributes['lazy'];
                if ($lazyByAttribute && ! $resolverSupportsLazyListeners) {
                    throw new InvalidArgumentException(sprintf(
                        'Lazy-loaded entity listeners can only be resolved by a resolver implementing %s.',
                        EntityListenerServiceResolver::class
                    ));
                }

                if (! isset($attributes['lazy']) && $resolverSupportsLazyListeners || $lazyByAttribute) {
                    $listener = $container->findDefinition($id);

                    if ($listener->isAbstract()) {
                        throw new InvalidArgumentException(sprintf('The service "%s" must not be abstract as this entity listener is lazy-loaded.', $id));
                    }

                    $resolver->addMethodCall('registerService', [$listener->getClass(), $id]);

                    // if the resolver uses the default class we will use a service locator for all listeners
                    if ($resolverClass === ContainerEntityListenerResolver::class) {
                        if (! isset($lazyServiceReferencesByResolver[$resolverId])) {
                            $lazyServiceReferencesByResolver[$resolverId] = [];
                        }
                        $lazyServiceReferencesByResolver[$resolverId][$id] = new Reference($id);
                    } else {
                        $listener->setPublic(true);
                    }
                } else {
                    $resolver->addMethodCall('register', [new Reference($id)]);
                }
            }
        }

        foreach ($lazyServiceReferencesByResolver as $resolverId => $listenerReferences) {
            $container->findDefinition($resolverId)->setArgument(0, ServiceLocatorTagPass::register($container, $listenerReferences));
        }
    }

    private function attachToListener(ContainerBuilder $container, $name, $id, array $attributes)
    {
        $listenerId = sprintf('doctrine.orm.%s_listeners.attach_entity_listeners', $name);

        if (! $container->has($listenerId)) {
            return;
        }

        $serviceDef = $container->getDefinition($id);

        $args = [
            $attributes['entity'],
            $serviceDef->getClass(),
            $attributes['event'],
        ];

        if (isset($attributes['method'])) {
            $args[] = $attributes['method'];
        }

        $container->findDefinition($listenerId)->addMethodCall('addEntityListener', $args);
    }

    private function getResolverClass(Definition $resolver, ContainerBuilder $container) : string
    {
        $resolverClass = $resolver->getClass();

        if (substr($resolverClass, 0, 1) === '%') {
            // resolve container parameter first
            $resolverClass = $container->getParameterBag()->resolveValue($resolver->getClass());
        }

        return $resolverClass;
    }
}
