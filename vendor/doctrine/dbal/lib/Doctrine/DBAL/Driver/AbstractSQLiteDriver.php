<?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Schema\SqliteSchemaManager;
use function strpos;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for SQLite based drivers.
 */
abstract class AbstractSQLiteDriver implements Driver, ExceptionConverterDriver
{
    /**
     * {@inheritdoc}
     *
     * @link http://www.sqlite.org/c3ref/c_abort.html
     */
    public function convertException($message, DriverException $exception)
    {
        if (strpos($exception->getMessage(), 'database is locked') !== false) {
            return new Exception\LockWaitTimeoutException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'must be unique') !== false ||
            strpos($exception->getMessage(), 'is not unique') !== false ||
            strpos($exception->getMessage(), 'are not unique') !== false ||
            strpos($exception->getMessage(), 'UNIQUE constraint failed') !== false
        ) {
            return new Exception\UniqueConstraintViolationException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'may not be NULL') !== false ||
            strpos($exception->getMessage(), 'NOT NULL constraint failed') !== false
        ) {
            return new Exception\NotNullConstraintViolationException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'no such table:') !== false) {
            return new Exception\TableNotFoundException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'already exists') !== false) {
            return new Exception\TableExistsException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'has no column named') !== false) {
            return new Exception\InvalidFieldNameException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'ambiguous column name') !== false) {
            return new Exception\NonUniqueFieldNameException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'syntax error') !== false) {
            return new Exception\SyntaxErrorException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'attempt to write a readonly database') !== false) {
            return new Exception\ReadOnlyException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'unable to open database file') !== false) {
            return new Exception\ConnectionException($message, $exception);
        }

        return new Exception\DriverException($message, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['path'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new SqlitePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new SqliteSchemaManager($conn);
    }
}
