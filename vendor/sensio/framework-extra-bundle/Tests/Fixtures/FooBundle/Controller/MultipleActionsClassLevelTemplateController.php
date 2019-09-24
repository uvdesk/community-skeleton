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

/**
 * @Template("@Foo/invokable/predefined.html.twig")
 */
class MultipleActionsClassLevelTemplateController
{
    /**
     * @Route("/multi/one-template/1/")
     */
    public function firstAction()
    {
        return [
            'foo' => 'bar',
        ];
    }

    /**
     * @Route("/multi/one-template/2/")
     * @Route("/multi/one-template/3/")
     */
    public function secondAction()
    {
        return [
            'foo' => 'bar',
        ];
    }

    /**
     * @Route("/multi/one-template/4/")
     * @Template("@Foo/overwritten.html.twig")
     */
    public function overwriteAction()
    {
        return [
            'foo' => 'foo bar baz',
        ];
    }
}
