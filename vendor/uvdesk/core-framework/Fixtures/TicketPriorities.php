<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;

class TicketPriorities extends DoctrineFixture
{
    private static $seeds = [
        [
            'code' => 'low',
            'description' => 'Low',
            'colorCode' => '#2DD051',
        ],
        [
            'code' => 'medium',
            'description' => 'Medium',
            'colorCode' => '#F5D02A',
        ],
        [
            'code' => 'high',
            'description' => 'High',
            'colorCode' => '#FA8B3C',
        ],
        [
            'code' => 'urgent',
            'description' => 'Urgent',
            'colorCode' => '#FF6565',
        ],
    ];

    public function load(ObjectManager $entityManager)
    {
        $availableTicketPriorities = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findAll();
        $availableTicketPriorities = array_map(function ($ticketPriority) {
            return $ticketPriority->getCode();
        }, $availableTicketPriorities);
        
        foreach (self::$seeds as $ticketPrioritySeed) {
            if (false === in_array($ticketPrioritySeed['code'], $availableTicketPriorities)) {
                $ticketPriority = new CoreEntities\TicketPriority();
                $ticketPriority->setCode($ticketPrioritySeed['code']);
                $ticketPriority->setDescription($ticketPrioritySeed['description']);
                $ticketPriority->setColorCode($ticketPrioritySeed['colorCode']);
    
                $entityManager->persist($ticketPriority);
            }
        }

        $entityManager->flush();
    }
}
