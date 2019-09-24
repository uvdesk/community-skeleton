<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Definition\RouterInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Routing\RoutingResourceInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Routing\ExposedRoutingResourceInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Routing\ProtectedRoutingResourceInterface;

class RouteLoader extends Loader implements RouterInterface
{
    CONST EXPOSED_PATH_PREFIX = '/{_locale}/';
    CONST PROTECTED_PATH_PREFIX = '/{_locale}/%uvdesk_site_path.member_prefix%/';

    private $exposedRoutingResources = [];
    private $protectedRoutingResources = [];
    
    public function __construct(ContainerInterface $container)
	{
        $this->env = $container->get('kernel')->getEnvironment();
    }

    public function addExposedRoutingResource(ExposedRoutingResourceInterface $routingResource, array $tags = [])
    {
        if (empty($tags)) {
            $this->exposedRoutingResources[] = $routingResource;

            return;
        }
        
        foreach ($tags as $tag) {
            if (empty($tag) || empty($tag['env'])) {
                $this->exposedRoutingResources[] = $routingResource;
            } else if (!empty($tag['env']) && $this->env === $tag['env']) {
                $this->exposedRoutingResources[] = $routingResource;
            }
        }
    }

    public function addProtectedRoutingResource(ProtectedRoutingResourceInterface $routingResource, array $tags = [])
    {
        if (empty($tags)) {
            $this->protectedRoutingResources[] = $routingResource;

            return;
        }
        
        foreach ($tags as $tag) {
            if (empty($tag) || empty($tag['env'])) {
                $this->protectedRoutingResources[] = $routingResource;
            } else if (!empty($tag['env']) && $this->env === $tag['env']) {
                $this->protectedRoutingResources[] = $routingResource;
            }
        }
    }
    
    public function load($resource, $type = null)
    {
        $routeCollection = new RouteCollection();

        // Add private routing resources
        foreach ($this->protectedRoutingResources as $routingResource) {
            $collection = $this->import($routingResource->getResourcePath(), $routingResource->getResourceType());

            foreach ($collection->all() as $name => $route) {
                $route->setPath(self::PROTECTED_PATH_PREFIX . ltrim($route->getPath(), '/'));
                $route->addDefaults(['_locale' => '%locale%']);
                $route->addRequirements(['_locale' => '%app_locales%']);
            }

            $routeCollection->addCollection($collection);
        }

        // Add public routing resources
        foreach ($this->exposedRoutingResources as $routingResource) {
            $collection = $this->import($routingResource->getResourcePath(), $routingResource->getResourceType());

            foreach ($collection->all() as $name => $route) {
                $route->setPath(self::EXPOSED_PATH_PREFIX . ltrim($route->getPath(), '/'));
                $route->addDefaults(['_locale' => '%locale%']);
                $route->addRequirements(['_locale' => '%app_locales%']);
            }

            $routeCollection->addCollection($collection);
        }

        return $routeCollection;
    }

    public function supports($resource, $type = null)
    {
        return 'uvdesk_extensions' === $type;
    }
}
