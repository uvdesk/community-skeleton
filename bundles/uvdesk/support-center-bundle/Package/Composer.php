<?php

namespace Webkul\UVDesk\SupportCenterBundle\Package;

use Webkul\UVDesk\PackageManager\Composer\ComposerPackage;
use Webkul\UVDesk\PackageManager\Composer\ComposerPackageExtension;

class Composer extends ComposerPackageExtension
{
    public function loadConfiguration()
    {
        $composerPackage = new ComposerPackage();
        $composerPackage
            ->combineProjectConfig('config/packages/security.yaml', 'Templates/security.yaml');
        
        return $composerPackage;
    }
}
