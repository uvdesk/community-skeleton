<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Removes injected parameter arguments if they don't exist in this app.
 *
 * @author Ryan Weaver <ryan@symfonycasts.com>
 */
class RemoveMissingParametersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.default_path')) {
            $container->getDefinition('maker.file_manager')
                ->replaceArgument(3, null);
        }
    }
}
