<?php

namespace Webkul\UVDesk\AutomationBundle\Workflow;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class FunctionalGroup
{
    const USER = 'user';
    const AGENT = 'agent';
    const TICKET = 'ticket';
    const CUSTOMER = 'customer';
}
