<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;

class UpdateGroup extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.assign_group';
    }

    public static function getDescription()
    {
        return "Assign to group";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        return $container->get('user.service')->getSupportGroups();
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if($entity instanceof Ticket) {
            $group = $entityManager->getRepository(SupportGroup::class)->find($value);
            if($group) {
                $entity->setSupportGroup($group);
                $entityManager->persist($entity);
                $entityManager->flush();
            } else {
                // User Group Not Found. Disable Workflow/Prepared Response
               // $this->disableEvent($event, $entity);
            }
        }
    }
}
