<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments;

interface SearchItemInterface
{
    public static function getIcon() : string;
    public static function getTitle() : string;
    public static function getRouteName() : string;
    public function getChildrenRoutes() : array;
}
