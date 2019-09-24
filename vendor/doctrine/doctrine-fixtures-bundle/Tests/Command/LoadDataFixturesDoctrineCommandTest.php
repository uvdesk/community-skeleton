<?php

declare(strict_types=1);

namespace Doctrine\Bundle\FixturesBundle\Tests\Command;

use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand;
use Doctrine\Bundle\FixturesBundle\Loader\SymfonyFixturesLoader;
use Doctrine\Common\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

class LoadDataFixturesDoctrineCommandTest extends TestCase
{
    /**
     * @group legacy
     * @expectedDeprecation The "Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand" constructor expects a "Doctrine\Common\Persistence\ManagerRegistry" instance as second argument, not passing it will throw a \TypeError in DoctrineFixturesBundle 4.0.
     */
    public function testInstantiatingWithoutManagerRegistry() : void
    {
        $loader = new SymfonyFixturesLoader(new Container());

        new LoadDataFixturesDoctrineCommand($loader);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testInstantiatingWithManagerRegistry() : void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $loader   = new SymfonyFixturesLoader(new Container());

        new LoadDataFixturesDoctrineCommand($loader, $registry);
    }
}
