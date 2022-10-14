<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Collaborator extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.ticket.collaborator_updated';
    }

    public static function getDescription()
    {
        return "Collaborator Added";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }
}
