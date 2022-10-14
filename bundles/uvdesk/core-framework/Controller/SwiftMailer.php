<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationUpdatedEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\SwiftMailer as SwiftMailerService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SwiftMailer extends AbstractController
{
    private $userService;
    private $translator;
    private $swiftMailer;
    
    public function __construct(UserService $userService, TranslatorInterface $translator,SwiftMailerService $swiftMailer)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->swiftMailer = $swiftMailer;
    }

    public function loadMailers()
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            throw new AccessDeniedException("Insufficient account privileges");
        }

        return $this->render('@UVDeskCoreFramework//SwiftMailer//listConfigurations.html.twig');
    }
    
    public function createMailerConfiguration(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();
            $params['password'] = base64_encode($params['password']);
            $swiftmailer = $this->swiftMailer;

            $swiftmailerConfiguration = $swiftmailer->createConfiguration($params['transport'], $params['id']);
            
            if (!empty($swiftmailerConfiguration)) {
                $swiftmailerConfiguration->initializeParams($params);
                $configurations = $swiftmailer->parseSwiftMailerConfigurations();

                $configurations[] = $swiftmailerConfiguration;
                
                try {
                    $swiftmailer->writeSwiftMailerConfigurations($configurations);
                    $this->addFlash('success', $this->translator->trans('SwiftMailer configuration created successfully.'));
                    return new RedirectResponse($this->generateUrl('helpdesk_member_swiftmailer_settings'));
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                }
            }
        }

        return $this->render('@UVDeskCoreFramework//SwiftMailer//manageConfigurations.html.twig');
    }

    public function updateMailerConfiguration($id, Request $request, ContainerInterface $container)
    {
        $swiftmailerService = $this->swiftMailer;;
        $swiftmailerConfigurations = $swiftmailerService->parseSwiftMailerConfigurations();
        
        foreach ($swiftmailerConfigurations as $index => $configuration) {
            if ($configuration->getId() == $id) {
                $swiftmailerConfiguration = $configuration;
                break;
            }
        }
       
        if (empty($swiftmailerConfiguration)) {
            return new Response('', 404);
        }

        if ($request->getMethod() == 'POST') {
            $params = $request->request->all(); 
            $params['password'] = base64_encode($params['password']);  
            $existingSwiftmailerConfiguration = clone $swiftmailerConfiguration;
            $swiftmailerConfiguration = $swiftmailerService->createConfiguration($params['transport'], $params['id']);
            $swiftmailerConfiguration->initializeParams($params);
              
            // Dispatch swiftmailer configuration updated event
            $event = new ConfigurationUpdatedEvent($swiftmailerConfiguration, $existingSwiftmailerConfiguration);
            
            $container->get('uvdesk.core.event_dispatcher')->dispatch($event, ConfigurationUpdatedEvent::NAME);

            // Updated swiftmailer configuration file
            $swiftmailerConfigurations[$index] = $swiftmailerConfiguration;            
            $swiftmailerService->writeSwiftMailerConfigurations($swiftmailerConfigurations);
            
            $this->addFlash('success', $this->translator->trans('SwiftMailer configuration updated successfully.'));
            return new RedirectResponse($this->generateUrl('helpdesk_member_swiftmailer_settings'));
        }

        return $this->render('@UVDeskCoreFramework//SwiftMailer//manageConfigurations.html.twig', [
            'configuration' => $swiftmailerConfiguration->castArray(),
        ]);
    }
}
