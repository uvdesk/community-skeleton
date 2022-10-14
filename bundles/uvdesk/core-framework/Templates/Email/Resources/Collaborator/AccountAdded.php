<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Collaborator;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class AccountAdded implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Collaborator added to ticket';
    private static $subject = 'A new Collaborator have been added';
    private static $message = <<<MESSAGE
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p style="text-align: center;">{%global.companyLogo%}</p>
    <p style="text-align: center;">&nbsp;</p>
    <p style="text-align: center;"><span style="font-size: 18px;"> <strong>Thank you for joining!!</strong> </span></p>
    <p style="text-align: center;"><em> <br /> </em></p>
    <p style="margin-bottom: 0cm; line-height: 100%;" align="left">Hello {%ticket.collaboratorName%},</p>
    <p style="margin-bottom: 0cm; line-height: 100%;" align="left">&nbsp;</p>
    <p>&nbsp;</p>
    <p>Collaborator of the ticket #{%ticket.id%} has added a reply. You can check the ticket from here {%ticket.customerLink%}</p>
    <p>&nbsp;</p>
    <p>Here go the message:</p>
    <p>{%ticket.threadMessage%}</p>
    <p>&nbsp;</p>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
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