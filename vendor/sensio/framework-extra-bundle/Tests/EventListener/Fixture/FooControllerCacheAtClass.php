<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * @Cache(smaxage="20")
 */
class FooControllerCacheAtClass
{
    const CLASS_SMAXAGE = 20;

    public function barAction()
    {
    }
}
