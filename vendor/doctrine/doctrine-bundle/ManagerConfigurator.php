<?php

namespace Doctrine\Bundle\DoctrineBundle;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Configurator for an EntityManager
 */
class ManagerConfigurator
{
    /** @var string[] */
    private $enabledFilters = [];

    /** @var string[] */
    private $filtersParameters = [];

    /**
     * @param string[] $enabledFilters
     * @param string[] $filtersParameters
     */
    public function __construct(array $enabledFilters, array $filtersParameters)
    {
        $this->enabledFilters    = $enabledFilters;
        $this->filtersParameters = $filtersParameters;
    }

    /**
     * Create a connection by name.
     */
    public function configure(EntityManagerInterface $entityManager)
    {
        $this->enableFilters($entityManager);
    }

    /**
     * Enables filters for a given entity manager
     */
    private function enableFilters(EntityManagerInterface $entityManager)
    {
        if (empty($this->enabledFilters)) {
            return;
        }

        $filterCollection = $entityManager->getFilters();
        foreach ($this->enabledFilters as $filter) {
            $filterObject = $filterCollection->enable($filter);
            if ($filterObject === null) {
                continue;
            }

            $this->setFilterParameters($filter, $filterObject);
        }
    }

    /**
     * Sets default parameters for a given filter
     *
     * @param string    $name   Filter name
     * @param SQLFilter $filter Filter object
     */
    private function setFilterParameters($name, SQLFilter $filter)
    {
        if (empty($this->filtersParameters[$name])) {
            return;
        }

        $parameters = $this->filtersParameters[$name];
        foreach ($parameters as $paramName => $paramValue) {
            $filter->setParameter($paramName, $paramValue);
        }
    }
}
