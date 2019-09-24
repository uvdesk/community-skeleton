<?php

declare(strict_types=1);

namespace ProxyManager\Factory\RemoteObject;

/**
 * Remote Object adapter interface
 *
 * @author Vincent Blanchon <blanchon.vincent@gmail.com>
 * @license MIT
 */
interface AdapterInterface
{
    /**
     * Call remote object
     *
     * @param string $wrappedClass
     * @param string $method
     * @param array  $params
     */
    public function call(string $wrappedClass, string $method, array $params = []);
}
