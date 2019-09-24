<?php

namespace Webkul\UVDesk\MailboxBundle\Services;

use PhpMimeMailParser\Parser;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\HTMLFilter;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Webkul\UVDesk\MailboxBundle\Utils\MailboxConfiguration;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\Configuration as ImapConfiguration;

class MailboxService
{
    const PATH_TO_CONFIG = '/config/packages/uvdesk_mailbox.yaml';

    private $parser;
    private $container;
	private $requestStack;
    private $entityManager;
    private $mailboxCollection = [];

    public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function getPathToConfigurationFile()
    {
        return $this->container->get('kernel')->getProjectDir() . self::PATH_TO_CONFIG;
    }

    public function createConfiguration($params)
    {
        $configuration = new MailboxConfigurations\MailboxConfiguration($params);
        return $configuration ?? null;
    }

    public function parseMailboxConfigurations(bool $ignoreInvalidAttributes = false) 
    {
        $path = $this->getPathToConfigurationFile();

        if (!file_exists($path)) {
            throw new \Exception("File '$path' not found.");
        }

        // Read configurations from package config.
        $mailboxConfiguration = new MailboxConfiguration();
        $swiftmailerService = $this->container->get('swiftmailer.service');
        $swiftmailerConfigurations = $swiftmailerService->parseSwiftMailerConfigurations();

        foreach (Yaml::parse(file_get_contents($path))['uvdesk_mailbox']['mailboxes'] ?? [] as $id => $params) {
            // Swiftmailer Configuration
            $swiftmailerConfiguration = null;

            foreach ($swiftmailerConfigurations as $configuration) {
                if ($configuration->getId() == $params['smtp_server']['mailer_id']) {
                    $swiftmailerConfiguration = $configuration;
                    break;
                }
            }
            
            // IMAP Configuration
            ($imapConfiguration = ImapConfiguration::guessTransportDefinition($params['imap_server']['host']))
                ->setUsername($params['imap_server']['username'])
                ->setPassword($params['imap_server']['password']);

            // Mailbox Configuration
            ($mailbox = new Mailbox($id))
                ->setName($params['name'])
                ->setIsEnabled($params['enabled'])
                ->setImapConfiguration($imapConfiguration);
            
            if (!empty($swiftmailerConfiguration)) {
                $mailbox->setSwiftMailerConfiguration($swiftmailerConfiguration);
            } else if (!empty($params['smtp_server']['mailer_id']) && true === $ignoreInvalidAttributes) {
                $mailbox->setSwiftMailerConfiguration($swiftmailerService->createConfiguration('smtp', $params['smtp_server']['mailer_id']));
            }

            $mailboxConfiguration->addMailbox($mailbox);
        }

        return $mailboxConfiguration;
    }

    private function getParser()
    {
        if (empty($this->parser)) {
            $this->parser = new Parser();
        }

        return $this->parser;
    }

    private function getRegisteredMailboxes()
    {
        if (empty($this->mailboxCollection)) {
            $this->mailboxCollection = array_map(function ($mailboxId) {
                return $this->container->getParameter("uvdesk.mailboxes.$mailboxId");
            }, $this->container->getParameter('uvdesk.mailboxes'));
        }

        return $this->mailboxCollection;
    }

    public function getRegisteredMailboxesById()
    {
        // Fetch existing content in file
        $filePath = $this->getPathToConfigurationFile();
        $file_content = file_get_contents($filePath);

        // Convert yaml file content into array and merge existing mailbox and new mailbox
        $file_content_array = Yaml::parse($file_content, 6);

        if ($file_content_array['uvdesk_mailbox']['mailboxes']) {
            foreach ($file_content_array['uvdesk_mailbox']['mailboxes'] as $key => $value) {
                $value['mailbox_id'] = $key;
                $mailboxCollection[] = $value;
            }
        }
        
        return $mailboxCollection ?? [];
    }

    public function parseAddress($type)
    {
        $addresses = mailparse_rfc822_parse_addresses($this->getParser()->getHeader($type));

        return $addresses ?: false;
    }

    public function getEmailAddress($addresses)
    {
        foreach ((array) $addresses as $address) {
            if (filter_var($address['address'], FILTER_VALIDATE_EMAIL)) {
                return $address['address'];
            }
        }

        return null;
    }

    public function getMailboxByEmail($email)
    {
        foreach ($this->getRegisteredMailboxes() as $registeredMailbox) {
            if ($email === $registeredMailbox['imap_server']['username']) {
                return $registeredMailbox;
            }
        }

        throw new \Exception("No mailbox found for email '$email'");
    }

    private function searchExistingTickets(array $criterias = [])
    {
        if (empty($criterias)) {
            return null;
        }

        $ticketRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');
        $threadRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread');

        foreach ($criterias as $criteria => $criteriaValue) {
            if (empty($criteriaValue)) {
                continue;
            }

            switch ($criteria) {
                case 'messageId':
                    // Search Criteria 1: Find ticket by unique message id
                    $ticket = $ticketRepository->findOneByReferenceIds($criteriaValue);

                    if (!empty($ticket)) {
                        return $ticket;
                    } else {
                        $thread = $threadRepository->findOneByMessageId($criteriaValue);
        
                        if (!empty($thread)) {
                            return $thread->getTicket();
                        }
                    }
                    break;
                case 'inReplyTo':
                    // Search Criteria 2: Find ticket based on in-reply-to reference id
                    $ticket = $ticketRepository->findOneByReferenceIds($criteriaValue);

                    if (!empty($ticket)) {
                        return $ticket;
                    } else {
                        $thread = $threadRepository->findOneByMessageId($criteriaValue);
        
                        if (!empty($thread)) {
                            return $thread->getTicket();
                        }
                    }
                    break;
                case 'referenceIds':
                    // Search Criteria 3: Find ticket based on reference id
                    // Break references into ind. message id collection, and iteratively 
                    // search for existing threads for these message ids.
                    $referenceIds = explode(' ', $criteriaValue);

                    foreach ($referenceIds as $messageId) {
                        $thread = $threadRepository->findOneByMessageId($messageId);

                        if (!empty($thread)) {
                            return $thread->getTicket();
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        // // Search Criteria 4: Find ticket based on subject
        // if (!empty($messageSubject)) {
        //     $ticket = $threadRepository->findTicketBySubject($senderEmail, $subject);

        //     if (!empty($ticket)) {
        //         return $ticket;
        //     }
        // }
        
        return null;
    }
    
    public function processMail($rawEmail)
    {
        $mailData = [];
        $parser = $this->getParser();
        $parser->setText($rawEmail);

        $from = $this->parseAddress('from') ?: $this->parseAddress('sender');
        $addresses = [
            'from' => $this->getEmailAddress($from),
            'to' => $this->parseAddress('to'),
            'cc' => $this->parseAddress('cc'),
            'delivered-to' => $this->parseAddress('delivered-to'),
        ];

        if (empty($addresses['from'])) {
            return;
        } else {
            if (!empty($addresses['to'])) {
                $addresses['to'] = array_map(function($address) {
                    return $address['address'];
                }, $addresses['to']);
            } else if (!empty($addresses['cc'])) {
                $addresses['to'] = array_map(function($address) {
                    return $address['address'];
                }, $addresses['cc']);
            }
            
            // Skip email processing if no to-emails are specified
            if (empty($addresses['to'])) {
                return;
            }

            // Skip email processing if email is an auto-forwarded message to prevent infinite loop.
            if ($parser->getHeader('precedence') || $parser->getHeader('x-autoreply') || $parser->getHeader('x-autorespond') || 'auto-replied' == $parser->getHeader('auto-submitted')) {
                return;
            }

            // Check for self-referencing. Skip email processing if a mailbox is configured by the sender's address.
            try {
                $this->getMailboxByEmail($addresses['from']);
                return;
            } catch (\Exception $e) {
                // An exception being thrown means no mailboxes were found from the recipient's address. Continue processing.
            }
        }

        // Process Mail - References
        $mailData['replyTo'] = $addresses['to'];
        $mailData['messageId'] = $parser->getHeader('message-id') ?: null;
        $mailData['inReplyTo'] = htmlspecialchars_decode($parser->getHeader('in-reply-to'));
        $mailData['referenceIds'] = htmlspecialchars_decode($parser->getHeader('references'));
        $mailData['cc'] = array_filter(explode(',', $parser->getHeader('cc'))) ?: [];
        $mailData['bcc'] = array_filter(explode(',', $parser->getHeader('bcc'))) ?: [];
        
        // Process Mail - User Details
        $mailData['source'] = 'email';
        $mailData['createdBy'] = 'customer';
        $mailData['role'] = 'ROLE_CUSTOMER';
        $mailData['from'] = $addresses['from'];
        $mailData['name'] = trim(current(explode('@', $from[0]['display'])));

        // Process Mail - Content
        $htmlFilter = new HTMLFilter();
        $mailData['subject'] = $parser->getHeader('subject');
        $mailData['message'] = autolink($htmlFilter->addClassEmailReplyQuote($parser->getMessageBody('html')));
        $mailData['attachments'] = $parser->getAttachments();
        
        if (!$mailData['message']) {
            $mailData['message'] = autolink($htmlFilter->addClassEmailReplyQuote($parser->getMessageBody('text')));
        }

        // $mailboxes = $this->getMailboxByEmail($data['replyTo']);
        // if(!count($mailboxes)) {
        //     if($cc) {
        //         foreach ($cc as $value) {
        //             $toAdress[] = $value['address'];
        //         }
        //         $mailboxes = $this->getMailboxByEmail($toAdress);

        //         if(count($mailboxes)) {
        //             foreach ($mailboxes as $mailbox) {
        //                 foreach ($data['cc'] as $key => $value) {
        //                     if (strpos($value, $mailbox->getEmail()) !== FALSE) {
        //                         unset($data['cc'][$key]);
        //                     }
        //                 }
        //             }
        //             $data['replyTo'] = $toAdress;
        //         }
        //     }
        // }

        $website = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('knowledgebase');
        
        if (!empty($mailData['from']) && $this->container->get('ticket.service')->isEmailBlocked($mailData['from'], $website)) {
           return;
        }

        // Search for any existing tickets
        $ticket = $this->searchExistingTickets([
            'messageId' => $mailData['messageId'],
            'inReplyTo' => $mailData['inReplyTo'],
            'referenceIds' => $mailData['referenceIds'],
            'from' => $mailData['from'],
            'subject' => $mailData['subject'],
        ]);

        if (empty($ticket)) {
            $mailData['threadType'] = 'create';
            $mailData['referenceIds'] = $mailData['messageId'];

            $this->addCollaboratorFlag = 1;
            $thread = $this->container->get('ticket.service')->createTicket($mailData);

            // Trigger ticket created event
            $event = new GenericEvent(CoreWorkflowEvents\Ticket\Create::getId(), [
                'entity' =>  $thread->getTicket(),
            ]);

            $this->container->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
        } else if (false === $ticket->getIsTrashed() && strtolower($ticket->getStatus()->getCode()) != 'spam') {
            $mailData['threadType'] = 'reply';
            $thread = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread')->findOneByMessageId($mailData['messageId']);

            if (!empty($thread)) {
                // Thread with the same message id exists. Skip processing.
                return;
            }

            if ($ticket->getCustomer() && $ticket->getCustomer()->getEmail() == $mailData['from']) {
                // Reply from customer
                $user = $ticket->getCustomer();

                $mailData['user'] = $user;
                $userDetails = $user->getCustomerInstance()->getPartialDetails();
            } else {
                $user = $this->entityManager->getRepository('UVDeskSupportBundle:User')->findOneByEmail($mailData['from']);

                if (!empty($user) && null != $user->getAgentInstance()) {
                    $mailData['user'] = $user;
                    $userDetails = $user->getAgentInstance()->getPartialDetails();
                } else {
                    // No user found.
                    // @TODO: Do something about this case.
                    return;
                }
            }

            $mailData['fullname'] = $userDetails['name'];

            $thread = $this->container->get('ticket.service')->createThread($ticket, $mailData);

            if ($thread->getCreatedBy() == 'customer') {
                $event = new GenericEvent(CoreWorkflowEvents\Ticket\CustomerReply::getId(), [
                    'entity' =>  $ticket,
                ]);
            } else {
                $event = new GenericEvent(CoreWorkflowEvents\Ticket\AgentReply::getId(), [
                    'entity' =>  $ticket,
                ]);
            }
                
            // Trigger thread reply event
            $this->container->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
        }

        return;
    }
}
