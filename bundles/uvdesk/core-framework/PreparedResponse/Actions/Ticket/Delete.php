<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;

class Delete extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.delete';
    }

    public static function getDescription()
    {
        return "Delete Ticket";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        return [];
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if($entity instanceof Ticket) {
            $entityManager->remove($entity);
            $entityManager->flush();
        }
    }
}
