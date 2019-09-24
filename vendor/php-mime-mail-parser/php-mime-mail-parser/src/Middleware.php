<?php

namespace PhpMimeMailParser;

/**
 * Wraps a callable as a Middleware
 */
class Middleware implements Contracts\Middleware
{
    /**
     * Create a middleware using a callable $fn
     *
     * @param callable $fn
     */
    public function __construct(callable $fn)
    {
        $this->parser = $fn;
    }

    /**
     * Process a mime part, optionally delegating parsing to the $next MiddlewareStack
     */
    public function parse(MimePart $part, MiddlewareStack $next)
    {
        return call_user_func($this->parser, $part, $next);
    }
}
