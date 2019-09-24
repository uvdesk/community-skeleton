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
use Symfony\Component\Routing\Annotation\Route;

class InvokableContainerController
{
    /**
     * @Route("/invokable/variable/container/{variable}/")
     * @Template()
     */
    public function variableAction($variable)
    {
    }

    /**
     * @Route("/invokable/another-variable/container/{variable}/")
     * @Template("@Foo/invokable_container/variable.html.twig")
     */
    public function anotherVariableAction($variable)
    {
        return [
            'variable' => $variable,
        ];
    }

    /**
     * @Route("/invokable/variable/container/{variable}/{another_variable}/")
     * @Template("@Foo/invokable_container/another_variable.html.twig")
     */
    public function doubleVariableAction($variable, $another_variable)
    {
        return [
            'variable' => $variable,
            'another_variable' => $another_variable,
        ];
    }

    /**
     * @Route("/invokable/predefined/container/")
     * @Template("@Foo/invokable/predefined.html.twig")
     */
    public function __invoke()
    {
        return [
            'foo' => 'bar',
        ];
    }
}
