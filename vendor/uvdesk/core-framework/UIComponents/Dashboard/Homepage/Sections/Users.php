<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;

class Users extends HomepageSection
{
    public static function getTitle() : string
    {
        return "Users";
    }

    public static function getDescription() : string
    {
        return "Control your Groups, Teams, Agents and Customers";
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_GROUP',
            'ROLE_AGENT_MANAGE_SUB_GROUP',
            'ROLE_AGENT_MANAGE_AGENT',
            'ROLE_AGENT_MANAGE_AGENT_PRIVILEGE',
            'ROLE_AGENT_MANAGE_CUSTOMER'
        ];
    }
}
