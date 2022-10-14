<?php

namespace Webkul\UVDesk\AutomationBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ActivityEvent extends Event
{
    private $eventName;
    private $entity;
    private $container;
    private $user;
    private $targetEntity;
    private $userType;
    private $notePlaceholders;
    private $subject;
    private $socialMedium;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function setParameters($params) {
        $this->eventName = $params['event'];
        $this->userType = isset($params['userType']) ? $params['userType'] : 'agent';
        $this->entity = $params['entity'];

        if(isset($params['notePlaceholders']))
            $this->notePlaceholders = $params['notePlaceholders'];

        if(isset($params['targetEntity']))
            $this->targetEntity = $params['targetEntity'];

        if(isset($params['user']))
            $this->user = $params['user'];

        if(isset($params['subject']) && $params['subject'] != '')
            $this->subject = $params['subject'];

        $this->socialMedium = isset($params['socialMedium']) ? $params['socialMedium'] : false;
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getNotePlaceholders()
    {
        return $this->notePlaceholders;
    }

    public function getTargetEntity()
    {
        return $this->targetEntity;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getCurrentUser()
    {
        $user = $this->container->get('user.service')->getSessionUser();
        if ($user)
            return $user;
        else {
            return $this->user;
        }
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getSocialMedium()
    {
        return $this->socialMedium;
    }
}
