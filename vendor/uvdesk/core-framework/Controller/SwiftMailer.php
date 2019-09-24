<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationUpdatedEvent;

class SwiftMailer extends Controller
{
    public function loadMailers()
    {
        return $this->render('@UVDeskCoreFramework//SwiftMailer//listConfigurations.html.twig');
    }
    
    public function createMailerConfiguration(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();
            $swiftmailer = $this->get('swiftmailer.service');

            $swiftmailerConfiguration = $swiftmailer->createConfiguration($params['transport'], $params['id']);
            
            if (!empty($swiftmailerConfiguration)) {
                $swiftmailerConfiguration->initializeParams($params);
                $configurations = $swiftmailer->parseSwiftMailerConfigurations();

                $configurations[] = $swiftmailerConfiguration;
                
                try {
                    $swiftmailer->writeSwiftMailerConfigurations($configurations);

                    $this->addFlash('success', 'SwiftMailer configuration created successfully.');
                    return new RedirectResponse($this->generateUrl('helpdesk_member_swiftmailer_settings'));
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                }
            }
        }

        return $this->render('@UVDeskCoreFramework//SwiftMailer//manageConfigurations.html.twig');
    }

    public function updateMailerConfiguration($id, Request $request)
    {
        $swiftmailerService = $this->get('swiftmailer.service');
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
            $existingSwiftmailerConfiguration = clone $swiftmailerConfiguration;
            $swiftmailerConfiguration = $swiftmailerService->createConfiguration($params['transport'], $params['id']);
            $swiftmailerConfiguration->initializeParams($params);
              
            // Dispatch swiftmailer configuration updated event
            $event = new ConfigurationUpdatedEvent($swiftmailerConfiguration, $existingSwiftmailerConfiguration);
            $this->get('uvdesk.core.event_dispatcher')->dispatch(ConfigurationUpdatedEvent::NAME, $event);

            // Updated swiftmailer configuration file
            $swiftmailerConfigurations[$index] = $swiftmailerConfiguration;            
            $swiftmailerService->writeSwiftMailerConfigurations($swiftmailerConfigurations);
            
            $this->addFlash('success', $this->get('translator')->trans('SwiftMailer configuration updated successfully.'));
            return new RedirectResponse($this->generateUrl('helpdesk_member_swiftmailer_settings'));
        }

        return $this->render('@UVDeskCoreFramework//SwiftMailer//manageConfigurations.html.twig', [
            'configuration' => $swiftmailerConfiguration->castArray(),
        ]);
    }
}
