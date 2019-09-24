<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;

class Apps extends HomepageSection
{
    public static function getTitle() : string
    {
        return "Apps";
    }

    public static function getDescription() : string
    {
        return "Integrate apps as per as your needs to get things done faster than ever";
    }

    public static function getRoles() : array
    {
        return [];
    }
}
