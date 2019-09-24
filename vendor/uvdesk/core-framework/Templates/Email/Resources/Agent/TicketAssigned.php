<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Agent;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class TicketAssigned implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Ticket Assign';
    private static $subject = 'Ticket #{% ticket.id %} assign to you';
    private static $message = <<<MESSAGE
    <p></p>
    <p style="text-align: center;">{%global.companyLogo%}</p>
    <p style="text-align: center;">
        <br />
    </p>
    <p style="text-align: center;">
        <b>
            <span style="font-size: 18px;">Ticket assigned- Get ready!!</span>
        </b>
    </p>
    <p style="text-align: center; ">
        <br />
    </p> Hello&nbsp;{%ticket.agentName%},
    <br />
    <br />
    <p></p>
    <p>A ticket&nbsp;{%ticket.id%} has been assigned to you. You are requested to follow this link&nbsp;{%ticket.agentLink%} to get the
        access of the ticket.</p>
    <p>
        <br />
    </p>
    <p>Here go the ticket message:</p>
    <p>{%ticket.message%}
        <br />
    </p>
    <p>
        <br />
    </p>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}
        <br />
    </p>
    <p></p>
    <p>
        <br />
    </p>
    <p></p>
    <p>
        <br />
    </p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
MESSAGE;

    public static function getName()
    {
        return self::$name;
    }

    public static function getTemplateType()
    {
        return self::$type;
    }

    public static function getSubject()
    {
        return self::$subject;
    }

    public static function getMessage()
    {
        return self::$message;
    }
}