<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\EventListener\Console;

use Doctrine\ORM\EntityManagerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Mailbox;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command as SymfonyFrameworkCommand;

class Console
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $output = $event->getOutput();
        $command = $event->getCommand();

        switch (true) {
            case $command instanceof SymfonyFrameworkCommand\CacheClearCommand:
                $this->preCacheClearEvent($event);
                break;
            default:
                break;
        }

        return;
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event)
    {
        return;
    }

    private function isDatabaseConfigurationValid()
    {
        $databaseConnection = $this->entityManager->getConnection();

        if (false === $databaseConnection->isConnected()) {
            try {    
                $databaseConnection->connect();
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }

    private function preCacheClearEvent(ConsoleCommandEvent $event)
    {
        // Proceed only if database url is correctly configured.
        if (false === $this->isDatabaseConfigurationValid()) {
            return;
        }

        $output = $event->getOutput();
        // $mailboxes = $this->container->getParameter('uvdesk.mailboxes');
        // $mailboxRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Mailbox');

        // // Check for any duplicate mailboxes for an email
        // foreach (array_count_values(array_column($mailboxes, 'email')) as $email => $occurrences) {
        //     if ($occurrences > 1) {
        //         $output->writeln([
        //             "\n <fg=red;>[MIS-CONFIG]</> <comment>Multiple mailboxes have been configured for email </comment><info>$email</info><comment>.</comment>",
        //             "\n Please verify your configuration settings under <info>uvdesk.mailboxes</info>.\n",
        //         ]);

        //         $event->disableCommand();
        //         return;
        //     }
        // }
        
        // // Validate mailbox configs of localized entities
        // foreach ($mailboxRepository->findByIsLocalized(true) as $localizedMailbox) {
        //     $config = null;

        //     foreach ($mailboxes as $mailboxConfig) {
        //         if ($localizedMailbox->getEmail() == $mailboxConfig['email']) {
        //             $config = $mailboxConfig;
        //             break;
        //         }
        //     }

        //     if (empty($config)) {
        //         $mailboxName = ucwords($localizedMailbox->getName());
        //         $mailboxEmail = $localizedMailbox->getEmail();

        //         $output->writeln([
        //             "\n <fg=red;>[MIS-CONFIG]</> <info>$mailboxName</info><comment> has been setup as a localized mailbox but no configurations were found for email </comment><info>$mailboxEmail</info><comment>.</comment>",
        //             "\n Please verify your configuration settings under <info>uvdesk.mailboxes</info>.\n",
        //         ]);

        //         $event->disableCommand();
        //         return;
        //     }
        // }

        // // Syncronize mailbox configs with database
        // foreach ($mailboxes as $mailboxName => $mailboxConfig) {
        //     $mailbox = $mailboxRepository->findOneByEmail($mailboxConfig['email']) ?: new Mailbox();
        //     $mailbox->setName($mailboxName);
        //     $mailbox->setEmail($mailboxConfig['email']);
        //     $mailbox->setIsEnabled($mailboxConfig['enabled']);
        //     $mailbox->setIsLocalized(true);

        //     $this->entityManager->persist($mailbox);
        // }

        // $this->entityManager->flush();
    }
}
