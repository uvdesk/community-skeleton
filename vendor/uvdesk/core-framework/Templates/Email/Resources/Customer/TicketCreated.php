<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Customer;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class TicketCreated implements UVDeskEmailTemplateInterface
{
    private static $type = "ticket";
    private static $name = 'Ticket generated success mail to customer';
    private static $subject = 'New ticket #{% ticket.id %} Received';
    private static $message = <<<MESSAGE
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p style="text-align: center;">{%global.companyLogo%}</p>
<p style="text-align: center;">
    <br />
</p>
<p style="text-align: center;">
    <b>
        <span style="font-size: 18px;">Ticket generated!!</span>
    </b>
</p>
<p style="text-align: center; ">
    <br />
</p>
<br />
<p></p>
<p>Hello&nbsp;{%ticket.customerName%},</p>
<p>
    <br />
</p>
<p></p>
<p>Thank you so much for taking the time to connect us!</p>
<p>
    <br />
</p>
<p>Your ticket #{%ticket.id%} has been received. You can check ticket through this link {%ticket.customerLink%} and you can also reply via this email.</p>
<p>
<p>
    <br />
</p>
<p>Our support staff will get back to you shortly (it might take a bit longer on evenings and weekends). Feel free to ask for any support request we will be happy to help.</p>
<p>
    <span style="line-height: 1.42857143;">
        <br />
    </span>
</p>
<p>Thanks and Regards</p>
<p>{%global.companyName%}
    <br />
</p>
<br />
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
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