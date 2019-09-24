<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\StylesheetResourceInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\JavascriptResourceInterface;

class DashboardTemplate implements ExtendableComponentInterface
{
    private $scripts = [];
    private $stylesheets = [];

	public function __construct(ContainerInterface $container, RequestStack $requestStack, RouterInterface $router)
	{
		$this->router = $router;
		$this->container = $container;
		$this->requestStack = $requestStack;
    }
    
    public function appendJavascript($javascript, $tags = [])
	{
		$this->scripts[] = $javascript;
    }

    public function getJavascriptResources()
    {
        return $this->scripts;
    }

	public function appendStylesheet($stylesheet, $tags = [])
	{
		$this->stylesheets[] = $stylesheet;
    }

    public function getStylesheetResources()
    {
        return $this->stylesheets;
    }
}
