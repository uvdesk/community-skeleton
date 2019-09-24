<?php

namespace Doctrine\Common\DataFixtures;

use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Shared Fixture interface needs to be implemented
 * by fixtures, which needs some references to be shared
 * among other fixture classes in order to maintain
 * relation mapping
 * 
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 */
interface SharedFixtureInterface extends FixtureInterface
{   
    /**
     * Set the reference repository
     * 
     * @param ReferenceRepository $referenceRepository
     */ 
    function setReferenceRepository(ReferenceRepository $referenceRepository);
}
