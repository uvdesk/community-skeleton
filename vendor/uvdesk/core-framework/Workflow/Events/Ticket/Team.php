<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Team extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.ticket.team_updated';
    }

    public static function getDescription()
    {
        return 'Team Updated';
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }
}
