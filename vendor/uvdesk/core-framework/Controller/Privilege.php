<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportPrivilege;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Privilege extends Controller
{
    public function listPrivilege(Request $request) 
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/Privileges/listSupportPriveleges.html.twig');
    }

    public function createPrivilege(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $formErrors = [];
        $supportPrivilege = new SupportPrivilege();
        $supportPrivilegeResources = $this->get('uvdesk.service')->getSupportPrivelegesResources();
        if ('POST' == $request->getMethod()) {
         
            $entityManager = $this->getDoctrine()->getManager();
            $supportPrivelegeFormDetails = $request->request->get('privilege_form');
            $supportPrivilege->setName($supportPrivelegeFormDetails['name']);
            $supportPrivilege->setDescription($supportPrivelegeFormDetails['description']);
            $supportPrivilege->setPrivileges($supportPrivelegeFormDetails['privileges']);

            $entityManager->persist($supportPrivilege);
            $entityManager->flush();  

            $this->addFlash('success', $this->get('translator')->trans('Success ! Privilege information saved successfully.'));
            return $this->redirect($this->generateUrl('helpdesk_member_privilege_collection'));

        }

        return $this->render('@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig', [
            'errors' => json_encode($formErrors),
            'supportPrivilege' => $supportPrivilege,
            'supportPrivilegeResources' => $supportPrivilegeResources,
        ]);
    }

    public function editPrivilege($supportPrivilegeId)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->get('request_stack')->getCurrentRequest();
        
        $supportPrivilege = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportPrivilege')->findOneById($supportPrivilegeId);
        
        if (empty($supportPrivilege)) {
            $this->noResultFound();
        }
        
        $formErrors = [];
        $supportPrivilegeResources = $this->get('uvdesk.service')->getSupportPrivelegesResources();

        if ('POST' == $request->getMethod()) {
            $supportPrivilegeDetails = $request->request->get('privilege_form');

            $supportPrivilege->setName($supportPrivilegeDetails['name']);
            $supportPrivilege->setDescription($supportPrivilegeDetails['description']);
            $supportPrivilege->setPrivileges($supportPrivilegeDetails['privileges']);

            $entityManager->persist($supportPrivilege);
            $entityManager->flush();  

            $this->addFlash('success',$this->get('translator')->trans( 'Privilege updated successfully.'));

            return $this->redirect($this->generateUrl('helpdesk_member_privilege_collection'));
        }
 
        return $this->render('@UVDeskCoreFramework/Privileges/updateSupportPrivelege.html.twig', [
            'errors' => json_encode($formErrors),
            'supportPrivilege' => $supportPrivilege,
            'supportPrivilegeResources' => $supportPrivilegeResources,
        ]);
    }
}