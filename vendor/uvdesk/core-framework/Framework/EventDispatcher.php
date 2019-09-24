<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Framework;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDisptacher;

class EventDispatcher extends SymfonyEventDisptacher
{
    private $container;
    private $requestStack;

    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    public function addEventListener($eventListener, array $tags = [])
    {
        foreach ($tags as $tag) {
            $this->addListener($tag['event'], [$eventListener, $tag['method']]);
        }
    }
}
