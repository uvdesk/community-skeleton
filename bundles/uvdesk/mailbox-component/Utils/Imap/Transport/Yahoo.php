<?php

namespace Webkul\UVDesk\MailboxBundle\Utils\Imap\Transport;

use Webkul\UVDesk\MailboxBundle\Utils\Imap\ConfigurationInterface;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\ResolvedConfigurationInterface;

class Yahoo implements ConfigurationInterface, ResolvedConfigurationInterface
{
    CONST CODE = 'yahoo';
    CONST NAME = 'Yahoo';
    CONST HOST = '{imap.mail.yahoo.com:993/imap/ssl}INBOX';

    private $username;
    private $password;
    
    public static function getCode()
    {
        return self::CODE;
    }

    public static function getName()
    {
        return self::NAME;
    }

    public static function getHost()
    {
        return self::HOST;
    }

    public static function getTransportCode()
    {
        return self::TRANSPORT_CODE;
    }

    public static function getTransportName()
    {
        return self::TRANSPORT_NAME;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
