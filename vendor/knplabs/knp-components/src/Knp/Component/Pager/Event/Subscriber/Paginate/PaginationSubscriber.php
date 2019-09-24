<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\Event\BeforeEvent;
use Knp\Component\Pager\Pagination\SlidingPagination;

class PaginationSubscriber implements EventSubscriberInterface
{
    /**
     * Lazy-load state tracker
     * @var bool
     */
    private $isLoaded = false;

    public function pagination(PaginationEvent $event): void
    {
        $event->setPagination(new SlidingPagination);
        $event->stopPropagation();
    }

    public function before(BeforeEvent $event): void
    {
        // Do not lazy-load more than once
        if ($this->isLoaded) {
            return;
        }

        $disp = $event->getEventDispatcher();
        // hook all standard subscribers
        $disp->addSubscriber(new ArraySubscriber);
        $disp->addSubscriber(new Callback\CallbackSubscriber);
        $disp->addSubscriber(new Doctrine\ORM\QueryBuilderSubscriber);
        $disp->addSubscriber(new Doctrine\ORM\QuerySubscriber);
        $disp->addSubscriber(new Doctrine\ODM\MongoDB\QueryBuilderSubscriber);
        $disp->addSubscriber(new Doctrine\ODM\MongoDB\QuerySubscriber);
        $disp->addSubscriber(new Doctrine\ODM\PHPCR\QueryBuilderSubscriber);
        $disp->addSubscriber(new Doctrine\ODM\PHPCR\QuerySubscriber);
        $disp->addSubscriber(new Doctrine\CollectionSubscriber);
        $disp->addSubscriber(new Doctrine\DBALQueryBuilderSubscriber);
        $disp->addSubscriber(new PropelQuerySubscriber);
        $disp->addSubscriber(new SolariumQuerySubscriber());
        $disp->addSubscriber(new ElasticaQuerySubscriber());

        $this->isLoaded = true;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.before' => ['before', 0],
            'knp_pager.pagination' => ['pagination', 0]
        ];
    }
}
