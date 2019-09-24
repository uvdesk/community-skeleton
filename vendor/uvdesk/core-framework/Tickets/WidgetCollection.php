<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Tickets;

use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;

class WidgetCollection implements ExtendableComponentInterface
{
	private $collection = [];

	public function add(WidgetInterface $widget)
	{
		$this->collection[] = $widget;
	}

	// Render side filter icons
	public function embedSideFilterIcons()
	{
		return array_reduce($this->collection, function($html, $segment) {
			$html .= '<span class="app-glyph filter-view-trigger" data-target="' . $segment::getDataTarget() . '" data-toggle="tooltip" data-placement="top" title="' . $segment::getTitle() . '">' . $segment::getIcon() . '</span>';

			return $html;
		}, '');
	}

	// Render side filter content
	public function embedSideFilterContent()
	{
		return array_reduce($this->collection, function($html, $segment) {
			$html .= $segment->getTemplate();

			return $html;
		}, '');
	}
}
