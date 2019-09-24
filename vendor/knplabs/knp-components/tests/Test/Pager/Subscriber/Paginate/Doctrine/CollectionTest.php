<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\CollectionSubscriber;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Mock\PaginationSubscriber as MockPaginationSubscriber;
use Test\Tool\BaseTestCase;

final class CollectionTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldPaginateCollection(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new CollectionSubscriber);
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $items = new ArrayCollection(['first', 'second']);
        $view = $p->paginate($items, 1, 10);

        $this->assertEquals(1, $view->getCurrentPageNumber());
        $this->assertEquals(10, $view->getItemNumberPerPage());
        $this->assertCount(2, $view->getItems());
        $this->assertEquals(2, $view->getTotalItemCount());
    }

    /**
     * @test
     */
    public function shouldSlicePaginateAnArray(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new CollectionSubscriber);
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $items = new ArrayCollection(range('a', 'u'));
        $view = $p->paginate($items, 2, 10);

        $this->assertEquals(2, $view->getCurrentPageNumber());
        $this->assertEquals(10, $view->getItemNumberPerPage());
        $this->assertCount(10, $view->getItems());
        $this->assertEquals(21, $view->getTotalItemCount());
    }

    /**
     * @test
     */
    public function shouldSupportPaginateStrategySubscriber(): void
    {
        $items = new ArrayCollection(['first', 'second']);
        $p = new Paginator;
        $view = $p->paginate($items, 1, 10);
        $this->assertInstanceOf(PaginationInterface::class, $view);
    }
}
