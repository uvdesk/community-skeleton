<?php

declare(strict_types=1);

namespace Doctrine\Bundle\FixturesBundle;

/**
 * FixtureGroupInterface can to be implemented by fixtures that belong in groups
 */
interface FixtureGroupInterface
{
    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups() : array;
}
