<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Customer;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class AccountCreated implements UVDeskEmailTemplateInterface
{
    private static $type = "user";
    private static $name = 'Customer Account Created';
    private static $subject = 'Welcome to {%global.companyName%} Helpdesk';
    private static $message = <<<MESSAGE
    <p></p>
    <p></p>
    <p></p>
    <p style="text-align: center; ">{%global.companyLogo%}</p>
    <p style="text-align: center; ">
        <br />
    </p>
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
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">Your account has been successfully created. We welcome&nbsp;you to the community of&nbsp;{%global.companyName%}.</p>
    <p style="margin-bottom: 0cm; line-height: 100%"
        align="left">
        <br />
    </p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">It is our privilege to have you as our customer. We are pretty much sure that you will love the fact that how simple it is
        to get started with the services. We are dedicated to making your working life simpler.</p>
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
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">Hoping that you will enjoy this experience.</p>
    <p style="margin-bottom: 0cm; line-height: 100%" align="left">
        <br />
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