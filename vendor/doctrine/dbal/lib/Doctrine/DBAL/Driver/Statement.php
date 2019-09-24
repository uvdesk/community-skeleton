<?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\ParameterType;

/**
 * Statement interface.
 * Drivers must implement this interface.
 *
 * This resembles (a subset of) the PDOStatement interface.
 */
interface Statement extends ResultStatement
{
    /**
     * Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional
     * placeholder in the SQL statement that was used to prepare the statement.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * @param mixed $param Parameter identifier. For a prepared statement using named placeholders,
     *                     this will be a parameter name of the form :name. For a prepared statement
     *                     using question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed $value The value to bind to the parameter.
     * @param int   $type  Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                     constants.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindValue($param, $value, $type = ParameterType::STRING);

    /**
     * Binds a PHP variable to a corresponding named (not supported by mysqli driver, see comment below) or question
     * mark placeholder in the SQL statement that was use to prepare the statement. Unlike PDOStatement->bindValue(),
     * the variable is bound as a reference and will only be evaluated at the time
     * that PDOStatement->execute() is called.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * Most parameters are input parameters, that is, parameters that are
     * used in a read-only fashion to build up the query. Some drivers support the invocation
     * of stored procedures that return data as output parameters, and some also as input/output
     * parameters that both send in data and are updated to receive it.
     *
     * @param mixed    $column   Parameter identifier. For a prepared statement using named placeholders,
     *                           this will be a parameter name of the form :name. For a prepared statement using
     *                           question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed    $variable Name of the PHP variable to bind to the SQL statement parameter.
     * @param int|null $type     Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                           constants. To return an INOUT parameter from a stored procedure, use the bitwise
     *                           OR operator to set the PDO::PARAM_INPUT_OUTPUT bits for the data_type parameter.
     * @param int|null $length   You must specify maxlength when using an OUT bind
     *                           so that PHP allocates enough memory to hold the returned value.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null);

    /**
     * Fetches the SQLSTATE associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorCode()
     *
     * @return string|int|bool The error code string.
     */
    public function errorCode();

    /**
     * Fetches extended error information associated with the last operation on the statement handle.
     *
     * @return mixed[] The error info array.
     */
    public function errorInfo();

    /**
     * Executes a prepared statement
     *
     * If the prepared statement included parameter markers, you must either:
     * call PDOStatement->bindParam() to bind PHP variables to the parameter markers:
     * bound variables pass their value as input and receive the output value,
     * if any, of their associated parameter markers or pass an array of input-only
     * parameter values.
     *
     * @param mixed[]|null $params An array of values with as many elements as there are
     *                             bound parameters in the SQL statement being executed.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function execute($params = null);

    /**
     * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
     * executed by the corresponding object.
     *
     * If the last SQL statement executed by the associated Statement object was a SELECT statement,
     * some databases may return the number of rows returned by that statement. However,
     * this behaviour is not guaranteed for all databases and should not be
     * relied on for portable applications.
     *
     * @return int The number of rows.
     */
    public function rowCount();
}
