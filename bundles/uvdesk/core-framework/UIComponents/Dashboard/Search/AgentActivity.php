<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class AgentActivity implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 17">
    <path id="activity" class="cls-1" d="M0,10v4H5L8,9l5,10h1l3-6h3V9H15l-1.364,3.854L8,2H7.015L3,10H0Z" transform="translate(0 -2)"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Agent Activity";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_agent_activity';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_AGENT_ACTIVITY'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
