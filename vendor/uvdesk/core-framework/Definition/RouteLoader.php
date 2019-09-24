<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Definition;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RouteLoader extends Loader implements RouterInterface
{
    private $routingResources = [];
    
    public function __construct(ContainerInterface $container)
	{
        $this->env = $container->get('kernel')->getEnvironment();
    }

    public function addRoutingResource(RoutingResourceInterface $routingResource, array $tags = [])
    {
        if (empty($tags)) {
            $this->routingResources[] = $routingResource;

            return;
        }
        
        foreach ($tags as $tag) {
            if (empty($tag) || empty($tag['env'])) {
                $this->routingResources[] = $routingResource;
            } else if (!empty($tag['env']) && $this->env === $tag['env']) {
                $this->routingResources[] = $routingResource;
            }
        }
    }
    
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        foreach ($this->routingResources as $routingResource) {
            $collection->addCollection($this->import($routingResource->getResourcePath(), $routingResource->getResourceType()));
        }

        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return 'uvdesk' === $type;
    }
}
