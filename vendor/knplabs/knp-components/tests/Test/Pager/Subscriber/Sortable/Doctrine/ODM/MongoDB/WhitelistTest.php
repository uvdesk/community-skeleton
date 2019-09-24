<?php

namespace Test\Pager\Subscriber\Sortable\Doctrine\ODM\MongoDB;

use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Event\Subscriber\Sortable\Doctrine\ODM\MongoDB\QuerySubscriber as Sortable;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Fixture\Document\Article;
use Test\Tool\BaseTestCaseMongoODM;

final class WhitelistTest extends BaseTestCaseMongoODM
{
    /**
     * @test
     */
    public function shouldWhitelistSortableFields(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->populate();
        $query = $this->dm
            ->createQueryBuilder(Article::class)
            ->getQuery()
        ;

        $requestStack = $this->createRequestStack(['sort' => 'title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $sortFieldWhitelist = ['title'];
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::SORT_FIELD_WHITELIST));

        $items = array_values($view->getItems());
        $this->assertCount(4, $items);
        $this->assertEquals('autumn', $items[0]->getTitle());

        $requestStack = $this->createRequestStack(['sort' => 'id', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::SORT_FIELD_WHITELIST));
    }

    /**
     * @test
     */
    public function shouldSortWithoutSpecificWhitelist(): void
    {
        $this->populate();
        $query = $this->dm
            ->createQueryBuilder(Article::class)
            ->getQuery()
        ;

        $requestStack = $this->createRequestStack(['sort' => 'title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $items = array_values($view->getItems());
        $this->assertEquals('autumn', $items[0]->getTitle());

        $requestStack = $this->createRequestStack(['sort' => 'id', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $items = array_values($view->getItems());
        $this->assertEquals('summer', $items[0]->getTitle());
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
