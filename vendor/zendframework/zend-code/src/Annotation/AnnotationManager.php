<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Annotation;

use Zend\Code\Annotation\Parser\ParserInterface;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

use function get_class;
use function is_object;

/**
 * Pluggable annotation manager
 *
 * Simply composes an EventManager. When createAnnotation() is called, it fires
 * off an event of the same name, passing it the resolved annotation class, the
 * annotation content, and the raw annotation string; the first listener to
 * return an object will halt execution of the event, and that object will be
 * returned as the annotation.
 */
class AnnotationManager implements EventManagerAwareInterface
{
    const EVENT_CREATE_ANNOTATION = 'createAnnotation';

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * Set the event manager instance
     *
     * @param  EventManagerInterface $events
     * @return AnnotationManager
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $this->events = $events;

        return $this;
    }

    /**
     * Retrieve event manager
     *
     * Lazy loads an instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }

        return $this->events;
    }

    /**
     * Attach a parser to listen to the createAnnotation event
     *
     * @param  ParserInterface $parser
     * @return AnnotationManager
     */
    public function attach(ParserInterface $parser)
    {
        $this->getEventManager()
             ->attach(self::EVENT_CREATE_ANNOTATION, [$parser, 'onCreateAnnotation']);

        return $this;
    }

    /**
     * Create Annotation
     *
     * @param  string[] $annotationData
     * @return false|\stdClass
     */
    public function createAnnotation(array $annotationData)
    {
        $event = new Event();
        $event->setName(self::EVENT_CREATE_ANNOTATION);
        $event->setTarget($this);
        $event->setParams([
            'class'   => $annotationData[0],
            'content' => $annotationData[1],
            'raw'     => $annotationData[2],
        ]);

        $eventManager = $this->getEventManager();
        $results = $eventManager->triggerEventUntil(function ($r) {
            return is_object($r);
        }, $event);

        $annotation = $results->last();

        return is_object($annotation) ? $annotation : false;
    }
}
