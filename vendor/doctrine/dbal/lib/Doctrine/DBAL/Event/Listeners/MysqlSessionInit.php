<?php

namespace Doctrine\DBAL\Event\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;

/**
 * MySQL Session Init Event Subscriber which allows to set the Client Encoding of the Connection.
 *
 * @deprecated Use "charset" option to PDO MySQL Connection instead.
 */
class MysqlSessionInit implements EventSubscriber
{
    /**
     * The charset.
     *
     * @var string
     */
    private $charset;

    /**
     * The collation, or FALSE if no collation.
     *
     * @var string|bool
     */
    private $collation;

    /**
     * Configure Charset and Collation options of MySQL Client for each Connection.
     *
     * @param string      $charset   The charset.
     * @param string|bool $collation The collation, or FALSE if no collation.
     */
    public function __construct($charset = 'utf8', $collation = false)
    {
        $this->charset   = $charset;
        $this->collation = $collation;
    }

    /**
     * @return void
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        $collation = $this->collation ? ' COLLATE ' . $this->collation : '';
        $args->getConnection()->executeUpdate('SET NAMES ' . $this->charset . $collation);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [Events::postConnect];
    }
}
