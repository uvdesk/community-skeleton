<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\Configuration;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\BaseConfiguration;

class Gmail extends BaseConfiguration
{
    CONST TRANSPORT_CODE = 'gmail';
    CONST TRANSPORT_NAME = 'Gmail';

    CONST TEMPLATE = <<<MAILER
        [[ id ]]:
            transport: gmail
            [[ username ]]
            [[ password ]]
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

    public function getWritableConfigurations()
    {
        $params = [
            '[[ id ]]' => $this->getId(),
            '[[ username ]]' => sprintf("username: %s", $this->getUsername()),
            '[[ password ]]' => sprintf("password: %s", $this->getPassword()),
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
            'sender_address' => $this->getSenderAddress(),
            'delivery_addresses' => $this->getDeliveryAddress(),
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
