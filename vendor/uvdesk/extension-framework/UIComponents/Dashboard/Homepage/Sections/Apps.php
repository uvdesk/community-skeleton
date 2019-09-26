<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;

class Apps extends HomepageSection
{   

    public static function getTitle() : string
    {

        return UVDeskService::dynamicTranslation("Apps"); 
    }

    public static function getDescription() : string
    {

        return UVDeskService::dynamicTranslation("Integrate apps as per your needs to get things done faster than ever"); 
    }

    public static function getRoles() : array
    {
        return [];
    }

}
