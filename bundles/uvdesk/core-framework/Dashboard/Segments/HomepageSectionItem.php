<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class HomepageSectionItem implements HomepageSectionItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M17,26a4,4,0,1,1-4,4A4,4,0,0,1,17,26Zm13,0a4,4,0,1,1-4,4A4,4,0,0,1,30,26Zm13,0a4,4,0,1,1-4,4A4,4,0,0,1,43,26Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getRoles() : array
    {
        return [];
    }
    
    public abstract static function getTitle() : string;
    public abstract static function getRouteName() : string;
    public abstract static function getSectionReferenceId() : string;
}
