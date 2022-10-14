<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Groups implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M54,36V52H45V36H42V24a3.807,3.807,0,0,1,4-4h7a3.807,3.807,0,0,1,4,4V36H54ZM49.5,18A4.5,4.5,0,1,1,54,13.5,4.487,4.487,0,0,1,49.5,18ZM33,52H27V39H20l6.37-16.081A4.224,4.224,0,0,1,30.379,20h0.253a4.244,4.244,0,0,1,4.009,2.922L40,39H33V52ZM30.49,18a4.5,4.5,0,1,1,4.5-4.5A4.487,4.487,0,0,1,30.49,18ZM15,52H6V36H3V24a3.807,3.807,0,0,1,4-4h7a3.807,3.807,0,0,1,4,4V36H15V52ZM10.5,18A4.5,4.5,0,1,1,15,13.5,4.487,4.487,0,0,1,10.5,18Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Groups";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_support_group_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_GROUP'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
