<?php

namespace Test\Pager\Subscriber\Paginate\Doctrine\ODM\MongoDB;

use Knp\Component\Pager\Paginator;
use Test\Fixture\Document\Article;
use Test\Tool\BaseTestCaseMongoODM;

final class QueryBuilderTest extends BaseTestCaseMongoODM
{
    /**
     * @test
     */
    public function shouldSupportPaginateStrategySubscriber(): void
    {
        $this->populate();
        $qb = $this
            ->getMockDocumentManager()
            ->createQueryBuilder(Article::class)
        ;
        $p = new Paginator;
        $pagination = $p->paginate($qb, 1, 2);
        $this->assertEquals(1, $pagination->getCurrentPageNumber());
        $this->assertEquals(2, $pagination->getItemNumberPerPage());
        $this->assertEquals(4, $pagination->getTotalItemCount());

        $items = array_values($pagination->getItems());
        $this->assertCount(2, $items);
        $this->assertEquals('summer', $items[0]->getTitle());
        $this->assertEquals('winter', $items[1]->getTitle());
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
