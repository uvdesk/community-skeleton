<?php

namespace Webkul\UVDesk\MailboxBundle\Package;

use Webkul\UVDesk\PackageManager\Composer\ComposerPackage;
use Webkul\UVDesk\PackageManager\Composer\ComposerPackageExtension;

class Composer extends ComposerPackageExtension
{
    public function loadConfiguration()
    {
        $composerPackage = new ComposerPackage();
        $composerPackage
            ->movePackageConfig('config/packages/uvdesk_mailbox.yaml', 'Templates/config.yaml');
        
        return $composerPackage;
    }
}
