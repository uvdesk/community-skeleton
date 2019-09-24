<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class FooControllerMultipleCacheAtMethod
{
    /**
     * @Cache()
     * @Cache()
     */
    public function barAction()
    {
    }
}
