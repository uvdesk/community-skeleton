<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Customer;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\UserForgotPassword as UserForgotPasswordEvent;

class ForgotPassword extends UserForgotPasswordEvent
{
    public static function getDescription()
    {
        return "Customer Forgot Password";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::CUSTOMER;
    }
}
