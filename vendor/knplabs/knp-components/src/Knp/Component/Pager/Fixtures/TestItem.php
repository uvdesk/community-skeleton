<?php

namespace Knp\Component\Pager\Fixtures;

class TestItem
{    /**
     * @var integer
     */
    private $sortProperty;

    /**
     * TestObject constructor.
     *
     * @param integer $sortProperty
     */
    public function __construct($sortProperty)
    {
        $this->sortProperty = $sortProperty;
    }

    /**
     * @return integer
     */
    public function getSortProperty()
    {
        return $this->sortProperty;
    }
}
