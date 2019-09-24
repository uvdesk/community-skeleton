<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerXHR extends Controller
{
    public function listCustomersXHR(Request $request) 
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $json = array();
        
        if($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');
            $json =  $repository->getAllCustomer($request->query, $this->container);
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    public function removeCustomerXHR(Request $request) 
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $json = array();
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $id = $request->attributes->get('customerId');
            $user = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(['id' => $id]);

            if($user) {

                $this->get('user.service')->removeCustomer($user);
                // Trigger customer created event
                $event = new GenericEvent(CoreWorkflowEvents\Customer\Delete::getId(), [
                    'entity' => $user,
                ]);

                $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                $json['alertClass'] = 'success';
                $json['alertMessage'] = ($this->get('translator')->trans('Success ! Customer removed successfully.'));
            } else {
                $json['alertClass'] =  'danger';
                $json['alertMessage'] = ($this->get('translator')->trans('Error ! Invalid customer id.'));
                $json['statusCode'] = Response::HTTP_NOT_FOUND;
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}
