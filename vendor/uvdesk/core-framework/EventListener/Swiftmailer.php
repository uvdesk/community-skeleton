<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationRemovedEvent;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationUpdatedEvent;

class Swiftmailer
{
    protected $container;

    public final function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function getPathToConfigurationFile()
    {
        return $this->container->getParameter('kernel.project_dir') . '/config/packages/uvdesk.yaml';
    }

    private function updateSwiftmailerConfigurationId($swiftmailerId = null)
    {
        $supportId = $this->container->getParameter('uvdesk.support_email.id');
        $supportName = $this->container->getParameter('uvdesk.support_email.name');
        
        if (!empty($supportId) && !empty($supportName)) {
            $template = require __DIR__ . '/../Templates/uvdesk.php';
            $content = strtr($template, [
                '{{ SITE_URL }}' => $this->container->getParameter('uvdesk.site_url'),
                '{{ SUPPORT_EMAIL_ID }}' => $supportId,
                '{{ SUPPORT_EMAIL_NAME }}' => $supportName,
                '{{ SUPPORT_EMAIL_MAILER_ID }}'  => $swiftmailerId ?? '~',
            ]);

            file_put_contents($this->getPathToConfigurationFile(), $content);
        }

        return;
    }

    public function onSwiftmailerConfigurationUpdated(ConfigurationUpdatedEvent $event)
    {
        $swiftmailerId = $this->container->hasParameter('uvdesk.support_email.mailer_id') ? $this->container->getParameter('uvdesk.support_email.mailer_id') : null;
        
        if (!empty($swiftmailerId)) {
            $updatedSwiftmailerConfiguration = $event->getUpdatedSwiftMailerConfiguration();
            $existingSwiftmailerConfiguration = $event->getExistingSwiftMailerConfiguration();

            if ($existingSwiftmailerConfiguration->getId() == $swiftmailerId) {
                $this->updateSwiftmailerConfigurationId($updatedSwiftmailerConfiguration->getId());
            }
        }

        return;
    }

    public function onSwiftmailerConfigurationRemoved(ConfigurationRemovedEvent $event)
    {
        $swiftmailerId = $this->container->hasParameter('uvdesk.support_email.mailer_id') ? $this->container->getParameter('uvdesk.support_email.mailer_id') : null;
        
        if (!empty($swiftmailerId)) {
            $swiftmailerConfiguration = $event->getSwiftMailerConfiguration();

            if ($swiftmailerConfiguration->getId() == $swiftmailerId) {
                $this->updateSwiftmailerConfigurationId(null);
            }
        }

        return;
    }
}
