<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

/**
 * The ParameterFormatterInterface defines the interface for formatting SQL query parameters to a string
 * for display output.
 *
 * @internal
 *
 * @see Doctrine\Migrations\ParameterFormatter
 */
interface ParameterFormatterInterface
{
    /**
     * @param mixed[] $params
     * @param mixed[] $types
     */
    public function formatParameters(array $params, array $types) : string;
}
