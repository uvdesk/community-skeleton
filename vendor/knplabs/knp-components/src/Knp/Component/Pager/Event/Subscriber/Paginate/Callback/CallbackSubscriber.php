<?php


namespace Knp\Component\Pager\Event\Subscriber\Paginate\Callback;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Callback pagination.
 *
 * @author Piotr Pelczar <me@athlan.pl>
 */
class CallbackSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof CallbackPagination) {
            $event->count = $event->target->getPaginationCount();
            if($event->count > 0) {
                $event->items = $event->target->getPaginationItems($event->getOffset(), $event->getLimit());
            }
            else {
                $event->items = [];
            }

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