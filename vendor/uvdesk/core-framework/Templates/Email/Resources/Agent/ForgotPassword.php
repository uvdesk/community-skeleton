<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\Resources\Agent;

use Webkul\UVDesk\CoreFrameworkBundle\Templates\Email\UVDeskEmailTemplateInterface;

abstract class ForgotPassword implements UVDeskEmailTemplateInterface
{
    private static $type = "user";
    private static $name = 'Agent Forgot Password';
    private static $subject = 'Agent Forgot Password';
    private static $message = <<<MESSAGE
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p style="text-align: center; ">{%global.companyLogo%}</p>
    <p style="text-align: center; ">
        <br />
    </p>
    <p style="text-align: center; ">
        <b>
            <span style="font-size: 18px;">Forgot password, this is it!!</span>
        </b>
    </p>
    <p style="text-align: center; ">
        <br />
    </p>
    <p>Hi&nbsp;{%user.userName%},
        <br />
    </p>
    <p>
        <br />
    </p>
    <p>You recently requested to reset your password for your {%global.companyName%} account. Click the link to reset it&nbsp;{%user.forgotPasswordLink%}</p>
    <p>
        <br />
    </p>
    <p>If you did not request a password reset, please ignore this mail or revert back to let us know.</p>
    <div>
        <br />
    </div>
    <p>Thanks and Regards</p>
    <p>{%global.companyName%}</p>
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