<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Categories implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M6,18h6V12l-6,.014V18Zm10-6v6H54V12H16ZM6,28h6V22l-6,.014V28Zm10-6v6H54V22H16ZM6,38h6V32l-6,.014V38Zm10-6v6H54V32H16ZM6,48h6V42l-6,.014V48Zm10-6v6H54V42H16Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Categories";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_category_collection';
    }

    public static function getRoles() : array
    {
        return ['ROLE_ADMIN','ROLE_AGENT_MANAGE_KNOWLEDGEBASE'];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
