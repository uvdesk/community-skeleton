<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Settings;

class EmailTemplates extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M49.224,52.979H10.813a4.783,4.783,0,0,1-4.8-4.736V24.566a4.7,4.7,0,0,1,2.281-4.025l3.082-1.78,3.4,2.779-4.582,2.648,19.83,12.218,19.83-12.218-4.6-2.66,3.4-2.779,3.1,1.793A4.68,4.68,0,0,1,54,24.566l0.024,23.678A4.783,4.783,0,0,1,49.224,52.979ZM30.018,32.4L16,24V7H44V23.748L30.018,32V32.4ZM20,11h4v4H20V11Zm6,0h8v4H26V11Zm-6,7h4v4H20V18Zm6,0H40v4H26V18Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Email Templates";
    }

    public static function getRouteName() : string
    {
        return 'email_templates_action';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_EMAIL_TEMPLATE'];
    }

    public static function getSectionReferenceId() : string
    {
        return Settings::class;
    }
}
