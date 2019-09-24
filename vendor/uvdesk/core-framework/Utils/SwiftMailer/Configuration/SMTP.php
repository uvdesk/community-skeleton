<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\Configuration;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\BaseConfiguration;

class SMTP extends BaseConfiguration
{
    CONST TRANSPORT_CODE = 'smtp';
    CONST TRANSPORT_NAME = 'SMTP';

    CONST TEMPLATE = <<<MAILER
        [[ id ]]:
            transport: smtp
            [[ username ]]
            [[ password ]]
            [[ host ]]
            [[ port ]]
            [[ encryption ]]
            [[ authentication ]]
            [[ sender_address ]]
            [[ delivery_addresses ]]
            [[ disable_delivery ]]

MAILER;
    
    private $host;
    private $port;
    private $encryptionMode;
    private $authenticationMode;

    public static function getTransportCode()
    {
        return self::TRANSPORT_CODE;
    }

    public static function getTransportName()
    {
        return self::TRANSPORT_NAME;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setEncryptionMode($encryptionMode)
    {
        $this->encryptionMode = $encryptionMode;
    }

    public function getEncryptionMode()
    {
        return $this->encryptionMode;
    }

    public function setAuthenticationMode($authenticationMode)
    {
        $this->authenticationMode= $authenticationMode;
    }

    public function getAuthenticationMode()
    {
        return $this->authenticationMode;
    }

    public function getWritableConfigurations()
    {
        $params = [
            '[[ id ]]' => $this->getId(),
            '[[ username ]]' => sprintf("username: %s", $this->getUsername()),
            '[[ password ]]' => sprintf("password: %s", $this->getPassword()),
            '[[ host ]]' => sprintf("host: %s", $this->getHost()),
            '[[ port ]]' => sprintf("port: %s", $this->getPort()),
            '[[ encryption ]]' => sprintf("encryption: %s", $this->getEncryptionMode()),
            '[[ authentication ]]' => sprintf("auth_mode: %s", $this->getAuthenticationMode()),
            '[[ sender_address ]]' => sprintf("sender_address: %s", $this->getSenderAddress()),
            '[[ delivery_addresses ]]' => "delivery_addresses: ['".$this->getDeliveryAddress()."']",
            '[[ disable_delivery ]]' => "disable_delivery: " . ($this->getDeliveryStatus() ? "false" : "true"),
        ];

        return strtr(self::TEMPLATE, $params);
    }

    public function castArray()
    {
        return [
            'transport' => $this->getTransportCode(),
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'encryption' => $this->getEncryptionMode(),
            'authentication' => $this->getAuthenticationMode(),
            'delivery_addresses' => $this->getDeliveryAddress(),
            'sender_address' => $this->getSenderAddress(),
            'deliveryStatus' => $this->getDeliveryStatus(),
        ];
    }

    public function initializeParams(array $params, $reset = false)
    {
        if (empty($param['deliveryStatus'])){
            $this->setDeliveryStatus(false);
        }

        foreach ($params as $param => $value) {
            switch ($param) {
                case 'id':
                    if (true == $reset) {
                        $this->setId($value);
                    }
                    break;
                case 'deliveryStatus':
                    $this->setDeliveryStatus(($value == 'on') ? true : false);
                    break;
                default:
                    $method = 'set' . ucfirst($param);
                    
                    if (is_callable([$this, $method])) {
                        $this->{$method}($value);
                    }
                    break;
            }
        }
    }

    public function resolveTransportConfigurations(array $params = [])
    {
        $this->setDeliveryStatus(true);

        foreach ($params as $param => $value) {
            $method = 'set' . ucfirst($param);

            switch ($param) {
                case 'disable_delivery':
                    $this->setDeliveryStatus(!(bool) $value);
                    break;
                case 'auth_mode':
                    $this->setAuthenticationMode($value);
                    break;
                case 'encryption':
                    $this->setEncryptionMode($value);
                    break;
                default:
                    $method = 'set' . ucfirst($param);
                    
                    if (is_callable([$this, $method])) {
                        $this->{$method}($value);
                    }
                    break;
            }
        }
    }
}
