<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class EmailSettings implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M49.224,54.979H10.813a4.783,4.783,0,0,1-4.8-4.736V26.566a4.7,4.7,0,0,1,2.281-4.025l3.082-1.78,3.4,2.779-4.582,2.648,19.83,12.218,19.83-12.218-4.6-2.66,3.4-2.779,3.1,1.793A4.68,4.68,0,0,1,54,26.566l0.024,23.678A4.783,4.783,0,0,1,49.224,54.979Zm-9.287-35.7a8.723,8.723,0,0,0,0-2.549l2.821-2.145a0.644,0.644,0,0,0,.16-0.832l-2.674-4.5a0.681,0.681,0,0,0-.815-0.286l-3.328,1.3a9.841,9.841,0,0,0-2.259-1.275L33.334,5.549A0.646,0.646,0,0,0,32.679,5H27.332a0.646,0.646,0,0,0-.655.546L26.169,8.994a10.347,10.347,0,0,0-2.259,1.275l-3.328-1.3a0.661,0.661,0,0,0-.816.286l-2.673,4.5a0.63,0.63,0,0,0,.16.832l2.82,2.145a10.052,10.052,0,0,0-.094,1.275,10.049,10.049,0,0,0,.094,1.274l-2.82,2.146a0.644,0.644,0,0,0-.16.832l2.673,4.5a0.681,0.681,0,0,0,.816.286l3.328-1.3a9.835,9.835,0,0,0,2.259,1.274l0.508,3.446a0.647,0.647,0,0,0,.655.546h5.347a0.646,0.646,0,0,0,.655-0.546l0.508-3.446A10.337,10.337,0,0,0,36.1,25.743l3.328,1.3a0.661,0.661,0,0,0,.815-0.286l2.674-4.5a0.644,0.644,0,0,0-.16-0.832Zm-9.932,3.277a4.553,4.553,0,1,1,4.678-4.551A4.621,4.621,0,0,1,30.006,22.558Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Email Settings";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_emails_settings';
    }

    public static function getRoles() : array
    {
        return ['ROLE_ADMIN'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
