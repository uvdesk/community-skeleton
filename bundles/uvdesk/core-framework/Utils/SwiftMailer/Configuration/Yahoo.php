<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\Configuration;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\BaseConfiguration;

class Yahoo extends BaseConfiguration
{
    CONST HOST = 'smtp.mail.yahoo.com';
    CONST PORT = '587';
    CONST ENCRYPTION_MODE = 'tls';
    CONST AUTHENTICATION_MODE = 'login';
    CONST TRANSPORT_CODE = 'yahoo';
    CONST TRANSPORT_NAME = 'Yahoo';

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

    public static function getTransportCode()
    {
        return self::TRANSPORT_CODE;
    }

    public static function getTransportName()
    {
        return self::TRANSPORT_NAME;
    }

    public function getHost()
    {
        return self::HOST;
    }

    public function getPort()
    {
        return self::PORT;
    }

    public function getEncryptionMode()
    {
        return self::ENCRYPTION_MODE;
    }

    public function getAuthenticationMode()
    {
        return self::AUTHENTICATION_MODE;
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
            '[[ sender_address ]]' => '# sender_address: ~',
            '[[ delivery_addresses ]]' => '# delivery_addresses: ~',
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
                case 'host':
                case 'port':
                case 'auth_mode':
                case 'encryption':
                    break;
                case 'disable_delivery':
                    $this->setDeliveryStatus(!(bool) $value);
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
