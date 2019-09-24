<?php

namespace Doctrine\Bundle\DoctrineBundle;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use const E_USER_DEPRECATED;
use function get_class;
use function trigger_error;

class ConnectionFactory
{
    /** @var mixed[][] */
    private $typesConfig = [];

    /** @var bool */
    private $initialized = false;

    /**
     * @param mixed[][] $typesConfig
     */
    public function __construct(array $typesConfig)
    {
        $this->typesConfig = $typesConfig;
    }

    /**
     * Create a connection by name.
     *
     * @param mixed[]         $params
     * @param string[]|Type[] $mappingTypes
     *
     * @return Connection
     */
    public function createConnection(array $params, Configuration $config = null, EventManager $eventManager = null, array $mappingTypes = [])
    {
        if (! $this->initialized) {
            $this->initializeTypes();
        }

        $connection = DriverManager::getConnection($params, $config, $eventManager);

        if (! empty($mappingTypes)) {
            $platform = $this->getDatabasePlatform($connection);
            foreach ($mappingTypes as $dbType => $doctrineType) {
                $platform->registerDoctrineTypeMapping($dbType, $doctrineType);
            }
        }

        if (! empty($this->typesConfig)) {
            $this->markTypesCommented($this->getDatabasePlatform($connection));
        }

        return $connection;
    }

    /**
     * Try to get the database platform.
     *
     * This could fail if types should be registered to an predefined/unused connection
     * and the platform version is unknown.
     * For details have a look at DoctrineBundle issue #673.
     *
     * @return AbstractPlatform
     *
     * @throws DBALException
     */
    private function getDatabasePlatform(Connection $connection)
    {
        try {
            return $connection->getDatabasePlatform();
        } catch (DriverException $driverException) {
            throw new DBALException(
                'An exception occured while establishing a connection to figure out your platform version.' . PHP_EOL .
                "You can circumvent this by setting a 'server_version' configuration value" . PHP_EOL . PHP_EOL .
                'For further information have a look at:' . PHP_EOL .
                'https://github.com/doctrine/DoctrineBundle/issues/673',
                0,
                $driverException
            );
        }
    }

    /**
     * initialize the types
     */
    private function initializeTypes()
    {
        foreach ($this->typesConfig as $typeName => $typeConfig) {
            if (Type::hasType($typeName)) {
                Type::overrideType($typeName, $typeConfig['class']);
            } else {
                Type::addType($typeName, $typeConfig['class']);
            }
        }

        $this->initialized = true;
    }

    private function markTypesCommented(AbstractPlatform $platform) : void
    {
        foreach ($this->typesConfig as $typeName => $typeConfig) {
            $type                   = Type::getType($typeName);
            $requiresSQLCommentHint = $type->requiresSQLCommentHint($platform);

            // Attribute is missing, make sure a type that doesn't require a comment is marked as commented
            // This is deprecated behaviour that will be dropped in 2.0.
            if ($typeConfig['commented'] === null) {
                if (! $requiresSQLCommentHint) {
                    @trigger_error(
                        sprintf(
                            'The type "%s" was implicitly marked as commented due to the configuration. This is deprecated and will be removed in DoctrineBundle 2.0. Either set the "commented" attribute in the configuration to "false" or mark the type as commented in "%s::requiresSQLCommentHint()."',
                            $typeName,
                            get_class($type)
                        ),
                        E_USER_DEPRECATED
                    );

                    $platform->markDoctrineTypeCommented($type);
                }

                continue;
            }

            // The following logic generates appropriate deprecation notices telling the user how to update their type configuration.
            if ($typeConfig['commented']) {
                if (! $requiresSQLCommentHint) {
                    @trigger_error(
                        sprintf(
                            'The type "%s" was marked as commented in its configuration but not in the type itself. This is deprecated and will be removed in DoctrineBundle 2.0. Please update the return value of "%s::requiresSQLCommentHint()."',
                            $typeName,
                            get_class($type)
                        ),
                        E_USER_DEPRECATED
                    );

                    $platform->markDoctrineTypeCommented($type);

                    continue;
                }

                @trigger_error(
                    sprintf(
                        'The type "%s" was explicitly marked as commented in its configuration. This is no longer necessary and will be removed in DoctrineBundle 2.0. Please remove the "commented" attribute from the type configuration.',
                        $typeName
                    ),
                    E_USER_DEPRECATED
                );

                continue;
            }

            if (! $requiresSQLCommentHint) {
                continue;
            }

            @trigger_error(
                sprintf(
                    'The type "%s" was marked as uncommented in its configuration but commented in the type itself. This is deprecated and will be removed in DoctrineBundle 2.0. Please update the return value of "%s::requiresSQLCommentHint()" or remove the "commented" attribute from the type configuration.',
                    $typeName,
                    get_class($type)
                ),
                E_USER_DEPRECATED
            );
        }
    }
}
