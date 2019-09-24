<?php

namespace Doctrine\DBAL\Portability;

use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\ColumnCase;
use Doctrine\DBAL\Driver\PDOConnection;
use PDO;
use const CASE_LOWER;
use const CASE_UPPER;
use function func_get_args;

/**
 * Portability wrapper for a Connection.
 */
class Connection extends \Doctrine\DBAL\Connection
{
    public const PORTABILITY_ALL           = 255;
    public const PORTABILITY_NONE          = 0;
    public const PORTABILITY_RTRIM         = 1;
    public const PORTABILITY_EMPTY_TO_NULL = 4;
    public const PORTABILITY_FIX_CASE      = 8;

    public const PORTABILITY_DB2          = 13;
    public const PORTABILITY_ORACLE       = 9;
    public const PORTABILITY_POSTGRESQL   = 13;
    public const PORTABILITY_SQLITE       = 13;
    public const PORTABILITY_OTHERVENDORS = 12;
    public const PORTABILITY_DRIZZLE      = 13;
    public const PORTABILITY_SQLANYWHERE  = 13;
    public const PORTABILITY_SQLSRV       = 13;

    /** @var int */
    private $portability = self::PORTABILITY_NONE;

    /** @var int */
    private $case;

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        $ret = parent::connect();
        if ($ret) {
            $params = $this->getParams();
            if (isset($params['portability'])) {
                if ($this->getDatabasePlatform()->getName() === 'oracle') {
                    $params['portability'] &= self::PORTABILITY_ORACLE;
                } elseif ($this->getDatabasePlatform()->getName() === 'postgresql') {
                    $params['portability'] &= self::PORTABILITY_POSTGRESQL;
                } elseif ($this->getDatabasePlatform()->getName() === 'sqlite') {
                    $params['portability'] &= self::PORTABILITY_SQLITE;
                } elseif ($this->getDatabasePlatform()->getName() === 'drizzle') {
                    $params['portability'] &= self::PORTABILITY_DRIZZLE;
                } elseif ($this->getDatabasePlatform()->getName() === 'sqlanywhere') {
                    $params['portability'] &= self::PORTABILITY_SQLANYWHERE;
                } elseif ($this->getDatabasePlatform()->getName() === 'db2') {
                    $params['portability'] &= self::PORTABILITY_DB2;
                } elseif ($this->getDatabasePlatform()->getName() === 'mssql') {
                    $params['portability'] &= self::PORTABILITY_SQLSRV;
                } else {
                    $params['portability'] &= self::PORTABILITY_OTHERVENDORS;
                }
                $this->portability = $params['portability'];
            }

            if (isset($params['fetch_case']) && $this->portability & self::PORTABILITY_FIX_CASE) {
                if ($this->_conn instanceof PDOConnection) {
                    // make use of c-level support for case handling
                    $this->_conn->setAttribute(PDO::ATTR_CASE, $params['fetch_case']);
                } else {
                    $this->case = $params['fetch_case'] === ColumnCase::LOWER ? CASE_LOWER : CASE_UPPER;
                }
            }
        }

        return $ret;
    }

    /**
     * @return int
     */
    public function getPortability()
    {
        return $this->portability;
    }

    /**
     * @return int
     */
    public function getFetchCase()
    {
        return $this->case;
    }

    /**
     * {@inheritdoc}
     */
    public function executeQuery($query, array $params = [], $types = [], ?QueryCacheProfile $qcp = null)
    {
        $stmt = new Statement(parent::executeQuery($query, $params, $types, $qcp), $this);
        $stmt->setFetchMode($this->defaultFetchMode);

        return $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($statement)
    {
        $stmt = new Statement(parent::prepare($statement), $this);
        $stmt->setFetchMode($this->defaultFetchMode);

        return $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        $this->connect();

        $stmt = $this->_conn->query(...func_get_args());
        $stmt = new Statement($stmt, $this);
        $stmt->setFetchMode($this->defaultFetchMode);

        return $stmt;
    }
}
