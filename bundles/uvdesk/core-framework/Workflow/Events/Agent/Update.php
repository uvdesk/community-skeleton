<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Agent;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Update extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.agent.update';
    }

    public static function getDescription()
    {
        return "Agent Update";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::AGENT;
    }
}
