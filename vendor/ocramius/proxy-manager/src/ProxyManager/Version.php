<?php

declare(strict_types=1);

namespace ProxyManager;

use PackageVersions\Versions;

/**
 * Version class - to be adjusted when a new release is created.
 *
 * Note that we cannot check the version at runtime via `git` because that would cause a lot of I/O operations.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
final class Version
{
    /**
     * Private constructor - this class is not meant to be instantiated
     */
    private function __construct()
    {
    }

    /**
     * Retrieves the package version in the format <detected-version>@<commit-hash>,
     * where the detected version is what composer could detect.
     *
     * @return string
     *
     * @throws \OutOfBoundsException
     */
    public static function getVersion() : string
    {
        return Versions::getVersion('ocramius/proxy-manager');
    }
}
