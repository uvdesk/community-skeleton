<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\BaseConfiguration;

/**
 * The swiftmailer.configuration.updated event is dispatched each time a mailer configuration
 * is updated in the system.
 */
class ConfigurationUpdatedEvent extends Event
{
    CONST NAME = 'swiftmailer.configuration.updated';

    private $updatedConfiguration;
    private $existingConfiguration;

    public function __construct(BaseConfiguration $updatedConfiguration, BaseConfiguration $existingConfiguration)
    {
        $this->updatedConfiguration = $updatedConfiguration;
        $this->existingConfiguration = $existingConfiguration;
    }

    public function getUpdatedSwiftMailerConfiguration(): BaseConfiguration
    {
        return $this->updatedConfiguration;
    }

    public function getExistingSwiftMailerConfiguration(): BaseConfiguration
    {
        return $this->existingConfiguration;
    }
}
