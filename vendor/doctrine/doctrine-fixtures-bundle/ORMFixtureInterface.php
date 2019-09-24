<?php

declare(strict_types=1);

namespace Doctrine\Bundle\FixturesBundle;

use Doctrine\Common\DataFixtures\FixtureInterface;

/**
 * Marks your fixtures that are specifically for the ORM.
 */
interface ORMFixtureInterface extends FixtureInterface
{
}
