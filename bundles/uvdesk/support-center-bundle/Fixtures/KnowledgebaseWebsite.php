<?php

namespace Webkul\UVDesk\SupportCenterBundle\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportCenterEntities;

class KnowledgebaseWebsite extends DoctrineFixture
{
    private static $websiteConfigurationSeed = [
        'status' => true,
        'brand_color' => '#7E91F0',
        'page_background_color' => '#FFFFFF',
        'header_background_color' => '#FFFFFF',
        'banner_background_color' => '#7C70F4',
        'nav_text_color' => '#7085F4',
        'nav_active_color' => '#7085F4',
        'page_link_color' => '#2750C4',
        'page_link_hover_color' => '#2750C4',
        'article_text_color' => '#333333',
        'site_description' => 'Hi! how can i help you.',
        'broadcast_message' => null,
        'ticket_create_option' => true,
        'disable_customer_login' => false,
        'login_required_to_create' => true,
        'home_page_content' => 'masonry',
    ];

    public function load(ObjectManager $entityManager)
    {
        $website = $entityManager->getRepository(CoreEntities\Website::class)->findOneByCode('knowledgebase');
        
        if (empty($website)) {
            ($website = new CoreEntities\Website())
                ->setName('Helpdesk Knowledgebase')
                ->setCode('knowledgebase')
                ->setThemeColor('#7E91F0')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());

            $entityManager->persist($website);
            $entityManager->flush();
        }

        $knowledgebaseWebsite = $entityManager->getRepository(SupportCenterEntities\KnowledgebaseWebsite::class)->findOneByWebsite($website);
        
        if (empty($websiteConfiguration)) {
            ($knowledgebaseWebsite = new SupportCenterEntities\KnowledgebaseWebsite())
                ->setStatus(self::$websiteConfigurationSeed['status'])
                ->setBrandColor(self::$websiteConfigurationSeed['brand_color'])
                ->setPageBackgroundColor(self::$websiteConfigurationSeed['page_background_color'])
                ->setHeaderBackgroundColor(self::$websiteConfigurationSeed['page_background_color'])
                ->setBannerBackgroundColor(self::$websiteConfigurationSeed['banner_background_color'])
                ->setLinkColor(self::$websiteConfigurationSeed['page_link_color'])
                ->setLinkHoverColor(self::$websiteConfigurationSeed['page_link_hover_color'])
                ->setArticleTextColor(self::$websiteConfigurationSeed['article_text_color'])
                ->setSiteDescription(self::$websiteConfigurationSeed['site_description'])
                ->setBroadcastMessage(self::$websiteConfigurationSeed['broadcast_message'])
                ->setTicketCreateOption(self::$websiteConfigurationSeed['ticket_create_option'])
                ->setHomepageContent(self::$websiteConfigurationSeed['home_page_content'])
                ->setDisableCustomerLogin(self::$websiteConfigurationSeed['disable_customer_login'])
                ->setIsActive(true)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setWebsite($website);

            $entityManager->persist($knowledgebaseWebsite);
            $entityManager->flush();
        }
    }
}
