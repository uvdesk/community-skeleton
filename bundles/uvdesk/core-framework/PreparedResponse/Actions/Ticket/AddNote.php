<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;

class AddNote extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.agent.add_note';
    }

    public static function getDescription()
    {
        return "Add Note";
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
        if($entity instanceof Ticket && $entity->getIsTrashed())
            return;
        if($entity instanceof Ticket) {
            $data = array();
            $data['ticket'] = $entity;
            $data['threadType'] = 'note';
            $data['source'] = 'website';
            $data['message'] = $value; 
            $data['createdBy'] = 'System';
            $container->get('ticket.service')->createThread($entity, $data);
        }
    }
}
