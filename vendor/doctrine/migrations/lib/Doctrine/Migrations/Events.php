<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

/**
 * The Events class contains constants for event names that a user can subscribe to.
 */
final class Events
{
    public const onMigrationsMigrating        = 'onMigrationsMigrating';
    public const onMigrationsMigrated         = 'onMigrationsMigrated';
    public const onMigrationsVersionExecuting = 'onMigrationsVersionExecuting';
    public const onMigrationsVersionExecuted  = 'onMigrationsVersionExecuted';
    public const onMigrationsVersionSkipped   = 'onMigrationsVersionSkipped';
}
