<?php

namespace Doctrine\Bundle\DoctrineBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DbalSchemaFilterPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\EntityListenerPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\ServiceRepositoryCompilerPass;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Proxy\Autoloader;
use Symfony\Bridge\Doctrine\DependencyInjection\CompilerPass\DoctrineValidationPass;
use Symfony\Bridge\Doctrine\DependencyInjection\CompilerPass\RegisterEventListenersAndSubscribersPass;
use Symfony\Bridge\Doctrine\DependencyInjection\Security\UserProvider\EntityFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineBundle extends Bundle
{
    /** @var callable|null */
    private $autoloader;

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterEventListenersAndSubscribersPass('doctrine.connections', 'doctrine.dbal.%s_connection.event_manager', 'doctrine'), PassConfig::TYPE_BEFORE_OPTIMIZATION);

        if ($container->hasExtension('security')) {
            $container->getExtension('security')->addUserProviderFactory(new EntityFactory('entity', 'doctrine.orm.security.user.provider'));
        }

        $container->addCompilerPass(new DoctrineValidationPass('orm'));
        $container->addCompilerPass(new EntityListenerPass());
        $container->addCompilerPass(new ServiceRepositoryCompilerPass());
        $container->addCompilerPass(new DbalSchemaFilterPass());
    }

    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        // Register an autoloader for proxies to avoid issues when unserializing them
        // when the ORM is used.
        if (! $this->container->hasParameter('doctrine.orm.proxy_namespace')) {
            return;
        }

        $namespace      = $this->container->getParameter('doctrine.orm.proxy_namespace');
        $dir            = $this->container->getParameter('doctrine.orm.proxy_dir');
        $proxyGenerator = null;

        if ($this->container->getParameter('doctrine.orm.auto_generate_proxy_classes')) {
            // See https://github.com/symfony/symfony/pull/3419 for usage of references
            $container = &$this->container;

            $proxyGenerator = static function ($proxyDir, $proxyNamespace, $class) use (&$container) {
                $originalClassName = ClassUtils::getRealClass($class);
                /** @var Registry $registry */
                $registry = $container->get('doctrine');

                // Tries to auto-generate the proxy file
                /** @var EntityManager $em */
                foreach ($registry->getManagers() as $em) {
                    if (! $em->getConfiguration()->getAutoGenerateProxyClasses()) {
                        continue;
                    }

                    $metadataFactory = $em->getMetadataFactory();

                    if ($metadataFactory->isTransient($originalClassName)) {
                        continue;
                    }

                    $classMetadata = $metadataFactory->getMetadataFor($originalClassName);

                    $em->getProxyFactory()->generateProxyClasses([$classMetadata]);

                    clearstatcache(true, Autoloader::resolveFile($proxyDir, $proxyNamespace, $class));

                    break;
                }
            };
        }

        $this->autoloader = Autoloader::register($dir, $namespace, $proxyGenerator);
    }

    /**
     * {@inheritDoc}
     */
    public function shutdown()
    {
        if ($this->autoloader !== null) {
            spl_autoload_unregister($this->autoloader);
            $this->autoloader = null;
        }

        // Clear all entity managers to clear references to entities for GC
        if ($this->container->hasParameter('doctrine.entity_managers')) {
            foreach ($this->container->getParameter('doctrine.entity_managers') as $id) {
                if (! $this->container->initialized($id)) {
                    continue;
                }

                $this->container->get($id)->clear();
            }
        }

        // Close all connections to avoid reaching too many connections in the process when booting again later (tests)
        if (! $this->container->hasParameter('doctrine.connections')) {
            return;
        }

        foreach ($this->container->getParameter('doctrine.connections') as $id) {
            if (! $this->container->initialized($id)) {
                continue;
            }

            $this->container->get($id)->close();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function registerCommands(Application $application)
    {
    }
}
