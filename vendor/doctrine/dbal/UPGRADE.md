# Upgrade to 2.9

## Deprecated `Statement::fetchColumn()` with an invalid index

Calls to `Statement::fetchColumn()` with an invalid column index currently return `NULL`. In the future, such calls will result in a exception.

## Deprecated `Configuration::getFilterSchemaAssetsExpression()`, `::setFilterSchemaAssetsExpression()` and `AbstractSchemaManager::getFilterSchemaAssetsExpression()`.

Regular expression-based filters are hard to extend by combining together. Instead, you may use callback-based filers via `::getSchemaAssetsFilter()` and `::getSchemaAssetsFilter()`. Callbacks can use regular expressions internally.

## Deprecated `Doctrine\DBAL\Types\Type::getDefaultLength()`

This method was never used by DBAL internally. It is now deprecated and will be removed in DBAL 3.0.

## Deprecated `Doctrine\DBAL\Types\Type::__toString()`

Relying on string representation is discouraged and will be removed in DBAL 3.0.

## Deprecated `NULL` value of `$offset` in LIMIT queries

The `NULL` value of the `$offset` argument in `AbstractPlatform::(do)?ModifyLimitQuery()` methods is deprecated. If explicitly used in the method call, the absence of the offset should be indicated with a `0`.

## Deprecated dbal:import CLI command

The `dbal:import` CLI command has been deprecated since it only works with PDO-based drivers by relying on a non-documented behavior of the extension, and it's impossible to make it work with other drivers.
Please use other database client applications for import, e.g.:

 * For MySQL and MariaDB: `mysql [dbname] < data.sql`.
 * For PostgreSQL: `psql [dbname] < data.sql`.
 * For SQLite: `sqlite3 /path/to/file.db < data.sql`.

# Upgrade to 2.8

## Deprecated usage of DB-generated UUIDs

The format of DB-generated UUIDs is inconsistent across supported platforms and therefore is not portable. Some of the platforms produce UUIDv1, some produce UUIDv4, some produce the values which are not even UUID.

Unless UUIDs are used in stored procedures which DBAL doesn't support, there's no real benefit of DB-generated UUIDs comparing to the application-generated ones.

Use a PHP library (e.g. [ramsey/uuid](https://packagist.org/packages/ramsey/uuid)) to generate UUIDs on the application side.

## Deprecated usage of binary fields whose length exceeds the platform maximum

- The usage of binary fields whose length exceeds the maximum field size on a given platform is deprecated.
  Use binary fields of a size which fits all target platforms, or use blob explicitly instead.

## Removed dependency on doctrine/common

The dependency on doctrine/common package has been removed.
DBAL now depends on doctrine/cache and doctrine/event-manager instead.
If you are using any other component from doctrine/common package,
you will have to add an explicit dependency to your composer.json.

## Corrected exception thrown by ``Doctrine\DBAL\Platforms\SQLAnywhere16Platform::getAdvancedIndexOptionsSQL()``

This method now throws SPL ``UnexpectedValueException`` instead of accidentally throwing ``Doctrine\Common\Proxy\Exception\UnexpectedValueException``.

# Upgrade to 2.7

## Doctrine\DBAL\Platforms\AbstractPlatform::DATE_INTERVAL_UNIT_* constants deprecated

``Doctrine\DBAL\Platforms\AbstractPlatform::DATE_INTERVAL_UNIT_*`` constants were moved into ``Doctrine\DBAL\Platforms\DateIntervalUnit`` class without the ``DATE_INTERVAL_UNIT_`` prefix.

## Doctrine\DBAL\Platforms\AbstractPlatform::TRIM_* constants deprecated

``Doctrine\DBAL\Platforms\AbstractPlatform::TRIM_*`` constants were moved into ``Doctrine\DBAL\Platforms\TrimMode`` class without the ``TRIM_`` prefix.

## Doctrine\DBAL\Connection::TRANSACTION_* constants deprecated

``Doctrine\DBAL\Connection::TRANSACTION_*`` were moved into ``Doctrine\DBAL\TransactionIsolationLevel`` class without the ``TRANSACTION_`` prefix. 

## DEPRECATION: direct usage of the PDO APIs in the DBAL API

1. When calling `Doctrine\DBAL\Driver\Statement` methods, instead of `PDO::PARAM_*` constants, `Doctrine\DBAL\ParameterType` constants should be used.
2. When calling `Doctrine\DBAL\Driver\ResultStatement` methods, instead of `PDO::FETCH_*` constants, `Doctrine\DBAL\FetchMode` constants should be used.
3. When configuring `Doctrine\DBAL\Portability\Connection`, instead of `PDO::CASE_*` constants, `Doctrine\DBAL\ColumnCase` constants should be used.
4. Usage of `PDO::PARAM_INPUT_OUTPUT` in `Doctrine\DBAL\Driver\Statement::bindValue()` is deprecated.
5. Usage of `PDO::FETCH_FUNC` in `Doctrine\DBAL\Driver\ResultStatement::fetch()` is deprecated.
6. Calls to `\PDOStatement` methods on a `\Doctrine\DBAL\Driver\PDOStatement` instance (e.g. `fetchObject()`) are deprecated.

# Upgrade to 2.6

## MINOR BC BREAK: `fetch()` and `fetchAll()` method signatures in `Doctrine\DBAL\Driver\ResultStatement`

1. ``Doctrine\DBAL\Driver\ResultStatement::fetch()`` now has 3 arguments instead of 1, respecting
``PDO::fetch()`` signature.

Before:

    Doctrine\DBAL\Driver\ResultStatement::fetch($fetchMode);

After:

    Doctrine\DBAL\Driver\ResultStatement::fetch($fetchMode, $cursorOrientation, $cursorOffset);

2. ``Doctrine\DBAL\Driver\ResultStatement::fetchAll()`` now has 3 arguments instead of 1, respecting
``PDO::fetchAll()`` signature.

Before:

    Doctrine\DBAL\Driver\ResultStatement::fetchAll($fetchMode);

After:

    Doctrine\DBAL\Driver\ResultStatement::fetch($fetchMode, $fetchArgument, $ctorArgs);


## MINOR BC BREAK: URL-style DSN with percentage sign in password

URL-style DSNs (e.g. ``mysql://foo@bar:localhost/db``) are now assumed to be percent-encoded
in order to allow certain special characters in usernames, paswords and database names. If
you are using a URL-style DSN and have a username, password or database name containing a
percentage sign, you need to update your DSN. If your password is, say, ``foo%foo``, it
should be encoded as ``foo%25foo``.

# Upgrade to 2.5.1

## MINOR BC BREAK: Doctrine\DBAL\Schema\Table

When adding indexes to ``Doctrine\DBAL\Schema\Table`` via ``addIndex()`` or ``addUniqueIndex()``,
duplicate indexes are not silently ignored/dropped anymore (based on semantics, not naming!).
Duplicate indexes are considered indexes that pass ``isFullfilledBy()`` or ``overrules()``
in ``Doctrine\DBAL\Schema\Index``.
This is required to make the index renaming feature introduced in 2.5.0 work properly and avoid
issues in the ORM schema tool / DBAL schema manager which pretends users from updating
their schemas and migrate to DBAL 2.5.*.
Additionally it offers more flexibility in declaring indexes for the user and potentially fixes
related issues in the ORM.
With this change, the responsibility to decide which index is a "duplicate" is completely deferred
to the user.
Please also note that adding foreign key constraints to a table via ``addForeignKeyConstraint()``,
``addUnnamedForeignKeyConstraint()`` or ``addNamedForeignKeyConstraint()`` now first checks if an
appropriate index is already present and avoids adding an additional auto-generated one eventually.

# Upgrade to 2.5

## BC BREAK: time type resets date fields to UNIX epoch

When mapping `time` type field to PHP's `DateTime` instance all unused date fields are
reset to UNIX epoch (i.e. 1970-01-01). This might break any logic which relies on comparing
`DateTime` instances with date fields set to the current date.

Use `!` format prefix (see http://php.net/manual/en/datetime.createfromformat.php) for parsing
time strings to prevent having different date fields when comparing user input and `DateTime`
instances as mapped by Doctrine.

## BC BREAK: Doctrine\DBAL\Schema\Table

The methods ``addIndex()`` and ``addUniqueIndex()`` in ``Doctrine\DBAL\Schema\Table``
have an additional, optional parameter. If you override these methods, you should
add this new parameter to the declaration of your overridden methods.

## BC BREAK: Doctrine\DBAL\Connection

The visibility of the property ``$_platform`` in ``Doctrine\DBAL\Connection``
was changed from protected to private. If you have subclassed ``Doctrine\DBAL\Connection``
in your application and accessed ``$_platform`` directly, you have to change the code
portions to use ``getDatabasePlatform()`` instead to retrieve the underlying database
platform.
The reason for this change is the new automatic platform version detection feature,
which lazily evaluates the appropriate platform class to use for the underlying database
server version at runtime.
Please also note, that calling ``getDatabasePlatform()`` now needs to establish a connection
in order to evaluate the appropriate platform class if ``Doctrine\DBAL\Connection`` is not
already connected. Under the following circumstances, it is not possible anymore to retrieve
the platform instance from the connection object without having to do a real connect:

1. ``Doctrine\DBAL\Connection`` was instantiated without the ``platform`` connection parameter.
2. ``Doctrine\DBAL\Connection`` was instantiated without the ``serverVersion`` connection parameter.
3. The underlying driver is "version aware" and can provide different platform instances
   for different versions.
4. The underlying driver connection is "version aware" and can provide the database server
   version without having to query for it.

If one of the above conditions is NOT met, there is no need for ``Doctrine\DBAL\Connection``
to do a connect when calling ``getDatabasePlatform()``.

## datetime Type uses date_create() as fallback

Before 2.5 the DateTime type always required a specific format, defined in
`$platform->getDateTimeFormatString()`, which could cause quite some troubles
on platforms that had various microtime precision formats. Starting with 2.5
whenever the parsing of a date fails with the predefined platform format,
the `date_create()` function will be used to parse the date.

This could cause some troubles when your date format is weird and not parsed
correctly by `date_create`, however since databases are rather strict on dates
there should be no problem.

## Support for pdo_ibm driver removed

The ``pdo_ibm`` driver is buggy and does not work well with Doctrine. Therefore it will no
longer be supported and has been removed from the ``Doctrine\DBAL\DriverManager`` drivers
map. It is highly encouraged to to use `ibm_db2` driver instead if you want to connect
to an IBM DB2 database as it is much more stable and secure.

If for some reason you have to utilize the ``pdo_ibm`` driver you can still use the `driverClass`
connection parameter to explicitly specify the ``Doctrine\DBAL\Driver\PDOIbm\Driver`` class.
However be aware that you are doing this at your own risk and it will not be guaranteed that
Doctrine will work as expected.

# Upgrade to 2.4

## Doctrine\DBAL\Schema\Constraint

If you have custom classes that implement the constraint interface, you have to implement
an additional method ``getQuotedColumns`` now. This method is used to build proper constraint
SQL for columns that need to be quoted, like keywords reserved by the specific platform used.
The method has to return the same values as ``getColumns`` only that those column names that
need quotation have to be returned quoted for the given platform.

# Upgrade to 2.3

## Oracle Session Init now sets Numeric Character

Before 2.3 the Oracle Session Init did not care about the numeric character of the Session.
This could lead to problems on non english locale systems that required a comma as a floating
point seperator in Oracle. Since 2.3, using the Oracle Session Init on connection start the
client session will be altered to set the numeric character to ".,":

    ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,'

See [DBAL-345](http://www.doctrine-project.org/jira/browse/DBAL-345) for more details.

## Doctrine\DBAL\Connection and Doctrine\DBAL\Statement

The query related methods including but not limited to executeQuery, exec, query, and executeUpdate
now wrap the driver exceptions such as PDOException with DBALException to add more debugging
information such as the executed SQL statement, and any bound parameters.

If you want to retrieve the driver specific exception, you can retrieve it by calling the
``getPrevious()`` method on DBALException.

Before:

    catch(\PDOException $ex) {
        // ...
    }

After:

    catch(\Doctrine\DBAL\DBALException $ex) {
        $pdoException = $ex->getPrevious();
        // ...
    }

## Doctrine\DBAL\Connection#setCharsetSQL() removed

This method only worked on MySQL and it is considered unsafe on MySQL to use SET NAMES UTF-8 instead
of setting the charset directly on connection already. Replace this behavior with the
connection charset option:

Before:

    $conn = DriverManager::getConnection(array(..));
    $conn->setCharset('UTF8');

After:

    $conn = DriverManager::getConnection(array('charset' => 'UTF8', ..));

## Doctrine\DBAL\Schema\Table#renameColumn() removed

Doctrine\DBAL\Schema\Table#renameColumn() was removed, because it drops and recreates
the column instead. There is no fix available, because a schema diff
cannot reliably detect if a column was renamed or one column was created
and another one dropped.

You should use explicit SQL ALTER TABLE statements to change columns names.

## Schema Filter paths

The Filter Schema assets expression is not wrapped in () anymore for the regexp automatically.

Before:

    $config->setFilterSchemaAssetsExpression('foo');

After:

    $config->setFilterSchemaAssetsExpression('(foo)');

## Creating MySQL Tables now defaults to UTF-8

If you are creating a new MySQL Table through the Doctrine API, charset/collate are
now set to 'utf8'/'utf8_unicode_ci' by default. Previously the MySQL server defaults were used.

# Upgrade to 2.2

## Doctrine\DBAL\Connection#insert and Doctrine\DBAL\Connection#update

Both methods now accept an optional last parameter $types with binding types of the values passed.
This can potentially break child classes that have overwritten one of these methods.

## Doctrine\DBAL\Connection#executeQuery

Doctrine\DBAL\Connection#executeQuery() got a new last parameter "QueryCacheProfile $qcp"

## Doctrine\DBAL\Driver\Statement split

The Driver statement was split into a ResultStatement and the normal statement extending from it.
This separates the configuration and the retrieval API from a statement.

## MsSql Platform/SchemaManager renamed

The MsSqlPlatform was renamed to SQLServerPlatform, the MsSqlSchemaManager was renamed
to SQLServerSchemaManager.

## Cleanup SQLServer Platform version mess

DBAL 2.1 and before were actually only compatible to SQL Server 2008, not earlier versions.
Still other parts of the platform did use old features instead of newly introduced datatypes
in SQL Server 2005. Starting with DBAL 2.2 you can pick the Doctrine abstraction exactly
matching your SQL Server version.

The PDO SqlSrv driver now uses the new `SQLServer2008Platform` as default platform.
This platform uses new features of SQL Server as of version 2008. This also includes a switch
in the used fields for "text" and "blob" field types to:

    "text" => "VARCHAR(MAX)"
    "blob" => "VARBINARY(MAX)"

Additionally `SQLServerPlatform` in DBAL 2.1 and before used "DATE", "TIME" and "DATETIME2" for dates.
This types are only available since version 2008 and the introduction of an explicit
SQLServer 2008 platform makes this dependency explicit.

An `SQLServer2005Platform` was also introduced to differentiate the features between
versions 2003, earlier and 2005.

With this change the `SQLServerPlatform` now throws an exception for using limit queries
with an offset, since SQLServer 2003 and lower do not support this feature.

To use the old SQL Server Platform, because you are using SQL Server 2003 and below use
the following configuration code:

    use Doctrine\DBAL\DriverManager;
    use Doctrine\DBAL\Platforms\SQLServerPlatform;
    use Doctrine\DBAL\Platforms\SQLServer2005Platform;

    // You are using SQL Server 2003 or earlier
    $conn = DriverManager::getConnection(array(
        'driver' => 'pdo_sqlsrv',
        'platform' => new SQLServerPlatform()
        // .. additional parameters
    ));

    // You are using SQL Server 2005
    $conn = DriverManager::getConnection(array(
        'driver' => 'pdo_sqlsrv',
        'platform' => new SQLServer2005Platform()
        // .. additional parameters
    ));

    // You are using SQL Server 2008
    $conn = DriverManager::getConnection(array(
        'driver' => 'pdo_sqlsrv',
        // 2008 is default platform
        // .. additional parameters
    ));
