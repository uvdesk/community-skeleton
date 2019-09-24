<?php

namespace Doctrine\DBAL\Logging;

/**
 * Interface for SQL loggers.
 */
interface SQLLogger
{
    /**
     * Logs a SQL statement somewhere.
     *
     * @param string              $sql    The SQL to be executed.
     * @param mixed[]|null        $params The SQL parameters.
     * @param int[]|string[]|null $types  The SQL parameter types.
     *
     * @return void
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null);

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery();
}
