<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Homepage\Sections\Knowledgebase;

class Articles extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M34.743,5.977h-19a4.769,4.769,0,0,0-4.726,4.8L11,49.19a4.77,4.77,0,0,0,4.726,4.8h28.52a4.79,4.79,0,0,0,4.749-4.8V20.381ZM32,23V9L46,23H32Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Articles";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_article_collection';
    }

    public static function getSectionReferenceId() : string
    {
        return Knowledgebase::class;
    }
}
