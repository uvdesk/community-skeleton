<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments;

interface HomepageSectionInterface
{
    public static function getTitle() : string;
    public static function getDescription() : string;
    public static function getRoles() : array;
    
    public function appendItem(HomepageSectionItemInterface $item) : HomepageSectionInterface;
    public function getItemCollection() : array;
}
