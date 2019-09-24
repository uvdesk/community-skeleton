<?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Platforms\PostgreSQL91Platform;
use Doctrine\DBAL\Platforms\PostgreSQL92Platform;
use Doctrine\DBAL\Platforms\PostgreSQL94Platform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Schema\PostgreSqlSchemaManager;
use Doctrine\DBAL\VersionAwarePlatformDriver;
use function preg_match;
use function strpos;
use function version_compare;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for PostgreSQL based drivers.
 */
abstract class AbstractPostgreSQLDriver implements Driver, ExceptionConverterDriver, VersionAwarePlatformDriver
{
    /**
     * {@inheritdoc}
     *
     * @link http://www.postgresql.org/docs/9.3/static/errcodes-appendix.html
     */
    public function convertException($message, DriverException $exception)
    {
        switch ($exception->getSQLState()) {
            case '40001':
            case '40P01':
                return new Exception\DeadlockException($message, $exception);
            case '0A000':
                // Foreign key constraint violations during a TRUNCATE operation
                // are considered "feature not supported" in PostgreSQL.
                if (strpos($exception->getMessage(), 'truncate') !== false) {
                    return new Exception\ForeignKeyConstraintViolationException($message, $exception);
                }

                break;
            case '23502':
                return new Exception\NotNullConstraintViolationException($message, $exception);

            case '23503':
                return new Exception\ForeignKeyConstraintViolationException($message, $exception);

            case '23505':
                return new Exception\UniqueConstraintViolationException($message, $exception);

            case '42601':
                return new Exception\SyntaxErrorException($message, $exception);

            case '42702':
                return new Exception\NonUniqueFieldNameException($message, $exception);

            case '42703':
                return new Exception\InvalidFieldNameException($message, $exception);

            case '42P01':
                return new Exception\TableNotFoundException($message, $exception);

            case '42P07':
                return new Exception\TableExistsException($message, $exception);

            case '7':
                // In some case (mainly connection errors) the PDO exception does not provide a SQLSTATE via its code.
                // The exception code is always set to 7 here.
                // We have to match against the SQLSTATE in the error message in these cases.
                if (strpos($exception->getMessage(), 'SQLSTATE[08006]') !== false) {
                    return new Exception\ConnectionException($message, $exception);
                }

                break;
        }

        return new Exception\DriverException($message, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function createDatabasePlatformForVersion($version)
    {
        if (! preg_match('/^(?P<major>\d+)(?:\.(?P<minor>\d+)(?:\.(?P<patch>\d+))?)?/', $version, $versionParts)) {
            throw DBALException::invalidPlatformVersionSpecified(
                $version,
                '<major_version>.<minor_version>.<patch_version>'
            );
        }

        $majorVersion = $versionParts['major'];
        $minorVersion = $versionParts['minor'] ?? 0;
        $patchVersion = $versionParts['patch'] ?? 0;
        $version      = $majorVersion . '.' . $minorVersion . '.' . $patchVersion;

        switch (true) {
            case version_compare($version, '10.0', '>='):
                return new PostgreSQL100Platform();
            case version_compare($version, '9.4', '>='):
                return new PostgreSQL94Platform();
            case version_compare($version, '9.2', '>='):
                return new PostgreSQL92Platform();
            case version_compare($version, '9.1', '>='):
                return new PostgreSQL91Platform();
            default:
                return new PostgreSqlPlatform();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['dbname'] ?? $conn->query('SELECT CURRENT_DATABASE()')->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new PostgreSqlPlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new PostgreSqlSchemaManager($conn);
    }
}
