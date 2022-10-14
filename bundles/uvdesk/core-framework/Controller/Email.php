<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Email extends AbstractController
{
    const LIMIT = 10;
    
    private $userService;
    private $translator;

    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    protected function getTemplate($request)
    {
        $emailTemplateRepository = $this->getDoctrine()->getRepository(EmailTemplates::class);

        $data = $emailTemplateRepository->findOneby([
            'id' => $request->attributes->get('template'),
            'user' => $this->userService->getCurrentUser()->getId()
        ]);

        $default = $emailTemplateRepository->findOneby([
            'id' => $request->attributes->get('template')
        ]);

        return $data == null ? $default : $data;
    }

    public function templates(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_EMAIL_TEMPLATE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework//templateList.html.twig');
    }

    public function templateForm(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_EMAIL_TEMPLATE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if ($request->attributes->get('template')) {
            $template = $this->getTemplate($request);
        } else {
            $template = new EmailTemplates();
        }

        if (!$template) {
            $this->noResultFound();
        }

        if (!$template->getMessage()) {
            $template->setMessage('<p>{%global.companyLogo%}<hr></p><p><br><br><br></p><p><i>' . "Cheers !" . ' </i><br> <i style="color:#397b21">{%global.companyName%}</i><br></p>');
        }

        if ($request->getMethod() == 'POST') {
            $entityManager= $this->getDoctrine()->getManager();
            $data = $request->request->all();

            $user_instance = $this->container->get('security.token_storage')->getToken()->getUser();
            $user_instance= $entityManager->getRepository(UserInstance::class)->findBy(['id'=>$user_instance->getId()]);

            $template->setUser($user_instance[0]);
            $template->setName($data['name']);
            $template->setSubject($data['subject']);
            $template->setMessage($data['message']);
            $template->setTemplateType($data['templateFor']);
            $entityManager->persist($template);
            $entityManager->flush();

            if ($request->attributes->get('template')) {
                $message = $this->translator->trans('Success! Template has been updated successfully.');
            } else {
                $message = $this->translator->trans('Success! Template has been added successfully.');

            }

            $this->addFlash('success', $message);

            return $this->redirectToRoute('email_templates_action');
        }

        return $this->render('@UVDeskCoreFramework//templateForm.html.twig', array(
            'template' => $template,
        ));
    }

    public function templatesxhr(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_EMAIL_TEMPLATE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();
        $error = false;
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $repository = $this->getDoctrine()->getRepository(EmailTemplates::class);
                $json =  $repository->getEmailTemplates($request->query, $container);
            } else {
                if ($request->attributes->get('template')){
                    if ($templateBase = $this->getTemplate($request)) {
                        if ($request->getMethod() == 'DELETE' ) {
                            $em = $this->getDoctrine()->getManager();
                            $em->remove($templateBase);
                            $em->flush();

                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = 'Success! Template has been deleted successfully.';
                        } else
                            $error = true;
                    } else {
                        $json['alertClass'] = 'danger';
                        $json['alertMessage'] = $this->translator->trans('Warning! resource not found.');
                        $json['statusCode'] = Response::HTTP_NO_FOUND;
                    }
                }
            }
        }

        if ($error) {
            $json['alertClass'] = 'danger';
            $json['alertMessage'] = $this->translator->trans('Warning! You can not remove predefined email template which is being used in workflow(s).');
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
