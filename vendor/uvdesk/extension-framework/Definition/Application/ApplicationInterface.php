<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Application;

use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;

interface ApplicationInterface
{
    public static function getMetadata() : ApplicationMetadata;

    public function setPackage(PackageInterface $package) : ApplicationInterface;
    
    public function getPackage() : PackageInterface;
}
