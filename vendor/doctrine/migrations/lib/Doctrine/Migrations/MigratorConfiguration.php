<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;

/**
 * The MigratorConfiguration class is responsible for defining the configuration for a migration.
 *
 * @internal
 *
 * @see Doctrine\Migrations\Migrator
 * @see Doctrine\Migrations\Version\Executor
 */
class MigratorConfiguration
{
    /** @var bool */
    private $dryRun = false;

    /** @var bool */
    private $timeAllQueries = false;

    /** @var bool */
    private $noMigrationException = false;

    /** @var bool */
    private $allOrNothing = false;

    /** @var Schema|null */
    private $fromSchema;

    public function isDryRun() : bool
    {
        return $this->dryRun;
    }

    public function setDryRun(bool $dryRun) : self
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    public function getTimeAllQueries() : bool
    {
        return $this->timeAllQueries;
    }

    public function setTimeAllQueries(bool $timeAllQueries) : self
    {
        $this->timeAllQueries = $timeAllQueries;

        return $this;
    }

    public function getNoMigrationException() : bool
    {
        return $this->noMigrationException;
    }

    public function setNoMigrationException(bool $noMigrationException = false) : self
    {
        $this->noMigrationException = $noMigrationException;

        return $this;
    }

    public function isAllOrNothing() : bool
    {
        return $this->allOrNothing;
    }

    public function setAllOrNothing(bool $allOrNothing) : self
    {
        $this->allOrNothing = $allOrNothing;

        return $this;
    }

    public function getFromSchema() : ?Schema
    {
        return $this->fromSchema;
    }

    public function setFromSchema(Schema $fromSchema) : self
    {
        $this->fromSchema = $fromSchema;

        return $this;
    }
}
