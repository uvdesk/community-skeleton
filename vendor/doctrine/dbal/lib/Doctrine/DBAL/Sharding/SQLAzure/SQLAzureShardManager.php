<?php

namespace Doctrine\DBAL\Sharding\SQLAzure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Sharding\ShardingException;
use Doctrine\DBAL\Sharding\ShardManager;
use Doctrine\DBAL\Types\Type;
use RuntimeException;
use function is_bool;
use function is_scalar;
use function sprintf;

/**
 * Sharding using the SQL Azure Federations support.
 */
class SQLAzureShardManager implements ShardManager
{
    /** @var string */
    private $federationName;

    /** @var bool */
    private $filteringEnabled;

    /** @var string */
    private $distributionKey;

    /** @var string */
    private $distributionType;

    /** @var Connection */
    private $conn;

    /** @var string|null */
    private $currentDistributionValue;

    /**
     * @throws ShardingException
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
        $params     = $conn->getParams();

        if (! isset($params['sharding']['federationName'])) {
            throw ShardingException::missingDefaultFederationName();
        }

        if (! isset($params['sharding']['distributionKey'])) {
            throw ShardingException::missingDefaultDistributionKey();
        }

        if (! isset($params['sharding']['distributionType'])) {
            throw ShardingException::missingDistributionType();
        }

        $this->federationName   = $params['sharding']['federationName'];
        $this->distributionKey  = $params['sharding']['distributionKey'];
        $this->distributionType = $params['sharding']['distributionType'];
        $this->filteringEnabled = (bool) ($params['sharding']['filteringEnabled'] ?? false);
    }

    /**
     * Gets the name of the federation.
     *
     * @return string
     */
    public function getFederationName()
    {
        return $this->federationName;
    }

    /**
     * Gets the distribution key.
     *
     * @return string
     */
    public function getDistributionKey()
    {
        return $this->distributionKey;
    }

    /**
     * Gets the Doctrine Type name used for the distribution.
     *
     * @return string
     */
    public function getDistributionType()
    {
        return $this->distributionType;
    }

    /**
     * Sets Enabled/Disable filtering on the fly.
     *
     * @param bool $flag
     *
     * @return void
     */
    public function setFilteringEnabled($flag)
    {
        $this->filteringEnabled = (bool) $flag;
    }

    /**
     * {@inheritDoc}
     */
    public function selectGlobal()
    {
        if ($this->conn->isTransactionActive()) {
            throw ShardingException::activeTransaction();
        }

        $sql = 'USE FEDERATION ROOT WITH RESET';
        $this->conn->exec($sql);
        $this->currentDistributionValue = null;
    }

    /**
     * {@inheritDoc}
     */
    public function selectShard($distributionValue)
    {
        if ($this->conn->isTransactionActive()) {
            throw ShardingException::activeTransaction();
        }

        if ($distributionValue === null || is_bool($distributionValue) || ! is_scalar($distributionValue)) {
            throw ShardingException::noShardDistributionValue();
        }

        $platform = $this->conn->getDatabasePlatform();
        $sql      = sprintf(
            'USE FEDERATION %s (%s = %s) WITH RESET, FILTERING = %s;',
            $platform->quoteIdentifier($this->federationName),
            $platform->quoteIdentifier($this->distributionKey),
            $this->conn->quote($distributionValue),
            ($this->filteringEnabled ? 'ON' : 'OFF')
        );

        $this->conn->exec($sql);
        $this->currentDistributionValue = $distributionValue;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentDistributionValue()
    {
        return $this->currentDistributionValue;
    }

    /**
     * {@inheritDoc}
     */
    public function getShards()
    {
        $sql = 'SELECT member_id as id,
                      distribution_name as distribution_key,
                      CAST(range_low AS CHAR) AS rangeLow,
                      CAST(range_high AS CHAR) AS rangeHigh
                      FROM sys.federation_member_distributions d
                      INNER JOIN sys.federations f ON f.federation_id = d.federation_id
                      WHERE f.name = ' . $this->conn->quote($this->federationName);

        return $this->conn->fetchAll($sql);
    }

     /**
      * {@inheritDoc}
      */
    public function queryAll($sql, array $params = [], array $types = [])
    {
        $shards = $this->getShards();
        if (! $shards) {
            throw new RuntimeException('No shards found for ' . $this->federationName);
        }

        $result          = [];
        $oldDistribution = $this->getCurrentDistributionValue();

        foreach ($shards as $shard) {
            $this->selectShard($shard['rangeLow']);
            foreach ($this->conn->fetchAll($sql, $params, $types) as $row) {
                $result[] = $row;
            }
        }

        if ($oldDistribution === null) {
            $this->selectGlobal();
        } else {
            $this->selectShard($oldDistribution);
        }

        return $result;
    }

    /**
     * Splits Federation at a given distribution value.
     *
     * @param mixed $splitDistributionValue
     *
     * @return void
     */
    public function splitFederation($splitDistributionValue)
    {
        $type = Type::getType($this->distributionType);

        $sql = 'ALTER FEDERATION ' . $this->getFederationName() . ' ' .
               'SPLIT AT (' . $this->getDistributionKey() . ' = ' .
               $this->conn->quote($splitDistributionValue, $type->getBindingType()) . ')';
        $this->conn->exec($sql);
    }
}
