<?php

namespace Doctrine\DBAL\Schema\Synchronizer;

use Doctrine\DBAL\Schema\Schema;

/**
 * The synchronizer knows how to synchronize a schema with the configured
 * database.
 */
interface SchemaSynchronizer
{
    /**
     * Gets the SQL statements that can be executed to create the schema.
     *
     * @return string[]
     */
    public function getCreateSchema(Schema $createSchema);

    /**
     * Gets the SQL Statements to update given schema with the underlying db.
     *
     * @param bool $noDrops
     *
     * @return string[]
     */
    public function getUpdateSchema(Schema $toSchema, $noDrops = false);

    /**
     * Gets the SQL Statements to drop the given schema from underlying db.
     *
     * @return string[]
     */
    public function getDropSchema(Schema $dropSchema);

    /**
     * Gets the SQL statements to drop all schema assets from underlying db.
     *
     * @return string[]
     */
    public function getDropAllSchema();

    /**
     * Creates the Schema.
     *
     * @return void
     */
    public function createSchema(Schema $createSchema);

    /**
     * Updates the Schema to new schema version.
     *
     * @param bool $noDrops
     *
     * @return void
     */
    public function updateSchema(Schema $toSchema, $noDrops = false);

    /**
     * Drops the given database schema from the underlying db.
     *
     * @return void
     */
    public function dropSchema(Schema $dropSchema);

    /**
     * Drops all assets from the underlying db.
     *
     * @return void
     */
    public function dropAllSchema();
}
