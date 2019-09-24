<?php

namespace Doctrine\DBAL\Driver;

use PDO;
use Traversable;

/**
 * Interface for the reading part of a prepare statement only.
 */
interface ResultStatement extends Traversable
{
    /**
     * Closes the cursor, enabling the statement to be executed again.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function closeCursor();

    /**
     * Returns the number of columns in the result set
     *
     * @return int The number of columns in the result set represented
     *                 by the PDOStatement object. If there is no result set,
     *                 this method should return 0.
     */
    public function columnCount();

    /**
     * Sets the fetch mode to use while iterating this statement.
     *
     * @param int   $fetchMode The fetch mode must be one of the {@link \Doctrine\DBAL\FetchMode} constants.
     * @param mixed $arg2
     * @param mixed $arg3
     *
     * @return bool
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null);

    /**
     * Returns the next row of a result set.
     *
     * @param int|null $fetchMode         Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int      $cursorOrientation For a ResultStatement object representing a scrollable cursor,
     *                                    this value determines which row will be returned to the caller.
     *                                    This value must be one of the \PDO::FETCH_ORI_* constants,
     *                                    defaulting to \PDO::FETCH_ORI_NEXT. To request a scrollable
     *                                    cursor for your ResultStatement object, you must set the \PDO::ATTR_CURSOR
     *                                    attribute to \PDO::CURSOR_SCROLL when you prepare the SQL statement with
     *                                    \PDO::prepare().
     * @param int      $cursorOffset      For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_ABS, this value
     *                                    specifies the absolute number of the row in the result set that shall be
     *                                    fetched.
     *                                    For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_REL, this value
     *                                    specifies the row to fetch relative to the cursor position before
     *                                    ResultStatement::fetch() was called.
     *
     * @return mixed The return value of this method on success depends on the fetch mode. In all cases, FALSE is
     *               returned on failure.
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0);

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param int|null     $fetchMode     Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int|null     $fetchArgument This argument has a different meaning depending on the value of the $fetchMode parameter:
     *                                    * {@link \Doctrine\DBAL\FetchMode::COLUMN}:
     *                                      Returns the indicated 0-indexed column.
     *                                    * {@link \Doctrine\DBAL\FetchMode::CUSTOM_OBJECT}:
     *                                      Returns instances of the specified class, mapping the columns of each row
     *                                      to named properties in the class.
     *                                    * \PDO::FETCH_FUNC: Returns the results of calling the specified function, using each row's
     *                                      columns as parameters in the call.
     * @param mixed[]|null $ctorArgs      Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     *
     * @return mixed[]
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null);

    /**
     * Returns a single column from the next row of a result set or FALSE if there are no more rows.
     *
     * @param int $columnIndex 0-indexed number of the column you wish to retrieve from the row.
     *                         If no value is supplied, fetches the first column.
     *
     * @return mixed|false A single column in the next row of a result set, or FALSE if there are no more rows.
     */
    public function fetchColumn($columnIndex = 0);
}
