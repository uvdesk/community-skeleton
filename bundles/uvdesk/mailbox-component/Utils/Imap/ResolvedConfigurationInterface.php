<?php

namespace Webkul\UVDesk\MailboxBundle\Utils\Imap;

interface ResolvedConfigurationInterface
{
    public static function getCode();
    
    public static function getName();
    
    public static function getHost();
    
    public function setUsername($username);
    
    public function getUsername();

    public function setPassword($password);
    
    public function getPassword();
}
