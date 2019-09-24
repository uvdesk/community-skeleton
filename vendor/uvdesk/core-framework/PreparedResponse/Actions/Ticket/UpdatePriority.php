<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;

class UpdatePriority extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.update_priority';
    }

    public static function getDescription()
    {
        return 'Set Priority As';
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        return array_map(function ($ticketPriority) {
            return [
                'id' => $ticketPriority->getId(),
                'name' => $ticketPriority->getDescription(),
            ];
        }, $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findAll());
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if( ($entity instanceof Ticket) && $value) {
            $priority = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->find($value);
            $entity->setPriority($priority);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
