<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationRemovedEvent;

class SwiftMailerXHR extends Controller
{
    public function loadMailersXHR(Request $request)
    {
        if (true === $request->isXmlHttpRequest()) {
            $collection = array_map(function ($configuartion) {
                return [
                    'id' => $configuartion->getId(),
                    'email' => $configuartion->getUsername(),
                    'transport' => $configuartion->getTransportName(),
                    'isActive' => $configuartion->getDeliveryStatus(),
                ];
            }, $this->get('swiftmailer.service')->parseSwiftMailerConfigurations());

            return new JsonResponse($collection);
        } 

        return new JsonResponse([], 404);
    }

    public function removeMailerConfiguration(Request $request)
    {
        $params = $request->query->all();
        $swiftmailer = $this->get('swiftmailer.service');
        $configurations = $swiftmailer->parseSwiftMailerConfigurations();
       
        if (!empty($configurations)) {
            foreach ($configurations as $index => $configuration) {
                if ($configuration->getId() == $params['id']) {
                    $swiftmailerConfiguration = $configuration;
                    break;
                }
            }

            if (!empty($swiftmailerConfiguration)) {
                unset($configurations[$index]);

                // Dispatch swiftmailer configuration removed event
                $event = new ConfigurationRemovedEvent($swiftmailerConfiguration);
                $this->get('uvdesk.core.event_dispatcher')->dispatch(ConfigurationRemovedEvent::NAME, $event);

                // Update swiftmailer configuration file
                $swiftmailer->writeSwiftMailerConfigurations($configurations);
                
                return new JsonResponse([
                    'alertClass' => 'success',
                    'alertMessage' => $this->get('translator')->trans('Swiftmailer configuration removed successfully.'),
                ]);
            }
        }

        return new JsonResponse([
            'alertClass' => 'error',
            'alertMessage' => 'No swiftmailer configurations found for mailer id: ' . $params['id'],
        ], 404);
    }
}
