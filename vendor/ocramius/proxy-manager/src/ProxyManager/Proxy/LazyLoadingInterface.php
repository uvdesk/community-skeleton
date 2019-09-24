<?php

declare(strict_types=1);

namespace ProxyManager\Proxy;

/**
 * Lazy loading object identifier
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface LazyLoadingInterface extends ProxyInterface
{
    /**
     * Set or unset the initializer for the proxy instance
     *
     * @link https://github.com/Ocramius/ProxyManager/blob/master/docs/lazy-loading-value-holder.md#lazy-initialization
     *
     * An initializer should have a signature like following:
     *
     * <code>
     * $initializer = function (& $wrappedObject, $proxy, string $method, array $parameters, & $initializer) {};
     * </code>
     *
     * @param \Closure|null $initializer
     *
     * @return mixed
     */
    public function setProxyInitializer(\Closure $initializer = null);

    /**
     * @return \Closure|null
     */
    public function getProxyInitializer();

    /**
     * Force initialization of the proxy
     *
     * @return bool true if the proxy could be initialized
     */
    public function initializeProxy() : bool;

    /**
     * Retrieves current initialization status of the proxy
     */
    public function isProxyInitialized() : bool;
}
