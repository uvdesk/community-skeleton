<?php

namespace Doctrine\Common\DataFixtures\Purger;

/**
 * PurgerInterface
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
interface PurgerInterface
{
    /**
     * Purge the data from the database for the given EntityManager.
     *
     * @return void
     */
    function purge();
}
