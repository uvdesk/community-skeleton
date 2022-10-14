<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Reports;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Reports;

class Kudos implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Kudos";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_report_achievements_insight_action';
    }

    public static function getSupportedRoutes() : array
    {
        return [];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_KUDOS'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Reports::class;
    }
}