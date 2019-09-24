<?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\SQLAnywhere11Platform;
use Doctrine\DBAL\Platforms\SQLAnywhere12Platform;
use Doctrine\DBAL\Platforms\SQLAnywhere16Platform;
use Doctrine\DBAL\Platforms\SQLAnywherePlatform;
use Doctrine\DBAL\Schema\SQLAnywhereSchemaManager;
use Doctrine\DBAL\VersionAwarePlatformDriver;
use function preg_match;
use function version_compare;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for SAP Sybase SQL Anywhere based drivers.
 */
abstract class AbstractSQLAnywhereDriver implements Driver, ExceptionConverterDriver, VersionAwarePlatformDriver
{
    /**
     * {@inheritdoc}
     *
     * @link http://dcx.sybase.com/index.html#sa160/en/saerrors/sqlerror.html
     */
    public function convertException($message, DriverException $exception)
    {
        switch ($exception->getErrorCode()) {
            case '-306':
            case '-307':
            case '-684':
                return new Exception\DeadlockException($message, $exception);
            case '-210':
            case '-1175':
            case '-1281':
                return new Exception\LockWaitTimeoutException($message, $exception);
            case '-100':
            case '-103':
            case '-832':
                return new Exception\ConnectionException($message, $exception);
            case '-143':
                return new Exception\InvalidFieldNameException($message, $exception);
            case '-193':
            case '-196':
                return new Exception\UniqueConstraintViolationException($message, $exception);
            case '-194':
            case '-198':
                return new Exception\ForeignKeyConstraintViolationException($message, $exception);
            case '-144':
                return new Exception\NonUniqueFieldNameException($message, $exception);
            case '-184':
            case '-195':
                return new Exception\NotNullConstraintViolationException($message, $exception);
            case '-131':
                return new Exception\SyntaxErrorException($message, $exception);
            case '-110':
                return new Exception\TableExistsException($message, $exception);
            case '-141':
            case '-1041':
                return new Exception\TableNotFoundException($message, $exception);
        }

        return new Exception\DriverException($message, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function createDatabasePlatformForVersion($version)
    {
        if (! preg_match(
            '/^(?P<major>\d+)(?:\.(?P<minor>\d+)(?:\.(?P<patch>\d+)(?:\.(?P<build>\d+))?)?)?/',
            $version,
            $versionParts
        )) {
            throw DBALException::invalidPlatformVersionSpecified(
                $version,
                '<major_version>.<minor_version>.<patch_version>.<build_version>'
            );
        }

        $majorVersion = $versionParts['major'];
        $minorVersion = $versionParts['minor'] ?? 0;
        $patchVersion = $versionParts['patch'] ?? 0;
        $buildVersion = $versionParts['build'] ?? 0;
        $version      = $majorVersion . '.' . $minorVersion . '.' . $patchVersion . '.' . $buildVersion;

        switch (true) {
            case version_compare($version, '16', '>='):
                return new SQLAnywhere16Platform();
            case version_compare($version, '12', '>='):
                return new SQLAnywhere12Platform();
            case version_compare($version, '11', '>='):
                return new SQLAnywhere11Platform();
            default:
                return new SQLAnywherePlatform();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['dbname'] ?? $conn->query('SELECT DB_NAME()')->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new SQLAnywhere12Platform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new SQLAnywhereSchemaManager($conn);
    }
}
