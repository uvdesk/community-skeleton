<?php

namespace Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ServiceRepositoryCompilerPass implements CompilerPassInterface
{
    const REPOSITORY_SERVICE_TAG = 'doctrine.repository_service';

    public function process(ContainerBuilder $container)
    {
        // when ORM is not enabled
        if (! $container->hasDefinition('doctrine.orm.container_repository_factory')) {
            return;
        }

        $locatorDef = $container->getDefinition('doctrine.orm.container_repository_factory');

        $repoServiceIds = array_keys($container->findTaggedServiceIds(self::REPOSITORY_SERVICE_TAG));

        $repoReferences = array_map(static function ($id) {
            return new Reference($id);
        }, $repoServiceIds);

        $ref = ServiceLocatorTagPass::register($container, array_combine($repoServiceIds, $repoReferences));
        $locatorDef->replaceArgument(0, $ref);
    }
}
