<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;

class UserForgotPassword extends WorkflowEvent
{
    public static function getId()
    {
        return 'uvdesk.user.forgot_password';
    }

    public static function getDescription()
    {
        return "User Forgot Password";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::USER;
    }
}
