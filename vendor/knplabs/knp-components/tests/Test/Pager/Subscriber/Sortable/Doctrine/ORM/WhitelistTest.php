<?php

namespace Test\Pager\Subscriber\Sortable\Doctrine\ORM;

use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Test\Fixture\Entity\Article;
use Test\Tool\BaseTestCaseORM;

final class WhitelistTest extends BaseTestCaseORM
{
    /**
     * @test
     */
    public function shouldWhitelistSortableFields(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->populate();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $sortFieldWhitelist = ['a.title'];
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::SORT_FIELD_WHITELIST));

        $items = $view->getItems();
        $this->assertCount(4, $items);
        $this->assertEquals('autumn', $items[0]->getTitle());

        $requestStack = $this->createRequestStack(['sort' => 'a.id', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::SORT_FIELD_WHITELIST));
    }

    /**
     * @test
     */
    public function shouldSortWithoutSpecificWhitelist(): void
    {
        $this->populate();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $items = $view->getItems();
        $this->assertEquals('autumn', $items[0]->getTitle());

        $requestStack = $this->createRequestStack(['sort' => 'a.id', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $items = $view->getItems();
        $this->assertEquals('summer', $items[0]->getTitle());
    }

    protected function getUsedEntityFixtures(): array
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
