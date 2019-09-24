<?php

namespace Doctrine\Common\DataFixtures;

/**
 * Ordered Fixture interface needs to be implemented
 * by fixtures, which needs to have a specific order
 * when being loaded by directory scan for example
 * 
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
interface OrderedFixtureInterface
{   
    /**
     * Get the order of this fixture
     * 
     * @return integer
     */  
    public function getOrder();
}
