<?php

namespace Test\Pager\Subscriber\Paginate;

use Elastica\Query;
use Elastica\Query\Term;
use Elastica\Result;
use Elastica\ResultSet;
use Elastica\SearchableInterface;
use Knp\Component\Pager\Event\Subscriber\Paginate\ElasticaQuerySubscriber;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Mock\PaginationSubscriber as MockPaginationSubscriber;
use Test\Tool\BaseTestCase;

final class ElasticaTest extends BaseTestCase
{
    public function testElasticaSubscriber(): void
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new ElasticaQuerySubscriber());
        $dispatcher->addSubscriber(new MockPaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $query = Query::create(new Term([
            'name' => 'Fred',
        ]));
        $response = $this->getMockBuilder(ResultSet::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())
            ->method('getTotalHits')
            ->willReturn(2);
        $response->expects($this->once())
            ->method('getResults')
            ->willReturn([new Result([]), new Result([])]);

        $searchable = $this->getMockBuilder(SearchableInterface::class)->getMock();
        $searchable->expects($this->once())
            ->method('search')
            ->with($query)
            ->willReturn($response);

        $view = $p->paginate([$searchable, $query], 1, 10);

        $this->assertEquals(0, $query->getParam('from'), 'Query offset set correctly');
        $this->assertEquals(10, $query->getParam('size'), 'Query limit set correctly');
        $this->assertSame($response, $view->getCustomParameter('resultSet'), 'Elastica ResultSet available in Paginator');

        $this->assertEquals(1, $view->getCurrentPageNumber());
        $this->assertEquals(10, $view->getItemNumberPerPage());
        $this->assertCount(2, $view->getItems());
        $this->assertEquals(2, $view->getTotalItemCount());
    }
}
