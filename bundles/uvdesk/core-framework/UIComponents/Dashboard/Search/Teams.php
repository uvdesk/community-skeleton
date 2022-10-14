<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Teams implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M45,36V52H36V36H33V24a3.807,3.807,0,0,1,4-4h7a3.807,3.807,0,0,1,4,4V36H45ZM40.5,18A4.5,4.5,0,1,1,45,13.5,4.487,4.487,0,0,1,40.5,18ZM24,52H15V36H12V24a3.807,3.807,0,0,1,4-4h7a3.807,3.807,0,0,1,4,4V36H24V52ZM19.5,18A4.5,4.5,0,1,1,24,13.5,4.487,4.487,0,0,1,19.5,18Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Teams";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_support_team_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_SUB_GROUP'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
