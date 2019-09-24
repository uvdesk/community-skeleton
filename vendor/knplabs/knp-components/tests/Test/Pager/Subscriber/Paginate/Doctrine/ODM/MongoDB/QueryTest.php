<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine\ODM\MongoDB;

use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ODM\MongoDB\QuerySubscriber;
use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Fixture\Document\Article;
use Test\Tool\BaseTestCaseMongoODM;

final class QueryTest extends BaseTestCaseMongoODM
{
    /**
     * @test
     */
    public function shouldPaginateSimpleDoctrineMongoDBQuery(): void
    {
        $this->populate();

        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new QuerySubscriber);
        $dispatcher->addSubscriber(new PaginationSubscriber); // pagination view
        $p = new Paginator($dispatcher);

        $qb = $this->dm->createQueryBuilder(Article::class);
        $query = $qb->getQuery();
        $pagination = $p->paginate($query, 1, 2);

        $this->assertInstanceOf(SlidingPagination::class, $pagination);
        $this->assertEquals(1, $pagination->getCurrentPageNumber());
        $this->assertEquals(2, $pagination->getItemNumberPerPage());
        $this->assertEquals(4, $pagination->getTotalItemCount());

        $items = array_values($pagination->getItems());
        $this->assertCount(2, $items);
        $this->assertEquals('summer', $items[0]->getTitle());
        $this->assertEquals('winter', $items[1]->getTitle());
    }

    /**
     * @test
     */
    public function shouldSupportPaginateStrategySubscriber(): void
    {
        $query = $this
            ->getMockDocumentManager()
            ->createQueryBuilder(Article::class)
            ->getQuery()
        ;
        $p = new Paginator;
        $pagination = $p->paginate($query, 1, 10);
        $this->assertInstanceOf(SlidingPagination::class, $pagination);
    }

    private function populate(): void
    {
        $em = $this->getMockDocumentManager();
        $summer = new Article;
        $summer->setTitle('summer');

        $winter = new Article;
        $winter->setTitle('winter');

        $autumn = new Article;
        $autumn->setTitle('autumn');

        $spring = new Article;
        $spring->setTitle('spring');

        $em->persist($summer);
        $em->persist($winter);
        $em->persist($autumn);
        $em->persist($spring);
        $em->flush();
    }
}
