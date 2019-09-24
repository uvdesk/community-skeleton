<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SavedFilters;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountXHR extends Controller
{
    public function listAgentsXHR(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if (true === $request->isXmlHttpRequest()) {
            $userRepository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');
            $agentCollection = $userRepository->getAllAgents($request->query, $this->container);
            return new Response(json_encode($agentCollection), 200, ['Content-Type' => 'application/json']);
        } 
        return new Response(json_encode([]), 404);
    }

    public function deleteAgent(Request $request)
    {
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $id = $request->query->get('id');
            /*
                Original Code: $user = $em->getRepository('WebkulUserBundle:User')->findUserByCompany($id,$company->getId());
                Using findUserByCompany() won't execute the UserListener, so user roles won't be set and user with ROLE_SUPER_ADMIN can be deleted as a result.
                To trigger UserListener to set roles, you need to only select 'u' instead of both 'u, dt' in query select clause.
                Doing this here instead of directly making changes to userRepository->findUserByCompany().
             */
            $user = $em->createQuery('SELECT u FROM UVDeskCoreFrameworkBundle:User u JOIN u.userInstance userInstance WHERE u.id = :userId  AND userInstance.supportRole != :roles')
                ->setParameter('userId', $id)
                ->setParameter('roles', 4)
                ->getOneOrNullResult();

            if ($user) {
                if($user->getAgentInstance()->getSupportRole() != "ROLE_SUPER_ADMIN") {
                    $this->get('user.service')->removeAgent($user);

                    // Trigger agent delete event
                    $event = new GenericEvent(CoreWorkflowEvents\Agent\Delete::getId(), [
                        'entity' => $user,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = ($this->get('translator')->trans('Success ! Agent removed successfully.'));
                } else {
                    $json['alertClass'] = 'warning';
                    $json['alertMessage'] = $this->translate("Warning ! You are allowed to remove account owner's account.");
                }
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->translate('Error ! Invalid user id.');
            }
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    } 

    public function savedFiltersXHR(Request $request)
    {
        $json = array();

            $em = $this->getDoctrine()->getManager();
            $user = $this->get('user.service')->getCurrentUser();
            $userData = $user->getAgentInstance();

            if($request->getMethod() == 'POST') {
                $content = $request->request->all();
                $filter = new SavedFilters();
                $filter->setName($content['name']);
                $filter->setRoute($content['route']);
                $filter->setUser($userData);
                $em->persist($filter);
                $em->flush();

                if(isset($content['is_default'])) {
                    $userData->setDefaultFiltering($filter->getId());
                    $em->persist($userData);
                    $em->flush();
                }

                $json['filter'] = ['id' => $filter->getId(), 'name' => $filter->getName(), 'route' => $filter->getRoute(), 'is_default' => isset($content['is_default'])];
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Filter has been saved successfully.');
            } elseif($request->getMethod() == 'PUT' || $request->getMethod() == 'PATCH') {
                $content = $request->request->all();
                $filter = $em->getRepository('UVDeskCoreFrameworkBundle:SavedFilters')->find($content['id']);
                $filter->setName($content['name']);
                $filter->setRoute($content['route']);
                $em->flush();

                if(isset($content['is_default']))
                    $userData->setDefaultFiltering($filter->getId());
                elseif($filter->getId() == $userData->getDefaultFiltering())
                    $userData->setDefaultFiltering(0);
                
                $em->persist($userData);
                $em->flush();

                $json['filter'] = ['id' => $filter->getId(), 'name' => $filter->getName(), 'route' => $filter->getRoute(), 'is_default' => isset($content['is_default']) ? 1 : 0 ];
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Filter has been updated successfully.');
            } elseif($request->getMethod() == 'DELETE') {

                $id = $request->attributes->get('filterId');
                $filter = $em->getRepository('UVDeskCoreFrameworkBundle:SavedFilters')->find($id);
                $em->remove($filter);
                $em->flush();

                // if($id == $userData->getDefaultFiltering())
                //     $userData->setDefaultFiltering(0);
                
                // $em->persist($userData);
                // $em->flush();

                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Filter has been removed successfully.');
            }
        
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
