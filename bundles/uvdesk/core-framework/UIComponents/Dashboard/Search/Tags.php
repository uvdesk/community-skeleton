<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Tags implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M42.935,14.247A4.683,4.683,0,0,0,39,12H11a5.182,5.182,0,0,0-5.015,5.313V43.74A5.164,5.164,0,0,0,11.036,49l27.782,0.026a4.972,4.972,0,0,0,4.117-2.22L53.972,30.526Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Tags";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_ticket_tag_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_TAG'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
