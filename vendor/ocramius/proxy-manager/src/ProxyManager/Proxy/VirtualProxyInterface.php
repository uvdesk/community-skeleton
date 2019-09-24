<?php

declare(strict_types=1);

namespace ProxyManager\Proxy;

/**
 * Virtual Proxy - a lazy initializing object wrapping around the proxied subject
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface VirtualProxyInterface extends LazyLoadingInterface, ValueHolderInterface
{
}
