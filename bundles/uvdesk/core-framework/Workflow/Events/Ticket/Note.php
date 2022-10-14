<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Note extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.ticket.note_added';
    }

    public static function getDescription()
    {
        return "Note Added";
    }
    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }
}
