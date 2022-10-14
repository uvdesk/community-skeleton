<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class UpdatePriority extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.update_priority';
    }

    public static function getDescription()
    {
        return "Set Priority As";
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
        }, $entityManager->getRepository(TicketPriority::class)->findAll());
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if( ($entity instanceof Ticket) && $value) {
            $priority = $entityManager->getRepository(TicketPriority::class)->find($value);
            $entity->setPriority($priority);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
