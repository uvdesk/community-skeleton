<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus;
use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class UpdateStatus extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.update_status';
    }

    public static function getDescription()
    {
        return "Set Status As";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        return array_map(function ($ticketStatus) {
            return [
                'id' => $ticketStatus->getId(),
                'name' => $ticketStatus->getDescription(),
            ];
        }, $entityManager->getRepository(TicketStatus::class)->findAll());
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        if ($entity instanceof Ticket && !empty($value)) {
            $ticketStatus = $entityManager->getRepository(TicketStatus::class)->findOneById($value);
            $entity->setStatus($ticketStatus);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
