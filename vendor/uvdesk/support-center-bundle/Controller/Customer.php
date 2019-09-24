<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Webkul\UVDesk\CoreFrameworkBundle\Form\UserProfile;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;

Class Customer extends Controller
{
    protected function redirectUserToLogin()
    {
        $authChecker = $this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_CUSTOMER'))
            return true;
    }

    protected function isWebsiteActive()
    {
        $error = false;

        if($error)
            $this->noResultFound();
    }

    protected function noResultFound()
    {
        throw new NotFoundHttpException('Permission Denied !');
    }

    protected function encodePassword(User $user, $plainPassword)
    {
      return  $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($user, $plainPassword);
    }

    protected function isLoginDisabled()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $website = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('knowledgebase');
        
        if (!empty($website)) {
            $configuration = $entityManager->getRepository('UVDeskSupportCenterBundle:KnowledgebaseWebsite')->findOneBy([
                'website' => $website->getId(),
                'isActive' => 1,
            ]);
            
            if (!empty($configuration) && $configuration->getDisableCustomerLogin()) {
                return true;
            }
        }

        return false;
    }

    public function login(Request $request)
    {
        if($this->redirectUserToLogin())
            return $this->redirect($this->generateUrl('helpdesk_customer_ticket_collection')); // Replace with Dashboard route

        /** check disabled customer login **/
        if($this->isLoginDisabled()) {
            $this->addFlash('warning', $this->get('translator')->trans('Warning ! Customer Login disabled by admin.') );
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $session = $request->getSession();

        $error = $session->get(Security::AUTHENTICATION_ERROR);
        $session->remove(Security::AUTHENTICATION_ERROR);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/login.html.twig', [
                'searchDisable' => true,
                'last_username' => $session->get(Security::LAST_USERNAME),
                'error'         => $error,
                'breadcrumbs' => [
                    [
                        'label' => $this->get('translator')->trans('Support Center'),
                        'url' => $this->generateUrl('helpdesk_knowledgebase')
                    ], [
                        'label' => $this->get('translator')->trans('Sign In'),
                        'url' => '#'
                    ]
                ]
            ]);
    }

    public function forgotPassword(Request $request)
    {
        if ($this->isLoginDisabled()) {
            $this->addFlash('warning',$this->get('translator')->trans('Warning ! Customer Login disabled by admin.'));
            return $this->redirect($this->generateUrl('webkul_support_center_front_solutions'));
        }

        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $user = new User();
            $data = $request->request->all();
            $repository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');
            $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email' => $data['email']));
            
            if ($user) {
                $key = time();
                
                // Trigger agent forgot event
                $event = new GenericEvent(CoreWorkflowEvents\Customer\ForgotPassword::getId(), [
                    'entity' => $user,
                ]);

                $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                $request->getSession()->getFlashBag()->set('success', 'Please check your mail for password update.');
                
                return $this->redirect($this->generateUrl('helpdesk_customer_login'));
                //@TODO: NEEDS TO SEND EMAIL FOR CHANGE PASSWORD URL.
            } else {
                $request->getSession()->getFlashBag()->set('warning',$this->get('translator')->trans('This Email is not registered with us.'));
            }
        }
        
        return $this->render('@UVDeskSupportCenter/Knowledgebase/forgotPassword.html.twig', [
            'searchDisable' => true,
            'breadcrumbs' => [
                ['label' => 'Support Center', 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => 'Forgot Password','url' => '#']
            ]
        ]);
    }


    public function updateCredentials($email, $verificationCode)
    {
        if ($this->isLoginDisabled() || (empty($email) || empty($verificationCode))) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->get('request_stack')->getCurrentRequest();

        // Validate request
        $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email);

        if (empty($user) || null == $user->getCustomerInstance() || $user->getVerificationCode() != $verificationCode) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }
        
        if ($request->getMethod() == 'POST') {
            $updatedCredentials = $request->request->all();
            
            if ($updatedCredentials['password'] === $updatedCredentials['confirmPassword']) {
                $user->setPassword($this->encodePassword($user, $updatedCredentials['password']));
                $user->setVerificationCode(TokenGenerator::generateToken());
                
                $entityManager->persist($user);
                $entityManager->flush();

                $request->getSession()->getFlashBag()->set('success', $this->get('translator')->trans('Your password has been updated successfully.'));
                return $this->redirect($this->generateUrl('helpdesk_customer_login'));
            } else {
                $request->getSession()->getFlashBag()->set('warning', $this->get('translator')->trans("Password don't match."));
            }
        }

        return $this->render('@UVDeskSupportCenter/Knowledgebase/resetPassword.html.twig', [
            'searchDisable' => true,
            'breadcrumbs' => [
                [
                    'label' =>'Support Center',
                    'url' => 'helpdesk_knowledgebase'
                ], [
                    'label' => 'Account Validation',
                    'url' => '#'
                ]
            ]
        ]);
    }

    public function Account(Request $request)
    {
        $this->isWebsiteActive();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $errors = [];

        if ($request->getMethod() == 'POST') {
            $data     = $request->request->all();
            $dataFiles = $request->files->get('user_form');
            $data = $data['user_form'];

            // Profile upload validation
            $validMimeType = ['image/jpeg', 'image/png', 'image/jpg'];
            if (isset($dataFiles['profileImage'])) {
                if (!in_array($dataFiles['profileImage']->getMimeType(), $validMimeType)) {
                    $this->addFlash('warning', $this->get('translator')->trans('Error ! Profile image is not valid, please upload a valid format'));
                    return $this->redirect($this->generateUrl('helpdesk_customer_account'));
                }
            } 

            $checkUser = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email'=>$data['email']));
            $errorFlag = 0;
            
            if ($checkUser) {
                if($checkUser->getId() != $user->getId())
                    $errorFlag = 1;
            }

            if (!$errorFlag) {
                $password = $user->getPassword();
                
                $form = $this->createForm(UserProfile::class, $user);
                $form->handleRequest($request);
                $form->submit(true);
                
                if ($form->isValid()) {
                    if ($data != null && (!empty($data['password']['first']))) {
                        $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($user, $data['password']['first']);
                        
                        if (!empty($encodedPassword) ) {
                            $user->setPassword($encodedPassword);
                        }
                    } else {
                        $user->setPassword($password);
                    }

                    $user->setFirstName($data['firstName']);
                    $user->setLastName($data['lastName']);
                    $user->setEmail($data['email']);
                    $em->persist($user);
                    $em->flush();

                    $userInstance = $em->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy(array('user' => $user->getId()));
                    
                    if (isset($dataFiles['profileImage'])) {
                        $assetDetails = $this->container->get('uvdesk.core.file_system.service')->getUploadManager()->uploadFile($dataFiles['profileImage'], 'profile');
                        $userInstance->setProfileImagePath($assetDetails['path']);
                    }

                    $userInstance  = $userInstance->setContactNumber($data['contactNumber']);
                    $em->persist($userInstance);
                    $em->flush();

                    $this->addFlash('success','Success ! Profile updated successfully.');
                    return $this->redirect($this->generateUrl('helpdesk_customer_account'));
                } else {
                    $errors = $form->getErrors();
                    dump($errors);
                    die;
                    $errors = $this->getFormErrors($form);
                }
            } else {
                $this->addFlash('warning','Error ! User with same email is already exist.');
                return $this->redirect($this->generateUrl('helpdesk_customer_account'));
            }
        }
        
        return $this->render('@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig', [
            'searchDisable' => true,
            'user' => $user,
        ]);
    }

    public function searchArticle(Request $request)
    {
        $this->isWebsiteActive();
        $searchQuery = $request->query->get('s');
        if (empty($searchQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_customer_ticket_collection'));
        }
  
        $articleCollection = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Article')->getArticleBySearch($request);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'search' => $searchQuery,
            'articles' => $articleCollection,
            'breadcrumbs' => [
                ['label' => $this->get('translator')->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $searchQuery, 'url' => '#'],
            ],
        ]);

    }
    
}