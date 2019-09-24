<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection\Passes;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\ContainerBuilderAwarePackageInterface;

class PackageConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds(ContainerBuilderAwarePackageInterface::class) as $reference => $tags) {
            $package = (new \ReflectionClass($reference))->newInstanceWithoutConstructor();
            $package->process($container);
        }
    }
}
