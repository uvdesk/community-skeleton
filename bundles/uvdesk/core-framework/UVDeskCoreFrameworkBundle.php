<?php

namespace Webkul\UVDesk\CoreFrameworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\Passes;
use Webkul\UVDesk\CoreFrameworkBundle\DependencyInjection\CoreFramework;

class UVDeskCoreFrameworkBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CoreFramework();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Passes\Events())
            ->addCompilerPass(new Passes\Routes())
            ->addCompilerPass(new Passes\Extendables())
            ->addCompilerPass(new Passes\DashboardComponents())
            ->addCompilerPass(new Passes\Ticket\Widgets())
            ->addCompilerPass(new Passes\Ticket\QuickActionButtons());
    }
}
