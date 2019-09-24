<?php

namespace Doctrine\Common\Persistence;

/**
 * Contract covering connection for a Doctrine persistence layer ManagerRegistry class to implement.
 */
interface ConnectionRegistry
{
    /**
     * Gets the default connection name.
     *
     * @return string The default connection name.
     */
    public function getDefaultConnectionName();

    /**
     * Gets the named connection.
     *
     * @param string $name The connection name (null for the default one).
     *
     * @return object
     */
    public function getConnection($name = null);

    /**
     * Gets an array of all registered connections.
     *
     * @return object[] An array of Connection instances.
     */
    public function getConnections();

    /**
     * Gets all connection names.
     *
     * @return string[] An array of connection names.
     */
    public function getConnectionNames();
}
