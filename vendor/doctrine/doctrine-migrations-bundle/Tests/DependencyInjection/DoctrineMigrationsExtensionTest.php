<?php

declare(strict_types=1);

namespace Doctrine\Bundle\MigrationsBundle\Tests\DependencyInjection;

use Doctrine\Bundle\MigrationsBundle\DependencyInjection\DoctrineMigrationsExtension;
use Doctrine\Migrations\Configuration\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use function sys_get_temp_dir;

class DoctrineMigrationsExtensionTest extends TestCase
{
    public function testOrganizeMigrations() : void
    {
        $container = $this->getContainer();
        $extension = new DoctrineMigrationsExtension();

        $config = ['organize_migrations' => 'BY_YEAR'];

        $extension->load(['doctrine_migrations' => $config], $container);

        $this->assertEquals(
            Configuration::VERSIONS_ORGANIZATION_BY_YEAR,
            $container->getParameter('doctrine_migrations.organize_migrations')
        );
    }

    private function getContainer() : ContainerBuilder
    {
        return new ContainerBuilder(new ParameterBag([
            'kernel.debug' => false,
            'kernel.bundles' => [],
            'kernel.cache_dir' => sys_get_temp_dir(),
            'kernel.environment' => 'test',
            'kernel.root_dir' => __DIR__ . '/../../', // src dir
        ]));
    }
}
