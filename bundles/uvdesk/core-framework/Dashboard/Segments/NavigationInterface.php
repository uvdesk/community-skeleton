<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments;

interface NavigationInterface
{
    public static function getIcon() : string;
    public static function getTitle() : string;
    public static function getRouteName() : string;
    public static function getRoles() : array;
    public function getChildrenRoutes() : array;
}
