<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;

class UpdateType extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.update_type';
    }

    public static function getDescription()
    {
        return "Set Type As";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $collection = $entityManager->getRepository(TicketType::class)->findBy(['isActive' => true], ['code' => 'ASC']);

        return array_map(function ($ticketType) {
            return [
                'id' => $ticketType->getId(),
                'name' => $ticketType->getCode(),
            ];
        }, $collection);
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if($entity instanceof Ticket && $value) {
            $type = $entityManager->getRepository(TicketType::class)->find($value);
            if($type) {
                $entity->setType($type);
                $entityManager->persist($entity);
                $entityManager->flush();
            } else {
                // Ticket Type Not Found. Disable Workflow/Prepared Response
                // $this->disableEvent($event, $entity);
            }
        }
    }
}
