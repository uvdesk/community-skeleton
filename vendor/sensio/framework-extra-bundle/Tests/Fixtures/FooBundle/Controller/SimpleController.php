<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures\FooBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleController
{
    /**
     * @Route("/simple/multiple/", defaults={"a": "a", "b": "b"})
     * @Template()
     */
    public function someAction($a, $b, $c = 'c')
    {
    }

    /**
     * @Route("/simple/multiple/{a}/{b}/")
     * @Template("@Foo/simple/some.html.twig")
     */
    public function someMoreAction($a, $b, $c = 'c')
    {
    }

    /**
     * @Route("/simple/multiple-with-vars/", defaults={"a": "a", "b": "b"})
     * @Template(vars={"a", "b"})
     */
    public function anotherAction($a, $b, $c = 'c')
    {
    }

    /**
     * @Route("/no-listener/")
     */
    public function noListenerAction()
    {
        return new Response('<html><body>I did not get rendered via twig</body></html>');
    }

    /**
     * @Route("/streamed/")
     * @Template(isStreamable=true)
     */
    public function streamedAction()
    {
        return [
            'foo' => 'foo',
            'bar' => 'bar',
        ];
    }
}
