<?php

namespace Webkul\UVDesk\AutomationBundle\Controller\Automations;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Webkul\UVDesk\AutomationBundle\Form;
use Webkul\UVDesk\AutomationBundle\Entity;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\AutomationBundle\EventListener\PreparedResponseListener;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PreparedResponseXHR extends AbstractController
{
    const ROLE_REQUIRED_MANUAL = 'ROLE_AGENT_MANAGE_WORKFLOW_MANUAL';
    const LIMIT = 20;
    const WORKFLOW_MANUAL = 0;
    const WORKFLOW_AUTOMATIC = 1;
    const NAME_LENGTH = 100;
    const DESCRIPTION_LENGTH = 200;

    private $userService;
    private $translator;
    private $preparedResponseListner;

    public function __construct(UserService $userService, PreparedResponseListener $preparedResponseListner ,TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->preparedResponseListner = $preparedResponseListner;
    }

    public function prepareResponseListXhr(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_MANUAL')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        $repository = $this->getDoctrine()->getRepository(Entity\PreparedResponses::class);
        $json = $repository->getPreparesResponses($request->query, $container);
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function prepareResponseDeleteXhr(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_MANUAL')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $id = $request->attributes->get('id');
            $preparedResponses = $em->getRepository(Entity\PreparedResponses::class)->find($id);

            $em->remove($preparedResponses);
            $em->flush();

            $json['alertClass'] = 'success';
            $json['alertMessage'] = $this->translator->trans('Success ! Prepared response removed successfully.');
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getPreparedResponseActionOptionsXHR($entity, Request $request, ContainerInterface $container)
    {
        foreach ($this->preparedResponseListner->getRegisteredPreparedResponseActions() as $preparedResponseAction) {
            if ($preparedResponseAction->getId() == $entity) {
                $options = $preparedResponseAction->getOptions($container);

                if (!empty($options)) {
                    return new Response(json_encode($options), 200, ['Content-Type' => 'application/json']);
                }

                break;
            }
        }

        return new Response(json_encode([
            'alertClass' => 'danger',
            'alertMessage' => 'Warning! You are not allowed to perform this action.',
        ]), 200, ['Content-Type' => 'application/json']);
    }
}
