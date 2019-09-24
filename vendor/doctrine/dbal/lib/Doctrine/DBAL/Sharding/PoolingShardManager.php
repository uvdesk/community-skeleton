<?php

namespace Doctrine\DBAL\Sharding;

use Doctrine\DBAL\Sharding\ShardChoser\ShardChoser;
use RuntimeException;

/**
 * Shard Manager for the Connection Pooling Shard Strategy
 */
class PoolingShardManager implements ShardManager
{
    /** @var PoolingShardConnection */
    private $conn;

    /** @var ShardChoser */
    private $choser;

    /** @var string|null */
    private $currentDistributionValue;

    public function __construct(PoolingShardConnection $conn)
    {
        $params       = $conn->getParams();
        $this->conn   = $conn;
        $this->choser = $params['shardChoser'];
    }

    /**
     * {@inheritDoc}
     */
    public function selectGlobal()
    {
        $this->conn->connect(0);
        $this->currentDistributionValue = null;
    }

    /**
     * {@inheritDoc}
     */
    public function selectShard($distributionValue)
    {
        $shardId = $this->choser->pickShard($distributionValue, $this->conn);
        $this->conn->connect($shardId);
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
        $params = $this->conn->getParams();
        $shards = [];

        foreach ($params['shards'] as $shard) {
            $shards[] = ['id' => $shard['id']];
        }

        return $shards;
    }

    /**
     * {@inheritDoc}
     *
     * @throws RuntimeException
     */
    public function queryAll($sql, array $params, array $types)
    {
        $shards = $this->getShards();
        if (! $shards) {
            throw new RuntimeException('No shards found.');
        }

        $result          = [];
        $oldDistribution = $this->getCurrentDistributionValue();

        foreach ($shards as $shard) {
            $this->conn->connect($shard['id']);
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
}
