<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;

abstract class BaseConfiguration
{
    CONST TOKEN_RANGE = '0123456789';

    protected $id;
    protected $username;
    protected $password;
    protected $senderAddress;
    protected $deliveryAddress;
    protected $deliveryStatus = false;

    public function __construct($id = null)
    {
        $this->setId($id ?: sprintf("mailer_%s", TokenGenerator::generateToken(4, self::TOKEN_RANGE)));
    }

    abstract public function castArray();
    abstract public static function getTransportCode();
    abstract public static function getTransportName();
    abstract public function getWritableConfigurations();
    abstract public function initializeParams(array $params);
    abstract public function resolveTransportConfigurations(array $params = []);

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSenderAddress($senderAddress)
    {
        $this->senderAddress = $senderAddress;
    }

    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryStatus(bool $deliveryStatus = true)
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    public function getDeliveryStatus()
    {
        return $this->deliveryStatus;
    }
}
