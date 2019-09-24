<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine\ODM\PHPCR;

use Knp\Component\Pager\Paginator;
use Test\Fixture\Document\PHPCR\Article;
use Test\Tool\BaseTestCasePHPCRODM;

final class QueryBuilderSubscriberTest extends BaseTestCasePHPCRODM
{
    /**
     * @test
     */
    public function shouldSupportPaginateStrategySubscriber(): void
    {
        $this->populate();

        $qb = $this->dm->createQueryBuilder();
        $qb->fromDocument(Article::class, 'a');

        $p = new Paginator();
        $pagination = $p->paginate($qb, 1, 2);
        $this->assertEquals(1, $pagination->getCurrentPageNumber());
        $this->assertEquals(2, $pagination->getItemNumberPerPage());
        $this->assertEquals(4, $pagination->getTotalItemCount());

        $items = $pagination->getItems();

        $this->assertCount(2, $items);
        $this->assertEquals('summer', $items->first()->getTitle());
        $this->assertEquals('winter', $items->last()->getTitle());
    }

    private function populate(): void
    {
        $dm = $this->getMockDocumentManager();

        $root = $dm->find(null, '/');

        $summer = new Article();
        $summer->setTitle('summer');
        $summer->setParent($root);

        $winter = new Article();
        $winter->setTitle('winter');
        $winter->setParent($root);

        $autumn = new Article();
        $autumn->setTitle('autumn');
        $autumn->setParent($root);

        $spring = new Article();
        $spring->setTitle('spring');
        $spring->setParent($root);

        $dm->persist($summer);
        $dm->persist($winter);
        $dm->persist($autumn);
        $dm->persist($spring);
        $dm->flush();
    }
}
