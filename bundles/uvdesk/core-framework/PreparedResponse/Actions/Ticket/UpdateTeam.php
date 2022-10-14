<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;

class UpdateTeam extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.assign_team';
    }

    public static function getDescription()
    {
        return "Assign to team";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        return $container->get('user.service')->getSupportTeams();
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if($entity instanceof Ticket) {
            $subGroup = $entityManager->getRepository(SupportTeam::class)->find($value);
            if($subGroup) {
                $entity->setSupportTeam($subGroup);
                $entityManager->persist($entity);
                $entityManager->flush();
            } else {
                // User Sub Group Not Found. Disable Workflow/Prepared Response
                //$this->disableEvent($event, $entity);
            }
        }
    }
}
