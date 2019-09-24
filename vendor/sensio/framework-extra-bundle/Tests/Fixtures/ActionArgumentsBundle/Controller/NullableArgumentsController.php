<?php

namespace Tests\Fixtures\ActionArgumentsBundle\Controller;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nullable-arguments")
 */
class NullableArgumentsController
{
    /**
     * @Route("/invoke/")
     */
    public function __invoke(RequestInterface $request, MessageInterface $message, ServerRequestInterface $serverRequest)
    {
        return new Response('<html><body>ok</body></html>');
    }

    /**
     * @Route("/with-default")
     */
    public function withDefaultAction(string $d = null)
    {
        return new Response(null === $d ? 'yes' : 'no');
    }

    /**
     * @Route("/without-default")
     */
    public function withoutDefaultAction(string $d)
    {
        return new Response(null === $d ? 'yes' : 'no');
    }

    /**
     * @Route("/nullable")
     */
    public function nullableAction(?string $d)
    {
        return new Response(null === $d ? 'yes' : 'no');
    }
}
