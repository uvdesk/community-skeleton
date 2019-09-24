<?php

declare(strict_types=1);

namespace ProxyManager\Generator\Util;

use PackageVersions\Versions;

/**
 * Utility class capable of generating
 * valid class/property/method identifiers
 * with a deterministic attached suffix,
 * in order to prevent property name collisions
 * and tampering from userland
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
abstract class IdentifierSuffixer
{
    const VALID_IDENTIFIER_FORMAT = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/';
    const DEFAULT_IDENTIFIER = 'g';

    final private function __construct()
    {
    }

    /**
     * Generates a valid unique identifier from the given name,
     * with a suffix attached to it
     */
    public static function getIdentifier(string $name) : string
    {
        static $salt;

        $salt   = $salt ?? $salt = self::loadBaseHashSalt();
        $suffix = \substr(\sha1($name . $salt), 0, 5);

        if (! preg_match(self::VALID_IDENTIFIER_FORMAT, $name)) {
            return self::DEFAULT_IDENTIFIER . $suffix;
        }

        return $name . $suffix;
    }

    private static function loadBaseHashSalt() : string
    {
        return \sha1(\serialize(Versions::VERSIONS));
    }
}
