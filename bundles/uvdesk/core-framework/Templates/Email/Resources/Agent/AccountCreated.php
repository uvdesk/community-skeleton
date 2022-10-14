<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Agent;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class AccountCreated implements UVDeskEmailTemplateInterface
{
    private static $type = "user";
    private static $name = 'Agent Account Created';
    private static $subject = 'Welcome to {%global.companyName%} Helpdesk Support System';
    private static $message = <<<MESSAGE
    <p></p>
    <p></p>
    <p></p>
    <p style="text-align: center; ">{%global.companyLogo%}</p>
    <p style="text-align: center; ">
        <span style="font-size: 18px;">
            <b>Thank you for joining!!</b>
        </span>
    </p>
    <p style="text-align: center; ">
        <i>
            <br />
        </i>
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">Hello&nbsp;{%user.userName%},</p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">
        <br />
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">Your account has been successfully created.</p>
    <p style="margin-bottom: 0cm; line-height: 100%"
        align="left">
        <br />
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">
        <span style="line-height: 100%;">Click on the link to set your password </span>{%user.accountValidationLink%}
        <span style="line-height: 100%;">&nbsp;and get started with the </span>{%global.companyName%}
        <span style="line-height: 100%;">&nbsp;services.</span>
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">
        <span style="line-height: 100%;">
            <br />
        </span>
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">Thanks and Regards
        <br />
    </p>
    <p>{%global.companyName%}</p>
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