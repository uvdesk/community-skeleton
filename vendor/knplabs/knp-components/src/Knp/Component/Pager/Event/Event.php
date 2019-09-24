<?php

namespace Knp\Component\Pager\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Contracts\EventDispatcher\Event as ContractEvent;

/**
 * Base class for events, BC compatible.
 */
if (Kernel::VERSION_ID >= 40300 && class_exists(ContractEvent::class)) {
    class Event extends ContractEvent
    {
    }
} else {
    class Event extends BaseEvent
    {
    }
}
