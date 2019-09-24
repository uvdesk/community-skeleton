<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Version;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\MigratorConfiguration;

/**
 * The ExecutorInterface defines the interface used for adding sql for a migration and executing that sql.
 *
 * @internal
 */
interface ExecutorInterface
{
    /**
     * @param mixed[] $params
     * @param mixed[] $types
     */
    public function addSql(string $sql, array $params = [], array $types = []) : void;

    public function execute(
        Version $version,
        AbstractMigration $migration,
        string $direction,
        ?MigratorConfiguration $migratorConfiguration = null
    ) : ExecutionResult;
}
