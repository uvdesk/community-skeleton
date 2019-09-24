<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Users;

class Privileges extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M44.985,21H43V16A13.239,13.239,0,0,0,30,3,13.24,13.24,0,0,0,17,16v5H14.989a5.087,5.087,0,0,0-5,5.143V51.857a5.087,5.087,0,0,0,5,5.143h30a5.087,5.087,0,0,0,5-5.143V26.143A5.087,5.087,0,0,0,44.985,21Zm-15,22.987a4.987,4.987,0,1,1,5-4.987A5.008,5.008,0,0,1,29.987,43.987ZM38,21H22V16a8,8,0,1,1,16,0v5Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Privileges";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_privilege_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_AGENT_PRIVILEGE'];
    }

    public static function getSectionReferenceId() : string
    {
        return Users::class;
    }
}
