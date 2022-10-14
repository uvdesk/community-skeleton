<?php

namespace Webkul\UVDesk\AutomationBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\AutomationBundle\Entity\PreparedResponses;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;

class PreparedResponseListener
{
    private $container;
    private $entityManager;
    private $registeredPreparedResponseActions = [];

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function registerPreparedResponseAction(PreparedResponseAction $serviceTag)
    {
        $this->registeredPreparedResponseActions[] = $serviceTag;
    }

    public function getRegisteredPreparedResponseActions()
    {
        return $this->registeredPreparedResponseActions;
    }

    public function executePreparedResponse(GenericEvent $event)
    {
        $preparedResponse = $this->entityManager->getRepository(PreparedResponses::class)->getPreparedResponse($event->getSubject());
        
        if (!empty($preparedResponse)) {
            $this->applyPreparedResponseActions($preparedResponse , $event->getArgument('entity'));
        }
    }

    private function applyPreparedResponseActions(PreparedResponses $preparedResponse, $entity)
    {
        foreach ($preparedResponse->getActions() as $attributes) {
            if (empty($attributes['type'])) {
                continue;
            }
            
            foreach ($this->getRegisteredPreparedResponseActions() as $preparedResponseAction) {
                if ($preparedResponseAction->getId() == $attributes['type']) {
                    $preparedResponseAction->applyAction($this->container, $entity, isset($attributes['value']) ? $attributes['value']: '');
                }
            }
        }
    }
}
