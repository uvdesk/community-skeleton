<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ODM\MongoDB;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;
use Doctrine\ODM\MongoDB\Query\Query;

class QuerySubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof Query) {
            // items
            $type = $event->target->getType();
            if ($type !== Query::TYPE_FIND) {
                throw new \UnexpectedValueException('ODM query must be a FIND type query');
            }
            static $reflectionProperty;
            if (is_null($reflectionProperty)) {
                $reflectionClass = new \ReflectionClass('Doctrine\ODM\MongoDB\Query\Query');
                $reflectionProperty = $reflectionClass->getProperty('query');
                $reflectionProperty->setAccessible(true);
            }
            $queryOptions = $reflectionProperty->getValue($event->target);
            $resultCount = clone $event->target;
            $queryOptions['type'] = Query::TYPE_COUNT;
            $reflectionProperty->setValue($resultCount, $queryOptions);
            $event->count = $resultCount->execute();

            $queryOptions = $reflectionProperty->getValue($event->target);
            $queryOptions['type'] = Query::TYPE_FIND;
            $queryOptions['limit'] = $event->getLimit();
            $queryOptions['skip'] = $event->getOffset();
            $resultQuery = clone $event->target;
            $reflectionProperty->setValue($resultQuery, $queryOptions);
            $cursor = $resultQuery->execute();

            $event->items = [];
            // iterator_to_array for GridFS results in 1 item
            foreach ($cursor as $item) {
                $event->items[] = $item;
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
