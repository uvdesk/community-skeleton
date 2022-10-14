<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;

class Settings implements PanelSidebarInterface
{
    public static function getTitle() : string
    {
        return "Settings";
    }
}
