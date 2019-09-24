<?php

namespace Knp\Component\Pager\Event\Subscriber\Sortable;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\BeforeEvent;

class SortableSubscriber implements EventSubscriberInterface
{
    /**
     * Lazy-load state tracker
     * @var bool
     */
    private $isLoaded = false;

    public function before(BeforeEvent $event): void
    {
        // Do not lazy-load more than once
        if ($this->isLoaded) {
            return;
        }

        $disp = $event->getEventDispatcher();
        // hook all standard sortable subscribers
        $request = $event->getRequest();
        $disp->addSubscriber(new Doctrine\ORM\QuerySubscriber($request));
        $disp->addSubscriber(new Doctrine\ODM\MongoDB\QuerySubscriber($request));
        $disp->addSubscriber(new ElasticaQuerySubscriber($request));
        $disp->addSubscriber(new PropelQuerySubscriber($request));
        $disp->addSubscriber(new SolariumQuerySubscriber($request));
        $disp->addSubscriber(new ArraySubscriber($request));

        $this->isLoaded = true;
    }

    public static function getSubscribedEvents()
    {
        return [
            'knp_pager.before' => ['before', 1]
        ];
    }
}
