<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Customer;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class Update extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.customer.updated';
    }

    public static function getDescription()
    {
        return "Customer Update";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::CUSTOMER;
    }
}
