<?php

namespace Doctrine\Bundle\DoctrineBundle\Mapping;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * @final
 */
class ContainerEntityListenerResolver implements EntityListenerServiceResolver
{
    /** @var ContainerInterface */
    private $container;

    /** @var object[] Map to store entity listener instances. */
    private $instances = [];

    /** @var string[] Map to store registered service ids */
    private $serviceIds = [];

    /**
     * @param ContainerInterface $container a service locator for listeners
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function clear($className = null)
    {
        if ($className === null) {
            $this->instances = [];

            return;
        }

        $className = $this->normalizeClassName($className);

        unset($this->instances[$className]);
    }

    /**
     * {@inheritdoc}
     */
    public function register($object)
    {
        if (! is_object($object)) {
            throw new InvalidArgumentException(sprintf('An object was expected, but got "%s".', gettype($object)));
        }

        $className = $this->normalizeClassName(get_class($object));

        $this->instances[$className] = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function registerService($className, $serviceId)
    {
        $this->serviceIds[$this->normalizeClassName($className)] = $serviceId;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($className)
    {
        $className = $this->normalizeClassName($className);

        if (! isset($this->instances[$className])) {
            if (isset($this->serviceIds[$className])) {
                $this->instances[$className] = $this->resolveService($this->serviceIds[$className]);
            } else {
                $this->instances[$className] = new $className();
            }
        }

        return $this->instances[$className];
    }

    /**
     * @return object
     */
    private function resolveService(string $serviceId)
    {
        if (! $this->container->has($serviceId)) {
            throw new RuntimeException(sprintf('There is no service named "%s"', $serviceId));
        }

        return $this->container->get($serviceId);
    }

    private function normalizeClassName(string $className) : string
    {
        return trim($className, '\\');
    }
}
