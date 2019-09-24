<?php

namespace Test\Pager\Subscriber\Paginate;

use Knp\Component\Pager\Event\Subscriber\Paginate\ArraySubscriber;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Mock\PaginationSubscriber as MockPaginationSubscriber;
use Test\Tool\BaseTestCase;

final class ArrayTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldPaginateAnArray(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new ArraySubscriber);
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $items = ['first', 'second'];
        $view = $p->paginate($items, 1, 10);
        $this->assertInstanceOf(PaginationInterface::class, $view);

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
        $dispatcher->addSubscriber(new ArraySubscriber);
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $items = range('a', 'u');
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
        $items = ['first', 'second'];
        $p = new Paginator;
        $view = $p->paginate($items, 1, 10);
        $this->assertInstanceOf(PaginationInterface::class, $view);
    }

    /**
     * @test
     */
    public function shouldPaginateArrayObject(): void
    {
        $items = ['first', 'second'];
        $array = new \ArrayObject($items);
        $p = new Paginator;
        $view = $p->paginate($array, 1, 10);
        $this->assertInstanceOf(PaginationInterface::class, $view);
    }
}
