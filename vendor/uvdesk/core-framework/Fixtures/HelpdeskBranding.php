<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;

class HelpdeskBranding extends DoctrineFixture
{
    public function load(ObjectManager $entityManager)
    {
        $website = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('helpdesk');
        
        if (empty($website)) {
            ($website = new CoreEntities\Website())
                ->setName('Support Center')
                ->setCode('helpdesk')
                ->setThemeColor('#7E91F0')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

            $entityManager->persist($website);
            $entityManager->flush();
        }
    }
}
