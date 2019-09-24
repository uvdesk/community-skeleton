<?php

namespace Doctrine\DBAL;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Driver\DrizzlePDOMySql\Driver as DrizzlePDOMySQLDriver;
use Doctrine\DBAL\Driver\IBMDB2\DB2Driver;
use Doctrine\DBAL\Driver\Mysqli\Driver as MySQLiDriver;
use Doctrine\DBAL\Driver\OCI8\Driver as OCI8Driver;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySQLDriver;
use Doctrine\DBAL\Driver\PDOOracle\Driver as PDOOCIDriver;
use Doctrine\DBAL\Driver\PDOPgSql\Driver as PDOPgSQLDriver;
use Doctrine\DBAL\Driver\PDOSqlite\Driver as PDOSQLiteDriver;
use Doctrine\DBAL\Driver\PDOSqlsrv\Driver as PDOSQLSrvDriver;
use Doctrine\DBAL\Driver\SQLAnywhere\Driver as SQLAnywhereDriver;
use Doctrine\DBAL\Driver\SQLSrv\Driver as SQLSrvDriver;
use PDO;
use function array_keys;
use function array_map;
use function array_merge;
use function class_implements;
use function in_array;
use function is_subclass_of;
use function parse_str;
use function parse_url;
use function preg_replace;
use function str_replace;
use function strpos;
use function substr;

/**
 * Factory for creating Doctrine\DBAL\Connection instances.
 */
final class DriverManager
{
    /**
     * List of supported drivers and their mappings to the driver classes.
     *
     * To add your own driver use the 'driverClass' parameter to
     * {@link DriverManager::getConnection()}.
     *
     * @var string[]
     */
    private static $_driverMap = [
        'pdo_mysql'          => PDOMySQLDriver::class,
        'pdo_sqlite'         => PDOSQLiteDriver::class,
        'pdo_pgsql'          => PDOPgSQLDriver::class,
        'pdo_oci'            => PDOOCIDriver::class,
        'oci8'               => OCI8Driver::class,
        'ibm_db2'            => DB2Driver::class,
        'pdo_sqlsrv'         => PDOSQLSrvDriver::class,
        'mysqli'             => MySQLiDriver::class,
        'drizzle_pdo_mysql'  => DrizzlePDOMySQLDriver::class,
        'sqlanywhere'        => SQLAnywhereDriver::class,
        'sqlsrv'             => SQLSrvDriver::class,
    ];

    /**
     * List of URL schemes from a database URL and their mappings to driver.
     *
     * @var string[]
     */
    private static $driverSchemeAliases = [
        'db2'        => 'ibm_db2',
        'mssql'      => 'pdo_sqlsrv',
        'mysql'      => 'pdo_mysql',
        'mysql2'     => 'pdo_mysql', // Amazon RDS, for some weird reason
        'postgres'   => 'pdo_pgsql',
        'postgresql' => 'pdo_pgsql',
        'pgsql'      => 'pdo_pgsql',
        'sqlite'     => 'pdo_sqlite',
        'sqlite3'    => 'pdo_sqlite',
    ];

    /**
     * Private constructor. This class cannot be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * Creates a connection object based on the specified parameters.
     * This method returns a Doctrine\DBAL\Connection which wraps the underlying
     * driver connection.
     *
     * $params must contain at least one of the following.
     *
     * Either 'driver' with one of the following values:
     *
     *     pdo_mysql
     *     pdo_sqlite
     *     pdo_pgsql
     *     pdo_oci (unstable)
     *     pdo_sqlsrv
     *     pdo_sqlsrv
     *     mysqli
     *     sqlanywhere
     *     sqlsrv
     *     ibm_db2 (unstable)
     *     drizzle_pdo_mysql
     *
     * OR 'driverClass' that contains the full class name (with namespace) of the
     * driver class to instantiate.
     *
     * Other (optional) parameters:
     *
     * <b>user (string)</b>:
     * The username to use when connecting.
     *
     * <b>password (string)</b>:
     * The password to use when connecting.
     *
     * <b>driverOptions (array)</b>:
     * Any additional driver-specific options for the driver. These are just passed
     * through to the driver.
     *
     * <b>pdo</b>:
     * You can pass an existing PDO instance through this parameter. The PDO
     * instance will be wrapped in a Doctrine\DBAL\Connection.
     *
     * <b>wrapperClass</b>:
     * You may specify a custom wrapper class through the 'wrapperClass'
     * parameter but this class MUST inherit from Doctrine\DBAL\Connection.
     *
     * <b>driverClass</b>:
     * The driver class to use.
     *
     * @param mixed[]            $params       The parameters.
     * @param Configuration|null $config       The configuration to use.
     * @param EventManager|null  $eventManager The event manager to use.
     *
     * @throws DBALException
     */
    public static function getConnection(
        array $params,
        ?Configuration $config = null,
        ?EventManager $eventManager = null
    ) : Connection {
        // create default config and event manager, if not set
        if (! $config) {
            $config = new Configuration();
        }
        if (! $eventManager) {
            $eventManager = new EventManager();
        }

        $params = self::parseDatabaseUrl($params);

        // URL support for MasterSlaveConnection
        if (isset($params['master'])) {
            $params['master'] = self::parseDatabaseUrl($params['master']);
        }

        if (isset($params['slaves'])) {
            foreach ($params['slaves'] as $key => $slaveParams) {
                $params['slaves'][$key] = self::parseDatabaseUrl($slaveParams);
            }
        }

        // URL support for PoolingShardConnection
        if (isset($params['global'])) {
            $params['global'] = self::parseDatabaseUrl($params['global']);
        }

        if (isset($params['shards'])) {
            foreach ($params['shards'] as $key => $shardParams) {
                $params['shards'][$key] = self::parseDatabaseUrl($shardParams);
            }
        }

        // check for existing pdo object
        if (isset($params['pdo']) && ! $params['pdo'] instanceof PDO) {
            throw DBALException::invalidPdoInstance();
        } elseif (isset($params['pdo'])) {
            $params['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $params['driver'] = 'pdo_' . $params['pdo']->getAttribute(PDO::ATTR_DRIVER_NAME);
        } else {
            self::_checkParams($params);
        }

        $className = $params['driverClass'] ?? self::$_driverMap[$params['driver']];

        $driver = new $className();

        $wrapperClass = Connection::class;
        if (isset($params['wrapperClass'])) {
            if (! is_subclass_of($params['wrapperClass'], $wrapperClass)) {
                throw DBALException::invalidWrapperClass($params['wrapperClass']);
            }

            $wrapperClass = $params['wrapperClass'];
        }

        return new $wrapperClass($params, $driver, $config, $eventManager);
    }

    /**
     * Returns the list of supported drivers.
     *
     * @return string[]
     */
    public static function getAvailableDrivers() : array
    {
        return array_keys(self::$_driverMap);
    }

    /**
     * Checks the list of parameters.
     *
     * @param mixed[] $params The list of parameters.
     *
     * @throws DBALException
     */
    private static function _checkParams(array $params) : void
    {
        // check existence of mandatory parameters

        // driver
        if (! isset($params['driver']) && ! isset($params['driverClass'])) {
            throw DBALException::driverRequired();
        }

        // check validity of parameters

        // driver
        if (isset($params['driver']) && ! isset(self::$_driverMap[$params['driver']])) {
            throw DBALException::unknownDriver($params['driver'], array_keys(self::$_driverMap));
        }

        if (isset($params['driverClass']) && ! in_array(Driver::class, class_implements($params['driverClass'], true))) {
            throw DBALException::invalidDriverClass($params['driverClass']);
        }
    }

    /**
     * Normalizes the given connection URL path.
     *
     * @return string The normalized connection URL path
     */
    private static function normalizeDatabaseUrlPath(string $urlPath) : string
    {
        // Trim leading slash from URL path.
        return substr($urlPath, 1);
    }

    /**
     * Extracts parts from a database URL, if present, and returns an
     * updated list of parameters.
     *
     * @param mixed[] $params The list of parameters.
     *
     * @return mixed[] A modified list of parameters with info from a database
     *                 URL extracted into indidivual parameter parts.
     *
     * @throws DBALException
     */
    private static function parseDatabaseUrl(array $params) : array
    {
        if (! isset($params['url'])) {
            return $params;
        }

        // (pdo_)?sqlite3?:///... => (pdo_)?sqlite3?://localhost/... or else the URL will be invalid
        $url = preg_replace('#^((?:pdo_)?sqlite3?):///#', '$1://localhost/', $params['url']);
        $url = parse_url($url);

        if ($url === false) {
            throw new DBALException('Malformed parameter "url".');
        }

        $url = array_map('rawurldecode', $url);

        // If we have a connection URL, we have to unset the default PDO instance connection parameter (if any)
        // as we cannot merge connection details from the URL into the PDO instance (URL takes precedence).
        unset($params['pdo']);

        $params = self::parseDatabaseUrlScheme($url, $params);

        if (isset($url['host'])) {
            $params['host'] = $url['host'];
        }
        if (isset($url['port'])) {
            $params['port'] = $url['port'];
        }
        if (isset($url['user'])) {
            $params['user'] = $url['user'];
        }
        if (isset($url['pass'])) {
            $params['password'] = $url['pass'];
        }

        $params = self::parseDatabaseUrlPath($url, $params);
        $params = self::parseDatabaseUrlQuery($url, $params);

        return $params;
    }

    /**
     * Parses the given connection URL and resolves the given connection parameters.
     *
     * Assumes that the connection URL scheme is already parsed and resolved into the given connection parameters
     * via {@link parseDatabaseUrlScheme}.
     *
     * @see parseDatabaseUrlScheme
     *
     * @param mixed[] $url    The URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     */
    private static function parseDatabaseUrlPath(array $url, array $params) : array
    {
        if (! isset($url['path'])) {
            return $params;
        }

        $url['path'] = self::normalizeDatabaseUrlPath($url['path']);

        // If we do not have a known DBAL driver, we do not know any connection URL path semantics to evaluate
        // and therefore treat the path as regular DBAL connection URL path.
        if (! isset($params['driver'])) {
            return self::parseRegularDatabaseUrlPath($url, $params);
        }

        if (strpos($params['driver'], 'sqlite') !== false) {
            return self::parseSqliteDatabaseUrlPath($url, $params);
        }

        return self::parseRegularDatabaseUrlPath($url, $params);
    }

    /**
     * Parses the query part of the given connection URL and resolves the given connection parameters.
     *
     * @param mixed[] $url    The connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     */
    private static function parseDatabaseUrlQuery(array $url, array $params) : array
    {
        if (! isset($url['query'])) {
            return $params;
        }

        $query = [];

        parse_str($url['query'], $query); // simply ingest query as extra params, e.g. charset or sslmode

        return array_merge($params, $query); // parse_str wipes existing array elements
    }

    /**
     * Parses the given regular connection URL and resolves the given connection parameters.
     *
     * Assumes that the "path" URL part is already normalized via {@link normalizeDatabaseUrlPath}.
     *
     * @see normalizeDatabaseUrlPath
     *
     * @param mixed[] $url    The regular connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     */
    private static function parseRegularDatabaseUrlPath(array $url, array $params) : array
    {
        $params['dbname'] = $url['path'];

        return $params;
    }

    /**
     * Parses the given SQLite connection URL and resolves the given connection parameters.
     *
     * Assumes that the "path" URL part is already normalized via {@link normalizeDatabaseUrlPath}.
     *
     * @see normalizeDatabaseUrlPath
     *
     * @param mixed[] $url    The SQLite connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     */
    private static function parseSqliteDatabaseUrlPath(array $url, array $params) : array
    {
        if ($url['path'] === ':memory:') {
            $params['memory'] = true;

            return $params;
        }

        $params['path'] = $url['path']; // pdo_sqlite driver uses 'path' instead of 'dbname' key

        return $params;
    }

    /**
     * Parses the scheme part from given connection URL and resolves the given connection parameters.
     *
     * @param mixed[] $url    The connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     *
     * @throws DBALException If parsing failed or resolution is not possible.
     */
    private static function parseDatabaseUrlScheme(array $url, array $params) : array
    {
        if (isset($url['scheme'])) {
            // The requested driver from the URL scheme takes precedence
            // over the default custom driver from the connection parameters (if any).
            unset($params['driverClass']);

            // URL schemes must not contain underscores, but dashes are ok
            $driver = str_replace('-', '_', $url['scheme']);

            // The requested driver from the URL scheme takes precedence over the
            // default driver from the connection parameters. If the driver is
            // an alias (e.g. "postgres"), map it to the actual name ("pdo-pgsql").
            // Otherwise, let checkParams decide later if the driver exists.
            $params['driver'] = self::$driverSchemeAliases[$driver] ?? $driver;

            return $params;
        }

        // If a schemeless connection URL is given, we require a default driver or default custom driver
        // as connection parameter.
        if (! isset($params['driverClass']) && ! isset($params['driver'])) {
            throw DBALException::driverRequired($params['url']);
        }

        return $params;
    }
}
