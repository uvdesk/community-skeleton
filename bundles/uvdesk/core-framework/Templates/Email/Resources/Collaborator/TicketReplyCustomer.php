<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Collaborator;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class TicketReplyCustomer implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Collaborator Reply To The Customer';
    private static $subject = 'Collaborator Reply Ticket #{% ticket.id %}';
    private static $message = <<<MESSAGE
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p style="text-align: center;">{%global.companyLogo%}</p>
    <p style="text-align: center;">&nbsp;</p>
    <p style="text-align: center;"><strong> <span style="font-size: 18px;">New Response!!</span> </strong></p>
    <p style="text-align: center;"><strong> <span style="font-size: 18px;"> <br /> </span> </strong></p>
    <p>Hello {%ticket.agentName%},</p>
    <p>&nbsp;</p>
    <p>Collaborator of the ticket #{%ticket.id%} has added a reply. You can check the ticket from here&nbsp;{%ticket.customerLink%}.</p>
    <p>&nbsp;</p>
    <p>Here go the message:</p>
    <p>{%ticket.threadMessage%}{%ticket.attachments%}</p>
    <p>&nbsp;</p>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}</p>
    <p>&nbsp;</p>
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