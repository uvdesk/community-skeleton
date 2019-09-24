<?php

namespace Doctrine\Bundle\DoctrineBundle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * References all Doctrine connections and entity managers in a given Container.
 */
class Registry extends ManagerRegistry implements RegistryInterface
{
    /**
     * @param string[] $connections
     * @param string[] $entityManagers
     * @param string   $defaultConnection
     * @param string   $defaultEntityManager
     */
    public function __construct(ContainerInterface $container, array $connections, array $entityManagers, $defaultConnection, $defaultEntityManager)
    {
        $this->container = $container;

        parent::__construct('ORM', $connections, $entityManagers, $defaultConnection, $defaultEntityManager, 'Doctrine\ORM\Proxy\Proxy');
    }

    /**
     * Gets the default entity manager name.
     *
     * @deprecated
     *
     * @return string The default entity manager name
     */
    public function getDefaultEntityManagerName()
    {
        @trigger_error('getDefaultEntityManagerName is deprecated since Symfony 2.1. Use getDefaultManagerName instead', E_USER_DEPRECATED);

        return $this->getDefaultManagerName();
    }

    /**
     * Gets a named entity manager.
     *
     * @deprecated
     *
     * @param string $name The entity manager name (null for the default one)
     *
     * @return EntityManager
     */
    public function getEntityManager($name = null)
    {
        @trigger_error('getEntityManager is deprecated since Symfony 2.1. Use getManager instead', E_USER_DEPRECATED);

        return $this->getManager($name);
    }

    /**
     * Gets an array of all registered entity managers
     *
     * @deprecated
     *
     * @return EntityManager[] an array of all EntityManager instances
     */
    public function getEntityManagers()
    {
        @trigger_error('getEntityManagers is deprecated since Symfony 2.1. Use getManagers instead', E_USER_DEPRECATED);

        return $this->getManagers();
    }

    /**
     * Resets a named entity manager.
     *
     * This method is useful when an entity manager has been closed
     * because of a rollbacked transaction AND when you think that
     * it makes sense to get a new one to replace the closed one.
     *
     * Be warned that you will get a brand new entity manager as
     * the existing one is not usable anymore. This means that any
     * other object with a dependency on this entity manager will
     * hold an obsolete reference. You can inject the registry instead
     * to avoid this problem.
     *
     * @deprecated
     *
     * @param string $name The entity manager name (null for the default one)
     */
    public function resetEntityManager($name = null)
    {
        @trigger_error('resetEntityManager is deprecated since Symfony 2.1. Use resetManager instead', E_USER_DEPRECATED);

        $this->resetManager($name);
    }

    /**
     * Resolves a registered namespace alias to the full namespace.
     *
     * This method looks for the alias in all registered entity managers.
     *
     * @deprecated
     *
     * @param string $alias The alias
     *
     * @return string The full namespace
     */
    public function getEntityNamespace($alias)
    {
        @trigger_error('getEntityNamespace is deprecated since Symfony 2.1. Use getAliasNamespace instead', E_USER_DEPRECATED);

        return $this->getAliasNamespace($alias);
    }

    /**
     * Resolves a registered namespace alias to the full namespace.
     *
     * This method looks for the alias in all registered entity managers.
     *
     * @see Configuration::getEntityNamespace
     *
     * @param string $alias The alias
     *
     * @return string The full namespace
     */
    public function getAliasNamespace($alias)
    {
        foreach (array_keys($this->getManagers()) as $name) {
            try {
                return $this->getManager($name)->getConfiguration()->getEntityNamespace($alias);
            } catch (ORMException $e) {
            }
        }

        throw ORMException::unknownEntityNamespace($alias);
    }

    /**
     * Gets all connection names.
     *
     * @deprecated
     *
     * @return string[] An array of connection names
     */
    public function getEntityManagerNames()
    {
        @trigger_error('getEntityManagerNames is deprecated since Symfony 2.1. Use getManagerNames instead', E_USER_DEPRECATED);

        return $this->getManagerNames();
    }

    /**
     * Gets the entity manager associated with a given class.
     *
     * @deprecated
     *
     * @param string $class A Doctrine Entity class name
     *
     * @return EntityManager|null
     */
    public function getEntityManagerForClass($class)
    {
        @trigger_error('getEntityManagerForClass is deprecated since Symfony 2.1. Use getManagerForClass instead', E_USER_DEPRECATED);

        return $this->getManagerForClass($class);
    }
}
