<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\MappingResource;

class Kernel
{
    private $isTwigConfigured = false;

    public function __construct(ContainerInterface $container, MappingResource $mappingResource)
    {
        $this->container = $container;
        $this->mappingResource = $mappingResource;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ('GET' === strtoupper($event->getRequest()->getMethod())) {
            $this->configureTwigResources();
        }
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        // $request = $event->getRequest();
        // list($class, $method) = explode('::', $request->get('_controller'));

        // $reflectionClass = new \ReflectionClass($class);
        
        // if ($reflectionClass->hasMethod($method)) {
        //     $args = [];
        //     $controllerArguments = $event->getArguments();

        //     foreach ($reflectionClass->getMethod($method)->getParameters() as $index => $parameter) {
        //         if ($parameter->getType() != null && ApplicationInterface::class === $parameter->getType()->getName()) {
        //             if (false === (bool) ($controllerArguments[$index] instanceof ApplicationInterface)) {
        //                 $vendor = $request->get('vendor');
        //                 $package = $request->get('extension');
        //                 $name = $request->get('application');

        //                 $application = $this->applicationCollection->findApplicationByFullyQualifiedName($vendor, $package, $name);

        //                 if (!empty($application)) {
        //                     $args[] = $application;

        //                     continue;
        //                 }
        //             }
        //         }
                
        //         $args[] = $controllerArguments[$index];
        //     }

        //     $event->setArguments($args);
        // }
    }

    private function configureTwigResources()
    {
        if ($this->isTwigConfigured) {
            return $this;
        }

        $twig = $this->container->get('uvdesk_extension.twig_loader');

        foreach ($this->mappingResource->getPackages() as $id => $attributes) {
            $class = new \ReflectionClass($id);
            $resources = dirname($class->getFileName()) . "/Resources/views";

            list($vendor, $package) = explode('/', $attributes['metadata']['name']);

            if (is_dir($resources)) {
                $twig->addPath($resources, sprintf("_uvdesk_extension_%s_%s", str_replace('-', '_', $vendor), str_replace('-', '_', $package)));
            }
        }

        $this->isTwigConfigured = true;
        
        return $this;
    }
}
