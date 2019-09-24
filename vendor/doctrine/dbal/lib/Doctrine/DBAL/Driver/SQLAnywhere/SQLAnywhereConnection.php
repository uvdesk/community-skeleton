<?php

namespace Doctrine\DBAL\Driver\SQLAnywhere;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use Doctrine\DBAL\ParameterType;
use function assert;
use function func_get_args;
use function is_float;
use function is_int;
use function is_resource;
use function is_string;
use function sasql_affected_rows;
use function sasql_commit;
use function sasql_connect;
use function sasql_error;
use function sasql_errorcode;
use function sasql_escape_string;
use function sasql_insert_id;
use function sasql_pconnect;
use function sasql_real_query;
use function sasql_rollback;
use function sasql_set_option;

/**
 * SAP Sybase SQL Anywhere implementation of the Connection interface.
 */
class SQLAnywhereConnection implements Connection, ServerInfoAwareConnection
{
    /** @var resource The SQL Anywhere connection resource. */
    private $connection;

    /**
     * Connects to database with given connection string.
     *
     * @param string $dsn        The connection string.
     * @param bool   $persistent Whether or not to establish a persistent connection.
     *
     * @throws SQLAnywhereException
     */
    public function __construct($dsn, $persistent = false)
    {
        $this->connection = $persistent ? @sasql_pconnect($dsn) : @sasql_connect($dsn);

        if (! is_resource($this->connection)) {
            throw SQLAnywhereException::fromSQLAnywhereError();
        }

        // Disable PHP warnings on error.
        if (! sasql_set_option($this->connection, 'verbose_errors', false)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        // Enable auto committing by default.
        if (! sasql_set_option($this->connection, 'auto_commit', 'on')) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function beginTransaction()
    {
        if (! sasql_set_option($this->connection, 'auto_commit', 'off')) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function commit()
    {
        if (! sasql_commit($this->connection)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        $this->endTransaction();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return sasql_errorcode($this->connection);
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return sasql_error($this->connection);
    }

    /**
     * {@inheritdoc}
     */
    public function exec($statement)
    {
        if (sasql_real_query($this->connection, $statement) === false) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        return sasql_affected_rows($this->connection);
    }

    /**
     * {@inheritdoc}
     */
    public function getServerVersion()
    {
        $version = $this->query("SELECT PROPERTY('ProductVersion')")->fetchColumn();

        assert(is_string($version));

        return $version;
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        if ($name === null) {
            return sasql_insert_id($this->connection);
        }

        return $this->query('SELECT ' . $name . '.CURRVAL')->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($prepareString)
    {
        return new SQLAnywhereStatement($this->connection, $prepareString);
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        $args = func_get_args();
        $stmt = $this->prepare($args[0]);

        $stmt->execute();

        return $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        if (is_int($input) || is_float($input)) {
            return $input;
        }

        return "'" . sasql_escape_string($this->connection, $input) . "'";
    }

    /**
     * {@inheritdoc}
     */
    public function requiresQueryForServerVersion()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function rollBack()
    {
        if (! sasql_rollback($this->connection)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        $this->endTransaction();

        return true;
    }

    /**
     * Ends transactional mode and enables auto commit again.
     *
     * @return bool Whether or not ending transactional mode succeeded.
     *
     * @throws SQLAnywhereException
     */
    private function endTransaction()
    {
        if (! sasql_set_option($this->connection, 'auto_commit', 'on')) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->connection);
        }

        return true;
    }
}
