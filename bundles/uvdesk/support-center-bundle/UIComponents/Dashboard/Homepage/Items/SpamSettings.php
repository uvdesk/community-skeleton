<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Settings;

class SpamSettings extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M29.994,5.98A24.007,24.007,0,1,0,53.974,29.987,24,24,0,0,0,29.994,5.98ZM12,29.365A17.359,17.359,0,0,1,29.36,12a17.148,17.148,0,0,1,10.634,3.668L15.666,40A17.156,17.156,0,0,1,12,29.365ZM30.629,48a14.544,14.544,0,0,1-9.634-3.537L44.455,21a14.549,14.549,0,0,1,3.536,9.636A17.358,17.358,0,0,1,30.629,48Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Spam Settings";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_spam';
    }

    public static function getRoles() : array
    {
        return ['ROLE_ADMIN'];
    }

    public static function getSectionReferenceId() : string
    {
        return Settings::class;
    }
}
