<?php

namespace Doctrine\DBAL\Exception;

use Doctrine\DBAL\DBALException;
use Exception;

/**
 * Base class for all errors detected in the driver.
 */
class DriverException extends DBALException
{
    /**
     * The previous DBAL driver exception.
     *
     * @var \Doctrine\DBAL\Driver\DriverException
     */
    private $driverException;

    /**
     * @param string                                $message         The exception message.
     * @param \Doctrine\DBAL\Driver\DriverException $driverException The DBAL driver exception to chain.
     */
    public function __construct($message, \Doctrine\DBAL\Driver\DriverException $driverException)
    {
        $exception = null;

        if ($driverException instanceof Exception) {
            $exception = $driverException;
        }

        parent::__construct($message, 0, $exception);

        $this->driverException = $driverException;
    }

    /**
     * Returns the driver specific error code if given.
     *
     * Returns null if no error code was given by the driver.
     *
     * @return int|string|null
     */
    public function getErrorCode()
    {
        return $this->driverException->getErrorCode();
    }

    /**
     * Returns the SQLSTATE the driver was in at the time the error occurred, if given.
     *
     * Returns null if no SQLSTATE was given by the driver.
     *
     * @return string|null
     */
    public function getSQLState()
    {
        return $this->driverException->getSQLState();
    }
}
