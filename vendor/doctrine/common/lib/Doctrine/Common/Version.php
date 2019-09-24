<?php
namespace Doctrine\Common;

/**
 * Class to store and retrieve the version of Doctrine.
 *
 * @link   www.doctrine-project.org
 * @since  2.0
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 *
 * @deprecated The Version class is deprecated, please refrain from checking the version of doctrine/common.
 */
class Version
{
    /**
     * Current Doctrine Version.
     */
    const VERSION = '2.10.0';

    /**
     * Compares a Doctrine version with the current one.
     *
     * @param string $version Doctrine version to compare.
     *
     * @return int -1 if older, 0 if it is the same, 1 if version passed as argument is newer.
     */
    public static function compare($version)
    {
        $currentVersion = str_replace(' ', '', strtolower(self::VERSION));
        $version        = str_replace(' ', '', $version);

        return version_compare($version, $currentVersion);
    }
}
