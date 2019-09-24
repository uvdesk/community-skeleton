<?php

namespace Doctrine\Bundle\DoctrineBundle\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Exception;
use PDO;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\VarDumper\Cloner\Data;

class ProfilerController implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Renders the profiler panel for the given token.
     *
     * @param string $token          The profiler token
     * @param string $connectionName
     * @param int    $query
     *
     * @return Response A Response instance
     */
    public function explainAction($token, $connectionName, $query)
    {
        /** @var Profiler $profiler */
        $profiler = $this->container->get('profiler');
        $profiler->disable();

        $profile = $profiler->loadProfile($token);
        $queries = $profile->getCollector('db')->getQueries();

        if (! isset($queries[$connectionName][$query])) {
            return new Response('This query does not exist.');
        }

        $query = $queries[$connectionName][$query];
        if (! $query['explainable']) {
            return new Response('This query cannot be explained.');
        }

        /** @var Connection $connection */
        $connection = $this->container->get('doctrine')->getConnection($connectionName);
        try {
            if ($connection->getDatabasePlatform() instanceof SQLServerPlatform) {
                $results = $this->explainSQLServerPlatform($connection, $query);
            } else {
                $results = $this->explainOtherPlatform($connection, $query);
            }
        } catch (Exception $e) {
            return new Response('This query cannot be explained.');
        }

        return new Response($this->container->get('twig')->render('@Doctrine/Collector/explain.html.twig', [
            'data' => $results,
            'query' => $query,
        ]));
    }

    private function explainSQLServerPlatform(Connection $connection, $query)
    {
        if (stripos($query['sql'], 'SELECT') === 0) {
            $sql = 'SET STATISTICS PROFILE ON; ' . $query['sql'] . '; SET STATISTICS PROFILE OFF;';
        } else {
            $sql = 'SET SHOWPLAN_TEXT ON; GO; SET NOEXEC ON; ' . $query['sql'] . '; SET NOEXEC OFF; GO; SET SHOWPLAN_TEXT OFF;';
        }

        $params = $query['params'];

        if ($params instanceof Data) {
            $params = $params->getValue(true);
        }

        $stmt = $connection->executeQuery($sql, $params, $query['types']);
        $stmt->nextRowset();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function explainOtherPlatform(Connection $connection, $query)
    {
        $params = $query['params'];

        if ($params instanceof Data) {
            $params = $params->getValue(true);
        }

        return $connection->executeQuery('EXPLAIN ' . $query['sql'], $params, $query['types'])
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
