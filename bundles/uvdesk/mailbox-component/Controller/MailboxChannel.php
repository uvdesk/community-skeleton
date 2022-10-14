<?php

namespace Webkul\UVDesk\MailboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\MailboxBundle\Utils\MailboxConfiguration;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\Configuration as ImapConfiguration;
use Webkul\UVDesk\MailboxBundle\Services\MailboxService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\SwiftMailer as SwiftMailerService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;

class MailboxChannel extends AbstractController
{
    private $mailboxService;
    private $translator;
    private $swiftMailer;
    private $userService;

    public function __construct(UserService $userService, MailboxService $mailboxService, TranslatorInterface $translator, SwiftMailerService $swiftMailer)
    {
        $this->userService = $userService;
        $this->mailboxService = $mailboxService;
        $this->translator = $translator;
        $this->swiftMailer = $swiftMailer;
    }

    public function loadMailboxes()
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskMailbox//listConfigurations.html.twig');
    }
    
    public function createMailboxConfiguration(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $swiftmailerConfigurationCollection = $this->swiftMailer->parseSwiftMailerConfigurations();

        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();

            // IMAP Configuration
            if (!empty($params['imap']['transport'])) {
                ($imapConfiguration = ImapConfiguration::createTransportDefinition($params['imap']['transport'], !empty($params['imap']['host']) ? trim($params['imap']['host'], '"') : null))
                    ->setUsername($params['imap']['username'])
                    ->setPassword(base64_encode($params['imap']['password']));
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
                $mailboxService = $this->mailboxService;
                $mailboxConfiguration = $mailboxService->parseMailboxConfigurations();

                ($mailbox = new Mailbox(!empty($params['id']) ? $params['id'] : null))
                    ->setName($params['name'])
                    ->setIsEnabled(!empty($params['isEnabled']) && 'on' == $params['isEnabled'] ? true : false)
                    ->setIsDeleted(!empty($params['isDeleted']) && 'on' == $params['isDeleted'] ? true : false)
                    ->setImapConfiguration($imapConfiguration)
                    ->setSwiftMailerConfiguration($swiftmailerConfiguration);

                $mailboxConfiguration->addMailbox($mailbox);

                file_put_contents($mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);

                $this->addFlash('success', $this->translator->trans('Mailbox successfully created.'));
                return new RedirectResponse($this->generateUrl('helpdesk_member_mailbox_settings'));
            }
        }

        return $this->render('@UVDeskMailbox//manageConfigurations.html.twig', [
            'swiftmailerConfigurations' => $swiftmailerConfigurationCollection,
        ]);
    }

    public function updateMailboxConfiguration($id, Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $mailboxService = $this->mailboxService;
        $existingMailboxConfiguration = $mailboxService->parseMailboxConfigurations();
        $swiftmailerConfigurationCollection = $this->swiftMailer->parseSwiftMailerConfigurations();

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
                ($imapConfiguration = ImapConfiguration::createTransportDefinition($params['imap']['transport'], !empty($params['imap']['host']) ? trim($params['imap']['host'], '"') : null))
                    ->setUsername($params['imap']['username'])
                    ->setPassword(base64_encode($params['imap']['password']));
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
                            ->setIsDeleted(!empty($params['isDeleted']) && 'on' == $params['isDeleted'] ? true : false)
                            ->setImapConfiguration($imapConfiguration)
                            ->setSwiftMailerConfiguration($swiftmailerConfiguration);

                        $mailboxConfiguration->addMailbox($mailbox);

                        continue;
                    }

                    $mailboxConfiguration->addMailbox($configuration);
                }

                file_put_contents($mailboxService->getPathToConfigurationFile(), (string) $mailboxConfiguration);

                $this->addFlash('success', $this->translator->trans('Mailbox successfully updated.'));
                
                return new RedirectResponse($this->generateUrl('helpdesk_member_mailbox_settings'));
            }
        }

        return $this->render('@UVDeskMailbox//manageConfigurations.html.twig', [
            'mailbox' => $mailbox ?? null,
            'swiftmailerConfigurations' => $swiftmailerConfigurationCollection,
        ]);
    }
}
