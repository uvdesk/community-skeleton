<?php

namespace Doctrine\DBAL\Driver\SQLAnywhere;

use Doctrine\DBAL\Driver\AbstractDriverException;
use InvalidArgumentException;
use function is_resource;
use function sasql_error;
use function sasql_errorcode;
use function sasql_sqlstate;
use function sasql_stmt_errno;
use function sasql_stmt_error;

/**
 * SAP Sybase SQL Anywhere driver exception.
 */
class SQLAnywhereException extends AbstractDriverException
{
    /**
     * Helper method to turn SQL Anywhere error into exception.
     *
     * @param resource|null $conn The SQL Anywhere connection resource to retrieve the last error from.
     * @param resource|null $stmt The SQL Anywhere statement resource to retrieve the last error from.
     *
     * @return SQLAnywhereException
     *
     * @throws InvalidArgumentException
     */
    public static function fromSQLAnywhereError($conn = null, $stmt = null)
    {
        if ($conn !== null && ! is_resource($conn)) {
            throw new InvalidArgumentException('Invalid SQL Anywhere connection resource given: ' . $conn);
        }

        if ($stmt !== null && ! is_resource($stmt)) {
            throw new InvalidArgumentException('Invalid SQL Anywhere statement resource given: ' . $stmt);
        }

        $state   = $conn ? sasql_sqlstate($conn) : sasql_sqlstate();
        $code    = null;
        $message = null;

        /**
         * Try retrieving the last error from statement resource if given
         */
        if ($stmt) {
            $code    = sasql_stmt_errno($stmt);
            $message = sasql_stmt_error($stmt);
        }

        /**
         * Try retrieving the last error from the connection resource
         * if either the statement resource is not given or the statement
         * resource is given but the last error could not be retrieved from it (fallback).
         * Depending on the type of error, it is sometimes necessary to retrieve
         * it from the connection resource even though it occurred during
         * a prepared statement.
         */
        if ($conn && ! $code) {
            $code    = sasql_errorcode($conn);
            $message = sasql_error($conn);
        }

        /**
         * Fallback mode if either no connection resource is given
         * or the last error could not be retrieved from the given
         * connection / statement resource.
         */
        if (! $conn || ! $code) {
            $code    = sasql_errorcode();
            $message = sasql_error();
        }

        if ($message) {
            return new self('SQLSTATE [' . $state . '] [' . $code . '] ' . $message, $state, $code);
        }

        return new self('SQL Anywhere error occurred but no error message was retrieved from driver.', $state, $code);
    }
}
