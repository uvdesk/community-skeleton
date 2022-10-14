<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Navigation;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Home implements NavigationInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="18px">
    <path fill-rule="evenodd" fill="rgb(158, 158, 158)" d="M8.000,18.000 L8.000,12.000 L12.000,12.000 L12.000,18.000 L17.000,18.000 L17.000,10.000 L20.000,10.000 L10.000,0.000 L-0.000,10.000 L3.000,10.000 L3.000,18.000 L8.000,18.000 Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Home";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_dashboard';
    }

    public static function getRoles() : array
    {
        return [];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
