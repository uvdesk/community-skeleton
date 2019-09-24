<?php

namespace Webkul\UVDesk\AutomationBundle\Package;

use Webkul\UVDesk\PackageManager\Composer\ComposerPackage;
use Webkul\UVDesk\PackageManager\Composer\ComposerPackageExtension;

class Composer extends ComposerPackageExtension
{
    public function loadConfiguration()
    {
        $composerPackage = new ComposerPackage();
        $composerPackage
            ->combineProjectConfig('config/packages/twig.yaml', 'Templates/twig.yaml');
        
        return $composerPackage;
    }
}
