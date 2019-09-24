<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Component\Pager\Paginator;
use Test\Fixture\Entity\Article;
use Test\Tool\BaseTestCaseORM;

final class DBALQueryBuilderTest extends BaseTestCaseORM
{
    /**
     * @test
     */
    public function shouldPaginateSimpleDoctrineQuery(): void
    {
        $this->populate();
        $p = new Paginator;

        $qb = new QueryBuilder($this->em->getConnection());
        $qb->select('*')
            ->from('Article', 'a')
        ;
        $view = $p->paginate($qb, 1, 2);

        $this->assertEquals(1, $view->getCurrentPageNumber());
        $this->assertEquals(2, $view->getItemNumberPerPage());
        $this->assertEquals(4, $view->getTotalItemCount());

        $items = $view->getItems();
        $this->assertCount(2, $items);
        $this->assertEquals('summer', $items[0]['title']);
        $this->assertEquals('winter', $items[1]['title']);
    }

    protected function getUsedEntityFixtures()
    {
        return [Article::class];
    }

    private function populate(): void
    {
        $em = $this->getMockSqliteEntityManager();
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
