<?php

namespace Doctrine\DBAL\Driver\Mysqli;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\StatementIterator;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use mysqli;
use mysqli_stmt;
use PDO;
use stdClass;
use function array_combine;
use function array_fill;
use function count;
use function feof;
use function fread;
use function get_resource_type;
use function is_resource;
use function sprintf;
use function str_repeat;

class MysqliStatement implements IteratorAggregate, Statement
{
    /** @var string[] */
    protected static $_paramTypeMap = [
        ParameterType::STRING       => 's',
        ParameterType::BINARY       => 's',
        ParameterType::BOOLEAN      => 'i',
        ParameterType::NULL         => 's',
        ParameterType::INTEGER      => 'i',
        ParameterType::LARGE_OBJECT => 'b',
    ];

    /** @var mysqli */
    protected $_conn;

    /** @var mysqli_stmt */
    protected $_stmt;

    /** @var string[]|bool|null */
    protected $_columnNames;

    /** @var mixed[]|null */
    protected $_rowBindedValues;

    /** @var mixed[] */
    protected $_bindedValues;

    /** @var string */
    protected $types;

    /**
     * Contains ref values for bindValue().
     *
     * @var mixed[]
     */
    protected $_values = [];

    /** @var int */
    protected $_defaultFetchMode = FetchMode::MIXED;

    /**
     * Indicates whether the statement is in the state when fetching results is possible
     *
     * @var bool
     */
    private $result = false;

    /**
     * @param string $prepareString
     *
     * @throws MysqliException
     */
    public function __construct(mysqli $conn, $prepareString)
    {
        $this->_conn = $conn;
        $this->_stmt = $conn->prepare($prepareString);
        if ($this->_stmt === false) {
            throw new MysqliException($this->_conn->error, $this->_conn->sqlstate, $this->_conn->errno);
        }

        $paramCount = $this->_stmt->param_count;
        if (0 >= $paramCount) {
            return;
        }

        $this->types         = str_repeat('s', $paramCount);
        $this->_bindedValues = array_fill(1, $paramCount, null);
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null)
    {
        if ($type === null) {
            $type = 's';
        } else {
            if (! isset(self::$_paramTypeMap[$type])) {
                throw new MysqliException(sprintf("Unknown type: '%s'", $type));
            }

            $type = self::$_paramTypeMap[$type];
        }

        $this->_bindedValues[$column] =& $variable;
        $this->types[$column - 1]     = $type;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
        if ($type === null) {
            $type = 's';
        } else {
            if (! isset(self::$_paramTypeMap[$type])) {
                throw new MysqliException(sprintf("Unknown type: '%s'", $type));
            }

            $type = self::$_paramTypeMap[$type];
        }

        $this->_values[$param]       = $value;
        $this->_bindedValues[$param] =& $this->_values[$param];
        $this->types[$param - 1]     = $type;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null)
    {
        if ($this->_bindedValues !== null) {
            if ($params !== null) {
                if (! $this->_bindValues($params)) {
                    throw new MysqliException($this->_stmt->error, $this->_stmt->errno);
                }
            } else {
                [$types, $values, $streams] = $this->separateBoundValues();
                if (! $this->_stmt->bind_param($types, ...$values)) {
                    throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
                }
                $this->sendLongData($streams);
            }
        }

        if (! $this->_stmt->execute()) {
            throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
        }

        if ($this->_columnNames === null) {
            $meta = $this->_stmt->result_metadata();
            if ($meta !== false) {
                $columnNames = [];
                foreach ($meta->fetch_fields() as $col) {
                    $columnNames[] = $col->name;
                }
                $meta->free();

                $this->_columnNames = $columnNames;
            } else {
                $this->_columnNames = false;
            }
        }

        if ($this->_columnNames !== false) {
            // Store result of every execution which has it. Otherwise it will be impossible
            // to execute a new statement in case if the previous one has non-fetched rows
            // @link http://dev.mysql.com/doc/refman/5.7/en/commands-out-of-sync.html
            $this->_stmt->store_result();

            // Bind row values _after_ storing the result. Otherwise, if mysqli is compiled with libmysql,
            // it will have to allocate as much memory as it may be needed for the given column type
            // (e.g. for a LONGBLOB field it's 4 gigabytes)
            // @link https://bugs.php.net/bug.php?id=51386#1270673122
            //
            // Make sure that the values are bound after each execution. Otherwise, if closeCursor() has been
            // previously called on the statement, the values are unbound making the statement unusable.
            //
            // It's also important that row values are bound after _each_ call to store_result(). Otherwise,
            // if mysqli is compiled with libmysql, subsequently fetched string values will get truncated
            // to the length of the ones fetched during the previous execution.
            $this->_rowBindedValues = array_fill(0, count($this->_columnNames), null);

            $refs = [];
            foreach ($this->_rowBindedValues as $key => &$value) {
                $refs[$key] =& $value;
            }

            if (! $this->_stmt->bind_result(...$refs)) {
                throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
            }
        }

        $this->result = true;

        return true;
    }

    /**
     * Split $this->_bindedValues into those values that need to be sent using mysqli::send_long_data()
     * and those that can be bound the usual way.
     *
     * @return array<int, array<int|string, mixed>|string>
     */
    private function separateBoundValues()
    {
        $streams = $values = [];
        $types   = $this->types;

        foreach ($this->_bindedValues as $parameter => $value) {
            if (! isset($types[$parameter - 1])) {
                $types[$parameter - 1] = static::$_paramTypeMap[ParameterType::STRING];
            }

            if ($types[$parameter - 1] === static::$_paramTypeMap[ParameterType::LARGE_OBJECT]) {
                if (is_resource($value)) {
                    if (get_resource_type($value) !== 'stream') {
                        throw new InvalidArgumentException('Resources passed with the LARGE_OBJECT parameter type must be stream resources.');
                    }
                    $streams[$parameter] = $value;
                    $values[$parameter]  = null;
                    continue;
                } else {
                    $types[$parameter - 1] = static::$_paramTypeMap[ParameterType::STRING];
                }
            }

            $values[$parameter] = $value;
        }

        return [$types, $values, $streams];
    }

    /**
     * Handle $this->_longData after regular query parameters have been bound
     *
     * @throws MysqliException
     */
    private function sendLongData($streams)
    {
        foreach ($streams as $paramNr => $stream) {
            while (! feof($stream)) {
                $chunk = fread($stream, 8192);

                if ($chunk === false) {
                    throw new MysqliException("Failed reading the stream resource for parameter offset ${paramNr}.");
                }

                if (! $this->_stmt->send_long_data($paramNr - 1, $chunk)) {
                    throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
                }
            }
        }
    }

    /**
     * Binds a array of values to bound parameters.
     *
     * @param mixed[] $values
     *
     * @return bool
     */
    private function _bindValues($values)
    {
        $params = [];
        $types  = str_repeat('s', count($values));

        foreach ($values as &$v) {
            $params[] =& $v;
        }

        return $this->_stmt->bind_param($types, ...$params);
    }

    /**
     * @return mixed[]|false
     */
    private function _fetch()
    {
        $ret = $this->_stmt->fetch();

        if ($ret === true) {
            $values = [];
            foreach ($this->_rowBindedValues as $v) {
                $values[] = $v;
            }

            return $values;
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        // do not try fetching from the statement if it's not expected to contain result
        // in order to prevent exceptional situation
        if (! $this->result) {
            return false;
        }

        $fetchMode = $fetchMode ?: $this->_defaultFetchMode;

        if ($fetchMode === FetchMode::COLUMN) {
            return $this->fetchColumn();
        }

        $values = $this->_fetch();
        if ($values === null) {
            return false;
        }

        if ($values === false) {
            throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
        }

        switch ($fetchMode) {
            case FetchMode::NUMERIC:
                return $values;

            case FetchMode::ASSOCIATIVE:
                return array_combine($this->_columnNames, $values);

            case FetchMode::MIXED:
                $ret  = array_combine($this->_columnNames, $values);
                $ret += $values;

                return $ret;

            case FetchMode::STANDARD_OBJECT:
                $assoc = array_combine($this->_columnNames, $values);
                $ret   = new stdClass();

                foreach ($assoc as $column => $value) {
                    $ret->$column = $value;
                }

                return $ret;

            default:
                throw new MysqliException(sprintf("Unknown fetch type '%s'", $fetchMode));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        $fetchMode = $fetchMode ?: $this->_defaultFetchMode;

        $rows = [];

        if ($fetchMode === FetchMode::COLUMN) {
            while (($row = $this->fetchColumn()) !== false) {
                $rows[] = $row;
            }
        } else {
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
    public function errorCode()
    {
        return $this->_stmt->errno;
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return $this->_stmt->error;
    }

    /**
     * {@inheritdoc}
     */
    public function closeCursor()
    {
        $this->_stmt->free_result();
        $this->result = false;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rowCount()
    {
        if ($this->_columnNames === false) {
            return $this->_stmt->affected_rows;
        }

        return $this->_stmt->num_rows;
    }

    /**
     * {@inheritdoc}
     */
    public function columnCount()
    {
        return $this->_stmt->field_count;
    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        $this->_defaultFetchMode = $fetchMode;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new StatementIterator($this);
    }
}
