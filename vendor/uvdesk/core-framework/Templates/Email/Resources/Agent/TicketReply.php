<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Agent;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class TicketReply implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Agent Reply To The Customer\'s ticket';
    private static $subject = 'New Reply Added on ticket #{% ticket.id %}';
    private static $message = <<<MESSAGE
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p style="text-align: center">{%global.companyLogo%}</p>
    <p style="text-align: center">
        <br>
    </p>
    <p style="text-align: center">
        <span style="font-size: 18px">
            <b style="font-weight:bold">New Response!!</b>
        </span>
    </p>
    <span style="font-size: 18px">
        <b style="font-weight:bold"> </b>
    </span>
    <p>
        <br>
    </p>
    <p></p>
    <p></p> Hello {%ticket.customerName%},
    <p></p>
    <p></p>
    <p>
        <span style="line-height: 1.42857">
            <br>
        </span>
    </p>
    <p>
        <span style="line-height: 1.42857">A reply has been added by the </span>{%ticket.agentName%} on your ticket {%ticket.id%}. Kindly follow this link {%ticket.customerLink%}
        to get the insight of the message.
        <span style="line-height: 1.42857"> </span>
    </p>
    <p>
        <span style="line-height: 1.42857">
            <br>
        </span>
    </p>
    <p>
        <span style="line-height: 1.42857">Here go the ticket message:</span>
    </p>
    <p>{%ticket.threadMessage%}{%ticket.attachments%}
        <br>
    </p>
    <p></p>
    <p></p>
    <p>
        <br>
    </p>
    <p></p>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}
        <br>
    </p>
    <br>
    <p></p>
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