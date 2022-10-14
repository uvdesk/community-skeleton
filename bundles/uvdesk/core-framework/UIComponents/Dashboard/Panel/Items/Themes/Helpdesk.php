<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Themes;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Branding;

class Helpdesk implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Helpdesk";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_helpdesk_theme';
    }

    public static function getSupportedRoutes() : array
    {
        return [];
    }

    public static function getRoles() : array
    {
        return [];
    }

    public static function getSidebarReferenceId() : string
    {
        return Branding::class;
    }
}
