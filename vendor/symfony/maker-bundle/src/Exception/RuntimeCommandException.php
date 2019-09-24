<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Exception;

use Symfony\Component\Console\Exception\ExceptionInterface;

/**
 * An exception whose output is displayed as a clean error.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
final class RuntimeCommandException extends \RuntimeException implements ExceptionInterface
{
}
