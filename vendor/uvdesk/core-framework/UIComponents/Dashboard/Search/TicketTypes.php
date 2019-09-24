<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;

class TicketTypes implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M6,44v5H22V44H6ZM6,11v5H33V11H6ZM33,54V49H54V44H33V39H28V54h5ZM17,23v5H6v5H17v5h5V23H17ZM54,33V28H28v5H54ZM39,21h5V16H54V11H44V6H39V21Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return "Ticket Types";
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_ticket_type_collection';
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }
}
