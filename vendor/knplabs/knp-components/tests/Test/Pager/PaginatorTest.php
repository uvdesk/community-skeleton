<?php

namespace Test\Pager;

use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Tool\BaseTestCase;

final class PaginatorTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldNotBeAbleToPaginateWithoutListeners(): void
    {
        $this->expectException(\RuntimeException::class);

        $paginator = new Paginator(new EventDispatcher());
        $paginator->paginate([]);
    }

    /**
     * @test
     */
    public function shouldFailToPaginateUnsupportedValue(): void
    {
        $this->expectException(\RuntimeException::class);

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new PaginationSubscriber());

        $paginator = new Paginator($dispatcher);
        $view = $paginator->paginate(null, 1, 10);
    }
}