<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Panel\Items\Knowledgebase;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Panel\Sidebars\Knowledgebase;

class Categories implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Categories";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_category_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_mailbox_settings',
            'helpdesk_member_knowledgebase_create_category',
            'helpdesk_member_knowledgebase_update_category',
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
