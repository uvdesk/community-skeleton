<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;

class Settings extends HomepageSection
{
    public static function getTitle() : string
    {
        return "Settings";
    }

    public static function getDescription() : string
    {
        return "Manage your Brand Identity, Company Information and other details at a glance";
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_EMAIL_TEMPLATE',
        ];
    }
}
