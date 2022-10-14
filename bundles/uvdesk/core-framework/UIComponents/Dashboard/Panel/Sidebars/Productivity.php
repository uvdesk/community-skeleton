<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;

class Productivity implements PanelSidebarInterface
{
    public static function getTitle() : string
    {
        return "Productivity";
    }
}
