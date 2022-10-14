<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ContainerBuilderAwarePackageInterface extends PackageInterface
{
    public function process(ContainerBuilder $container);
}