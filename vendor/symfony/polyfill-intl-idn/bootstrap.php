<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Polyfill\Intl\Idn as p;

if (!function_exists('idn_to_ascii')) {
    define('U_IDNA_PROHIBITED_ERROR', 66560);
    define('U_IDNA_ERROR_START', 66560);
    define('U_IDNA_UNASSIGNED_ERROR', 66561);
    define('U_IDNA_CHECK_BIDI_ERROR', 66562);
    define('U_IDNA_STD3_ASCII_RULES_ERROR', 66563);
    define('U_IDNA_ACE_PREFIX_ERROR', 66564);
    define('U_IDNA_VERIFICATION_ERROR', 66565);
    define('U_IDNA_LABEL_TOO_LONG_ERROR', 66566);
    define('U_IDNA_ZERO_LENGTH_LABEL_ERROR', 66567);
    define('U_IDNA_DOMAIN_NAME_TOO_LONG_ERROR', 66568);
    define('U_IDNA_ERROR_LIMIT', 66569);
    define('U_STRINGPREP_PROHIBITED_ERROR', 66560);
    define('U_STRINGPREP_UNASSIGNED_ERROR', 66561);
    define('U_STRINGPREP_CHECK_BIDI_ERROR', 66562);
    define('IDNA_DEFAULT', 0);
    define('IDNA_ALLOW_UNASSIGNED', 1);
    define('IDNA_USE_STD3_RULES', 2);
    define('IDNA_CHECK_BIDI', 4);
    define('IDNA_CHECK_CONTEXTJ', 8);
    define('IDNA_NONTRANSITIONAL_TO_ASCII', 16);
    define('IDNA_NONTRANSITIONAL_TO_UNICODE', 32);
    define('INTL_IDNA_VARIANT_2003', 0);
    define('INTL_IDNA_VARIANT_UTS46', 1);
    define('IDNA_ERROR_EMPTY_LABEL', 1);
    define('IDNA_ERROR_LABEL_TOO_LONG', 2);
    define('IDNA_ERROR_DOMAIN_NAME_TOO_LONG', 4);
    define('IDNA_ERROR_LEADING_HYPHEN', 8);
    define('IDNA_ERROR_TRAILING_HYPHEN', 16);
    define('IDNA_ERROR_HYPHEN_3_4', 32);
    define('IDNA_ERROR_LEADING_COMBINING_MARK', 64);
    define('IDNA_ERROR_DISALLOWED', 128);
    define('IDNA_ERROR_PUNYCODE', 256);
    define('IDNA_ERROR_LABEL_HAS_DOT', 512);
    define('IDNA_ERROR_INVALID_ACE_LABEL', 1024);
    define('IDNA_ERROR_BIDI', 2048);
    define('IDNA_ERROR_CONTEXTJ', 4096);

    if (PHP_VERSION_ID < 70400) {
        function idn_to_ascii($domain, $options = IDNA_DEFAULT, $variant = INTL_IDNA_VARIANT_2003, &$idna_info = array()) { return p\Idn::idn_to_ascii($domain, $options, $variant, $idna_info); }
        function idn_to_utf8($domain, $options = IDNA_DEFAULT, $variant = INTL_IDNA_VARIANT_2003, &$idna_info = array()) { return p\Idn::idn_to_utf8($domain, $options, $variant, $idna_info); }
    } else {
        function idn_to_ascii($domain, $options = IDNA_DEFAULT, $variant = INTL_IDNA_VARIANT_UTS46, &$idna_info = array()) { return p\Idn::idn_to_ascii($domain, $options, $variant, $idna_info); }
        function idn_to_utf8($domain, $options = IDNA_DEFAULT, $variant = INTL_IDNA_VARIANT_UTS46, &$idna_info = array()) { return p\Idn::idn_to_utf8($domain, $options, $variant, $idna_info); }
    }
}
