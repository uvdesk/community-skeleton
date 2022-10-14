<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus;

class MarkSpam extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.mark_spam';
    }

    public static function getDescription()
    {
        return "Mark Spam";
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
            $status = $entityManager->getRepository(TicketStatus::class)->find(6);
            $entity->setStatus($status);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
