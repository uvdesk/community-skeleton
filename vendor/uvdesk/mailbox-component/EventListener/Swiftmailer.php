<?php

namespace Webkul\UVDesk\MailboxBundle\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationRemovedEvent;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationUpdatedEvent;

class Swiftmailer
{
    protected $container;
    protected $requestStack;

    public final function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    public function onSwiftMailerConfigurationUpdated(ConfigurationUpdatedEvent $event)
    {
        $isUpdateRequiredFlag = false;
        $updatedConfiguration = $event->getUpdatedSwiftMailerConfiguration();
        $existingConfiguration = $event->getExistingSwiftMailerConfiguration();
               
        if ($updatedConfiguration->getId() == $existingConfiguration->getId()) {
            // We only need to update if the swiftmailer configuration's id has changed
            // or if it has been disabled.

            return;
        }

        $mailboxConfiguration = $this->container->get('uvdesk.mailbox')->parseMailboxConfigurations(true);

        foreach ($mailboxConfiguration->getMailboxes() as $existingMailbox) {
            if ($existingMailbox->getSwiftmailerConfiguration()->getId() == $existingConfiguration->getId()) {
                // Disable mailbox and update configuration
                $mailbox = new Mailbox($existingMailbox->getId());
                $mailbox->setName($existingMailbox->getName())
                    ->setIsEnabled($existingMailbox->getIsEnabled())
                    ->setImapConfiguration($existingMailbox->getImapConfiguration())
                    ->setSwiftMailerConfiguration($updatedConfiguration);
                
                $isUpdateRequiredFlag = true;
                $mailboxConfiguration->removeMailbox($existingMailbox);
                $mailboxConfiguration->addMailbox($mailbox);
            }
        }

        if (true === $isUpdateRequiredFlag) {
            file_put_contents($this->container->get('uvdesk.mailbox')->getPathToConfigurationFile(), (string) $mailboxConfiguration);
        }
        
        return;
    }

    public function onSwiftMailerConfigurationRemoved(ConfigurationRemovedEvent $event)
    {
        $isUpdateRequiredFlag = false;
        $configuration = $event->getSwiftMailerConfiguration(); 
        $mailboxConfiguration = $this->container->get('uvdesk.mailbox')->parseMailboxConfigurations();

        foreach ($mailboxConfiguration->getMailboxes() as $existingMailbox) {
                if (null != $existingMailbox->getSwiftmailerConfiguration() && $existingMailbox->getSwiftmailerConfiguration()->getId() == $configuration->getId()) {
                    // Disable mailbox and update configuration
                    $mailbox = new Mailbox($existingMailbox->getId());
                    $mailbox->setName($existingMailbox->getName())
                        ->setIsEnabled(false)
                        ->setImapConfiguration($existingMailbox->getImapConfiguration());

                    $isUpdateRequiredFlag = true;
                    $mailboxConfiguration->removeMailbox($existingMailbox);
                    $mailboxConfiguration->addMailbox($mailbox);
                }
        }

        if (true === $isUpdateRequiredFlag) {
            file_put_contents($this->container->get('uvdesk.mailbox')->getPathToConfigurationFile(), (string) $mailboxConfiguration);
        }

        return;
    }
}
