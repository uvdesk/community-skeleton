<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class SavedReplies implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M49.206,6.014H10.789a4.794,4.794,0,0,0-4.778,4.8L5.987,54,15,45H49c2.641,0,5.008-1.753,5.008-4.393V10.813A4.815,4.815,0,0,0,49.206,6.014ZM45,36H15V31H45v5Zm0-8H15V23H45v5Zm0-8H15V15H45v5Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Saved Replies";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_saved_replies';
    }

    public static function getRoles() : array
    {
        return [];
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
