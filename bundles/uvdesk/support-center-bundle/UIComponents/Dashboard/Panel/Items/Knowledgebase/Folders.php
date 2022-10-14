<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Panel\Items\Knowledgebase;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Panel\Sidebars\Knowledgebase;

class Folders implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Folders";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_folders_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_knowledgebase_create_folder',
            'helpdesk_member_knowledgebase_update_folder',
            'helpdesk_member_knowledgebase_folders_collection',
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_KNOWLEDGEBASE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Knowledgebase::class;
    }
}
