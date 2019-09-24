<?php

namespace Doctrine\DBAL\Sharding\ShardChoser;

use Doctrine\DBAL\Sharding\PoolingShardConnection;

/**
 * The MultiTenant Shard choser assumes that the distribution value directly
 * maps to the shard id.
 */
class MultiTenantShardChoser implements ShardChoser
{
    /**
     * {@inheritdoc}
     */
    public function pickShard($distributionValue, PoolingShardConnection $conn)
    {
        return $distributionValue;
    }
}
