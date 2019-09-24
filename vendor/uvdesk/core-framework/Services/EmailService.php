<?php
namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailService
{
    private $request;
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $container, RequestStack $request, EntityManagerInterface $entityManager)
    {
        $this->request = $request;
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function trans($text)
    {
        return $this->container->get('translator')->trans($text);
    }

    public function getEmailPlaceHolders($params)
    {
        $placeHolders = [];
        $allEmailPlaceholders = [];
        $template = is_array($params) ? ($params['match'] . 'Note') : (!empty($params) ? $params : 'template');

        if ($template == 'template') {
            $placeHolders = [
                'ticket' => [
                    'id' => [
                        'title' => $this->trans('Ticket Id'),
                        'info' => $this->trans('ticket.id.placeHolders.info'),
                    ],
                    'subject' => [
                        'title' => $this->trans('Ticket Subject'),
                        'info' => $this->trans('ticket.subject.placeHolders.info'),
                    ],
                    'message' => [
                        'title' => $this->trans('Ticket Message'),
                        'info' => $this->trans('ticket.message.placeHolders.info'),
                    ],
                    'attachments' => [
                        'title' => $this->trans('Ticket Attachments'),
                        'info' => $this->trans('ticket.attachments.placeHolders.info'),
                    ],
                    'threadMessage' => [
                        'title' => $this->trans('Ticket Thread Message'),
                        'info' => $this->trans('ticket.threadMessage.placeHolders.info'),
                    ],
                    'tags' => [
                        'title' => $this->trans('Ticket Tags'),
                        'info' => $this->trans('ticket.tags.placeHolders.info'),
                    ],
                    'source' => [
                        'title' => $this->trans('Ticket Source'),
                        'info' => $this->trans('ticket.source.placeHolders.info'),
                    ],
                    'status' => [
                        'title' => $this->trans('Ticket Status'),
                        'info' => $this->trans('ticket.status.placeHolders.info'),
                    ],
                    'priority' => [
                        'title' => $this->trans('Ticket Priority'),
                        'info' => $this->trans('ticket.priority.placeHolders.info'),
                    ],
                    'group' => [
                        'title' => $this->trans('Ticket Group'),
                        'info' => $this->trans('ticket.group.placeHolders.info'),
                    ],
                    'team' => [
                        'title' => $this->trans('Ticket Team'),
                        'info' => $this->trans('ticket.team.placeHolders.info'),
                    ],
                    'customerName' => [
                        'title' => $this->trans('Ticket Customer Name'),
                        'info' => $this->trans('ticket.customerName.placeHolders.info'),
                    ],
                    'customerEmail' => [
                        'title' => $this->trans('Ticket Customer Email'),
                        'info' => $this->trans('ticket.customerEmail.placeHolders.info'),
                    ],
                    'agentName' => [
                        'title' => $this->trans('Ticket Agent Name'),
                        'info' => $this->trans('ticket.agentName.placeHolders.info'),
                    ],
                    'agentEmail' => [
                        'title' => $this->trans('Ticket Agent Email'),
                        'info' => $this->trans('ticket.agentEmail.placeHolders.info'),
                    ],
                    'agentLink' => [
                        'title' => $this->trans('Ticket Agent Link'),
                        'info' => $this->trans('ticket.link.placeHolders.info'),
                    ],
                    'customerLink' => [
                        'title' => $this->trans('Ticket Customer Link'),
                        'info' => $this->trans('ticket.link.placeHolders.info'),
                    ],
                    'collaboratorName' => [
                        'title' => $this->trans('Last Collaborator Name'),
                        'info' => $this->trans('ticket.collaborator.name.placeHolders.info'),
                    ],
                    'collaboratorEmail' => [
                        'title' => $this->trans('Last Collaborator Email'),
                        'info' => $this->trans('ticket.collaborator.email.placeHolders.info'),
                    ],
                ],
                'user'  => [
                    'userName' => [
                        'title' => $this->trans('Agent/ Customer Name'),
                        'info' => $this->trans('user.name.info'),
                    ],
                    'userEmail' => [
                        'title' => $this->trans('Email'),
                        'info' => $this->trans('user.email.info'),
                    ],
                    'accountValidationLink' => [
                        'title' => $this->trans('Account Validation Link'),
                        'info' => $this->trans('user.account.validate.link.info'),
                    ],
                    'forgotPasswordLink' => [
                        'title' => $this->trans('Password Forgot Link'),
                        'info' => $this->trans('user.password.forgot.link.info'),
                    ],
                ],
                'global' => [
                    'companyName' => [
                        'title' => $this->trans('Company Name'),
                        'info' => $this->trans('global.companyName'),
                    ],
                    'companyLogo' => [
                        'title' => $this->trans('Company Logo'),
                        'info' => $this->trans('global.companyLogo'),
                    ],
                    'companyUrl' => [
                        'title' => $this->trans('Company URL'),
                        'info' => $this->trans('global.companyUrl'),
                    ],
                ],
            ];
        } elseif ($template == 'savedReply') {
            $placeHolders = [
                'ticket' => [
                    'id' => [
                        'title' => $this->trans('Ticket Id'),
                        'info' => $this->trans('ticket.id.placeHolders.info'),
                    ],
                    'subject' => [
                        'title' => $this->trans('Ticket Subject'),
                        'info' => $this->trans('ticket.subject.placeHolders.info'),
                    ],
                    'status' => [
                        'title' => $this->trans('Ticket Status'),
                        'info' => $this->trans('ticket.status.placeHolders.info'),
                    ],
                    'priority' => [
                        'title' => $this->trans('Ticket Priority'),
                        'info' => $this->trans('ticket.priority.placeHolders.info'),
                    ],
                    'group' => [
                        'title' => $this->trans('Ticket Group'),
                        'info' => $this->trans('ticket.group.placeHolders.info'),
                    ],
                    'team' => [
                        'title' => $this->trans('Ticket Team'),
                        'info' => $this->trans('ticket.team.placeHolders.info'),
                    ],
                    'customerName' => [
                        'title' => $this->trans('Ticket Customer Name'),
                        'info' => $this->trans('ticket.customerName.placeHolders.info'),
                    ],
                    'customerEmail' => [
                        'title' => $this->trans('Ticket Customer Email'),
                        'info' => $this->trans('ticket.customerEmail.placeHolders.info'),
                    ],
                    'agentName' => [
                        'title' => $this->trans('Ticket Agent Name'),
                        'info' => $this->trans('ticket.agentName.placeHolders.info'),
                    ],
                    'agentEmail' => [
                        'title' => $this->trans('Ticket Agent Email'),
                        'info' => $this->trans('ticket.agentEmail.placeHolders.info'),
                    ],
                    'link' => [
                        'title' => $this->trans('Ticket Link'),
                        'info' => $this->trans('ticket.link.placeHolders.info'),
                    ],
                ],
            ];
        } elseif ($template == 'ticketNote') {
            $placeHolders = [
                'type' => [
                    'previousType' => [
                        'title' => $this->trans('Previous Type'),
                        'info' => $this->trans('type.previous.placeHolders.info'),
                    ],
                    'updatedType' => [
                        'title' => $this->trans('Updated Type'),
                        'info' => $this->trans('type.updated.placeHolders.info'),
                    ],
                ],
                'status' => [
                    'previousStatus' => [
                        'title' => $this->trans('Previous Status'),
                        'info' => $this->trans('status.previous.placeHolders.info'),
                    ],
                    'updatedStatus' => [
                        'title' => $this->trans('Updated Status'),
                        'info' => $this->trans('status.updated.placeHolders.info'),
                    ],
                ],
                'group' => [
                    'previousGroup' => [
                        'title' => $this->trans('Previous Group'),
                        'info' => $this->trans('group.previous.placeHolders.info'),
                    ],
                    'updatedGroup' => [
                        'title' => $this->trans('Updated Group'),
                        'info' => $this->trans('group.updated.placeHolders.info'),
                    ],
                ],
                'team' => [
                    'previousTeam' => [
                        'title' => $this->trans('Previous Team'),
                        'info' => $this->trans('team.previous.placeHolders.info'),
                    ],
                    'updatedTeam' => [
                        'title' => $this->trans('Updated Team'),
                        'info' => $this->trans('team.updated.placeHolders.info'),
                    ],
                ],
                'priority' => [
                    'previousPriority' => [
                        'title' => $this->trans('Previous Priority'),
                        'info' => $this->trans('priority.previous.placeHolders.info'),
                    ],
                    'updatedPriority' => [
                        'title' => $this->trans('Updated Priority'),
                        'info' => $this->trans('priority.updated.placeHolders.info'),
                    ],
                ],
                'agent' => [
                    'previousAgent' => [
                        'title' => $this->trans('Previous Agent'),
                        'info' => $this->trans('agent.previous.placeHolders.info'),
                    ],
                    'updatedAgent' => [
                        'title' => $this->trans('Updated Agent'),
                        'info' => $this->trans('agent.updated.placeHolders.info'),
                    ],
                    'responsePerformingAgent' => [
                        'title' => $this->trans('Response Performing Agent'),
                        'info' => $this->trans('agent.response.placeHolders.info'),
                    ],
                ],
            ];
        } elseif($template == 'manualNote') {
            $placeHolders = [
                'ticket' => [
                    'id' => [
                        'title' => $this->trans('Ticket Id'),
                        'info' => $this->trans('ticket.id.placeHolders.info'),
                    ],
                    'subject' => [
                        'title' => $this->trans('Ticket Subject'),
                        'info' => $this->trans('ticket.subject.placeHolders.info'),
                    ],
                    'status' => [
                        'title' => $this->trans('Ticket Status'),
                        'info' => $this->trans('ticket.status.placeHolders.info'),
                    ],
                    'priority' => [
                        'title' => $this->trans('Ticket Priority'),
                        'info' => $this->trans('ticket.priority.placeHolders.info'),
                    ],
                    'group' => [
                        'title' => $this->trans('Ticket Group'),
                        'info' => $this->trans('ticket.group.placeHolders.info'),
                    ],
                    'team' => [
                        'title' => $this->trans('Ticket Team'),
                        'info' => $this->trans('ticket.team.placeHolders.info'),
                    ],
                    'customerName' => [
                        'title' => $this->trans('Ticket Customer Name'),
                        'info' => $this->trans('ticket.customerName.placeHolders.info'),
                    ],
                    'customerEmail' => [
                        'title' => $this->trans('Ticket Customer Email'),
                        'info' => $this->trans('ticket.customerEmail.placeHolders.info'),
                    ],
                    'agentName' => [
                        'title' => $this->trans('Ticket Agent Name'),
                        'info' => $this->trans('ticket.agentName.placeHolders.info'),
                    ],
                    'agentEmail' => [
                        'title' => $this->trans('Ticket Agent Email'),
                        'info' => $this->trans('ticket.agentEmail.placeHolders.info'),
                    ],
                ],
            ];
        }

        return $placeHolders;
    }

    public function getEmailPlaceholderValues(User $user, $userType = 'member')
    {
        if (null == $user->getVerificationCode()) {
            // Set user verification code
            $user->setVerificationCode(TokenGenerator::generateToken());

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $router = $this->container->get('router');
        $helpdeskWebsite = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('helpdesk');

        // Link to company knowledgebase
        if (false == array_key_exists('UVDeskSupportCenterBundle', $this->container->getParameter('kernel.bundles'))) {
            $companyURL = $this->container->getParameter('uvdesk.site_url');
        } else {
            $companyURL = $router->generate('helpdesk_knowledgebase', [], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        // Resolve path to helpdesk brand image
        $companyLogoURL = sprintf('http://%s%s', $this->container->getParameter('uvdesk.site_url'), '/bundles/uvdeskcoreframework/images/uv-avatar-uvdesk.png');
        $helpdeskKnowledgebaseWebsite = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('knowledgebase');

        if (!empty($helpdeskKnowledgebaseWebsite) && null != $helpdeskKnowledgebaseWebsite->getLogo()) {
            $companyLogoURL = sprintf('http://%s%s', $this->container->getParameter('uvdesk.site_url'), $helpdeskKnowledgebaseWebsite->getLogo());
        }
        
        // Link to update account login credentials
        $updateCredentialsURL = $router->generate(('customer' == $userType) ? 'helpdesk_customer_update_account_credentials' : 'helpdesk_member_update_account_credentials', [
            'email' => $user->getEmail(),
            'verificationCode' => $user->getVerificationCode(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $placeholderParams = [
            'user.userName' => $user->getFullName(),
            'user.userEmail' => $user->getEmail(),
            'user.assignUserEmail' => $user->getEmail(),
            'user.forgotPasswordLink' => "<a href='$updateCredentialsURL'>$updateCredentialsURL</a>",
            'user.accountValidationLink' => "<a href='$updateCredentialsURL'>$updateCredentialsURL</a>",
            'global.companyName' => $helpdeskWebsite->getName(),
            'global.companyLogo' => "<img style='max-height:60px' src='$companyLogoURL'/>",
            'global.companyUrl' => "<a href='$companyURL'>$companyURL</a>",
        ];
        
        return $placeholderParams;
    }

    public function getTicketPlaceholderValues(Ticket $ticket, $type = "")
    {
        $supportTeam = $ticket->getSupportTeam();
        $supportGroup = $ticket->getSupportGroup();
        $supportTags = array_map(function ($supportTag) { return $supportTag->getName(); }, $ticket->getSupportTags()->toArray());
        
        $router = $this->container->get('router');
        $helpdeskWebsite = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('helpdesk');
        
        // Resolve path to helpdesk brand image
        $companyLogoURL = sprintf('http://%s%s', $this->container->getParameter('uvdesk.site_url'), '/bundles/uvdeskcoreframework/images/uv-avatar-uvdesk.png');
        $helpdeskKnowledgebaseWebsite = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('knowledgebase');

        if (!empty($helpdeskKnowledgebaseWebsite) && null != $helpdeskKnowledgebaseWebsite->getLogo()) {
            $companyLogoURL = sprintf('http://%s%s', $this->container->getParameter('uvdesk.site_url'), $helpdeskKnowledgebaseWebsite->getLogo());
        }
        
        // Link to company knowledgebase
        if (false == array_key_exists('UVDeskSupportCenterBundle', $this->container->getParameter('kernel.bundles'))) {
            $companyURL = $this->container->getParameter('uvdesk.site_url');
        } else {
            $companyURL = $router->generate('helpdesk_knowledgebase', [], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $customerPartialDetails = $ticket->getCustomer()->getCustomerInstance()->getPartialDetails();
        $agentPartialDetails = $ticket->getAgent() ? $ticket->getAgent()->getAgentInstance()->getPartialDetails() : null;

        //Ticket Url and create ticket url for agent
        $viewTicketURLAgent = $router->generate('helpdesk_member_ticket', [
            'ticketId' => $ticket->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        $generateTicketURLAgent = $router->generate('helpdesk_member_create_ticket', [], UrlGeneratorInterface::ABSOLUTE_URL);

        if (false != array_key_exists('UVDeskSupportCenterBundle', $this->container->getParameter('kernel.bundles'))) {
                $viewTicketURL = $router->generate('helpdesk_customer_ticket', [
                    'id' => $ticket->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL);
    
                $generateTicketURLCustomer = $router->generate('helpdesk_customer_create_ticket', [], UrlGeneratorInterface::ABSOLUTE_URL);
        } else {
            $viewTicketURL = '';
            $generateTicketURLCustomer = '';
        }

        $placeholderParams = [
            'ticket.id' => $ticket->getId(),
            'ticket.subject' => $ticket->getSubject(),
            'ticket.message' =>  (isset($ticket->createdThread)) ? $ticket->createdThread->getMessage() : '',
            'ticket.threadMessage' => (isset($ticket->createdThread)) ? $ticket->createdThread->getMessage() : '',
            'ticket.tags' => implode(',', $supportTags),
            'ticket.source' => ucfirst($ticket->getSource()),
            'ticket.status' => $ticket->getStatus()->getDescription(),
            'ticket.priority' => $ticket->getPriority()->getDescription(),
            'ticket.team' => $supportTeam ? $supportTeam->getName() : '',
            'ticket.group' => $supportGroup ? $supportGroup->getName() : '',
            'ticket.customerName' => $customerPartialDetails['name'],
            'ticket.customerEmail' => $customerPartialDetails['email'],
            'ticket.agentName' => !empty($agentPartialDetails) ? $agentPartialDetails['name'] : '',
            'ticket.agentEmail' => !empty($agentPartialDetails) ? $agentPartialDetails['email'] : '',
            'ticket.attachments' => '',
            'ticket.collaboratorName' => '',
            'ticket.collaboratorEmail' => '',
            'ticket.agentLink' => sprintf("<a href='%s'>#%s</a>", $viewTicketURLAgent, $ticket->getId()),
            'ticket.ticketGenerateUrlAgent' => sprintf("<a href='%s'>click here</a>", $generateTicketURLAgent),
            'ticket.customerLink' => sprintf("<a href='%s'>#%s</a>", $viewTicketURL, $ticket->getId()),
            'ticket.ticketGenerateUrlCustomer' => sprintf("<a href='%s'>click here</a>", $generateTicketURLCustomer),
            'global.companyName' => $helpdeskWebsite->getName(),
            'global.companyLogo' => "<img style='max-height:60px' src='$companyLogoURL'/>",
            'global.companyUrl' => "<a href='$companyURL'>$companyURL</a>",
        ];

        return $placeholderParams;
    }

    public function processEmailSubject($subject, array $emailPlaceholders = [])
    {
        foreach ($emailPlaceholders as $var => $value) {
            $subject = strtr($subject, ["{%$var%}" => $value, "{% $var %}" => $value]);
        }
        
        return $subject;
    }

    public function processEmailContent($content, array $emailPlaceholders = [], $isSavedReply = false)
    {
        $twigTemplatingEngine = $this->container->get('twig');
        $baseEmailTemplate = $this->container->getParameter('uvdesk.default.templates.email');

        foreach ($emailPlaceholders as $var => $value) {
            $content = strtr($content, ["{%$var%}" => $value, "{% $var %}" => $value]);
        }

        $content = $isSavedReply ? stripslashes($content) : htmlspecialchars_decode(preg_replace(['#&lt;script&gt;#', '#&lt;/script&gt;#'], ['&amp;lt;script&amp;gt;', '&amp;lt;/script&amp;gt;'], $content));

        return $twigTemplatingEngine->render($baseEmailTemplate, ['message' => $content]);
    }

    public function sendMail($subject, $content, $recipient, array $headers = [], $mailboxEmail = null, array $attachments = [], $cc = [], $bcc = [])
    {
        if (empty($mailboxEmail)) {
            // Send email on behalf of support helpdesk
            $supportEmail = $this->container->getParameter('uvdesk.support_email.id');
            $supportEmailName = $this->container->getParameter('uvdesk.support_email.name');
            $mailerID = $this->container->getParameter('uvdesk.support_email.mailer_id');
        } else {
            // Register automations conditionally if AutomationBundle has been added as an dependency.
            if (!array_key_exists('UVDeskMailboxBundle', $this->container->getParameter('kernel.bundles'))) {
                return;
            } else {
                // Send email on behalf of configured mailbox
                try {
                    $mailbox = $this->container->get('uvdesk.mailbox')->getMailboxByEmail($mailboxEmail);
    
                    if (true === $mailbox['enabled']) {
                        $supportEmail = $mailbox['email'];
                        $supportEmailName = $mailbox['name'];
                        $mailerID = $mailbox['smtp_server']['mailer_id'];
                    } else {
                        // @TODO: Log mailbox disabled notice
                        return;
                    }
                } catch (\Exception $e) {
                    // @TODO: Log exception - Mailbox not found
                    return;
                }
            }
        }

        // Retrieve mailer to be used for sending emails
        try {
            $mailer = $this->container->get('swiftmailer.mailer' . (('default' == $mailerID) ? '' : ".$mailerID"));
        } catch (\Exception $e) {
            // @TODO: Log exception - Mailer not found
            return;
        }

        // Create a message
        $message = (new \Swift_Message($subject))
            ->setFrom([$supportEmail => $supportEmailName])
            ->setTo($recipient)
            ->setBcc($bcc)
            ->setCc($cc)
            ->setBody($content, 'text/html');

        foreach ($attachments as $attachmentPath) {
            $message->attach(\Swift_Attachment::fromPath($attachmentPath));
        }

        $messageHeaders = $message->getHeaders();
        foreach ($headers as $headerName => $headerValue) {
            $messageHeaders->addTextHeader($headerName, $headerName);
        }

        try {
            $messageId = $message->getId();
            $mailer->send($message);
            
            return "<$messageId>";
        } catch (\Exception $e) {
            // @TODO: Log exception
        }

        return null;
    }
}
