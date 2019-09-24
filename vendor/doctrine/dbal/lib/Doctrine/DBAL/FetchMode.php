<?php

namespace Doctrine\DBAL;

use PDO;

/**
 * Contains statement fetch modes.
 */
final class FetchMode
{
    /**
     * Specifies that the fetch method shall return each row as an array indexed
     * by column name as returned in the corresponding result set. If the result
     * set contains multiple columns with the same name, the statement returns
     * only a single value per column name.
     *
     * @see \PDO::FETCH_ASSOC
     */
    public const ASSOCIATIVE = PDO::FETCH_ASSOC;

    /**
     * Specifies that the fetch method shall return each row as an array indexed
     * by column number as returned in the corresponding result set, starting at
     * column 0.
     *
     * @see \PDO::FETCH_NUM
     */
    public const NUMERIC = PDO::FETCH_NUM;

    /**
     * Specifies that the fetch method shall return each row as an array indexed
     * by both column name and number as returned in the corresponding result set,
     * starting at column 0.
     *
     * @see \PDO::FETCH_BOTH
     */
    public const MIXED = PDO::FETCH_BOTH;

    /**
     * Specifies that the fetch method shall return each row as an object with
     * property names that correspond to the column names returned in the result
     * set.
     *
     * @see \PDO::FETCH_OBJ
     */
    public const STANDARD_OBJECT = PDO::FETCH_OBJ;

    /**
     * Specifies that the fetch method shall return only a single requested
     * column from the next row in the result set.
     *
     * @see \PDO::FETCH_COLUMN
     */
    public const COLUMN = PDO::FETCH_COLUMN;

    /**
     * Specifies that the fetch method shall return a new instance of the
     * requested class, mapping the columns to named properties in the class.
     *
     * @see \PDO::FETCH_CLASS
     */
    public const CUSTOM_OBJECT = PDO::FETCH_CLASS;

    /**
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
}
