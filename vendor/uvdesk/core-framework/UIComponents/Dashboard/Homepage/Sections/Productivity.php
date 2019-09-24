<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;

class Productivity extends HomepageSection
{
    public static function getTitle() : string
    {
        return "Productivity";
    }

    public static function getDescription() : string
    {
        return "Automate your processes by creating set of rules and presets to respond faster to the tickets";
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_WORKFLOW_MANUAL',
            'ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC',
            'ROLE_AGENT_MANAGE_TICKET_TYPE',
            'ROLE_AGENT_MANAGE_TAG',
        ];
    }
}
