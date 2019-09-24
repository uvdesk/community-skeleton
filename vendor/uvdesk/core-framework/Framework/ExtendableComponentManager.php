<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Framework;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ExtendableComponentManager
{
    private $components = [];

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
    }

    public function addComponent(ExtendableComponentInterface $component, array $tags = [])
    {
        $this->components[get_class($component)] = $component;
    }

    public function getRegisteredComponent($className) : ExtendableComponentInterface
    {
        return $this->components[$className];
    }
}
