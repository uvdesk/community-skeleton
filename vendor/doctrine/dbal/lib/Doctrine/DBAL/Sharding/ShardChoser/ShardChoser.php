<?php

namespace Doctrine\DBAL\Sharding\ShardChoser;

use Doctrine\DBAL\Sharding\PoolingShardConnection;

/**
 * Given a distribution value this shard-choser strategy will pick the shard to
 * connect to for retrieving rows with the distribution value.
 */
interface ShardChoser
{
    /**
     * Picks a shard for the given distribution value.
     *
     * @param string|int $distributionValue
     *
     * @return string|int
     */
    public function pickShard($distributionValue, PoolingShardConnection $conn);
}
