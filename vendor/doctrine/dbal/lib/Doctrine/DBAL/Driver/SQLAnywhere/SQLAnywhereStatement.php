<?php

namespace Doctrine\DBAL\Driver\SQLAnywhere;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\StatementIterator;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use PDO;
use ReflectionClass;
use ReflectionObject;
use stdClass;
use const SASQL_BOTH;
use function array_key_exists;
use function func_get_args;
use function func_num_args;
use function gettype;
use function is_array;
use function is_numeric;
use function is_object;
use function is_resource;
use function is_string;
use function sasql_fetch_array;
use function sasql_fetch_assoc;
use function sasql_fetch_object;
use function sasql_fetch_row;
use function sasql_prepare;
use function sasql_stmt_affected_rows;
use function sasql_stmt_bind_param_ex;
use function sasql_stmt_errno;
use function sasql_stmt_error;
use function sasql_stmt_execute;
use function sasql_stmt_field_count;
use function sasql_stmt_reset;
use function sasql_stmt_result_metadata;
use function sprintf;

/**
 * SAP SQL Anywhere implementation of the Statement interface.
 */
class SQLAnywhereStatement implements IteratorAggregate, Statement
{
    /** @var resource The connection resource. */
    private $conn;

    /** @var string Name of the default class to instantiate when fetching class instances. */
    private $defaultFetchClass = '\stdClass';

    /** @var mixed[] Constructor arguments for the default class to instantiate when fetching class instances. */
    private $defaultFetchClassCtorArgs = [];

    /** @var int Default fetch mode to use. */
    private $defaultFetchMode = FetchMode::MIXED;

    /** @var resource The result set resource to fetch. */
    private $result;

    /** @var resource The prepared SQL statement to execute. */
    private $stmt;

    /** @var mixed[] The references to bound parameter values. */
    private $boundValues = [];

    /**
     * Prepares given statement for given connection.
     *
     * @param resource $conn The connection resource to use.
     * @param string   $sql  The SQL statement to prepare.
     *
     * @throws SQLAnywhereException
     */
    public function __construct($conn, $sql)
    {
        if (! is_resource($conn)) {
            throw new SQLAnywhereException('Invalid SQL Anywhere connection resource: ' . $conn);
        }

        $this->conn = $conn;
        $this->stmt = sasql_prepare($conn, $sql);

        if (! is_resource($this->stmt)) {
            throw SQLAnywhereException::fromSQLAnywhereError($conn);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null)
    {
        switch ($type) {
            case ParameterType::INTEGER:
            case ParameterType::BOOLEAN:
                $type = 'i';
                break;

            case ParameterType::LARGE_OBJECT:
                $type = 'b';
                break;

            case ParameterType::NULL:
            case ParameterType::STRING:
            case ParameterType::BINARY:
                $type = 's';
                break;

            default:
                throw new SQLAnywhereException('Unknown type: ' . $type);
        }

        $this->boundValues[$column] =& $variable;

        if (! sasql_stmt_bind_param_ex($this->stmt, $column - 1, $variable, $type, $variable === null)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->conn, $this->stmt);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
        return $this->bindParam($param, $value, $type);
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function closeCursor()
    {
        if (! sasql_stmt_reset($this->stmt)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->conn, $this->stmt);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function columnCount()
    {
        return sasql_stmt_field_count($this->stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return sasql_stmt_errno($this->stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return sasql_stmt_error($this->stmt);
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function execute($params = null)
    {
        if (is_array($params)) {
            $hasZeroIndex = array_key_exists(0, $params);

            foreach ($params as $key => $val) {
                $key = $hasZeroIndex && is_numeric($key) ? $key + 1 : $key;

                $this->bindValue($key, $val);
            }
        }

        if (! sasql_stmt_execute($this->stmt)) {
            throw SQLAnywhereException::fromSQLAnywhereError($this->conn, $this->stmt);
        }

        $this->result = sasql_stmt_result_metadata($this->stmt);

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws SQLAnywhereException
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        if (! is_resource($this->result)) {
            return false;
        }

        $fetchMode = $fetchMode ?: $this->defaultFetchMode;

        switch ($fetchMode) {
            case FetchMode::COLUMN:
                return $this->fetchColumn();

            case FetchMode::ASSOCIATIVE:
                return sasql_fetch_assoc($this->result);

            case FetchMode::MIXED:
                return sasql_fetch_array($this->result, SASQL_BOTH);

            case FetchMode::CUSTOM_OBJECT:
                $className = $this->defaultFetchClass;
                $ctorArgs  = $this->defaultFetchClassCtorArgs;

                if (func_num_args() >= 2) {
                    $args      = func_get_args();
                    $className = $args[1];
                    $ctorArgs  = $args[2] ?? [];
                }

                $result = sasql_fetch_object($this->result);

                if ($result instanceof stdClass) {
                    $result = $this->castObject($result, $className, $ctorArgs);
                }

                return $result;

            case FetchMode::NUMERIC:
                return sasql_fetch_row($this->result);

            case FetchMode::STANDARD_OBJECT:
                return sasql_fetch_object($this->result);

            default:
                throw new SQLAnywhereException('Fetch mode is not supported: ' . $fetchMode);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        $rows = [];

        switch ($fetchMode) {
            case FetchMode::CUSTOM_OBJECT:
                while (($row = $this->fetch(...func_get_args())) !== false) {
                    $rows[] = $row;
                }
                break;

            case FetchMode::COLUMN:
                while (($row = $this->fetchColumn()) !== false) {
                    $rows[] = $row;
                }
                break;

            default:
                while (($row = $this->fetch($fetchMode)) !== false) {
                    $rows[] = $row;
                }
        }

        return $rows;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn($columnIndex = 0)
    {
        $row = $this->fetch(FetchMode::NUMERIC);

        if ($row === false) {
            return false;
        }

        return $row[$columnIndex] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new StatementIterator($this);
    }

    /**
     * {@inheritdoc}
     */
    public function rowCount()
    {
        return sasql_stmt_affected_rows($this->stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        $this->defaultFetchMode          = $fetchMode;
        $this->defaultFetchClass         = $arg2 ?: $this->defaultFetchClass;
        $this->defaultFetchClassCtorArgs = $arg3 ? (array) $arg3 : $this->defaultFetchClassCtorArgs;
    }

    /**
     * Casts a stdClass object to the given class name mapping its' properties.
     *
     * @param stdClass      $sourceObject     Object to cast from.
     * @param string|object $destinationClass Name of the class or class instance to cast to.
     * @param mixed[]       $ctorArgs         Arguments to use for constructing the destination class instance.
     *
     * @return object
     *
     * @throws SQLAnywhereException
     */
    private function castObject(stdClass $sourceObject, $destinationClass, array $ctorArgs = [])
    {
        if (! is_string($destinationClass)) {
            if (! is_object($destinationClass)) {
                throw new SQLAnywhereException(sprintf(
                    'Destination class has to be of type string or object, %s given.',
                    gettype($destinationClass)
                ));
            }
        } else {
            $destinationClass = new ReflectionClass($destinationClass);
            $destinationClass = $destinationClass->newInstanceArgs($ctorArgs);
        }

        $sourceReflection           = new ReflectionObject($sourceObject);
        $destinationClassReflection = new ReflectionObject($destinationClass);

        foreach ($sourceReflection->getProperties() as $sourceProperty) {
            $sourceProperty->setAccessible(true);

            $name  = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);

            if ($destinationClassReflection->hasProperty($name)) {
                $destinationProperty = $destinationClassReflection->getProperty($name);

                $destinationProperty->setAccessible(true);
                $destinationProperty->setValue($destinationClass, $value);
            } else {
                $destinationClass->$name = $value;
            }
        }

        return $destinationClass;
    }
}
