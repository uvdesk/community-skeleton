<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportPrivilege;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PrivilegeXHR extends AbstractController
{
    private $userService;
    private $translator;
    
    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function listPrivilegeXHR(Request $request, ContainerInterface $container) 
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if (true === $request->isXmlHttpRequest()) {
            $paginationResponse = $this->getDoctrine()->getRepository(SupportPrivilege::class)->getAllPrivileges($request->query, $container);

            return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function deletePrivilegeXHR($supportPrivilegeId)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_PRIVILEGE')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $request = $this->get('request_stack')->getCurrentRequest();

        if ("DELETE" == $request->getMethod()) {
            $entityManager = $this->getDoctrine()->getManager();
            $supportPrivilege = $entityManager->getRepository(SupportPrivilege::class)->findOneById($supportPrivilegeId);

            if (!empty($supportPrivilege)) {
                $entityManager->remove($supportPrivilege);
                $entityManager->flush();

                return new Response(json_encode([
                    'alertClass' => 'success',
                    'alertMessage' => $this->translator->trans('Support Privilege removed successfully'),
                ]), 200, ['Content-Type' => 'application/json']);
            }
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

}
