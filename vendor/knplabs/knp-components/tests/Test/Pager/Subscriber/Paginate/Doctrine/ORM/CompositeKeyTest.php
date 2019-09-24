<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\QuerySubscriber;
use Knp\Component\Pager\Paginator;
use Test\Fixture\Entity\Composite;
use Test\Tool\BaseTestCaseORM;

final class CompositeKeyTest extends BaseTestCaseORM
{
    /**
     * @test
     */
    public function shouldBeHandledByQueryHintByPassingCount(): void
    {
        $p = new Paginator;
        $em = $this->getMockSqliteEntityManager();
        $this->populate($em);

        $count = $em
            ->createQuery('SELECT COUNT(c) FROM Test\Fixture\Entity\Composite c')
            ->getSingleScalarResult()
        ;

        $query = $em
            ->createQuery('SELECT c FROM Test\Fixture\Entity\Composite c')
            ->setHint('knp_paginator.count', $count)
        ;
        $query->setHint(QuerySubscriber::HINT_FETCH_JOIN_COLLECTION, false);
        $view = $p->paginate($query, 1, 10, ['wrap-queries' => true]);

        $items = $view->getItems();
        $this->assertCount(4, $items);
    }

    protected function getUsedEntityFixtures(): array
    {
        return [Composite::class];
    }

    private function populate(EntityManagerInterface $em): void
    {
        $summer = new Composite;
        $summer->setId(1);
        $summer->setTitle('summer');
        $summer->setUid(100);

        $winter = new Composite;
        $winter->setId(2);
        $winter->setTitle('winter');
        $winter->setUid(200);

        $autumn = new Composite;
        $autumn->setId(3);
        $autumn->setTitle('autumn');
        $autumn->setUid(300);

        $spring = new Composite;
        $spring->setId(4);
        $spring->setTitle('spring');
        $spring->setUid(400);

        $em->persist($summer);
        $em->persist($winter);
        $em->persist($autumn);
        $em->persist($spring);
        $em->flush();
    }

}
