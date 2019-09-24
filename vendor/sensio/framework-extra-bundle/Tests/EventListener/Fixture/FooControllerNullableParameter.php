<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture;

class FooControllerNullableParameter
{
    public function requiredParamAction(\DateTime $param)
    {
    }

    public function defaultParamAction(\DateTime $param = null)
    {
    }

    public function nullableParamAction(?\DateTime $param)
    {
    }
}
