<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Customer;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class TicketReply implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Customer Reply To The Agent';
    private static $subject = 'Customer Reply Ticket #{% ticket.id %}';
    private static $message = <<<MESSAGE
    <p></p>
    <p></p>
    <p style="text-align: center; ">{%global.companyLogo%}</p>
    <p style="text-align: center; ">
        <br />
    </p>
    <p style="text-align: center; ">
        <b>
            <span style="font-size: 18px;">New Response!!</span>
        </b>
    </p>
    <p style="text-align: center; ">
        <b>
            <span style="font-size: 18px;">
                <br />
            </span>
        </b>
    </p> Hello {%ticket.agentName%},</p>
    <p></p>
    <p>
        <br />
    </p>
    <p></p>
    <p></p>
    <p>
        <span style="line-height: 1.42857143;">New reply have been added to ticket #{%ticket.id%} you can login to ticket system through this link&nbsp;{%ticket.agentLink%}.</span>
    </p>
    <p>
        <span style="line-height: 1.42857143;">&nbsp;</span>
    </p>
    <p>
        <span style="line-height: 1.42857143;">Customer reply:
            <br />
        </span>{%ticket.threadMessage%}{%ticket.attachments%}</p>
    <p>
        <br />
    </p>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}
        <br />
    </p>
    <p>
        <br />
    </p>
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