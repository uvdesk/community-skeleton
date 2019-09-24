<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\UIComponents\Dashboard\Navigation;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;

class Apps implements NavigationInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px">
    <path fill-rule="evenodd" fill="rgb(158, 158, 158)" d="M18,14H16v4a2,2,0,0,1-2,2H10V18.5a2.5,2.5,0,0,0-5,0V20H2a2,2,0,0,1-2-2V14H1.5a2.5,2.5,0,0,0,0-5H0V6A2,2,0,0,1,2,4H6V2a2,2,0,0,1,4,0V4h4a2,2,0,0,1,2,2v4h2A2,2,0,0,1,18,14Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Apps";
    }

    public static function getRouteName() : string
    {
        return 'uvdesk_extensions_applications_dashboard';
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
