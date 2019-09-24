<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;

class Customer extends Controller
{
    public function listCustomers(Request $request) 
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/Customers/listSupportCustomers.html.twig');
    }

    public function createCustomer(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')){          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if ($request->getMethod() == "POST") {
            $entityManager = $this->getDoctrine()->getManager();
            $formDetails = $request->request->get('customer_form');
            $uploadedFiles = $request->files->get('customer_form');

            // Profile upload validation
            $validMimeType = ['image/jpeg', 'image/png', 'image/jpg'];
            if(isset($uploadedFiles['profileImage'])){
                if(!in_array($uploadedFiles['profileImage']->getMimeType(), $validMimeType)){
                    $this->addFlash('warning', $this->get('translator')->trans('Error ! Profile image is not valid, please upload a valid format'));
                    return $this->redirect($this->generateUrl('helpdesk_member_create_customer_account'));
                }
            }

            $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email' => $formDetails['email']));
            $customerInstance = !empty($user) ? $user->getCustomerInstance() : null;

            if (empty($customerInstance)){
                if (!empty($formDetails)) {
                    $fullname = trim(implode(' ', [$formDetails['firstName'], $formDetails['lastName']]));
                    $supportRole = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_CUSTOMER');
    
                    $user = $this->container->get('user.service')->createUserInstance($formDetails['email'], $fullname, $supportRole, [
                        'contact' => $formDetails['contactNumber'],
                        'source' => 'website',
                        'active' => !empty($formDetails['isActive']) ? true : false,
                        'image' => $uploadedFiles['profileImage'],
                    ]);
    
                    $this->addFlash('success', $this->get('translator')->trans('Success ! Customer saved successfully.'));
    
                    return $this->redirect($this->generateUrl('helpdesk_member_manage_customer_account_collection'));
                }
            } else {
                $this->addFlash('warning', $this->get('translator')->trans('Error ! User with same email already exist.'));
            }
        }
        
        return $this->render('@UVDeskCoreFramework/Customers/createSupportCustomer.html.twig', [
            'user' => new User(),
            'errors' => json_encode([])
        ]);
    }

    public function editCustomer(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UVDeskCoreFrameworkBundle:User');

        if($userId = $request->attributes->get('customerId')) {
            $user = $repository->findOneBy(['id' =>  $userId]);
            if(!$user)
                $this->noResultFound();
        }
        if ($request->getMethod() == "POST") {
            $contentFile = $request->files->get('customer_form');
           
            // Customer Profile upload validation
            $validMimeType = ['image/jpeg', 'image/png', 'image/jpg'];
            if(isset($contentFile['profileImage'])){
                if(!in_array($contentFile['profileImage']->getMimeType(), $validMimeType)){
                    $this->addFlash('warning', 'Error ! Profile image is not valid, please upload a valid format');
                    return $this->render('@UVDeskCoreFramework/Customers/updateSupportCustomer.html.twig', ['user' => $user,'errors' => json_encode([])]);
                }
            }
            if($userId) {
                $data = $request->request->all();
                $data = $data['customer_form'];
                $checkUser = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email' => $data['email']));
                $errorFlag = 0;

                if($checkUser) {
                    if($checkUser->getId() != $userId)
                        $errorFlag = 1;
                }
                
                if(!$errorFlag && 'hello@uvdesk.com' !== $user->getEmail()) {
                    $password = $user->getPassword();
                    $email = $user->getEmail();
                    $user->setFirstName($data['firstName']);
                    $user->setLastName($data['lastName']);
                    $user->setEmail($data['email']);
                    $user->setIsEnabled(isset($data['isActive']) ? 1 : 0);
                    $em->persist($user);

                    // User Instance
                    $userInstance = $em->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy(array('user' => $user->getId()));
                    $userInstance->setUser($user);
                    $userInstance->setIsActive(isset($data['isActive']) ? 1 : 0);
                    $userInstance->setIsVerified(0);
                    if(isset($data['source']))
                        $userInstance->setSource($data['source']);
                    else
                        $userInstance->setSource('website');
                    if(isset($data['contactNumber'])) {
                        $userInstance->setContactNumber($data['contactNumber']);
                    }
                    if(isset($contentFile['profileImage'])){
                        $assetDetails = $this->container->get('uvdesk.core.file_system.service')->getUploadManager()->uploadFile($contentFile['profileImage'], 'profile');
                        $userInstance->setProfileImagePath($assetDetails['path']);
                    }

                    $em->persist($userInstance);
                    $em->flush();

                    $user->addUserInstance($userInstance);
                    $em->persist($user);
                    $em->flush();

                    // Trigger customer created event
                    $event = new GenericEvent(CoreWorkflowEvents\Customer\Update::getId(), [
                        'entity' => $user,
                    ]);
    
                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    $this->addFlash('success', 'Success ! Customer information updated successfully.'); 
                    return $this->redirect($this->generateUrl('helpdesk_member_manage_customer_account_collection'));
                } else {
                    $this->addFlash('warning', 'Error ! User with same email is already exist.');
                }
            } 
        } elseif($request->getMethod() == "PUT") {
            $content = json_decode($request->getContent(), true);
            $userId  = $content['id'];
            $user = $repository->findOneBy(['id' =>  $userId]);
            
            if (!$user)
                $this->noResultFound();

            $checkUser = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email' => $content['email']));
            $errorFlag = 0;

            if ($checkUser) {
                if($checkUser->getId() != $userId)
                    $errorFlag = 1;
            }

            if (!$errorFlag && 'hello@uvdesk.com' !== $user->getEmail()) {
                    $name = explode(' ', $content['name']);
                    $lastName = isset($name[1]) ? $name[1] : ' ';
                    $user->setFirstName($name[0]);
                    $user->setLastName($lastName);
                    $user->setEmail($content['email']);
                    $em->persist($user);

                    //user Instance
                    $userInstance = $em->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy(array('user' => $user->getId()));
                    if(isset($content['contactNumber'])){
                        $userInstance->setContactNumber($content['contactNumber']);
                    }
                    $em->persist($userInstance);
                    $em->flush();

                    $json['alertClass']      = 'success';
                    $json['alertMessage']    = $this->get('translator')->trans('Success ! Customer updated successfully.');
            } else {
                    $json['alertClass']      = 'error';
                    $json['alertMessage']    = $this->get('translator')->trans('Error ! Customer with same email already exist.');      
            }

            return new Response(json_encode($json), 200, []);
        }

        return $this->render('@UVDeskCoreFramework/Customers/updateSupportCustomer.html.twig', [
            'user' => $user,
            'errors' => json_encode([])
        ]);
    }

    protected function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
                   ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
    
    public function bookmarkCustomer(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $id = $request->attributes->get('id') ? : $data['id'];
        $user = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(['id' => $id]);
        if(!$user)  {
            $json['error'] = 'resource not found';
            return new JsonResponse($json, Response::HTTP_NOT_FOUND);
        }
        $userInstance = $em->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy(array(
                'user' => $id,
                'supportRole' => 4
            )
        );

        if($userInstance->getIsStarred()) {
            $userInstance->setIsStarred(0);
            $em->persist($userInstance);
            $em->flush();
            $json['alertClass'] = 'success';
            $json['message'] = $this->get('translator')->trans('unstarred Action Completed successfully');             
        } else {
            $userInstance->setIsStarred(1);
            $em->persist($userInstance);
            $em->flush();
            $json['alertClass'] = 'success';
            $json['message'] = $this->get('translator')->trans('starred Action Completed successfully');             
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}