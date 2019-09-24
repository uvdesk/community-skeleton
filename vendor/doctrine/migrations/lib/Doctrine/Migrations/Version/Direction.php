<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Version;

/**
 * The Direction class contains constants for the directions a migration can be executed.
 *
 * @internal
 */
final class Direction
{
    public const UP   = 'up';
    public const DOWN = 'down';

    /**
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
}
