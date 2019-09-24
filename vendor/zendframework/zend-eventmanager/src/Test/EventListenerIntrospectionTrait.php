<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zend-eventmanager for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-eventmanager/blob/master/LICENSE.md
 */

namespace Zend\EventManager\Test;

use PHPUnit\Framework\Assert;
use ReflectionProperty;
use Zend\EventManager\EventManager;

/**
 * Trait providing utility methods and assertions for use in PHPUnit test cases.
 *
 * This trait may be composed into a test case, and provides:
 *
 * - methods for introspecting events and listeners
 * - methods for asserting listeners are attached at a specific priority
 *
 * Some functionality in this trait duplicates functionality present in the
 * version 2 EventManagerInterface and/or EventManager implementation, but
 * abstracts that functionality for use in v3. As such, components or code
 * that is testing for listener registration should use the methods in this
 * trait to ensure tests are forwards-compatible between zend-eventmanager
 * versions.
 */
trait EventListenerIntrospectionTrait
{
    /**
     * Retrieve a list of event names from an event manager.
     *
     * @param EventManager $events
     * @return string[]
     */
    private function getEventsFromEventManager(EventManager $events)
    {
        $r = new ReflectionProperty($events, 'events');
        $r->setAccessible(true);
        $listeners = $r->getValue($events);
        return array_keys($listeners);
    }

    /**
     * Retrieve an interable list of listeners for an event.
     *
     * Given an event and an event manager, returns an iterator with the
     * listeners for that event, in priority order.
     *
     * If $withPriority is true, the key values will be the priority at which
     * the given listener is attached.
     *
     * Do not pass $withPriority if you want to cast the iterator to an array,
     * as many listeners will likely have the same priority, and thus casting
     * will collapse to the last added.
     *
     * @param string $event
     * @param EventManager $events
     * @param bool $withPriority
     * @return \Traversable
     */
    private function getListenersForEvent($event, EventManager $events, $withPriority = false)
    {
        $r = new ReflectionProperty($events, 'events');
        $r->setAccessible(true);
        $internal = $r->getValue($events);

        $listeners = [];
        foreach (isset($internal[$event]) ? $internal[$event] : [] as $p => $listOfListeners) {
            foreach ($listOfListeners as $l) {
                $listeners[$p] = isset($listeners[$p]) ? array_merge($listeners[$p], $l) : $l;
            }
        }

        return $this->traverseListeners($listeners, $withPriority);
    }

    /**
     * Assert that a given listener exists at the specified priority.
     *
     * @param callable $expectedListener
     * @param int $expectedPriority
     * @param string $event
     * @param EventManager $events
     * @param string $message Failure message to use, if any.
     */
    private function assertListenerAtPriority(
        callable $expectedListener,
        $expectedPriority,
        $event,
        EventManager $events,
        $message = ''
    ) {
        $message = $message ?: sprintf(
            'Listener not found for event "%s" and priority %d',
            $event,
            $expectedPriority
        );
        $listeners = $this->getListenersForEvent($event, $events, true);
        $found     = false;
        foreach ($listeners as $priority => $listener) {
            if ($listener === $expectedListener
                && $priority === $expectedPriority
            ) {
                $found = true;
                break;
            }
        }
        Assert::assertTrue($found, $message);
    }

    /**
     * Returns an indexed array of listeners for an event.
     *
     * Returns an indexed array of listeners for an event, in priority order.
     * Priority values will not be included; use this only for testing if
     * specific listeners are present, or for a count of listeners.
     *
     * @param string $event
     * @param EventManager $events
     * @return callable[]
     */
    private function getArrayOfListenersForEvent($event, EventManager $events)
    {
        return iterator_to_array($this->getListenersForEvent($event, $events));
    }

    /**
     * Generator for traversing listeners in priority order.
     *
     * @param array $listeners
     * @param bool $withPriority When true, yields priority as key.
     */
    public function traverseListeners(array $queue, $withPriority = false)
    {
        krsort($queue, SORT_NUMERIC);

        foreach ($queue as $priority => $listeners) {
            $priority = (int) $priority;
            foreach ($listeners as $listener) {
                if ($withPriority) {
                    yield $priority => $listener;
                } else {
                    yield $listener;
                }
            }
        }
    }
}
