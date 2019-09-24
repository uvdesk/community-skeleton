<?php

namespace PhpMimeMailParser;

use PhpMimeMailParser\Contracts\MiddleWare;

/**
 * A stack of middleware chained together by (MiddlewareStack $next)
 */
class MiddlewareStack
{
    /**
     * Next MiddlewareStack in chain
     *
     * @var MiddlewareStack
     */
    protected $next;

    /**
     * Middleware in this MiddlewareStack
     *
     * @var Middleware
     */
    protected $middleware;

    /**
     * Construct the first middleware in this MiddlewareStack
     * The next middleware is chained through $MiddlewareStack->add($Middleware)
     *
     * @param Middleware $middleware
     */
    public function __construct(Middleware $middleware = null)
    {
        $this->middleware = $middleware;
    }

    /**
     * Creates a chained middleware in MiddlewareStack
     *
     * @param Middleware $middleware
     * @return MiddlewareStack Immutable MiddlewareStack
     */
    public function add(Middleware $middleware)
    {
        $stack = new static($middleware);
        $stack->next = $this;
        return $stack;
    }

    /**
     * Parses the MimePart by passing it through the Middleware
     * @param MimePart $part
     * @return MimePart
     */
    public function parse(MimePart $part)
    {
        if (!$this->middleware) {
            return $part;
        }
        $part = call_user_func(array($this->middleware, 'parse'), $part, $this->next);
        return $part;
    }

    /**
     * Creates a MiddlewareStack based on an array of middleware
     *
     * @param Middleware[] $middlewares
     * @return MiddlewareStack
     */
    public static function factory(array $middlewares = array())
    {
        $stack = new static;
        foreach ($middlewares as $middleware) {
            $stack = $stack->add($middleware);
        }
        return $stack;
    }

    /**
     * Allow calling MiddlewareStack instance directly to invoke parse()
     *
     * @param MimePart $part
     * @return MimePart
     */
    public function __invoke(MimePart $part)
    {
        return $this->parse($part);
    }
}
