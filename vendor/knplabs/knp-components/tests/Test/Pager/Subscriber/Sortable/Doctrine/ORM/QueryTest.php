<?php

namespace Test\Pager\Subscriber\Sortable\Doctrine\ORM;

use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\QuerySubscriber;
use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Event\Subscriber\Sortable\Doctrine\ORM\QuerySubscriber as Sortable;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Test\Fixture\Entity\Article;
use Test\Tool\BaseTestCaseORM;

final class QueryTest extends BaseTestCaseORM
{
    /**
     * @test
     */
    public function shouldHandleApcQueryCache(): void
    {
        if (!extension_loaded('apc') || !ini_get('apc.enable_cli')) {
            $this->markTestSkipped('APC extension is not loaded.');
        }
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcCache);
        $config->setProxyDir(__DIR__);
        $config->setProxyNamespace('Gedmo\Mapping\Proxy');
        $config->setAutoGenerateProxyClasses(false);
        $config->setMetadataDriverImpl($this->getMetadataDriverImplementation());

        $conn = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $em = \Doctrine\ORM\EntityManager::create($conn, $config);
        $schema = array_map(function($class) use ($em) {
            return $em->getClassMetadata($class);
        }, (array)$this->getUsedEntityFixtures());

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $schemaTool->dropSchema([]);
        $schemaTool->createSchema($schema);
        $this->populate($em);

        $query = $em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);

        $query = $em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');
        $view = $p->paginate($query, 1, 10);
    }

    /**
     * @test
     */
    public function shouldSortSimpleDoctrineQuery(): void
    {
        $em = $this->getMockSqliteEntityManager();
        $this->populate($em);

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new PaginationSubscriber);
        $dispatcher->addSubscriber(new Sortable($requestStack->getCurrentRequest()));
        $p = new Paginator($dispatcher, $requestStack);

        $this->startQueryLog();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');
        $query->setHint(QuerySubscriber::HINT_FETCH_JOIN_COLLECTION, false);
        $view = $p->paginate($query, 1, 10);

        $items = $view->getItems();
        $this->assertCount(4, $items);
        $this->assertEquals('autumn', $items[0]->getTitle());
        $this->assertEquals('spring', $items[1]->getTitle());
        $this->assertEquals('summer', $items[2]->getTitle());
        $this->assertEquals('winter', $items[3]->getTitle());

        $this->assertEquals(2, $this->queryAnalyzer->getNumExecutedQueries());
        $executed = $this->queryAnalyzer->getExecutedQueries();

        // Different aliases separators according to Doctrine version
        if (version_compare(\Doctrine\ORM\Version::VERSION, '2.5', '<')) {
            $this->assertEquals('SELECT a0_.id AS id0, a0_.title AS title1, a0_.enabled AS enabled2 FROM Article a0_ ORDER BY a0_.title ASC LIMIT 10', $executed[1]);
        } else {
            $this->assertEquals('SELECT a0_.id AS id_0, a0_.title AS title_1, a0_.enabled AS enabled_2 FROM Article a0_ ORDER BY a0_.title ASC LIMIT 10', $executed[1]);
        }
    }

    /**
     * @test
     */
    public function shouldSortSimpleDoctrineQuery2(): void
    {
        $em = $this->getMockSqliteEntityManager();
        $this->populate($em);

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'desc']);
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new PaginationSubscriber);
        $dispatcher->addSubscriber(new Sortable($requestStack->getCurrentRequest()));
        $p = new Paginator($dispatcher, $requestStack);

        $this->startQueryLog();
        $query = $this->em->createQuery('SELECT a FROM Test\Fixture\Entity\Article a');
        $query->setHint(QuerySubscriber::HINT_FETCH_JOIN_COLLECTION, false);
        $view = $p->paginate($query);

        $items = $view->getItems();
        $this->assertCount(4, $items);
        $this->assertEquals('winter', $items[0]->getTitle());
        $this->assertEquals('summer', $items[1]->getTitle());
        $this->assertEquals('spring', $items[2]->getTitle());
        $this->assertEquals('autumn', $items[3]->getTitle());

        $this->assertEquals(2, $this->queryAnalyzer->getNumExecutedQueries());
        $executed = $this->queryAnalyzer->getExecutedQueries();

        // Different aliases separators according to Doctrine version
        if (version_compare(\Doctrine\ORM\Version::VERSION, '2.5', '<')) {
            $this->assertEquals('SELECT a0_.id AS id0, a0_.title AS title1, a0_.enabled AS enabled2 FROM Article a0_ ORDER BY a0_.title DESC LIMIT 10', $executed[1]);
        } else {
            $this->assertEquals('SELECT a0_.id AS id_0, a0_.title AS title_1, a0_.enabled AS enabled_2 FROM Article a0_ ORDER BY a0_.title DESC LIMIT 10', $executed[1]);
        }
    }

    /**
     * @test
     */
    public function shouldValidateSortableParameters(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $query = $this
            ->getMockSqliteEntityManager()
            ->createQuery('SELECT a FROM Test\Fixture\Entity\Article a')
        ;

        $requestStack = $this->createRequestStack(['sort' => '"a.title\'', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $view = $p->paginate($query, 1, 10);
    }

    /**
     * @test
     */
    public function shouldSortByAnyAvailableAlias(): void
    {
        $em = $this->getMockSqliteEntityManager();
        $this->populate($em);

        $dql = <<<___SQL
        SELECT a, COUNT(a) AS counter
        FROM Test\Fixture\Entity\Article a
___SQL;
        $query = $this->em->createQuery($dql);
        $query->setHint(QuerySubscriber::HINT_FETCH_JOIN_COLLECTION, false);

        $requestStack = $this->createRequestStack(['sort' => 'counter', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $this->startQueryLog();
        $view = $p->paginate($query, 1, 10, [PaginatorInterface::DISTINCT => false]);

        $this->assertEquals(2, $this->queryAnalyzer->getNumExecutedQueries());
        $executed = $this->queryAnalyzer->getExecutedQueries();

        // Different aliases separators according to Doctrine version
        if (version_compare(\Doctrine\ORM\Version::VERSION, '2.5', '<')) {
            $this->assertEquals('SELECT a0_.id AS id0, a0_.title AS title1, a0_.enabled AS enabled2, COUNT(a0_.id) AS sclr3 FROM Article a0_ ORDER BY sclr3 ASC LIMIT 10', $executed[1]);
        } else {
            $this->assertEquals('SELECT a0_.id AS id_0, a0_.title AS title_1, a0_.enabled AS enabled_2, COUNT(a0_.id) AS sclr_3 FROM Article a0_ ORDER BY sclr_3 ASC LIMIT 10', $executed[1]);
        }
    }

    /**
     * @test
     */
    public function shouldWorkWithInitialPaginatorEventDispatcher(): void
    {
        $em = $this->getMockSqliteEntityManager();
        $this->populate($em);
        $query = $this
            ->em
            ->createQuery('SELECT a FROM Test\Fixture\Entity\Article a')
        ;
        $query->setHint(QuerySubscriber::HINT_FETCH_JOIN_COLLECTION, false);

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $this->startQueryLog();
        $view = $p->paginate($query, 1, 10);
        $this->assertInstanceOf(SlidingPagination::class, $view);

        $this->assertEquals(2, $this->queryAnalyzer->getNumExecutedQueries());
        $executed = $this->queryAnalyzer->getExecutedQueries();

        // Different aliases separators according to Doctrine version
        if (version_compare(\Doctrine\ORM\Version::VERSION, '2.5', '<')) {
            $this->assertEquals('SELECT a0_.id AS id0, a0_.title AS title1, a0_.enabled AS enabled2 FROM Article a0_ ORDER BY a0_.title ASC LIMIT 10', $executed[1]);
        } else {
            $this->assertEquals('SELECT a0_.id AS id_0, a0_.title AS title_1, a0_.enabled AS enabled_2 FROM Article a0_ ORDER BY a0_.title ASC LIMIT 10', $executed[1]);
        }
    }

    /**
     * @test
     */
    public function shouldNotExecuteExtraQueriesWhenCountIsZero(): void
    {
        $query = $this
            ->getMockSqliteEntityManager()
            ->createQuery('SELECT a FROM Test\Fixture\Entity\Article a')
        ;

        $requestStack = $this->createRequestStack(['sort' => 'a.title', 'direction' => 'asc']);
        $p = new Paginator(null, $requestStack);
        $this->startQueryLog();
        $view = $p->paginate($query, 1, 10);
        $this->assertInstanceOf(SlidingPagination::class, $view);

        $this->assertEquals(2, $this->queryAnalyzer->getNumExecutedQueries());
    }

    protected function getUsedEntityFixtures(): array
    {
        return [Article::class];
    }

    private function populate($em): void
    {
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

    private function getApcEntityManager()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcCache);
        $config->setProxyDir(__DIR__);
        $config->setProxyNamespace('Gedmo\Mapping\Proxy');
        $config->setAutoGenerateProxyClasses(false);
        $config->setMetadataDriverImpl($this->getMetadataDriverImplementation());

        $conn = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $em = \Doctrine\ORM\EntityManager::create($conn, $config);
        return $em;
    }
}
