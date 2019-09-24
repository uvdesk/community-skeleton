<?php

declare(strict_types=1);

namespace ProxyManager\Proxy;

/**
 * Access interceptor object marker
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface AccessInterceptorInterface extends ProxyInterface
{
    /**
     * Set or remove the prefix interceptor for a method
     *
     * @link https://github.com/Ocramius/ProxyManager/blob/master/docs/access-interceptor-value-holder.md
     *
     * A prefix interceptor should have a signature like following:
     *
     * <code>
     * $interceptor = function ($proxy, $instance, string $method, array $params, & $returnEarly) {};
     * </code>
     *
     * @param string        $methodName        name of the intercepted method
     * @param \Closure|null $prefixInterceptor interceptor closure or null to unset the currently active interceptor
     *
     * @return void
     */
    public function setMethodPrefixInterceptor(string $methodName, \Closure $prefixInterceptor = null);

    /**
     * Set or remove the suffix interceptor for a method
     *
     * @link https://github.com/Ocramius/ProxyManager/blob/master/docs/access-interceptor-value-holder.md
     *
     * A prefix interceptor should have a signature like following:
     *
     * <code>
     * $interceptor = function ($proxy, $instance, string $method, array $params, $returnValue, & $returnEarly) {};
     * </code>
     *
     * @param string        $methodName        name of the intercepted method
     * @param \Closure|null $suffixInterceptor interceptor closure or null to unset the currently active interceptor
     *
     * @return void
     */
    public function setMethodSuffixInterceptor(string $methodName, \Closure $suffixInterceptor = null);
}
