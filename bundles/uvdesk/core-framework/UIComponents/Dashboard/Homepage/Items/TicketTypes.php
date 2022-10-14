<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Items;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSectionItem;
use Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections\Productivity;

class TicketTypes extends HomepageSectionItem
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px" height="60px" viewBox="0 0 60 60">
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

    public static function getRoles() : array
    {
        return ['ROLE_AGENT_MANAGE_TICKET_TYPE'];
    }

    public static function getSectionReferenceId() : string
    {
        return Productivity::class;
    }
}
