<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Navigation;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Reports implements NavigationInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="19px" height="20px">
    <path fill-rule="evenodd" fill="rgb(158, 158, 158)" d="M14.000,20.000 L19.000,20.000 L19.000,6.000 L14.000,6.000 L14.000,20.000 ZM5.026,19.987 L5.000,10.000 L-0.000,9.994 L-0.000,20.000 L5.026,19.987 ZM12.000,20.000 L12.000,0.000 L7.000,0.000 L7.000,20.000 L12.000,20.000 Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Reports";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_agent_activity';
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
