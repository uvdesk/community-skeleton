<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Users;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Users;

class Customers implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Customers";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_manage_customer_account_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_create_customer_account',
            'helpdesk_member_manage_customer_account',
            'helpdesk_member_manage_customer_account_collection', 
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_CUSTOMER'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Users::class;
    }
}
