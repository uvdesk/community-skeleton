<?php

namespace Tests\Fixtures\FooBundle\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Mapping\Entity
 */
class Foo
{
    /**
     * @Mapping\Column(type="integer")
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="AUTO")
     */
    private $id;
}
