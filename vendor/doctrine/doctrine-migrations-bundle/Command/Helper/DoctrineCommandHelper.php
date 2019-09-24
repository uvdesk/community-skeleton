<?php

declare(strict_types=1);

namespace Doctrine\Bundle\MigrationsBundle\Command\Helper;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DoctrineCommandHelper as BaseDoctrineCommandHelper;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Sharding\PoolingShardConnection;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use function count;
use function sprintf;

/**
 * Provides some helper and convenience methods to configure doctrine commands in the context of bundles
 * and multiple connections/entity managers.
 */
abstract class DoctrineCommandHelper extends BaseDoctrineCommandHelper
{
    public static function setApplicationHelper(Application $application, InputInterface $input) : void
    {
        $container = $application->getKernel()->getContainer();

        /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');

        $managerNames = $doctrine->getManagerNames();

        if ($input->getOption('db') !== null || count($managerNames) === 0) {
            self::setApplicationConnection($application, $input->getOption('db'));
        } else {
            self::setApplicationEntityManager($application, $input->getOption('em'));
        }

        if ($input->getOption('shard') === null) {
            return;
        }

        /** @var ConnectionHelper $dbHelper */
        $dbHelper = $application->getHelperSet()->get('db');

        $connection = $dbHelper->getConnection();

        if (! $connection instanceof PoolingShardConnection) {
            if (count($managerNames) === 0) {
                throw new LogicException(sprintf(
                    "Connection '%s' must implement shards configuration.",
                    $input->getOption('db')
                ));
            }

            throw new LogicException(sprintf(
                "Connection of EntityManager '%s' must implement shards configuration.",
                $input->getOption('em')
            ));
        }

        $connection->connect($input->getOption('shard'));
    }
}
