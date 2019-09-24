<?php

namespace Knp\Bundle\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidDefinitionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PaginatorAwarePass.
 *
 * This compiler scans for the 'knp_paginator.injectable' tag and injects the Paginator service.
 */
final class PaginatorAwarePass implements CompilerPassInterface
{
    /**
     * @var string
     */
    const PAGINATOR_AWARE_TAG = 'knp_paginator.injectable';

    /**
     * @var string
     */
    const PAGINATOR_AWARE_INTERFACE = 'Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface';

    /**
     * Populates all tagged services with the paginator service.
     *
     * @param ContainerBuilder $container
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Config\Definition\Exception\InvalidDefinitionException
     */
    public function process(ContainerBuilder $container): void
    {
        $defaultAttributes = ['paginator' => 'knp_paginator'];

        foreach ($container->findTaggedServiceIds(self::PAGINATOR_AWARE_TAG) as $id => $attributes) {
            $definition = $container->getDefinition($id);

            $refClass = new \ReflectionClass($definition->getClass());
            if (!$refClass->implementsInterface(self::PAGINATOR_AWARE_INTERFACE)) {
                throw new \InvalidArgumentException(
                    \sprintf('Service "%s" must implement interface "%s".', $id, self::PAGINATOR_AWARE_INTERFACE)
                );
            }

            $attributes = \array_merge($defaultAttributes, $attributes);
            if (!$container->has($attributes['paginator'])) {
                throw new InvalidDefinitionException(
                    \sprintf(
                        'Paginator service "%s" for tag "%s" on service "%s" could not be found.',
                        $attributes['paginator'],
                        self::PAGINATOR_AWARE_TAG,
                        $id
                    )
                );
            }

            $definition->addMethodCall('setPaginator', [new Reference($attributes['paginator'])]);
            $container->setDefinition($id, $definition);
        }
    }
}
