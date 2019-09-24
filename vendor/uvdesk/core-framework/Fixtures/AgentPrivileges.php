<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;

class AgentPrivileges extends DoctrineFixture
{
    private static $seeds = [
        [
            'name' => 'Default Privileges',
            'description' => 'Default Privileges',
            'privileges' => [
                'ROLE_AGENT_ADD_NOTE'
            ],
        ],
    ];

    public function load(ObjectManager $entityManager)
    {
        $availableSupportPrivileges = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportPrivilege')->findAll();

        if (empty($availableSupportPrivileges)) {
            foreach (self::$seeds as $supportPrivilegeSeed) {
                $supportPrivilege = new CoreEntities\SupportPrivilege();
                $supportPrivilege->setName($supportPrivilegeSeed['name']);
                $supportPrivilege->setDescription($supportPrivilegeSeed['description']);
                $supportPrivilege->setPrivileges($supportPrivilegeSeed['privileges']);
                $supportPrivilege->setCreatedAt(new \Datetime('now'));

                $entityManager->persist($supportPrivilege);
            }
    
            $entityManager->flush();
        }
    }
}
