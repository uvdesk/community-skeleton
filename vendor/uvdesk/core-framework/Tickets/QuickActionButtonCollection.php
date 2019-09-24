<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Tickets;

use Twig\Environment as TwigEnvironment;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\DashboardTemplate;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;

class QuickActionButtonCollection implements ExtendableComponentInterface
{
	private $collection = [];

	public function __construct(TwigEnvironment $twig, DashboardTemplate $dashboard)
    {
		$this->twig = $twig;
		$this->dashboard = $dashboard;
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
			$quickActionButton->prepareDashboard($this->dashboard);
		}
	}
}
