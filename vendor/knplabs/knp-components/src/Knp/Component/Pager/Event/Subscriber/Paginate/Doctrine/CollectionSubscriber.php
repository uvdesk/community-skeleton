<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;
use ArrayObject;
use Doctrine\Common\Collections\Collection;

class CollectionSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof Collection) {
            $event->count = $event->target->count();
            $event->items = new ArrayObject($event->target->slice(
                $event->getOffset(),
                $event->getLimit()
            ));
            $event->stopPropagation();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 0]
        ];
    }
}
