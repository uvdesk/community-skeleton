<?php

namespace Test\Pager\Pagination;

use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Mock\CustomParameterSubscriber;
use Test\Mock\PaginationSubscriber as MockPaginationSubscriber;
use Test\Tool\BaseTestCase;

final class CustomParameterTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldGiveCustomParametersToPaginationView(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new CustomParameterSubscriber);
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $items = ['first', 'second'];
        $view = $p->paginate($items, 1, 10);

        $this->assertEquals('val', $view->getCustomParameter('test'));
        $this->assertNull($view->getCustomParameter('nonExisting'));
    }
}
