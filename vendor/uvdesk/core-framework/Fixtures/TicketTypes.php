<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;

class TicketTypes extends DoctrineFixture
{
    private static $seeds = [
        [
            'code' => 'support',
            'description' => 'Support',
            'isActive' => true,
        ],
    ];

    public function load(ObjectManager $entityManager)
    {
        $availableTicketTypes = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findAll();
        $availableTicketTypes = array_map(function ($ticketType) {
            return $ticketType->getCode();
        }, $availableTicketTypes);
        
        foreach (self::$seeds as $ticketTypeSeed) {
            if (false === in_array($ticketTypeSeed['code'], $availableTicketTypes)) {
                $ticketType = new CoreEntities\TicketType();
                $ticketType->setCode($ticketTypeSeed['code']);
                $ticketType->setDescription($ticketTypeSeed['description']);
                $ticketType->setIsActive($ticketTypeSeed['isActive']);
    
                $entityManager->persist($ticketType);
            }
        }

        $entityManager->flush();
    }
}
