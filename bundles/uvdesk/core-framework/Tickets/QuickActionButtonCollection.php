<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Tickets;

use Twig\Environment as TwigEnvironment;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\DashboardTemplate;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;

class QuickActionButtonCollection implements ExtendableComponentInterface
{
	private $collection = [];
	
	public function __construct(TwigEnvironment $twig, DashboardTemplate $dashboard, UserService $userService)
    {
		$this->twig = $twig;
		$this->dashboard = $dashboard;
		$this->userService = $userService;
    }

	public function add(QuickActionButtonInterface $quickActionButton)
	{
		$this->collection[] = $quickActionButton;
	}

	public function injectTemplates()
	{
		return array_reduce($this->collection, function ($stream, $quickActionButton) {
			return $stream .= $quickActionButton->renderTemplate($this->twig);
		}, '');
	}

	public function prepareAssets()
	{
		foreach ($this->collection as $quickActionButton) {
			if ($quickActionButton::getRoles() != null) {
				foreach ($quickActionButton::getRoles() as $accessRole) {
					if ($this->userService->isAccessAuthorized($accessRole)) {
						$quickActionButton->prepareDashboard($this->dashboard);
		
						break;
					}
				}
			} else {
				$quickActionButton->prepareDashboard($this->dashboard);
			}
		}
	}
}
