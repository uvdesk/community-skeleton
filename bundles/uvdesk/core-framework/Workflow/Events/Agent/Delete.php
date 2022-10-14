<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Agent;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Delete extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.agent.removed';
    }

    public static function getDescription()
    {
        return "Agent Deleted";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::AGENT;
    }
}
