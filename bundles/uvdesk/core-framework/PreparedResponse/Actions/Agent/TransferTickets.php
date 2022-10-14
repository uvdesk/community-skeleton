<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Agent;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;

class TransferTickets extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.agent.transfer_tickets';
    }

    public static function getDescription()
    {
        return "Transfer Tickets";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::AGENT;
    }
    
    public static function getOptions(ContainerInterface $container)
    {
        return [];
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
    }
}
