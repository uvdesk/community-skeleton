<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class UpdateTeam extends WorkflowAction
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
