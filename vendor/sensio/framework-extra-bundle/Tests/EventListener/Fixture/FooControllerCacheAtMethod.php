<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class FooControllerCacheAtMethod
{
    const METHOD_SMAXAGE = 15;

    /**
     * @Cache(smaxage="15")
     */
    public function barAction()
    {
    }
}
