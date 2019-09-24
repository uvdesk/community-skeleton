<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;

/**
 * @internal
 */
class EventRegistry
{
    // list of *known* events to always include (if they exist)
    private static $newEventsMap = [
        'kernel.exception' => ExceptionEvent::class,
        'kernel.request' => RequestEvent::class,
        'kernel.response' => ResponseEvent::class,
        'kernel.view' => ViewEvent::class,
        'kernel.controller_arguments' => ControllerArgumentsEvent::class,
        'kernel.controller' => ControllerEvent::class,
        'kernel.terminate' => TerminateEvent::class,
    ];

    private static $eventsMap = [
        'console.command' => ConsoleCommandEvent::class,
        'console.terminate' => ConsoleTerminateEvent::class,
        'console.error' => ConsoleErrorEvent::class,
        'kernel.request' => GetResponseEvent::class,
        'kernel.exception' => GetResponseForExceptionEvent::class,
        'kernel.view' => GetResponseForControllerResultEvent::class,
        'kernel.controller' => FilterControllerEvent::class,
        'kernel.controller_arguments' => FilterControllerArgumentsEvent::class,
        'kernel.response' => FilterResponseEvent::class,
        'kernel.terminate' => PostResponseEvent::class,
        'kernel.finish_request' => FinishRequestEvent::class,
        'security.authentication.success' => AuthenticationEvent::class,
        'security.authentication.failure' => AuthenticationFailureEvent::class,
        'security.interactive_login' => InteractiveLoginEvent::class,
        'security.switch_user' => SwitchUserEvent::class,
    ];

    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;

        // Loop through the new event classes
        foreach (self::$newEventsMap as $oldEventName => $newEventClass) {
            //Check if the new event classes exist, if so replace the old one with the new.
            if (isset(self::$eventsMap[$oldEventName]) && class_exists($newEventClass)) {
                unset(self::$eventsMap[$oldEventName]);
                self::$eventsMap[$newEventClass] = $newEventClass;
            }
        }
    }

    /**
     * Returns all known event names in the system.
     */
    public function getAllActiveEvents(): array
    {
        $activeEvents = [];
        foreach (self::$eventsMap as $eventName => $eventClass) {
            if (!class_exists($eventClass)) {
                continue;
            }

            $activeEvents[] = $eventName;
        }

        $listeners = $this->eventDispatcher->getListeners();

        // Check if these listeners are part of the new events.
        foreach (array_keys($listeners) as $listenerKey) {
            if (isset(self::$newEventsMap[$listenerKey])) {
                unset($listeners[$listenerKey]);
            }
        }

        $activeEvents = array_unique(array_merge($activeEvents, array_keys($listeners)));

        asort($activeEvents);

        return $activeEvents;
    }

    /**
     * Attempts to get the event class for a given event.
     */
    public function getEventClassName(string $event)
    {
        if (isset(self::$eventsMap[$event])) {
            return self::$eventsMap[$event];
        }

        $listeners = $this->eventDispatcher->getListeners($event);
        if (empty($listeners)) {
            return null;
        }

        foreach ($listeners as $listener) {
            if (!\is_array($listener) || 2 !== \count($listener)) {
                continue;
            }

            $reflectionMethod = new \ReflectionMethod($listener[0], $listener[1]);
            $args = $reflectionMethod->getParameters();
            if (!$args) {
                continue;
            }

            if (null !== $type = $args[0]->getType()) {
                return (string) $type;
            }
        }

        return null;
    }
}
