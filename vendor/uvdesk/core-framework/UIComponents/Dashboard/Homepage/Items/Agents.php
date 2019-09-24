<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Users;

class Agents extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M30.5,2.974A22.308,22.308,0,0,0,8,25.081V42c0,4.078,2.85,8,7,8h8V29.994H13V25.081A17.337,17.337,0,0,1,30.5,7.887,17.337,17.337,0,0,1,48,25.081v4.913H38V50H48v2H31v5H46c4.15,0,7-3.278,7-7.355V25.081A22.308,22.308,0,0,0,30.5,2.974Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Agents";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_account_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_AGENT'];
    }

    public static function getSectionReferenceId() : string
    {
        return Users::class;
    }
}
