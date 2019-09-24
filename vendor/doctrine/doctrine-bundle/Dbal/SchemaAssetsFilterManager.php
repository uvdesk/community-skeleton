<?php

namespace Doctrine\Bundle\DoctrineBundle\Dbal;

/**
 * Manages schema filters passed to Connection::setSchemaAssetsFilter()
 */
class SchemaAssetsFilterManager
{
    /** @var callable[] */
    private $schemaAssetFilters;

    /**
     * @param callable[] $schemaAssetFilters
     */
    public function __construct(array $schemaAssetFilters)
    {
        $this->schemaAssetFilters = $schemaAssetFilters;
    }

    public function __invoke($assetName) : bool
    {
        foreach ($this->schemaAssetFilters as $schemaAssetFilter) {
            if ($schemaAssetFilter($assetName) === false) {
                return false;
            }
        }

        return true;
    }
}
