<?php

declare(strict_types=1);

namespace Doctrine\Bundle\FixturesBundle;

use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Base class designed for data fixtures so they don't have to extend and
 * implement different classes/interfaces according to their needs.
 */
abstract class Fixture extends AbstractFixture implements ORMFixtureInterface
{
}
