<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Intl\Globals\IntlGlobals;

if (!function_exists('intl_is_failure')) {
    function intl_is_failure($errorCode) { return IntlGlobals::isFailure($errorCode); }
    function intl_get_error_code() { return IntlGlobals::getErrorCode(); }
    function intl_get_error_message() { return IntlGlobals::getErrorMessage(); }
    function intl_error_name($errorCode) { return IntlGlobals::getErrorName($errorCode); }
}
