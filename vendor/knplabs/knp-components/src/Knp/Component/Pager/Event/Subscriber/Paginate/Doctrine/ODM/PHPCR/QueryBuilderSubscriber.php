<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ODM\PHPCR;

use Doctrine\ODM\PHPCR\Query\Builder\QueryBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;

/**
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class QueryBuilderSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if (!$event->target instanceof QueryBuilder) {
            return;
        }

        $event->target = $event->target->getQuery();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 10/*make sure to transform before any further modifications*/]
        ];
    }
}
