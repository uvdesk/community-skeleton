<?php

declare(strict_types=1);

namespace ProxyManager\Inflector\Util;

/**
 * Encodes parameters into a class-name safe string
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class ParameterEncoder
{
    /**
     * Converts the given parameters into a set of characters that are safe to
     * use in a class name
     */
    public function encodeParameters(array $parameters) : string
    {
        return base64_encode(serialize($parameters));
    }
}
