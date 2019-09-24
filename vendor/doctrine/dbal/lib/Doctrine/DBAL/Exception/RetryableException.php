<?php

namespace Doctrine\DBAL\Exception;

/**
 * Marker interface for all exceptions where retrying the transaction makes sense.
 */
interface RetryableException
{
}
