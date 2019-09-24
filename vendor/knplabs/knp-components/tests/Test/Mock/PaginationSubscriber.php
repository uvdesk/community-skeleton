<?php

namespace Test\Mock;

use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PaginationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.pagination' => ['pagination', 0]
        ];
    }

    public function pagination(PaginationEvent $e): void
    {
        $e->setPagination(new SlidingPagination);
        $e->stopPropagation();
    }
}
