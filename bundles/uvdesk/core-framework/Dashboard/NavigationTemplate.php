<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class NavigationTemplate implements ExtendableComponentInterface
{
	CONST TEMPLATE = '<ul class="uv-menubar">[[ COLLECTION ]]</ul>';
	CONST TEMPLATE_ITEM = '<li title = "[[ NAME ]]" class = "[[ ATTRIBUTES ]]" data-toggle = "tooltip" data-placement = "right"><a class="[[ isActive ]]" href="[[ URL ]]"><span class="uv-icon">[[ SVG ]]</span><span class="uv-menu-item">[[ NAME ]]</span></a></li>';
	
	private $segments = [];

	public function __construct(ContainerInterface $container, RequestStack $requestStack, RouterInterface $router, UserService $userService, TranslatorInterface $translator)
	{
		$this->router = $router;
		$this->container = $container;
		$this->requestStack = $requestStack;
		$this->userService = $userService;
		$this->translator = $translator;
	}

	public function appendNavigation(NavigationInterface $segment, $tags = [])
	{
		$this->segments[] = $segment;
	}

	public function render()
	{
		$router = $this->router;
		$request = $this->requestStack->getCurrentRequest();

		
		$route = $this->requestStack->getCurrentRequest()->get('_route');
		// Compile accessible segments by end-user
		$accessibleSegments = [];
		foreach ($this->segments as $item) {
			if (null == $item::getRoles()) {
				$accessibleSegments[] = $item;
			} else {
				foreach ($item::getRoles() as $requiredPermission) {
					if ($this->userService->isAccessAuthorized($requiredPermission)) {
						$accessibleSegments[] = $item;

						break;
					}
				}
			}
		}

		if (array_key_exists(2, $accessibleSegments))
        {
			$temp = $accessibleSegments[1];
			$accessibleSegments[1] = $accessibleSegments[2];
			$accessibleSegments[2] = $temp;
        }
		// Reduce the accessible segments into injectible html snippet
		$html = array_reduce($accessibleSegments, function($html, $segment) use ($router, $request, $route) {
			$isActive = '';
			if($segment::getRouteName() == $route) {
				$isActive = "uv-item-active";
			}

			$html .= strtr(self::TEMPLATE_ITEM, [
				'[[ SVG ]]' => $segment::getIcon(),
				'[[ NAME ]]' => $this->translator->trans($segment::getTitle()),
				'[[ URL ]]' => $router->generate($segment::getRouteName()),
				'[[ isActive ]]' => $isActive,
			]);

			return $html;
		}, '');

		return strtr(self::TEMPLATE, ['[[ COLLECTION ]]' => $html]);
	}
}
