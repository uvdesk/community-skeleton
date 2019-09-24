<?php

namespace Webkul\UVDesk\MailboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\MailboxBundle\Utils\MailboxConfiguration;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\Configuration as ImapConfiguration;

class MailboxChannel extends Controller
{
    public function loadMailboxes()
    {
        return $this->render('@UVDeskMailbox//listConfigurations.html.twig');
    }
    
    public function createMailboxConfiguration(Request $request)
    {
        $swiftmailerConfigurationCollection = $this->get('swiftmailer.service')->parseSwiftMailerConfigurations();

        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();

            // IMAP Configuration
            if (!empty($params['imap']['transport'])) {
                ($imapConfiguration = ImapConfiguration::createTransportDefinition($params['imap']['transport'], !empty($params['imap']['host']) ? $params['imap']['host'] : null))
                    ->setUsername($params['imap']['username'])
                    ->setPassword($params['imap']['password']);
            }

            // Swiftmailer Configuration
            if (!empty($params['swiftmailer_id'])) {
                foreach ($swiftmailerConfigurationCollection as $configuration) {
                    if ($configuration->getId() == $params['swiftmailer_id']) {
                        $swiftmailerConfiguration = $configuration;
                        break;
                    }
                }
            }

            if (!empty($imapConfiguration) && !empty($swiftmailerConfiguration)) {
                $mailboxService = $this->get('uvdesk.mailbox');
                $mailboxConfiguration = $mailboxService->parseMailboxConfigurations();

                ($mailbox = new Mailbox(!empty($params['id']) ? $params['id'] : null))
                    ->setName($params['name'])
                    ->setIsEnabled(!empty($params['isEnabled']) && 'on' == $params['isEnabled'] ? true : false)
                    ->setImapConfiguration($imapConfiguration)
                    ->setSwiftMailerConfiguration($swiftmailerConfiguration);

                $mailboxConfiguration->addMailbox($mailbox);

                file_put_contents($mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);

                $this->addFlash('success', $this->get('translator')->trans('Mailbox successfully created.'));
                return new RedirectResponse($this->generateUrl('helpdesk_member_mailbox_settings'));
            }
        }

        return $this->render('@UVDeskMailbox//manageConfigurations.html.twig', [
            'swiftmailerConfigurations' => $swiftmailerConfigurationCollection,
        ]);
    }

    public function updateMailboxConfiguration($id, Request $request)
    {
        $mailboxService = $this->get('uvdesk.mailbox');
        $existingMailboxConfiguration = $mailboxService->parseMailboxConfigurations();
        $swiftmailerConfigurationCollection = $this->get('swiftmailer.service')->parseSwiftMailerConfigurations();

        foreach ($existingMailboxConfiguration->getMailboxes() as $configuration) {
            if ($configuration->getId() == $id) {
                $mailbox = $configuration;
                break;
            }
        }

        if (empty($mailbox)) {
            return new Response('', 404);
        }

        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();

            // IMAP Configuration
            if (!empty($params['imap']['transport'])) {
                ($imapConfiguration = ImapConfiguration::createTransportDefinition($params['imap']['transport'], !empty($params['imap']['host']) ? $params['imap']['host'] : null))
                    ->setUsername($params['imap']['username'])
                    ->setPassword($params['imap']['password']);
            }

            // Swiftmailer Configuration
            if (!empty($params['swiftmailer_id'])) {
                foreach ($swiftmailerConfigurationCollection as $configuration) {
                    if ($configuration->getId() == $params['swiftmailer_id']) {
                        $swiftmailerConfiguration = $configuration;

                        break;
                    }
                }
            }

            if (!empty($imapConfiguration) && !empty($swiftmailerConfiguration)) {
                $mailboxConfiguration = new MailboxConfiguration();
                
                foreach ($existingMailboxConfiguration->getMailboxes() as $configuration) {
                    if ($mailbox->getId() == $configuration->getId()) {
                        if (empty($params['id'])) {
                            $mailbox = new Mailbox();
                        } else if ($mailbox->getId() != $params['id']) {
                            $mailbox = new Mailbox($params['id']);
                        }

                        $mailbox
                            ->setName($params['name'])
                            ->setIsEnabled(!empty($params['isEnabled']) && 'on' == $params['isEnabled'] ? true : false)
                            ->setImapConfiguration($imapConfiguration)
                            ->setSwiftMailerConfiguration($swiftmailerConfiguration);

                        $mailboxConfiguration->addMailbox($mailbox);

                        continue;
                    }

                    $mailboxConfiguration->addMailbox($configuration);
                }

                file_put_contents($mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);

                $this->addFlash('success', $this->get('translator')->trans('Mailbox successfully updated.'));
                return new RedirectResponse($this->generateUrl('helpdesk_member_mailbox_settings'));
            }
        }

        return $this->render('@UVDeskMailbox//manageConfigurations.html.twig', [
            'mailbox' => $mailbox ?? null,
            'swiftmailerConfigurations' => $swiftmailerConfigurationCollection,
        ]);
    }
}
