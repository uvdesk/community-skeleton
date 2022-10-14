<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\FileSystem\FileSystem;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntites;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

Class Announcement extends AbstractController
{
    private $translator;
    private $userService;

    public function __construct(TranslatorInterface $translator, UserService $userService)
    {
        $this->translator = $translator;
        $this->userService = $userService;
    }

    public function listAnnouncement(Request $request)    
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskSupportCenter/Staff/Announcement/listAnnouncement.html.twig');
    }

    public function listAnnouncementXHR(Request $request, ContainerInterface $container)    
    {
        $json = array();
        $repository = $this->getDoctrine()->getRepository(SupportEntites\Announcement::class);
        $json =  $repository->getAllAnnouncements($request->query, $container);
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function updateAnnouncement(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $em = $this->getDoctrine()->getManager();
        
        if($request->attributes->get('announcementId')){
            $announcement = $this->getDoctrine()->getRepository(SupportEntites\Announcement::class)
                        ->findOneBy([
                                'id' => $request->attributes->get('announcementId')
                            ]);
            $announcement->setCreatedAt(new \DateTime('now'));          
            if(!$announcement)
                $this->noResultFound();
        } else {
            $announcement = new SupportEntites\Announcement();
            $announcement->setCreatedAt(new \DateTime('now'));
        }
        
        if($request->getMethod() == "POST") {
            $request = $request->request->get('announcement_form');
            $group = $em->getRepository(CoreEntites\SupportGroup::class)->find($request['group']);

            $announcement->setTitle($request['title']);
            $announcement->setPromoText($request['promotext']);
            $announcement->setPromotag($request['promotag']);
            $announcement->setTagColor($request['tagColor']);
            $announcement->setLinkText($request['linkText']);
            $announcement->setLinkURL($request['linkURL']);
            $announcement->setIsActive($request['status']);
            $announcement->setGroup($group);
            $em->persist($announcement);
            $em->flush();

            $this->addFlash('success', 'Success! Announcement data saved successfully.');
            return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_marketing_announcement'));
            
        }

        return $this->render('@UVDeskSupportCenter/Staff/Announcement/announcementForm.html.twig', [
                'announcement' => $announcement,
                'errors' => ''
        ]);
    }

    public function removeAnnouncementXHR(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $knowledgebaseAnnouncementId = $request->attributes->get('announcementId');

        $knowledgebaseAnnouncement = $this->getDoctrine()->getRepository(SupportEntites\Announcement::class)
            ->findOneBy([
                'id' => $request->attributes->get('announcementId')
            ]);

        if ($knowledgebaseAnnouncement) {
            $entityManager->remove($knowledgebaseAnnouncement);
            $entityManager->flush();

            $json = [
                'alertClass' => 'success',
                'alertMessage' => 'Announcement deleted successfully!',
            ];
            $responseCode = 200;
        } else {
            $json = [
                'alertClass' => 'warning',
                'alertMessage' => 'Announcement not found!',
            ];
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
