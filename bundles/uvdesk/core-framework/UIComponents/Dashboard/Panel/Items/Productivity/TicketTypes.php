<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Productivity;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Productivity;

class TicketTypes implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Ticket Types";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_ticket_type_collection';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'helpdesk_member_create_ticket_type',
            'helpdesk_member_update_ticket_type', 
            'helpdesk_member_ticket_type_collection',
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_TICKET_TYPE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Productivity::class;
    }
}
