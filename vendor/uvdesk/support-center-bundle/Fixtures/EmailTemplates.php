<?php

namespace Webkul\UVDesk\SupportCenterBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Webkul\UVDesk\CoreEntities\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Webkul\UVDesk\SupportCenterBundle\Templates\Email\Resources as SupportCenterEmailTemplates;

class EmailTemplates extends DoctrineFixture
{
    private static $seeds = [
        SupportCenterEmailTemplates\Customer\AccountCreated::class,
        SupportCenterEmailTemplates\Customer\ForgotPassword::class,
    ];

    public function load(ObjectManager $entityManager)
    {
        // $emailTemplateCollection = $entityManager->getRepository('UVDeskCoreFrameworkBundle:EmailTemplates')->findAll();

        // if (empty($emailTemplateCollection)) {
        //     foreach (self::$seeds as $coreEmailTemplate) {
        //         ($emailTemplate = new CoreEntities\EmailTemplates())
        //             ->setName($coreEmailTemplate::getName())
        //             ->setSubject($coreEmailTemplate::getSubject())
        //             ->setMessage($coreEmailTemplate::getMessage());

        //         $entityManager->persist($emailTemplate);
        //     }

        //     $entityManager->flush();
        // }
    }
}
