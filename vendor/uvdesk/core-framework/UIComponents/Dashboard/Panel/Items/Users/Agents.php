<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Users;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Users;

class Agents implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Agents";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_account_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_account',
            'helpdesk_member_create_account',
            'helpdesk_member_account_collection', 
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_AGENT'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Users::class;
    }
}
