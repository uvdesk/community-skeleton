<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class UpdateTag extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.update_tag';
    }

    public static function getDescription()
    {
        return "Set Tag As";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        return array_map(function ($tag) {
            return [
                'id' => $tag->getId(),
                'name' => $tag->getName(),
            ];
        }, $entityManager->getRepository(Tag::class)->findAll());
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        if($entity instanceof Ticket) {
            $isAlreadyAdded = 0;
            $tags = $container->get('ticket.service')->getTicketTagsById($entity->getId());
            if(is_array($tags)) {
                foreach ($tags as $tag) {
                    if($tag['id'] == $value)
                        $isAlreadyAdded = 1;
                }
            }
            if(!$isAlreadyAdded) {
                $tag = $entityManager->getRepository(Tag::class)->find($value);
                if($tag) {
                    $entity->addSupportTag($tag);
                    $entityManager->persist($entity);
                    $entityManager->flush();
                } else {
                    // Ticket Tag Not Found. Disable Workflow/Prepared Response
                    //$this->disableEvent($event, $object);
                }
            }
        }
    }
}
