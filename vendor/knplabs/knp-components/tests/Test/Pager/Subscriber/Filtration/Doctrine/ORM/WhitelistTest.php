<?php

namespace Test\Pager\Subscriber\Filtration\Doctrine\ORM;

use Knp\Component\Pager\Event\Subscriber\Filtration\FiltrationSubscriber as Filtration;
use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Fixture\Entity\Article;
use Test\Tool\BaseTestCaseORM;

final class WhitelistTest extends BaseTestCaseORM
{
    /**
     * @test
     */
    public function shouldWhitelistFiltrationFields(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->populate();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new PaginationSubscriber());
        $dispatcher->addSubscriber(new Filtration());
        $requestStack = $this->createRequestStack(['filterParam' => 'a.title', 'filterValue' => 'summer']);
        $p = new Paginator($dispatcher, $requestStack);

        $filterFieldWhitelist = ['a.invalid'];
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::FILTER_FIELD_WHITELIST));

        $items = $view->getItems();
        $this->assertCount(1, $items);
        $this->assertEquals('summer', $items[0]->getTitle());

        $requestStack = $this->createRequestStack(['filterParam' => 'a.id', 'filterValue' => 'summer']);
        $p = new Paginator($dispatcher, $requestStack);
        $view = $p->paginate($query, 1, 10, compact(PaginatorInterface::FILTER_FIELD_WHITELIST));
    }

    /**
     * @test
     */
    public function shouldFilterWithoutSpecificWhitelist(): void
    {
        $this->populate();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new PaginationSubscriber());
        $dispatcher->addSubscriber(new Filtration());
        $requestStack = $this->createRequestStack(['filterParam' => 'a.title', 'filterValue' => 'autumn']);
        $p = new Paginator($dispatcher, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $items = $view->getItems();
        $this->assertEquals('autumn', $items[0]->getTitle());
    }

    /**
     * @test
     */
    public function shouldFilterWithoutSpecificWhitelist2(): void
    {
        $this->populate();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new PaginationSubscriber());
        $dispatcher->addSubscriber(new Filtration());

        $requestStack = $this->createRequestStack(['filterParam' => 'a.id', 'filterValue' => 'autumn']);
        $p = new Paginator($dispatcher, $requestStack);
        $view = $p->paginate($query);

        $items = $view->getItems();
        $this->assertCount(0, $items);
    }

    protected function getUsedEntityFixtures(): array
    {
        return [Article::class];
    }

    private function populate(): void
    {
        $em = $this->getMockSqliteEntityManager();
        $summer = new Article();
        $summer->setTitle('summer');

        $winter = new Article();
        $winter->setTitle('winter');

        $autumn = new Article();
        $autumn->setTitle('autumn');

        $spring = new Article();
        $spring->setTitle('spring');

        $em->persist($summer);
        $em->persist($winter);
        $em->persist($autumn);
        $em->persist($spring);
        $em->flush();
    }
}
