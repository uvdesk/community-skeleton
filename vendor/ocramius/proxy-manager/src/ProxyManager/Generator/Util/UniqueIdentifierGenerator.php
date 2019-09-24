<?php

declare(strict_types=1);

namespace ProxyManager\Generator\Util;

/**
 * Utility class capable of generating unique
 * valid class/property/method identifiers
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
abstract class UniqueIdentifierGenerator
{
    const VALID_IDENTIFIER_FORMAT = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/';
    const DEFAULT_IDENTIFIER = 'g';

    /**
     * Generates a valid unique identifier from the given name
     */
    public static function getIdentifier(string $name) : string
    {
        return str_replace(
            '.',
            '',
            uniqid(
                preg_match(static::VALID_IDENTIFIER_FORMAT, $name)
                ? $name
                : static::DEFAULT_IDENTIFIER,
                true
            )
        );
    }
}
