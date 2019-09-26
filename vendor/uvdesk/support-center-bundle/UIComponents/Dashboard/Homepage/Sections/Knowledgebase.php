<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;

class Knowledgebase extends HomepageSection
{
    public static function getTitle() : string
    {
        return UVDeskService::dynamicTranslation("Knowledgebase");
    }

    public static function getDescription() : string
    {
        return UVDeskService::dynamicTranslation("Knowledgebase is a source of rigid and complex information which helps Customers to help themselves");
    }

}
