<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection\ContainerExtension;
use Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection\Passes\RoutingPass;
use Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection\Passes\ConfigurationPass;
use Webkul\UVDesk\ExtensionFrameworkBundle\DependencyInjection\Passes\PackageConfigurationPass;

class UVDeskExtensionFrameworkBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ContainerExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new RoutingPass())
            ->addCompilerPass(new ConfigurationPass())
            ->addCompilerPass(new PackageConfigurationPass());
    }
}
