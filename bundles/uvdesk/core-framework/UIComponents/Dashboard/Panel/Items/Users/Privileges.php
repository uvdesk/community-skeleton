<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Users;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Users;

class Privileges implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Privileges";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_privilege_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_create_privilege',
            'helpdesk_member_update_privilege',
            'helpdesk_member_privilege_collection', 
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_AGENT_PRIVILEGE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Users::class;
    }
}
