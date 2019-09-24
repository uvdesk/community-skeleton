<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportPrivilege;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PrivilegeXHR extends Controller
{
    public function listPrivilegeXHR(Request $request) 
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if (true === $request->isXmlHttpRequest()) {
            $paginationResponse = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:SupportPrivilege')->getAllPrivileges($request->query, $this->container);

            return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function deletePrivilegeXHR($supportPrivilegeId)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $request = $this->get('request_stack')->getCurrentRequest();

        if ("DELETE" == $request->getMethod()) {
            $entityManager = $this->getDoctrine()->getManager();
            $supportPrivilege = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportPrivilege')->findOneById($supportPrivilegeId);

            if (!empty($supportPrivilege)) {
                $entityManager->remove($supportPrivilege);
                $entityManager->flush();

                return new Response(json_encode([
                    'alertClass' => 'success',
                    'alertMessage' => $this->get('translator')->trans('Support Privilege removed successfully.'),
                ]), 200, ['Content-Type' => 'application/json']);
            }
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

}
