<?php

namespace Webkul\UVDesk\MailboxBundle\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationRemovedEvent;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\Event\ConfigurationUpdatedEvent;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\SwiftMailer as SwiftMailerService;
use Webkul\UVDesk\MailboxBundle\Services\MailboxService;

class Swiftmailer
{
    protected $container;
    protected $requestStack;
    protected $swiftMailer;
    private $mailboxService;

    public final function __construct(ContainerInterface $container, RequestStack $requestStack, SwiftMailerService $swiftMailer, MailboxService $mailboxService)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
        $this->swiftMailer = $swiftMailer;
        $this->mailboxService = $mailboxService;
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

        $mailboxConfiguration = $this->mailboxService->parseMailboxConfigurations(true);

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
            file_put_contents($this->mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);
        }
        
        return;
    }

    public function onSwiftMailerConfigurationRemoved(ConfigurationRemovedEvent $event)
    {
        $isUpdateRequiredFlag = false;
        $configuration = $event->getSwiftMailerConfiguration(); 
        $mailboxConfiguration = $this->mailboxService->parseMailboxConfigurations();

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
            file_put_contents($this->mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);
        }

        return;
    }
}
