<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds tagged request.param_converter services to converter.manager service.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddParamConverterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('sensio_framework_extra.converter.manager')) {
            return;
        }

        $definition = $container->getDefinition('sensio_framework_extra.converter.manager');
        $disabled = $container->getParameter('sensio_framework_extra.disabled_converters');
        $container->getParameterBag()->remove('sensio_framework_extra.disabled_converters');

        foreach ($container->findTaggedServiceIds('request.param_converter') as $id => $converters) {
            foreach ($converters as $converter) {
                $name = isset($converter['converter']) ? $converter['converter'] : null;

                if (null !== $name && \in_array($name, $disabled)) {
                    continue;
                }

                $priority = isset($converter['priority']) ? $converter['priority'] : 0;

                if ('false' === $priority || false === $priority) {
                    $priority = null;
                }

                $definition->addMethodCall('add', [new Reference($id), $priority, $name]);
            }
        }
    }
}
