<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Items\Settings;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Panel\Sidebars\Settings;

class EmailTemplates implements PanelSidebarItemInterface
{
    public static function getTitle() : string
    {
        return "Email Templates";
    }

    public static function getRouteName() : string
    {
        return 'email_templates_action';
    }

    public static function getSupportedRoutes() : array
    {
        return [
            'email_templates_action',
            'email_templates_addaction',
            'email_templates_editaction',
        ];
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_EMAIL_TEMPLATE'];
    }

    public static function getSidebarReferenceId() : string
    {
        return Settings::class;
    }
}
