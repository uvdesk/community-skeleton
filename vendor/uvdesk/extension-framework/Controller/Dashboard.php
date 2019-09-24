<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\ExtensionFrameworkBundle\Utils\ApplicationCollection;

class Dashboard extends Controller
{
    public function applications(Request $request)
    {
        return $this->render('@UVDeskExtensionFramework//dashboard.html.twig', []);
    }

    public function applicationsXHR(Request $request, ApplicationCollection $applications)
    {
        $assetsManager = $this->get('uvdesk_extension.assets_manager');

        $collection = array_map(function ($application) use ($assetsManager) {
            $metadata = $application->getMetadata();
            $packageMetadata = $application->getPackage()->getMetadata();

            return [
                'icon' => $assetsManager->getUrl($metadata->getIconPath()),
                'name' => $metadata->getName(),
                'qname' => $metadata->getQualifiedName(),
                'reference' => [
                    'vendor' => $packageMetadata->getVendor(),
                    'package' => $packageMetadata->getPackage(),
                ],
            ];
        }, $applications->getCollection());

        return new JsonResponse($collection);
    }
}
