<?php

namespace Doctrine\DBAL\Event\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use const CASE_UPPER;
use function array_change_key_case;
use function array_merge;
use function count;
use function implode;

/**
 * Should be used when Oracle Server default environment does not match the Doctrine requirements.
 *
 * The following environment variables are required for the Doctrine default date format:
 *
 * NLS_TIME_FORMAT="HH24:MI:SS"
 * NLS_DATE_FORMAT="YYYY-MM-DD HH24:MI:SS"
 * NLS_TIMESTAMP_FORMAT="YYYY-MM-DD HH24:MI:SS"
 * NLS_TIMESTAMP_TZ_FORMAT="YYYY-MM-DD HH24:MI:SS TZH:TZM"
 */
class OracleSessionInit implements EventSubscriber
{
    /** @var string[] */
    protected $_defaultSessionVars = [
        'NLS_TIME_FORMAT' => 'HH24:MI:SS',
        'NLS_DATE_FORMAT' => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_FORMAT' => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
        'NLS_NUMERIC_CHARACTERS' => '.,',
    ];

    /**
     * @param string[] $oracleSessionVars
     */
    public function __construct(array $oracleSessionVars = [])
    {
        $this->_defaultSessionVars = array_merge($this->_defaultSessionVars, $oracleSessionVars);
    }

    /**
     * @return void
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        if (! count($this->_defaultSessionVars)) {
            return;
        }

        array_change_key_case($this->_defaultSessionVars, CASE_UPPER);
        $vars = [];
        foreach ($this->_defaultSessionVars as $option => $value) {
            if ($option === 'CURRENT_SCHEMA') {
                $vars[] = $option . ' = ' . $value;
            } else {
                $vars[] = $option . " = '" . $value . "'";
            }
        }
        $sql = 'ALTER SESSION SET ' . implode(' ', $vars);
        $args->getConnection()->executeUpdate($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [Events::postConnect];
    }
}
