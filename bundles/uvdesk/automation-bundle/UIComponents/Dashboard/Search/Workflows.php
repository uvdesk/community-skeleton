<?php

namespace Webkul\UVDesk\AutomationBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Workflows implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M25.783,21.527L10.245,6.019,6.016,10.248,21.524,25.756ZM37.512,6.019l6.119,6.119L6.016,49.783l4.229,4.229L47.89,16.4l6.119,6.119V6.019h-16.5ZM38.5,34.245l-4.229,4.229,9.389,9.389-6.149,6.149h16.5v-16.5L47.89,43.634Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Workflows";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_workflow_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
