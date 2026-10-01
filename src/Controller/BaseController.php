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
            $supportRoleRepository = $entityManager->getRepository(SupportRole::class);
            $ownerSupportRole = $supportRoleRepository->findOneByCode('ROLE_SUPER_ADMIN');
            $administratorSupportRole = $supportRoleRepository->findOneByCode('ROLE_ADMIN');

            if (!empty($ownerSupportRole) || !empty($administratorSupportRole)) {
                $userInstanceRepository = $entityManager->getRepository(UserInstance::class);

                $owners = !empty($ownerSupportRole) ? $userInstanceRepository->findBySupportRole($ownerSupportRole) : [];
                $administrators = !empty($administratorSupportRole) ? $userInstanceRepository->findBySupportRole($administratorSupportRole) : [];

                if (!empty($owners) || !empty($administrators)) {
                    $availableBundles = array_keys($kernel->getBundles());
                    $websiteRepository = $entityManager->getRepository(Website::class);

                    if (in_array('UVDeskSupportCenterBundle', $availableBundles, true)) {
                        $supportCenterWebsite = $websiteRepository->findOneByCode('knowledgebase');

                        if (!empty($supportCenterWebsite)) {
                            return $this->redirectToRoute('helpdesk_knowledgebase', [], 301);
                        }
                    }

                    $helpdeskWebsite = $websiteRepository->findOneByCode('helpdesk');

                    if (!empty($helpdeskWebsite)) {
                        return $this->redirectToRoute('helpdesk_member_handle_login');
                    }
                }
            }
        } catch (\Throwable $e) {
        }

        return $this->forward(ConfigureHelpdesk::class . '::load');
    }
}
