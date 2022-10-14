<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Kudos implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M6,53h9V26H6V53ZM53.985,28.255A3.936,3.936,0,0,0,50,24H36l1.932-10.515L38,12.766a3.437,3.437,0,0,0-.96-2.383l-2.312-2.36L20.375,22.837A4.526,4.526,0,0,0,19,26V49c0,2.473,2.051,3.983,4.45,3.983L43,53a4.458,4.458,0,0,0,4.093-2.759L53.68,34.392a4.559,4.559,0,0,0,.305-1.641V28.457l-0.022-.022Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Kudos";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_report_achievements_insight_action';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_KUDOS'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}