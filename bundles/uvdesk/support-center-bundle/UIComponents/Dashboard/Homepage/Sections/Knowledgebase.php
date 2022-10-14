<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;

class Knowledgebase extends HomepageSection
{
    public static function getTitle() : string
    {
        return "Knowledgebase";
    }

    public static function getDescription() : string
    {
        return "Knowledgebase is a source of rigid and complex information which helps Customers to help themselves";
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_KNOWLEDGEBASE'
        ];
    }
}
