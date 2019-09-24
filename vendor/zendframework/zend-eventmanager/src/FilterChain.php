<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zend-eventmanager for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-eventmanager/blob/master/LICENSE.md
 */

namespace Zend\EventManager;

/**
 * FilterChain: intercepting filter manager
 */
class FilterChain implements Filter\FilterInterface
{
    /**
     * @var Filter\FilterIterator All filters
     */
    protected $filters;

    /**
     * Constructor
     *
     * Initializes Filter\FilterIterator in which filters will be aggregated
     */
    public function __construct()
    {
        $this->filters = new Filter\FilterIterator();
    }

    /**
     * Apply the filters
     *
     * Begins iteration of the filters.
     *
     * @param  mixed $context Object under observation
     * @param  mixed $argv Associative array of arguments
     * @return mixed
     */
    public function run($context, array $argv = [])
    {
        $chain = clone $this->getFilters();

        if ($chain->isEmpty()) {
            return;
        }

        $next = $chain->extract();

        return $next($context, $argv, $chain);
    }

    /**
     * Connect a filter to the chain
     *
     * @param  callable $callback PHP Callback
     * @param  int $priority Priority in the queue at which to execute;
     *     defaults to 1 (higher numbers == higher priority)
     * @return CallbackHandler (to allow later unsubscribe)
     * @throws Exception\InvalidCallbackException
     */
    public function attach(callable $callback, $priority = 1)
    {
        $this->filters->insert($callback, $priority);
        return $callback;
    }

    /**
     * Detach a filter from the chain
     *
     * @param  callable $filter
     * @return bool Returns true if filter found and unsubscribed; returns false otherwise
     */
    public function detach(callable $filter)
    {
        return $this->filters->remove($filter);
    }

    /**
     * Retrieve all filters
     *
     * @return Filter\FilterIterator
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Clear all filters
     *
     * @return void
     */
    public function clearFilters()
    {
        $this->filters = new Filter\FilterIterator();
    }

    /**
     * Return current responses
     *
     * Only available while the chain is still being iterated. Returns the
     * current ResponseCollection.
     *
     * @return null|ResponseCollection
     */
    public function getResponses()
    {
        return;
    }
}
