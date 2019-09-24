<?php

namespace Doctrine\DBAL\Driver\DrizzlePDOMySql;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\ParameterType;

class Connection extends PDOConnection
{
    /**
     * {@inheritdoc}
     */
    public function quote($value, $type = ParameterType::STRING)
    {
        if ($type === ParameterType::BOOLEAN) {
            return $value ? 'true' : 'false';
        }

        return parent::quote($value, $type);
    }
}
