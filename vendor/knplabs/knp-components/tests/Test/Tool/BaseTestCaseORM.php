<?php

namespace Test\Tool;

use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Mapping\DefaultNamingStrategy;
use Doctrine\ORM\Mapping\DefaultQuoteStrategy;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Base test case contains common mock objects
 * and functionality among all extensions using
 * ORM object manager
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @package Gedmo
 * @subpackage BaseTestCase
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class BaseTestCaseORM extends BaseTestCase
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var QueryAnalyzer
     */
    protected $queryAnalyzer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

    }

    /**
     * EntityManager mock object together with
     * annotation mapping driver and pdo_sqlite
     * database in memory
     *
     * @param EventManager $evm
     * @return EntityManager
     */
    protected function getMockSqliteEntityManager(EventManager $evm = null)
    {
        $conn = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $config = $this->getMockAnnotatedConfig();
        $em = EntityManager::create($conn, $config, $evm ?: $this->getEventManager());

        $schema = array_map(function($class) use ($em) {
            return $em->getClassMetadata($class);
        }, (array)$this->getUsedEntityFixtures());

        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema([]);
        $schemaTool->createSchema($schema);
        return $this->em = $em;
    }

    /**
     * EntityManager mock object together with
     * annotation mapping driver and custom
     * connection
     *
     * @param array $conn
     * @param EventManager $evm
     * @return EntityManager
     */
    protected function getMockCustomEntityManager(array $conn, EventManager $evm = null)
    {
        $config = $this->getMockAnnotatedConfig();
        $em = EntityManager::create($conn, $config, $evm ?: $this->getEventManager());

        $schema = array_map(function($class) use ($em) {
            return $em->getClassMetadata($class);
        }, (array)$this->getUsedEntityFixtures());

        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema([]);
        $schemaTool->createSchema($schema);
        return $this->em = $em;
    }

    /**
     * EntityManager mock object with
     * annotation mapping driver
     *
     * @param EventManager $evm
     * @return EntityManager
     */
    protected function getMockMappedEntityManager(EventManager $evm = null)
    {
        $driver = $this->createMock(Driver::class);
        $driver->expects($this->once())
            ->method('getDatabasePlatform')
            ->willReturn($this->createMock(MySqlPlatform::class));

        $connection = $this->getMockBuilder(Connection::class)
            ->setConstructorArgs([[], $driver])
            ->getMock();

        $connection->expects($this->once())
            ->method('getEventManager')
            ->willReturn($evm ?: $this->getEventManager());

        $config = $this->getMockAnnotatedConfig();
        $this->em = EntityManager::create($connection, $config);

        return $this->em;
    }

    /**
     * Starts query statistic log
     *
     * @throws \RuntimeException
     */
    protected function startQueryLog(): void
    {
        if (!$this->em || !$this->em->getConnection()->getDatabasePlatform()) {
            throw new \RuntimeException('EntityManager and database platform must be initialized');
        }
        $this->queryAnalyzer = new QueryAnalyzer($this->em->getConnection()->getDatabasePlatform());
        $this->em
            ->getConfiguration()
            ->expects($this->any())
            ->method('getSQLLogger')
            ->willReturn($this->queryAnalyzer);
    }

    /**
     * Stops query statistic log and outputs
     * the data to screen or file
     *
     * @param boolean $dumpOnlySql
     * @param boolean $writeToLog
     * @throws \RuntimeException
     */
    protected function stopQueryLog($dumpOnlySql = false, $writeToLog = false): void
    {
        if ($this->queryAnalyzer) {
            ob_start();
            $this->queryAnalyzer->getOutput($dumpOnlySql);
            $output = ob_get_contents();
            ob_end_clean();

            if (!$writeToLog) {
                echo $output;

                return;
            }

            $fileName = __DIR__.'/../../temp/query_debug_'.time().'.log';
            if (($file = fopen($fileName, 'wb+')) !== false) {
                throw new \RuntimeException('Unable to write to the log file');
            }

            fwrite($file, $output);
            fclose($file);
        }
    }

    /**
     * Creates default mapping driver
     *
     * @return MappingDriver
     */
    protected function getMetadataDriverImplementation()
    {
        return new AnnotationDriver($_ENV['annotation_reader']);
    }

    /**
     * Get a list of used fixture classes
     *
     * @return array
     */
    abstract protected function getUsedEntityFixtures();

    /**
     * Build event manager
     *
     * @return EventManager
     */
    private function getEventManager()
    {
        return new EventManager();
    }

    /**
     * Get annotation mapping configuration
     *
     * @return \Doctrine\ORM\Configuration
     */
    private function getMockAnnotatedConfig()
    {
        $config = $this->createMock(Configuration::class);
        $config
            ->expects($this->once())
            ->method('getProxyDir')
            ->willReturn(__DIR__.'/../../temp')
        ;

        $config
            ->expects($this->once())
            ->method('getProxyNamespace')
            ->willReturn('Proxy')
        ;

        $config
            ->expects($this->once())
            ->method('getAutoGenerateProxyClasses')
            ->willReturn(true)
        ;

        $config
            ->expects($this->once())
            ->method('getClassMetadataFactoryName')
            ->willReturn(ClassMetadataFactory::class)
        ;

        $mappingDriver = $this->getMetadataDriverImplementation();

        $config
            ->expects($this->any())
            ->method('getMetadataDriverImpl')
            ->willReturn($mappingDriver)
        ;

        $config
            ->expects($this->any())
            ->method('getDefaultRepositoryClassName')
            ->willReturn(EntityRepository::class)
        ;

        $config
            ->expects($this->any())
            ->method('getQuoteStrategy')
            ->willReturn(new DefaultQuoteStrategy())
        ;

        $config
            ->expects($this->any())
            ->method('getNamingStrategy')
            ->willReturn(new DefaultNamingStrategy())
        ;

        $config
            ->expects($this->any())
            ->method('getCustomHydrationMode')
            ->willReturn('Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\Query\AsIsHydrator')
        ;

        $config
            ->expects($this->any())
            ->method('getDefaultQueryHints')
            ->willReturn([])
        ;

        return $config;
    }
}
