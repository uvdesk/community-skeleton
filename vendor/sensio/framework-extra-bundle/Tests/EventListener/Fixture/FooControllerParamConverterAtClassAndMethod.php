<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @ParamConverter("test")
 */
class FooControllerParamConverterAtClassAndMethod
{
    /**
     * @ParamConverter("test2")
     */
    public function barAction($test, $test2)
    {
    }
}
