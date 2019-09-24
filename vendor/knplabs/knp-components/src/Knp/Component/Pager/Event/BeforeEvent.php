<?php

namespace Knp\Component\Pager\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specific Event class for paginator
 */
class BeforeEvent extends Event
{
    private $eventDispatcher;

    private $request;

    public function __construct(EventDispatcherInterface $eventDispatcher, ?Request $request)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->request = $request;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function getRequest(): Request
    {
        return $this->request ?? Request::createFromGlobals();
    }
}
