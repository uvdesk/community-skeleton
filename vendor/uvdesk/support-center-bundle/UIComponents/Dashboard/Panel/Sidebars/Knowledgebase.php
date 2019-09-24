<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Panel\Sidebars;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;

class Knowledgebase implements PanelSidebarInterface
{
    public static function getTitle() : string
    {
        return "Knowledgebase";
    }
}
