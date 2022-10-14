<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Users;

class Customers extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M39.025,28a7,7,0,1,0-7.013-7A6.976,6.976,0,0,0,39.025,28ZM22.013,28A7,7,0,1,0,15,21,6.976,6.976,0,0,0,22.013,28Zm-0.751,4.29c-5.082,0-15.267,2.674-15.267,8V46H37V40C37,34.675,26.344,32.287,21.262,32.287Zm17.449,0c-0.633,0-1.352.046-2.116,0.114,2.53,1.92,4.4,4.216,4.4,7.6v6H53.978V40.287C53.978,34.961,43.793,32.287,38.711,32.287Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Customers";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_manage_customer_account_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_CUSTOMER'];
    }

    public static function getSectionReferenceId() : string
    {
        return Users::class;
    }
}
