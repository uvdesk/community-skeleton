<?php

declare(strict_types=1);

namespace Doctrine\Bundle\FixturesBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FixturesCompilerPass implements CompilerPassInterface
{
    public const FIXTURE_TAG = 'doctrine.fixture.orm';

    public function process(ContainerBuilder $container) : void
    {
        $definition     = $container->getDefinition('doctrine.fixtures.loader');
        $taggedServices = $container->findTaggedServiceIds(self::FIXTURE_TAG);

        $fixtures = [];
        foreach ($taggedServices as $serviceId => $tags) {
            $groups = [];
            foreach ($tags as $tagData) {
                if (! isset($tagData['group'])) {
                    continue;
                }

                $groups[] = $tagData['group'];
            }

            $fixtures[] = [
                'fixture' => new Reference($serviceId),
                'groups' => $groups,
            ];
        }

        $definition->addMethodCall('addFixtures', [$fixtures]);
    }
}
