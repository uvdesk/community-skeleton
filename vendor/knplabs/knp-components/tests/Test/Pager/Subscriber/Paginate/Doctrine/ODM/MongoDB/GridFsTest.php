<?php

namespace Test\Pager\Subscriber\Sortable\Doctrine\ODM\MongoDB;

use Knp\Component\Pager\Paginator;
use Test\Fixture\Document\Image;
use Test\Tool\BaseTestCaseMongoODM;

final class GridFsTest extends BaseTestCaseMongoODM
{
    /**
     * @test
     */
    public function shouldPaginate(): void
    {
        $this->populate();

        $query = $this->dm
            ->createQueryBuilder(Image::class)
            ->getQuery()
        ;

        $p = new Paginator;
        $view = $p->paginate($query, 1, 10);

        $cursor = $query->execute();
        $this->assertCount(4, $view->getItems());
    }

    private function populate(): void
    {
        $mockFile = __DIR__.'/summer.gif';
        $dm = $this->getMockDocumentManager();
        $summer = new Image;
        $summer->setTitle('summer');
        $summer->setFile($mockFile);

        $winter = new Image;
        $winter->setTitle('winter');
        $winter->setFile($mockFile);

        $autumn = new Image;
        $autumn->setTitle('autumn');
        $autumn->setFile($mockFile);

        $spring = new Image;
        $spring->setTitle('spring');
        $spring->setFile($mockFile);

        $dm->persist($summer);
        $dm->persist($winter);
        $dm->persist($autumn);
        $dm->persist($spring);
        $dm->flush();
    }
}
