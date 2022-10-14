<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\ExtensionFrameworkBundle\Utils\ApplicationCollection;
use Webkul\UVDesk\ExtensionFrameworkBundle\Application\Routine\ApiRoutine;
use Webkul\UVDesk\ExtensionFrameworkBundle\Application\Routine\RenderDashboardRoutine;

class Application extends AbstractController
{
    public function dashboard($vendor, $package, $qualifiedName, ApplicationCollection $applicationCollection, RenderDashboardRoutine $event)
    {
        $application = $applicationCollection->findApplicationByFullyQualifiedName($vendor, $package, $qualifiedName);

        if (empty($application)) {
            throw new \Exception("No application found with the qualified name of '$qualifiedName' within the '$vendor/$package' namespace.", 404);
        }

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($application);
        $dispatcher->dispatch($event, $event::getName());

        // Prepare template data
        $templateData = array_merge([
            'dashboard' => [
                'template' => $event->getTemplateReference()
            ],
            'application' => $application
        ], $event->getTemplateData());

        return $this->render('@UVDeskExtensionFramework//applicationDashboard.html.twig', $templateData);
    }

    public function apiEndpointXHR($vendor, $package, $qualifiedName, ApplicationCollection $applicationCollection, ApiRoutine $event)
    {
        $application = $applicationCollection->findApplicationByFullyQualifiedName($vendor, $package, $qualifiedName);

        if (empty($application)) {
            throw new \Exception("No application found with the qualified name of '$qualifiedName' within the '$vendor/$package' namespace.", 404);
        }

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($application);
        $dispatcher->dispatch($event, $event::getName());

        return new JsonResponse($event->getResponseData(), $event->getResponseCode());
    }
}