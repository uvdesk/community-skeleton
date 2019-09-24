<?php

namespace Test\Pager\Pagination;

use Knp\Component\Pager\Event\Subscriber\Paginate\ArraySubscriber;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Mock\PaginationSubscriber as MockPaginationSubscriber;
use Test\Tool\BaseTestCase;

final class AbstractPaginationTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCustomizeParameterNames(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $dispatcher->addSubscriber(new ArraySubscriber);
        $p = new Paginator($dispatcher);

        $items = ['first', 'second'];
        $view = $p->paginate($items, 1, 10);

        // test default names first
        $this->assertEquals('page', $view->getPaginatorOption(PaginatorInterface::PAGE_PARAMETER_NAME));
        $this->assertEquals('sort', $view->getPaginatorOption(PaginatorInterface::SORT_FIELD_PARAMETER_NAME));
        $this->assertEquals('direction', $view->getPaginatorOption(PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME));
        $this->assertTrue($view->getPaginatorOption(PaginatorInterface::DISTINCT));
        $this->assertNull($view->getPaginatorOption(PaginatorInterface::SORT_FIELD_WHITELIST));

        // now customize
        $options = [
            PaginatorInterface::PAGE_PARAMETER_NAME => 'p',
            PaginatorInterface::SORT_FIELD_PARAMETER_NAME => 's',
            PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME => 'd',
            PaginatorInterface::DISTINCT => false,
            PaginatorInterface::SORT_FIELD_WHITELIST => ['a.f', 'a.d']
        ];

        $view = $p->paginate($items, 1, 10, $options);

        $this->assertEquals('p', $view->getPaginatorOption(PaginatorInterface::PAGE_PARAMETER_NAME));
        $this->assertEquals('s', $view->getPaginatorOption(PaginatorInterface::SORT_FIELD_PARAMETER_NAME));
        $this->assertEquals('d', $view->getPaginatorOption(PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME));
        $this->assertFalse($view->getPaginatorOption(PaginatorInterface::DISTINCT));
        $this->assertEquals(['a.f', 'a.d'], $view->getPaginatorOption(PaginatorInterface::SORT_FIELD_WHITELIST));

        // change default paginator options
        $p->setDefaultPaginatorOptions([
            PaginatorInterface::PAGE_PARAMETER_NAME => 'pg',
            PaginatorInterface::SORT_FIELD_PARAMETER_NAME => 'srt',
            PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME => 'dir'
        ]);
        $view = $p->paginate($items, 1, 10);

        $this->assertEquals('pg', $view->getPaginatorOption(PaginatorInterface::PAGE_PARAMETER_NAME));
        $this->assertEquals('srt', $view->getPaginatorOption(PaginatorInterface::SORT_FIELD_PARAMETER_NAME));
        $this->assertEquals('dir', $view->getPaginatorOption(PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME));
        $this->assertTrue($view->getPaginatorOption(PaginatorInterface::DISTINCT));
    }
}
