<?php
namespace Doctrine\Common\Proxy;

use Closure;
use Doctrine\Common\Persistence\Proxy as BaseProxy;

/**
 * Interface for proxy classes.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @author Marco Pivetta  <ocramius@gmail.com>
 * @since  2.4
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
interface Proxy extends BaseProxy
{
    /**
     * Marks the proxy as initialized or not.
     *
     * @param boolean $initialized
     *
     * @return void
     */
    public function __setInitialized($initialized);

    /**
     * Sets the initializer callback to be used when initializing the proxy. That
     * initializer should accept 3 parameters: $proxy, $method and $params. Those
     * are respectively the proxy object that is being initialized, the method name
     * that triggered initialization and the parameters passed to that method.
     *
     * @param Closure|null $initializer
     *
     * @return void
     */
    public function __setInitializer(Closure $initializer = null);

    /**
     * Retrieves the initializer callback used to initialize the proxy.
     *
     * @see __setInitializer
     *
     * @return Closure|null
     */
    public function __getInitializer();

    /**
     * Sets the callback to be used when cloning the proxy. That initializer should accept
     * a single parameter, which is the cloned proxy instance itself.
     *
     * @param Closure|null $cloner
     *
     * @return void
     */
    public function __setCloner(Closure $cloner = null);

    /**
     * Retrieves the callback to be used when cloning the proxy.
     *
     * @see __setCloner
     *
     * @return Closure|null
     */
    public function __getCloner();

    /**
     * Retrieves the list of lazy loaded properties for a given proxy
     *
     * @return array Keys are the property names, and values are the default values
     *               for those properties.
     */
    public function __getLazyProperties();
}
