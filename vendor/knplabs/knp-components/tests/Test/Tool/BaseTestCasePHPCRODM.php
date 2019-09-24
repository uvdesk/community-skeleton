<?php

namespace Test\Tool;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\PHPCR\Query\Query;
use Jackalope\RepositoryFactoryDoctrineDBAL;
use Jackalope\Transport\DoctrineDBAL\RepositorySchema;
use PHPUnit\Framework\TestCase;

/**
 * Base test case contains common mock objects
 */
abstract class BaseTestCasePHPCRODM extends TestCase
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    protected function setUp(): void
    {
        if (!class_exists(Query::class)) {
            $this->markTestSkipped('Doctrine PHPCR-ODM is not available');
        }
    }

    protected function tearDown(): void
    {
        if ($this->dm) {
            $this->dm = null;
        }
    }

    protected function getMockDocumentManager(EventManager $evm = null)
    {
        $config = new \Doctrine\ODM\PHPCR\Configuration();
        $config->setMetadataDriverImpl($this->getMetadataDriverImplementation());

        $this->dm = DocumentManager::create($this->getSession(), $config, $evm ?: $this->getEventManager());

        return $this->dm;
    }

    protected function getMetadataDriverImplementation()
    {
        return new AnnotationDriver($_ENV['annotation_reader']);
    }

    private function getSession()
    {
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path'   => ':memory:',
        ]);
        $factory = new RepositoryFactoryDoctrineDBAL();
        $repository = $factory->getRepository([
            'jackalope.doctrine_dbal_connection' => $connection,
        ]);

        $schema = new RepositorySchema(['disable_fks' => true], $connection);
        $schema->reset();

        $session = $repository->login(new \PHPCR\SimpleCredentials('', ''));

        $cnd = <<<CND
<phpcr='http://www.doctrine-project.org/projects/phpcr_odm'>
[phpcr:managed]
mixin
- phpcr:class (STRING)
- phpcr:classparents (STRING) multiple
CND;

        $session->getWorkspace()->getNodeTypeManager()->registerNodeTypesCnd($cnd, true);

        return $session;
    }

    private function getEventManager()
    {
        return new EventManager();
    }
}
