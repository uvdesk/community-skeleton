<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Website;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * Forward request to other controllers based on application state.
     *
     * @Route("/", name="base_route")
     */
    public function base(EntityManagerInterface $entityManager, KernelInterface $kernel)
    {
        try {
            // For a quick check we'll just see if support roles have been defined.
            $ownerSupportRole = $entityManager->getRepository(SupportRole::class)->findOneByCode('ROLE_SUPER_ADMIN');
            $administratorSupportRole = $entityManager->getRepository(SupportRole::class)->findOneByCode('ROLE_ADMIN');

            if (!empty($ownerSupportRole) || !empty($administratorSupportRole)) {
                $userInstanceRepository = $entityManager->getRepository(UserInstance::class);
                
                // If support roles are present, we'll check if any users exists with the administrator role.
                $owners = $userInstanceRepository->findBySupportRole($ownerSupportRole);
                $administrators = $userInstanceRepository->findBySupportRole($administratorSupportRole);

                if (!empty($owners) || !empty($administrators)) {
                    $availableBundles = array_keys($kernel->getBundles());
                    $websiteRepository = $entityManager->getRepository(Website::class);

                    // Redirect user to front panel
                    if (in_array('UVDeskSupportCenterBundle', $availableBundles)) {
                        $supportCenterWebsite = $websiteRepository->findOneByCode('knowledgebase');

                        if (!empty($supportCenterWebsite)) {
                            return $this->redirectToRoute('helpdesk_knowledgebase', [], 301);
                        }
                    }

                    // Redirect user to back panel
                    $helpdeskWebsite = $websiteRepository->findOneByCode('helpdesk');

                    if (!empty($helpdeskWebsite)) {
                        return $this->redirectToRoute('helpdesk_member_handle_login');
                    }
                }
            }
        } catch (\Exception $e) {
            // ...
        }
        
        return $this->forward(ConfigureHelpdesk::class . "::load");
    }
}
