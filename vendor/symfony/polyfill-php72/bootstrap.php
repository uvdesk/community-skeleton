<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Polyfill\Php72 as p;

if (PHP_VERSION_ID < 70200) {
    if ('\\' === DIRECTORY_SEPARATOR && !function_exists('sapi_windows_vt100_support')) {
        function sapi_windows_vt100_support($stream, $enable = null) { return p\Php72::sapi_windows_vt100_support($stream, $enable); }
    }
    if (!function_exists('stream_isatty')) {
        function stream_isatty($stream) { return p\Php72::stream_isatty($stream); }
    }
    if (!function_exists('utf8_encode')) {
        function utf8_encode($s) { return p\Php72::utf8_encode($s); }
        function utf8_decode($s) { return p\Php72::utf8_decode($s); }
    }
    if (!function_exists('spl_object_id')) {
        function spl_object_id($s) { return p\Php72::spl_object_id($s); }
    }
    if (!defined('PHP_OS_FAMILY')) {
        define('PHP_OS_FAMILY', p\Php72::php_os_family());
    }
    if (!function_exists('mb_chr')) {
        function mb_ord($s, $enc = null) { return p\Php72::mb_ord($s, $enc); }
        function mb_chr($code, $enc = null) { return p\Php72::mb_chr($code, $enc); }
        function mb_scrub($s, $enc = null) { $enc = null === $enc ? mb_internal_encoding() : $enc; return mb_convert_encoding($s, $enc, $enc); }
    }
}
