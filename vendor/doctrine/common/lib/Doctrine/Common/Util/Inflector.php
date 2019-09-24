<?php
namespace Doctrine\Common\Util;

use Doctrine\Common\Inflector\Inflector as BaseInflector;
use function trigger_error;
use const E_USER_DEPRECATED;

@trigger_error(Inflector::class . ' is deprecated.', E_USER_DEPRECATED);

/**
 * Doctrine inflector has static methods for inflecting text.
 *
 * Kept for backwards compatibility reasons, was moved to its own component.
 *
 * @deprecated The Inflector class is deprecated, use Doctrine\Common\Inflector\Inflector from doctrine/inflector package instead,
 */
class Inflector extends BaseInflector
{
}
