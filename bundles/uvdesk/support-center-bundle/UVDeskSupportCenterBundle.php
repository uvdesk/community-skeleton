<?php

namespace Webkul\UVDesk\SupportCenterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webkul\UVDesk\SupportCenterBundle\DependencyInjection\SupportCenterExtension;

class UVDeskSupportCenterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SupportCenterExtension();
    }
}
