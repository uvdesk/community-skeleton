<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\Routing\Fixtures;

use Symfony\Component\Routing\Annotation\Route;

class InvokableController
{
    /**
     * @Route("/", name="index")
     */
    public function __invoke()
    {
    }
}
