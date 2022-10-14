<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Branding implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M30,6a24,24,0,0,0,0,48,4,4,0,0,0,2.96-6.693,3.985,3.985,0,0,1,2.987-6.64h4.72A13.338,13.338,0,0,0,54,27.333C54,15.547,43.253,6,30,6ZM15.333,30a4,4,0,1,1,4-4A3.995,3.995,0,0,1,15.333,30Zm8-10.667a4,4,0,1,1,4-4A3.995,3.995,0,0,1,23.333,19.333Zm13.333,0a4,4,0,1,1,4-4A3.995,3.995,0,0,1,36.667,19.333Zm8,10.667a4,4,0,1,1,4-4A3.995,3.995,0,0,1,44.667,30Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Branding";
    }

    public static function getRoles() : array
    {
        return ['ROLE_ADMIN'];
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_helpdesk_theme';
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
