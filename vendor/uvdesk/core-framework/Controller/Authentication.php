<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\Form\FormError;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;

class Authentication extends Controller
{
    public function login(Request $request)
    {
        if (null == $this->get('user.service')->getSessionUser()) {
            return $this->render('@UVDeskCoreFramework//login.html.twig', [
                'last_username' => $this->get('security.authentication_utils')->getLastUsername(),
                'error' => $this->get('security.authentication_utils')->getLastAuthenticationError(),
            ]);
        }
        
        return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
    }

    public function logout(Request $request)
    {
        return;
    }

    public function forgotPassword(Request $request)
    {
        if (null == $this->get('user.service')->getSessionUser()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            if ($request->getMethod() == 'POST') {
                $user = new User();
                $form = $this->createFormBuilder($user,['csrf_protection' => false])
                        ->add('email',EmailType::class)
                        ->getForm();

                $form->submit(['email' => $request->request->get('forgot_password_form')['email']]);
                $form->handleRequest($request);
                
                if ($form->isValid()) {
                    $repository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:User');
                    $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('email' => $form->getData()->getEmail()));
                  
                    if($user) {
                        // Trigger agent forgot password event
                        $event = new GenericEvent(CoreWorkflowEvents\Agent\ForgotPassword::getId(), [
                            'entity' => $user,
                        ]);
                        
                        $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
                        $request->getSession()->getFlashBag()->set('success', $this->get('translator')->trans('Please check your mail for password update.'));
                        
                        return $this->redirect($this->generateUrl('helpdesk_member_update_account_credentials')."/".$form->getData()->getEmail());
                    } else {
                        $request->getSession()->getFlashBag()->set('warning', $this->get('translator')->trans('This Email address is not registered with us.'));
                    }
                }
            }

            return $this->render("@UVDeskCoreFramework//forgotPassword.html.twig");
        }
        
        return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));       
    }

    public function updateCredentials($email, $verificationCode)
    {
        if (empty($email) || empty($verificationCode)) {
            return $this->redirect($this->generateUrl('helpdesk_member_handle_login'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();

        // Validate request
        $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email);

        if (empty($user) || null == $user->getAgentInstance() || $user->getVerificationCode() != $verificationCode) {
            return $this->redirect($this->generateUrl('helpdesk_member_handle_login'));
        }
    
        if ($request->getMethod() == 'POST') {
            $updatedCredentials = $request->request->all();

            if ($updatedCredentials['password'] === $updatedCredentials['confirmPassword']) {
                $user->setPassword($this->encodePassword($user, $updatedCredentials['password']));
                $user->setVerificationCode(TokenGenerator::generateToken());

                $entityManager->persist($user);
                $entityManager->flush();

                $request->getSession()->getFlashBag()->set('success', $this->get('translator')->trans('Your password has been updated successfully.'));
                return $this->redirect($this->generateUrl('helpdesk_member_handle_login'));
            } else {
                $request->getSession()->getFlashBag()->set('warning', $this->get('translator')->trans("Password don't match."));
            }
        }
       
        return $this->render("@UVDeskCoreFramework//resetPassword.html.twig");
    }

    protected function encodePassword(User $user, $plainPassword)
    {
      return  $encodedPassword = $this->container->get('security.password_encoder')->encodePassword($user, $plainPassword);
    }
}
