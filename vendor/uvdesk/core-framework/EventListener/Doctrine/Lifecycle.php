<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\EventListener\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Lifecycle
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $timestamp = new \DateTime('now');

        switch (true) {
            case $entity instanceof CoreEntities\TicketRating:
                $entity->setCreatedAt($timestamp);
                break;
            case $entity instanceof CoreEntities\Ticket:
                $entity->setCreatedAt($timestamp)->setUpdatedAt($timestamp);
                break;
            case $entity instanceof CoreEntities\SavedFilters:
                $entity->setDateAdded($timestamp)->setDateUpdated($timestamp);
                break;
            case $entity instanceof CoreEntities\Thread:
                $entity->setCreatedAt($timestamp)->setUpdatedAt($timestamp);
                
                if ('reply' === $entity->getThreadType() && 'agent' === $entity->getCreatedBy()) {
                    $ticket = $entity->getTicket();
                    $ticket->setIsNew(false);
                    $ticket->setIsReplied(true);
                    $ticket->setIsCustomerViewed(false);

                    $args->getEntityManager()->persist($ticket);
                } else if ('create' === $entity->getThreadType()) {
                    $ticket = $entity->getTicket();
                    $ticket->setIsReplied(0);

                    $args->getEntityManager()->persist($ticket);
                }
                break;
            default:
                break;
        }

        return;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $timestamp = new \DateTime('now');

        switch (true) {
            case $entity instanceof CoreEntities\Ticket:
            case $entity instanceof CoreEntities\Thread:
                $entity->setUpdatedAt($timestamp);
                break;
            case $entity instanceof CoreEntities\SavedFilters:
                $entity->setDateUpdated($timestamp);
                break;
            default:
                break;
        }
        
        return;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $timestamp = new \DateTime('now');

        switch (true) {
            default:
                break;
        }

        return;
    }
}
