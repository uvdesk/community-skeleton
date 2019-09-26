<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;

class Settings extends HomepageSection
{
    public static function getTitle() : string
    {
        return UVDeskService::dynamicTranslation("Settings");
    }

    public static function getDescription() : string
    {
        return UVDeskService::dynamicTranslation("Manage your Brand Identity, Company Information and other details at a glance");
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_EMAIL_TEMPLATE',
        ];
    }

}
