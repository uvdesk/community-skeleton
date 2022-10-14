<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard;

use Twig\Environment as TwigEnvironment;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\PanelSidebarItemInterface;

class AsideTemplate implements ExtendableComponentInterface
{
	CONST SECTION_TEMPLATE = '<div class="uv-brick"><div class="uv-brick-head"><h6>[[ TITLE ]]</h6><p>[[ DESCRIPTION ]]</p></div><div class="uv-brick-section">[[ COLLECTION ]]</div></div>';
	CONST SECTION_ITEM_TEMPLATE = '<a href="[[ PATH ]]"><div class="uv-brick-container"><div class="uv-brick-icon">[[ SVG ]]</div><p>[[ TITLE ]]</p></div></a>';

	private $panelSidebars = [];
	private $panelSidebarItems = [];
	private $isOrganized = false;

	public function __construct(RequestStack $requestStack, TwigEnvironment $twig, UserService $userService)
	{
        $this->twig = $twig;
        $this->userService = $userService;
        $this->requestStack = $requestStack;
	}

	public function addPanelSidebar(PanelSidebarInterface $panelSidebar, $tags = [])
	{
		$this->panelSidebars[get_class($panelSidebar)] = $panelSidebar;
	}

	public function addPanelSidebarItem(PanelSidebarItemInterface $panelSidebarItem, $tags = [])
	{
		$this->panelSidebarItems[get_class($panelSidebarItem)] = $panelSidebarItem;
	}

	public function renderSidebar($sidebarReference)
	{
        $sidebar = [
            'title' => null,
            'collection' => [],
        ];
        
        if (!empty($this->panelSidebars[$sidebarReference])) {
            $sidebar['title'] = $sidebarReference::getTitle();
            $route = $this->requestStack->getCurrentRequest()->get('_route');

            foreach ($this->panelSidebarItems as $itemReference => $item) {
                if ($item::getSidebarReferenceId() == $sidebarReference) {
                    $supportedRoutes = array_unique(array_merge((array) $item::getRouteName(), $item::getSupportedRoutes()));

                    if (null == $item::getRoles()) {
                        $sidebar['collection'][] = [
                            'title' => $item::getTitle(),
                            'routeName' => $item::getRouteName(),
                            'isActive' => in_array($route, $supportedRoutes),
                        ];
                    } else {
                        foreach ($item::getRoles() as $requiredPermission) {
                            if ($this->userService->isAccessAuthorized($requiredPermission)) {
                                $sidebar['collection'][] = [
                                    'title' => $item::getTitle(),
                                    'routeName' => $item::getRouteName(),
                                    'isActive' => in_array($route, $supportedRoutes),
                                ];
    
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            $sidebar['title'] = $sidebarReference::getTitle();
            $route = $this->requestStack->getCurrentRequest()->get('_route');

            foreach ($this->panelSidebarItems as $itemReference => $item) {
                if ($item::getSidebarReferenceId() == $sidebarReference) {
                    $supportedRoutes = array_unique(array_merge((array) $item::getRouteName(), $item::getSupportedRoutes()));

                    if (null == $item::getRoles()) {
                        $sidebar['collection'][] = [
                            'title' => $item::getTitle(),
                            'routeName' => $item::getRouteName(),
                            'isActive' => in_array($route, $supportedRoutes),
                        ];
                    } else {
                        foreach ($item::getRoles() as $requiredPermission) {
                            if ($this->userService->isAccessAuthorized($requiredPermission)) {
                                $sidebar['collection'][] = [
                                    'title' => $item::getTitle(),
                                    'routeName' => $item::getRouteName(),
                                    'isActive' => in_array($route, $supportedRoutes),
                                ];
    
                                break;
                            }
                        }
                    }
                }
            } 
        }

        // Sort sidebar items alphabatically
        usort($sidebar['collection'], function ($item_1, $item_2) {
            return strcasecmp($item_1['title'], $item_2['title']);
        });

        return $this->twig->render('@UVDeskCoreFramework/Templates/aside.html.twig', [ 'sidebar' => $sidebar ]);
	}
}