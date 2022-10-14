<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;

class UserRoles extends DoctrineFixture
{
    private static $seeds = [
        [
            'code' => 'ROLE_SUPER_ADMIN',
            'description' => 'Account Owner'
        ],
        [
            'code' => 'ROLE_ADMIN',
            'description' => 'Administrator'
        ],
        [
            'code' => 'ROLE_AGENT',
            'description' => 'Agent'
        ],
        [
            'code' => 'ROLE_CUSTOMER',
            'description' => 'Customer'
        ],
    ];

    public function load(ObjectManager $entityManager)
    {
        $availablePermissions = $entityManager->getRepository(SupportRole::class)->findAll();
        $availablePermissions = array_map(function ($permission) {
            return $permission->getCode();
        }, $availablePermissions);
        
        foreach (self::$seeds as $roleSeed) {
            if (false === in_array($roleSeed['code'], $availablePermissions)) {
                $role = new CoreEntities\SupportRole();
                $role->setCode($roleSeed['code']);
                $role->setDescription($roleSeed['description']);
    
                $entityManager->persist($role);
            }
        }

        $entityManager->flush();
    }
}
