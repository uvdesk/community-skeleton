<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard;

use Symfony\Component\Routing\RouterInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomepageTemplate implements ExtendableComponentInterface
{
	CONST SECTION_TEMPLATE = '<div class="uv-brick"><div class="uv-brick-head"><h6>[[ TITLE ]]</h6><p>[[ DESCRIPTION ]]</p></div><div class="uv-brick-section">[[ COLLECTION ]]</div></div>';
	CONST SECTION_ITEM_TEMPLATE = '<a href="[[ PATH ]]"><div class="uv-brick-container"><div class="uv-brick-icon">[[ SVG ]]</div><p>[[ TITLE ]]</p></div></a>';

	private $sections = [];
	private $sectionItems = [];
	private $isOrganized = false;

	public function __construct(RouterInterface $router, UserService $userService, TranslatorInterface $translator)
	{
		$this->router = $router;
		$this->userService = $userService;
		$this->translator = $translator;
	}

	public function appendSection(HomepageSectionInterface $section, $tags = [])
	{
		$this->sections[] = $section;
	}

	public function appendSectionItem(HomepageSectionItemInterface $sectionItem, $tags = [])
	{
		$this->sectionItems[] = $sectionItem;
	}

	private function organizeCollection()
	{
		$references = [];
		
		// Sort segments alphabetically
		usort($this->sections, function($section_1, $section_2) {
			return strcasecmp($section_1::getTitle(), $section_2::getTitle());
		});

		// @TODO: Refactor!!!
		$findSectionByName = function(&$array, $name) {
			for ($i = 0; $i < count($array); $i++) {
				if (strtolower($array[$i]::getTitle()) === $name) {
					return array($i, $array[$i]);
				}
			}
		};

		// re-inserting users section
		$users_sec = $findSectionByName($this->sections, "users"); 
		array_splice($this->sections, $users_sec[0], 1);
		array_splice($this->sections, $findSectionByName($this->sections, "knowledgebase")[0] + 1, 0, [$users_sec[1]]);

		usort($this->sectionItems, function($item_1, $item_2) {
			return strcasecmp($item_1::getTitle(), $item_2::getTitle());
		});

		// Maintain array references
		foreach ($this->sections as $reference => $section) {
			$references[get_class($section)] = $reference;
		}

		// Iteratively add child segments to their respective parent segments
		foreach ($this->sectionItems as $sectionItem) {
			if (!array_key_exists($sectionItem::getSectionReferenceId(), $references)) {
				continue;

				// @TODO: Handle exception
				throw new \Exception("No dashboard section [" . $sectionItem::getSectionReferenceId() . "] found for section item " . $sectionItem::getTitle() . " [" . get_class($sectionItem) . "].");
			}

			$this->sections[$references[$sectionItem::getSectionReferenceId()]]->appendItem($sectionItem);
		}

		$this->isOrganized = true;
	}

	private function isSegmentAccessible($segment)
	{
		if ($segment::getRoles() != null) {
			$is_accessible = false;

			foreach ($segment::getRoles() as $accessRole) {
				if ($this->userService->isAccessAuthorized($accessRole)) {
					$is_accessible = true;
	
					break;
				}
			}

			return $is_accessible;
		}

		return true;
	}

	private function getAccessibleSegments()
	{
		$whitelist = [];

		// Filter segments based on user credentials
		foreach ($this->sections as $segment) {
			if (false == $this->isSegmentAccessible($segment)) {
				continue;
			}

			foreach ($segment->getItemCollection() as $childSegment) {
				if (false == $this->isSegmentAccessible($childSegment)) {
					continue;
				}

				$whitelist[get_class($segment)][] = get_class($childSegment);
			}
		}

		return $whitelist;
	}

	public function render()
	{
		if (false == $this->isOrganized) {
			$this->organizeCollection();
		}

		$html = '';
		$whitelist = $this->getAccessibleSegments();

		// Render user accessible segments
		foreach ($this->sections as $segment) {
			if (empty($whitelist[get_class($segment)])) {
				continue;
			}

			$sectionHtml = '';
			$references = $whitelist[get_class($segment)];

			foreach ($segment->getItemCollection() as $childSegment) {
				if (!in_array(get_class($childSegment), $references)) {
					continue;
				}

				$sectionHtml .= strtr(self::SECTION_ITEM_TEMPLATE, [
					'[[ SVG ]]' => $childSegment::getIcon(),
					'[[ TITLE ]]' => $this->translator->trans($childSegment::getTitle()),
					'[[ PATH ]]' => $this->router->generate($childSegment::getRouteName()),
				]);
			}

			$html .= strtr(self::SECTION_TEMPLATE, [
				'[[ TITLE ]]' => $this->translator->trans($segment::getTitle()),
				'[[ DESCRIPTION ]]' => $this->translator->trans($segment::getDescription()),
				'[[ COLLECTION ]]' => $sectionHtml,
			]);
		}

		return $html;
	}
}
