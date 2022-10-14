<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class AgentReply extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.ticket.agent_reply';
    }

    public static function getDescription()
    {
        return "Agent Reply";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }
}
