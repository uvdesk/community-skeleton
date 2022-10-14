<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\Query;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\AgentActivity;
use Webkul\UVDesk\MailboxBundle\Utils\Mailbox\Mailbox;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Website;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SavedReplies;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;
use Webkul\UVDesk\MailboxBundle\Utils\MailboxConfiguration;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\CoreFrameworkBundle\Services\CustomFieldsService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\FileUploadService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use UVDesk\CommunityPackages\UVDesk\FormComponent\Entity;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\Configuration as ImapConfiguration;
use Symfony\Component\Filesystem\Filesystem;
use Webkul\UVDesk\SupportCenterBundle\Entity\Article;
use Webkul\UVDesk\SupportCenterBundle\Entity\KnowledgebaseWebsite;
use Webkul\UVDesk\AutomationBundle\Entity\PreparedResponses;
use UVDesk\CommunityPackages\UVDesk\FormComponent\Entity as CommunityPackageEntities;


class TicketService
{
    const PATH_TO_CONFIG = '/config/packages/uvdesk_mailbox.yaml';

    protected $container;
	protected $requestStack;
    protected $entityManager;
    protected $fileUploadService;
    protected $userService;
    
    public function __construct(
        ContainerInterface $container, 
        RequestStack $requestStack, 
        EntityManagerInterface $entityManager, 
        FileUploadService $fileUploadService,
        CustomFieldsService $customFieldsService,
        UserService $userService)
    {
        $this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->fileUploadService = $fileUploadService;
        $this->customFieldsService = $customFieldsService;
        $this->userService = $userService;
    }

    public function getAllMailboxes()
    {
        $collection = array_map(function ($mailbox) {
            return [
                'id' => $mailbox->getId(),
                'name' => $mailbox->getName(),
                'isEnabled' => $mailbox->getIsEnabled(),
                'email'     => $mailbox->getImapConfiguration()->getUsername(),
            ];
        }, $this->parseMailboxConfigurations()->getMailboxes());

        return $collection;
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

    public function getPathToConfigurationFile()
    {
        return $this->container->get('kernel')->getProjectDir() . self::PATH_TO_CONFIG;
    }

    public function getRandomRefrenceId($email = null)
    {
        $email = !empty($email) ? $email : $this->container->getParameter('uvdesk.support_email.id');
        $emailDomain = substr($email, strpos($email, '@'));

        return sprintf("<%s%s>", TokenGenerator::generateToken(20, '0123456789abcdefghijklmnopqrstuvwxyz'), $emailDomain);
    }

    // @TODO: Refactor this out of this service. Use UserService::getSessionUser() instead.
    public function getUser()
    {
        return $this->container->get('user.service')->getCurrentUser();
    }

    public function getDefaultType()
    {
        $typeCode = $this->container->getParameter('uvdesk.default.ticket.type');
        $ticketType = $this->entityManager->getRepository(TicketType::class)->findOneByCode($typeCode);

        return !empty($ticketType) ? $ticketType : null;
    }

    public function getDefaultStatus()
    {
        $statusCode = $this->container->getParameter('uvdesk.default.ticket.status');
        $ticketStatus = $this->entityManager->getRepository(TicketStatus::class)->findOneByCode($statusCode);

        return !empty($ticketStatus) ? $ticketStatus : null;
    }

    public function getDefaultPriority()
    {
        $priorityCode = $this->container->getParameter('uvdesk.default.ticket.priority');
        $ticketPriority = $this->entityManager->getRepository(TicketPriority::class)->findOneByCode($priorityCode);

        return !empty($ticketPriority) ? $ticketPriority : null;
    }

    public function appendTwigSnippet($snippet = '')
    {
        switch ($snippet) {
            case 'createMemberTicket':
                return $this->getMemberCreateTicketSnippet();
                break;
            default:
                break;
        }

        return '';
    }

    public function getMemberCreateTicketSnippet()
    {   
        $twigTemplatingEngine = $this->container->get('twig');
        $ticketTypeCollection = $this->entityManager->getRepository(TicketType::class)->findByIsActive(true);
        
        $isFolderExist  =  $this->userService->isfileExists('apps/uvdesk/form-component');
        if ($isFolderExist) {
            $headerCustomFields = $this->customFieldsService->getCustomFieldsArray('user');
        }

        return $twigTemplatingEngine->render('@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig', [
            'ticketTypeCollection' => $ticketTypeCollection,
            'headerCustomFields' => $headerCustomFields ?? null,
        ]);
    }

    public function getCustomerCreateTicketCustomFieldSnippet()
    {   
        $isFolderExist  =  $this->userService->isfileExists('apps/uvdesk/form-component');
        if ($isFolderExist) { 
            $customFields = $this->customFieldsService->getCustomFieldsArray('customer');
        }

        return $customFields ?? null;
    }

    public function createTicket(array $params = [])
    {
        $thread = $this->entityManager->getRepository(Thread::class)->findOneByMessageId($params['messageId']);

        if (empty($thread)) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($params['from']);

            if (empty($user) || null == $user->getCustomerInstance()) {
                $role = $this->entityManager->getRepository(SupportRole::class)->findOneByCode($params['role']);
                if (empty($role)) {
                    throw new \Exception("The requested role '" . $params['role'] . "' does not exist.");
                }
                
                // Create User Instance
                $user = $this->container->get('user.service')->createUserInstance($params['from'], $params['name'], $role, [
                    'source' => strtolower($params['source']),
                    'active' => true,
                ]);
            }

            $params['role'] = 4;
            $params['mailboxEmail'] = current($params['replyTo']); 
            $params['customer'] = $params['user'] = $user;

            return $this->createTicketBase($params);
        }

        return;
    }

    public function createTicketBase(array $ticketData = [])
    {
        if ('email' == $ticketData['source']) {
            try {
                if (array_key_exists('UVDeskMailboxBundle', $this->container->getParameter('kernel.bundles'))) {
                    $mailbox = $this->container->get('uvdesk.mailbox')->getMailboxByEmail($ticketData['mailboxEmail']);
                    $ticketData['mailboxEmail'] = $mailbox['email'];
                }
            } catch (\Exception $e) {
                // No mailbox found for this email. Skip ticket creation.
                return;
            }
        }

        // Set Defaults
        $ticketType = !empty($ticketData['type']) ? $ticketData['type'] : $this->getDefaultType();
        $ticketStatus = !empty($ticketData['status']) ? $ticketData['status'] : $this->getDefaultStatus();
        $ticketPriority = !empty($ticketData['priority']) ? $ticketData['priority'] : $this->getDefaultPriority();
        $ticketMessageId = 'email' == $ticketData['source'] ? (!empty($ticketData['messageId']) ? $ticketData['messageId'] : null) : $this->getRandomRefrenceId();

        $ticketData['type'] = $ticketType;
        $ticketData['status'] = $ticketStatus;
        $ticketData['priority'] = $ticketPriority;
        $ticketData['messageId'] = $ticketMessageId;
        $ticketData['isTrashed'] = false;

        $ticket = new Ticket();
        foreach ($ticketData as $property => $value) {
            $callable = 'set' . ucwords($property);

            if (method_exists($ticket, $callable)) {
                $ticket->$callable($value);
            }
        }

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $this->createThread($ticket, $ticketData);
    }
    
    public function createThread(Ticket $ticket, array $threadData)
    {
        $threadData['isLocked'] = 0;
      
        if ('forward' === $threadData['threadType']) {
            $threadData['replyTo'] = $threadData['to'];
        }

        $collaboratorEmails = array_merge(!empty($threadData['cccol']) ? $threadData['cccol'] : [], !empty($threadData['cc']) ? $threadData['cc'] : []);
        if (!empty($collaboratorEmails)) {
            $threadData['cc'] = $collaboratorEmails;
        }
   
        $thread = new Thread();
        $thread->setTicket($ticket);
        $thread->setCreatedAt(new \DateTime());
        $thread->setUpdatedAt(new \DateTime());

        if ($threadData['threadType'] != "note") {
            foreach ($threadData as $property => $value) {
                if (!empty($value)) {
                    $callable = 'set' . ucwords($property);
                    if (method_exists($thread, $callable)) {
                        $thread->$callable($value);
                    }
                }
            }
        } else {
            $this->setTicketNotePlaceholderValue($thread, $threadData, $ticket);
        }

        // Update ticket reference ids is thread message id is defined
        if (null != $thread->getMessageId() && false === strpos($ticket->getReferenceIds(), $thread->getMessageId())) {
            $updatedReferenceIds = $ticket->getReferenceIds() . ' ' . $thread->getMessageId();            
            $ticket->setReferenceIds($updatedReferenceIds);

            $this->entityManager->persist($ticket);
        }

        if ('reply' === $threadData['threadType']) {
            if ('agent' === $threadData['createdBy']) {
                // Ticket has been updated by support agents, mark as agent replied | customer view pending
                $ticket->setIsCustomerViewed(false);
                $ticket->setIsReplied(true);

                $customerName = $ticket->getCustomer()->getFirstName().' '.$ticket->getCustomer()->getLastName();

                $agentActivity = new AgentActivity();
                $agentActivity->setThreadType('reply');
                $agentActivity->setTicket($ticket);
                $agentActivity->setAgent($thread->getUser());
                $agentActivity->setCustomerName($customerName);
                $agentActivity->setAgentName('agent');
                $agentActivity->setCreatedAt(new \DateTime());

                $this->entityManager->persist($agentActivity);
            } else {
                // Ticket has been updated by customer, mark as agent view | reply pending
                $ticket->setIsAgentViewed(false);
                $ticket->setIsReplied(false);
            }

            $this->entityManager->persist($ticket);
        } else if ('create' === $threadData['threadType']) {
            $ticket->setIsReplied(false);
            $this->entityManager->persist($ticket);

            $customerName = $ticket->getCustomer()->getFirstName().' '.$ticket->getCustomer()->getLastName();

            $agentActivity = new AgentActivity();
            $agentActivity->setThreadType('create');
            $agentActivity->setTicket($ticket);
            $agentActivity->setAgent($thread->getUser());
            $agentActivity->setCustomerName($customerName );
            $agentActivity->setAgentName('agent');
            $agentActivity->setCreatedAt(new \DateTime());

            $this->entityManager->persist($agentActivity);
        }
        
        $ticket->currentThread = $this->entityManager->getRepository(Thread::class)->getTicketCurrentThread($ticket);
        
        $this->entityManager->persist($thread);
        $this->entityManager->flush();
        
        $ticket->createdThread = $thread;

        // Uploading Attachments
        if (!empty($threadData['attachments'])) {
            if ('email' == $threadData['source']) {
                $this->saveThreadEmailAttachments($thread, $threadData['attachments']);
            } else if (!empty($threadData['attachments'])) {
                $this->saveThreadAttachment($thread, $threadData['attachments']);
            }
        }

        return $thread;
    }

    public function setTicketNotePlaceholderValue($thread, $threadData, $ticket)
    {
        if (!empty($threadData)) {
            foreach ($threadData as $property => $value) {
                if (!empty($value)) {
                    $callable = 'set' . ucwords($property);
                    if (method_exists($thread, $callable)) {
                        if($callable != "setMessage") {
                            $thread->$callable($value);
                        } else {
                            $notesPlaceholders = $this->getNotePlaceholderValues($ticket, 'customer');
                            $content = $value;
                            foreach ($notesPlaceholders as $key => $val) {
                                if(strpos($value, "{%$key%}") !== false){
                                    $content = strtr($value, ["{%$key%}" => $val, "{% $key %}" => $val]);
                                }
                            }
                            
                            $content = stripslashes($content);
                            $thread->$callable($content);
                        }
                    }
                }
            }
        }
    }

    public function saveThreadAttachment($thread, array $attachments)
    {
        $prefix = 'threads/' . $thread->getId();
        $uploadManager = $this->container->get('uvdesk.core.file_system.service')->getUploadManager();

        foreach ($attachments as $attachment) {
            $uploadedFileAttributes = $uploadManager->uploadFile($attachment, $prefix);

            if (!empty($uploadedFileAttributes['path'])) {
                ($threadAttachment = new Attachment())
                    ->setThread($thread)
                    ->setName($uploadedFileAttributes['name'])
                    ->setPath($uploadedFileAttributes['path'])
                    ->setSize($uploadedFileAttributes['size'])
                    ->setContentType($uploadedFileAttributes['content-type']);
                
                $this->entityManager->persist($threadAttachment);
            }
        }

        $this->entityManager->flush();
    }

    public function saveThreadEmailAttachments($thread, array $attachments)
    {
        $prefix = 'threads/' . $thread->getId();
        $uploadManager = $this->container->get('uvdesk.core.file_system.service')->getUploadManager();
        
        // Upload thread attachments
        foreach ($attachments as $attachment) {
            $uploadedFileAttributes = $uploadManager->uploadEmailAttachment($attachment, $prefix);
            
            if (!empty($uploadedFileAttributes['path'])) {
                ($threadAttachment = new Attachment())
                    ->setThread($thread)
                    ->setName($uploadedFileAttributes['name'])
                    ->setPath($uploadedFileAttributes['path'])
                    ->setSize($uploadedFileAttributes['size'])
                    ->setContentType($uploadedFileAttributes['content-type']);
                
                $this->entityManager->persist($threadAttachment);
            }
        }

        $this->entityManager->flush();
    }

    public function getTypes()
    {
        static $types;
        if (null !== $types)
            return $types;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tp.id','tp.code As name')->from(TicketType::class, 'tp')
                ->andwhere('tp.isActive = 1')
                ->orderBy('tp.code', 'ASC');

        return $types = $qb->getQuery()->getArrayResult();
    }

    public function getStatus()
    {
        static $statuses;
        if (null !== $statuses)
            return $statuses;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('ts')->from(TicketStatus::class, 'ts');
        // $qb->orderBy('ts.sortOrder', Criteria::ASC);

        return $statuses = $qb->getQuery()->getArrayResult();
    }

    public function getTicketTotalThreads($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(th.id) as threadCount')->from(Ticket::class, 't')
            ->leftJoin('t.threads', 'th')
            ->andWhere('t.id = :ticketId')
            ->andWhere('th.threadType = :threadType')
            ->setParameter('threadType','reply')
            ->setParameter('ticketId', $ticketId);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(t.id) as threadCount')->from(Thread::class, 't')
            ->andWhere('t.ticket = :ticketId')
            ->andWhere('t.threadType = :threadType')
            ->setParameter('threadType','reply')
            ->setParameter('ticketId', $ticketId);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTicketTags($request = null)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tg')->from(Tag::class, 'tg');

        if($request) {
            $qb->andwhere("tg.name LIKE :tagName");
            $qb->setParameter('tagName', '%'.urldecode($request->query->get('query')).'%');
            $qb->andwhere("tg.id NOT IN (:ids)");
            $qb->setParameter('ids', explode(',',urldecode($request->query->get('not'))));
        }

        return $qb->getQuery()->getArrayResult();
    }
    
    public function paginateMembersTicketCollection(Request $request)
    {
        $params = $request->query->all();
        $activeUser = $this->container->get('user.service')->getSessionUser();
        $activeUserTimeZone = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'Knowledgebase']);
        $agentTimeZone = !empty($activeUser->getTimezone()) ? $activeUser->getTimezone() : $activeUserTimeZone->getTimezone();
        $agentTimeFormat = !empty($activeUser->getTimeformat()) ? $activeUser->getTimeformat() : $activeUserTimeZone->getTimeformat();

        $ticketRepository = $this->entityManager->getRepository(Ticket::class);

        $website = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'helpdesk']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        $supportGroupReference = $this->entityManager->getRepository(User::class)->getUserSupportGroupReferences($activeUser);
        $supportTeamReference  = $this->entityManager->getRepository(User::class)->getUserSupportTeamReferences($activeUser);

        // Get base query
        $baseQuery = $ticketRepository->prepareBaseTicketQuery($activeUser, $supportGroupReference, $supportTeamReference, $params);
        $ticketTabs = $ticketRepository->getTicketTabDetails($activeUser, $supportGroupReference, $supportTeamReference, $params);

        // Apply Pagination
        $pageNumber = !empty($params['page']) ? (int) $params['page'] : 1;
        $itemsLimit = !empty($params['limit']) ? (int) $params['limit'] : $ticketRepository::DEFAULT_PAGINATION_LIMIT;

        if (isset($params['repliesLess']) || isset($params['repliesMore'])) {
            $paginationOptions = ['wrap-queries' => true];
            $paginationQuery = $baseQuery->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY);
        } else {
            $paginationOptions = ['distinct' => true];
            $paginationQuery = $baseQuery->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY)
                ->setHint('knp_paginator.count', isset($params['status']) ? $ticketTabs[$params['status']] : $ticketTabs[1]);
        }

        $pagination = $this->container->get('knp_paginator')->paginate($paginationQuery, $pageNumber, $itemsLimit, $paginationOptions);
        // Process Pagination Response
        $ticketCollection = [];
        $paginationParams = $pagination->getParams();
        $paginationData = $pagination->getPaginationData();

        $paginationParams['page'] = 'replacePage';
        $paginationData['url'] = '#' . $this->container->get('uvdesk.service')->buildPaginationQuery($paginationParams);
        // $container->get('default.service')->buildSessionUrl('ticket',$queryParameters);


        $ticketThreadCountQueryTemplate = $this->entityManager->createQueryBuilder()
            ->select('COUNT(thread.id) as threadCount')
            ->from(Ticket::class, 'ticket')
            ->leftJoin('ticket.threads', 'thread')
            ->where('ticket.id = :ticketId')
            ->andWhere('thread.threadType = :threadType')->setParameter('threadType', 'reply');
        
        foreach ($pagination->getItems() as $ticketDetails) {
            $ticket = array_shift($ticketDetails);

            $ticketThreadCountQuery = clone $ticketThreadCountQueryTemplate;
            $ticketThreadCountQuery->setParameter('ticketId', $ticket['id']);

            $totalTicketReplies = (int) $ticketThreadCountQuery->getQuery()->getSingleScalarResult();
            $ticketHasAttachments = false;
            $dbTime = $ticket['createdAt'];
            
            $formattedTime= $this->fomatTimeByPreference($dbTime,$timeZone,$timeFormat,$agentTimeZone,$agentTimeFormat);

            $currentDateTime  = new \DateTime('now');
            if($this->getLastReply($ticket['id'])) {
                $lastRepliedTime = 
                $this->time2string($currentDateTime->getTimeStamp() - $this->getLastReply($ticket['id'])['createdAt']->getTimeStamp());
            } else {
                $lastRepliedTime = 
                $this->time2string($currentDateTime->getTimeStamp() - $ticket['createdAt']->getTimeStamp());
            }

            $ticketResponse = [
                'id' => $ticket['id'],
                'subject' => $ticket['subject'],
                'isStarred' => $ticket['isStarred'],
                'isAgentView' => $ticket['isAgentViewed'],
                'isTrashed' => $ticket['isTrashed'],
                'source' => $ticket['source'],
                'group' => $ticketDetails['groupName'],
                'team' => $ticketDetails['teamName'],
                'priority' => $ticket['priority'],
                'type' => $ticketDetails['typeName'],
                'timestamp' => $formattedTime['dateTimeZone'],
                'formatedCreatedAt' => $formattedTime['dateTimeZone']->format($formattedTime['timeFormatString']),
                'totalThreads' => $totalTicketReplies,
                'agent' => null,
                'customer' => null,
                'hasAttachments' => $ticketHasAttachments,
                'lastReplyTime' => $lastRepliedTime
            ];
           
            if (!empty($ticketDetails['agentId'])) {
                $ticketResponse['agent'] = [
                    'id' => $ticketDetails['agentId'],
                    'name' => $ticketDetails['agentName'],
                    'smallThumbnail' => $ticketDetails['smallThumbnail'],
                ];
            }

            if (!empty($ticketDetails['customerId'])) {
                $ticketResponse['customer'] = [
                    'id' => $ticketDetails['customerId'],
                    'name' => $ticketDetails['customerName'],
                    'email' => $ticketDetails['customerEmail'],
                    'smallThumbnail' => $ticketDetails['customersmallThumbnail'],
                ];
            }

            array_push($ticketCollection, $ticketResponse);
        }
         
        return [
            'tickets' => $ticketCollection,
            'pagination' => $paginationData,
            'tabs' => $ticketTabs,
            'labels' => [
                'predefind' => $this->getPredefindLabelDetails($activeUser, $supportGroupReference, $supportTeamReference, $params),
                'custom' => $this->getCustomLabelDetails($this->container),
            ],
          
        ];
    }

    // Convert Timestamp to day/hour/min
    Public function time2string($time) {
        $d = floor($time/86400);
        $_d = ($d < 10 ? '0' : '').$d;

        $h = floor(($time-$d*86400)/3600);
        $_h = ($h < 10 ? '0' : '').$h;

        $m = floor(($time-($d*86400+$h*3600))/60);
        $_m = ($m < 10 ? '0' : '').$m;

        $s = $time-($d*86400+$h*3600+$m*60);
        $_s = ($s < 10 ? '0' : '').$s;

        $time_str = "0 minutes";
        if($_d != 00)
            $time_str = $_d." ".'days';
        elseif($_h != 00)
            $time_str = $_h." ".'hours';
        elseif($_m != 00)
            $time_str = $_m." ".'minutes';

        return $time_str." "."ago";
    }

    public function getPredefindLabelDetails(User $currentUser, array $supportGroupIds = [], array $supportTeamIds = [], array $params = [])
    {
        $data = array();
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $ticketRepository = $this->entityManager->getRepository(Ticket::class);
        $queryBuilder->select('COUNT(DISTINCT ticket.id) as ticketCount')->from(Ticket::class, 'ticket');
            
        // // applyFilter according to permission
        $queryBuilder->where('ticket.isTrashed != 1');
        $userInstance = $currentUser->getAgentInstance();

        if (!empty($userInstance) &&  'ROLE_AGENT' == $userInstance->getSupportRole()->getCode() 
        && $userInstance->getTicketAccesslevel() != 1) {
            $supportGroupIds = implode(',', $supportGroupIds);
            $supportTeamIds = implode(',', $supportTeamIds);

            if ($userInstance->getTicketAccesslevel() == 4) {
                $queryBuilder->andwhere('ticket.agent = ' . $currentUser->getId());
            } elseif ($userInstance->getTicketAccesslevel() == 2) {
                $query = '';
                if ($supportGroupIds){
                    $query .= ' OR supportGroup.id IN('.$supportGroupIds.') ';
                }
                if ($supportTeamIds) {
                    $query .= ' OR supportTeam.id IN('.$supportTeamIds.') ';
                }
                $queryBuilder->leftJoin('ticket.supportGroup', 'supportGroup')
                            ->leftJoin('ticket.supportTeam', 'supportTeam')
                            ->andwhere('( ticket.agent = ' . $currentUser->getId().$query.')');
                    
            } elseif ($userInstance->getTicketAccesslevel() == 3) {
                $query = '';
                if ($supportTeamIds) {
                    $query .= ' OR supportTeam.id IN('.$supportTeamIds.') ';
                }
                $queryBuilder->leftJoin('ticket.supportGroup', 'supportGroup')
                            ->leftJoin('ticket.supportTeam', 'supportTeam')
                            ->andwhere('( ticket.agent = ' . $currentUser->getId().$query. ')');
            }
        }

        // for all tickets count
        $data['all'] = $queryBuilder->getQuery()->getSingleScalarResult();

        // for new tickets count
        $newQb = clone $queryBuilder;
        $newQb->andwhere('ticket.isNew = 1');
        $data['new'] = $newQb->getQuery()->getSingleScalarResult();

        // for unassigned tickets count
        $unassignedQb = clone $queryBuilder;
        $unassignedQb->andwhere("ticket.agent is NULL");
        $data['unassigned'] = $unassignedQb->getQuery()->getSingleScalarResult();

        // for unanswered ticket count
        $unansweredQb = clone $queryBuilder;
        $unansweredQb->andwhere('ticket.isReplied = 0');
        $data['notreplied'] = $unansweredQb->getQuery()->getSingleScalarResult();

        // for my tickets count
        $mineQb = clone $queryBuilder;
        $mineQb->andWhere("ticket.agent = :agentId")
                ->setParameter('agentId', $currentUser->getId());
        $data['mine'] = $mineQb->getQuery()->getSingleScalarResult();

        // for starred tickets count
        $starredQb = clone $queryBuilder;
        $starredQb->andwhere('ticket.isStarred = 1');
        $data['starred'] = $starredQb->getQuery()->getSingleScalarResult();

        // for trashed tickets count
        $trashedQb = clone $queryBuilder;
        $trashedQb->where('ticket.isTrashed = 1');
        if ($currentUser->getRoles()[0] != 'ROLE_SUPER_ADMIN' && $userInstance->getTicketAccesslevel() != 1) {
            $trashedQb->andwhere('ticket.agent = ' . $currentUser->getId());
        }
        $data['trashed'] = $trashedQb->getQuery()->getSingleScalarResult();

        return $data;
    }
    
    public function paginateMembersTicketThreadCollection(Ticket $ticket, Request $request)
    {
        $params = $request->query->all();
        $entityManager = $this->entityManager;
        $activeUser = $this->container->get('user.service')->getSessionUser();

        $activeUserTimeZone = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'Knowledgebase']);
        $agentTimeZone = !empty($activeUser->getTimezone()) ? $activeUser->getTimezone() : $activeUserTimeZone->getTimezone();
        $agentTimeFormat = !empty($activeUser->getTimeformat()) ? $activeUser->getTimeformat() : $activeUserTimeZone->getTimeformat();
        
        $threadRepository = $entityManager->getRepository(Thread::class);
        $uvdeskFileSystemService = $this->container->get('uvdesk.core.file_system.service');

        // Get base query
        $enableLockedThreads = $this->container->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_LOCK_AND_UNLOCK_THREAD');
        $baseQuery = $threadRepository->prepareBasePaginationRecentThreadsQuery($ticket, $params, $enableLockedThreads);
        
        // Apply Pagination
        $paginationItemsQuery = clone $baseQuery;
        $totalPaginationItems = $paginationItemsQuery->select('COUNT(DISTINCT thread.id)')->getQuery()->getSingleScalarResult();
        
        $pageNumber = !empty($params['page']) ? (int) $params['page'] : 1;
        $itemsLimit = !empty($params['limit']) ? (int) $params['limit'] : $threadRepository::DEFAULT_PAGINATION_LIMIT;
        
        $paginationOptions = ['distinct' => true];
        $paginationQuery = $baseQuery->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY)->setHint('knp_paginator.count', (int) $totalPaginationItems);

        $pagination = $this->container->get('knp_paginator')->paginate($paginationQuery, $pageNumber, $itemsLimit, $paginationOptions);

        // Process Pagination Response
        $threadCollection = [];
        $paginationParams = $pagination->getParams();
        $paginationData = $pagination->getPaginationData();

        $website = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'helpdesk']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        if (!empty($params['threadRequestedId'])) {
            $requestedThreadCollection = $baseQuery
                ->andWhere('thread.id >= :threadRequestedId')->setParameter('threadRequestedId', (int) $params['threadRequestedId'])
                ->getQuery()->getArrayResult();
            
            $totalRequestedThreads = count($requestedThreadCollection);
            $paginationData['current'] = ceil($totalRequestedThreads / $threadRepository::DEFAULT_PAGINATION_LIMIT);

            if ($paginationData['current'] > 1) {
                $paginationData['firstItemNumber'] = 1;
                $paginationData['lastItemNumber'] = $totalRequestedThreads;
                $paginationData['next'] = ceil(($totalRequestedThreads + 1) / $threadRepository::DEFAULT_PAGINATION_LIMIT);
            }
        }

        $paginationParams['page'] = 'replacePage';
        $paginationData['url'] = '#' . $this->container->get('uvdesk.service')->buildPaginationQuery($paginationParams);
        foreach ($pagination->getItems() as $threadDetails) {
            $dbTime = $threadDetails['createdAt'];
            $formattedTime = $this->fomatTimeByPreference($dbTime,$timeZone,$timeFormat,$agentTimeZone,$agentTimeFormat);

            $threadResponse = [
                'id' => $threadDetails['id'],
                'user' => null,
                'fullname' => null,
				'reply' => html_entity_decode($threadDetails['message']),
				'source' => $threadDetails['source'],
                'threadType' => $threadDetails['threadType'],
                'userType' => $threadDetails['createdBy'],
                'timestamp' => $formattedTime['dateTimeZone'],
                'formatedCreatedAt' => $formattedTime['dateTimeZone']->format($formattedTime['timeFormatString']),
                'bookmark' => $threadDetails['isBookmarked'],
                'isLocked' => $threadDetails['isLocked'],
                'replyTo' => $threadDetails['replyTo'],
                'cc' => $threadDetails['cc'],
                'bcc' => $threadDetails['bcc'],
                'attachments' => $threadDetails['attachments'],
            ];
  
            if (!empty($threadDetails['user'])) {
                $threadResponse['fullname'] = trim($threadDetails['user']['firstName'] . ' ' . $threadDetails['user']['lastName']);
                $threadResponse['user'] = [
                    'id' => $threadDetails['user']['id'],
                    'smallThumbnail' => $threadDetails['user']['userInstance'][0]['profileImagePath'],
                    'name' => $threadResponse['fullname'],
                ];
            }

            if (!empty($threadResponse['attachments'])) {
                $threadResponse['attachments'] = array_map(function ($attachment) use ($entityManager, $uvdeskFileSystemService) {
                    $attachmentReferenceObject = $entityManager->getReference(Attachment::class, $attachment['id']);
                    return $uvdeskFileSystemService->getFileTypeAssociations($attachmentReferenceObject);
                }, $threadResponse['attachments']);
            }

            array_push($threadCollection, $threadResponse);
        }

        return [
            'threads' => $threadCollection,
            'pagination' => $paginationData,
        ];
    }

    public function massXhrUpdate(Request $request)
    {
        $params = $request->request->get('data');

        foreach ($params['ids'] as $ticketId) {
            $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);

            if (false == $this->isTicketAccessGranted($ticket)) {
		        throw new \Exception('Access Denied', 403);
	        }
            
            if (empty($ticket)) {
                continue;
            }


            switch ($params['actionType']) {
                case 'trashed':
                    if (false == $ticket->getIsTrashed()) {
                        $ticket->setIsTrashed(true);
                        
                        $this->entityManager->persist($ticket);
                    }

                    // Trigger ticket delete event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Delete::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');

                    break;
                case 'delete':

                    $threads = $ticket->getThreads();
                    $fileService = new Filesystem();
                    if (count($threads) > 0) {
                        foreach($threads as $thread) {
                            if (!empty($thread)) {
                                $fileService->remove($this->container->getParameter('kernel.project_dir').'/public/assets/threads/'.$thread->getId());
                            }
                        }
                    }

                    $this->entityManager->remove($ticket);
                    

                    break;
                case 'restored':
                    if (true == $ticket->getIsTrashed()) {
                        $ticket->setIsTrashed(false);

                        $this->entityManager->persist($ticket);
                    }
                    break;
                case 'agent':
                    if ($ticket->getAgent() == null || $ticket->getAgent() && $ticket->getAgent()->getId() != $params['targetId']) {

                        $agent = $this->entityManager->getRepository(User::class)->find($params['targetId']);
                        $ticket->setAgent($agent);
    
                        $this->entityManager->persist($ticket);
    
                        // Trigger Agent Assign event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Agent::getId(), [
                            'entity' => $ticket,
                        ]);
    
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }
                    break;
                case 'status':
                    if ($ticket->getStatus() == null || $ticket->getStatus() && $ticket->getStatus()->getId() != $params['targetId']) {

                        $status = $this->entityManager->getRepository(TicketStatus::class)->findOneById($params['targetId']);
                        $ticket->setStatus($status);

                        $this->entityManager->persist($ticket);

                        // Trigger ticket status event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Status::getId(), [
                            'entity' => $ticket,
                        ]);
                        
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }
                    
                    break;
                case 'type':
                    if ($ticket->getType() == null || $ticket->getType() && $ticket->getType()->getId() != $params['targetId']) {

                        $type = $this->entityManager->getRepository(TicketType::class)->findOneById($params['targetId']);
                        $ticket->setType($type);
    
                        $this->entityManager->persist($ticket);
    
                        // Trigger ticket type event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Type::getId(), [
                            'entity' => $ticket,
                        ]);
    
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }

                    break;
                case 'group':
                    if ($ticket->getSupportGroup() == null || $ticket->getSupportGroup() && $ticket->getSupportGroup()->getId() != $params['targetId']) {

                        $group = $this->entityManager->getRepository(SupportGroup::class)->find($params['targetId']);
                        $ticket->setSupportGroup($group);
    
                        $this->entityManager->persist($ticket);
    
                        // Trigger Support group event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Group::getId(), [
                            'entity' => $ticket,
                        ]);
    
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }

                    break;
                case 'team':
                    if ($ticket->getSupportTeam() == null || $ticket->getSupportTeam() && $ticket->getSupportTeam()->getId() != $params['targetId']){

                        $team = $this->entityManager->getRepository(SupportTeam::class)->find($params['targetId']);
                        $ticket->setSupportTeam($team);
                        
                        $this->entityManager->persist($ticket);
        
                        // Trigger team event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Team::getId(), [
                            'entity' => $ticket,
                        ]);
        
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }

                    break;
                case 'priority':
                    if ($ticket->getPriority() == null || $ticket->getPriority() && $ticket->getPriority()->getId() != $params['targetId']) {
                        
                        $priority = $this->entityManager->getRepository(TicketPriority::class)->find($params['targetId']);
                        $ticket->setPriority($priority);
    
                        $this->entityManager->persist($ticket);
    
                        // Trigger ticket Priority event
                        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Priority::getId(), [
                            'entity' => $ticket,
                        ]);
    
                        $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
                    }

                    break;
                case 'label':
                    $label = $this->entityManager->getRepository(SupportLabel::class)->find($params['targetId']);
                    
                    if ($label && !$this->entityManager->getRepository(Ticket::class)->isLabelAlreadyAdded($ticket, $label)) {
                        $ticket->addSupportLabel($label);
                    }
                    
                    $this->entityManager->persist($ticket);

                    break;
                default:
                    break;
            }
        } 

        $this->entityManager->flush();

        return [
            'alertClass' => 'success',
            'alertMessage' => $this->trans('Tickets have been updated successfully'),
        ];
    }
    
    public function getNotePlaceholderValues($ticket, $type = "customer")
    {
        $variables = array();
        $variables['ticket.id'] = $ticket->getId();
        $variables['ticket.subject'] = $ticket->getSubject();

        $variables['ticket.status'] = $ticket->getStatus()->getCode();
        $variables['ticket.priority'] = $ticket->getPriority()->getCode();
        if($ticket->getSupportGroup())
            $variables['ticket.group'] = $ticket->getSupportGroup()->getName();
        else
            $variables['ticket.group'] = '';

        $variables['ticket.team'] = ($ticket->getSupportTeam() ? $ticket->getSupportTeam()->getName() : '');

        $customer = $this->container->get('user.service')->getCustomerPartialDetailById($ticket->getCustomer()->getId());
        $variables['ticket.customerName'] = $customer['name'];
        $userService = $this->container->get('user.service');
      
        $variables['ticket.agentName'] = '';
        $variables['ticket.agentEmail'] = '';
        if ($ticket->getAgent()) {
            $agent = $this->container->get('user.service')->getAgentDetailById($ticket->getAgent()->getId());
            if($agent) {
                $variables['ticket.agentName'] = $agent['name'];
                $variables['ticket.agentEmail'] = $agent['email'];
            }
        }

        $router = $this->container->get('router');

        if ($type == 'customer') {
            $ticketListURL = $router->generate('helpdesk_member_ticket_collection', [
                'id' => $ticket->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        } else {
            $ticketListURL = $router->generate('helpdesk_customer_ticket_collection', [
                'id' => $ticket->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $variables['ticket.link'] = sprintf("<a href='%s'>#%s</a>", $ticketListURL, $ticket->getId());

        return $variables;
    }

    public function paginateMembersTicketTypeCollection(Request $request)
    {
        // Get base query
        $params = $request->query->all();
        $ticketRepository = $this->entityManager->getRepository(Ticket::class);
        $paginationQuery = $ticketRepository->prepareBasePaginationTicketTypesQuery($params);

        // Apply Pagination
        $paginationOptions = ['distinct' => true];
        $pageNumber = !empty($params['page']) ? (int) $params['page'] : 1;
        $itemsLimit = !empty($params['limit']) ? (int) $params['limit'] : $ticketRepository::DEFAULT_PAGINATION_LIMIT;

        $pagination = $this->container->get('knp_paginator')->paginate($paginationQuery, $pageNumber, $itemsLimit, $paginationOptions);

        // Process Pagination Response
        $paginationParams = $pagination->getParams();
        $paginationData = $pagination->getPaginationData();

        $paginationParams['page'] = 'replacePage';
        $paginationData['url'] = '#' . $this->container->get('uvdesk.service')->buildPaginationQuery($paginationParams);

        return [
            'types' => array_map(function ($ticketType) {
                return [
                    'id' => $ticketType->getId(),
                    'code' => strtoupper($ticketType->getCode()),
                    'description' => $ticketType->getDescription(),
                    'isActive' => $ticketType->getIsActive(),
                ];
            }, $pagination->getItems()),
            'pagination_data' => $paginationData,
        ];
    }

    public function paginateMembersTagCollection(Request $request)
    {
        // Get base query
        $params = $request->query->all();
        $ticketRepository = $this->entityManager->getRepository(Ticket::class);
        $baseQuery = $ticketRepository->prepareBasePaginationTagsQuery($params);

        // Apply Pagination
        $paginationResultsQuery = clone $baseQuery;
        $paginationResultsQuery->select('COUNT(supportTag.id)');
        $paginationQuery = $baseQuery->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY)->setHint('knp_paginator.count', count($paginationResultsQuery->getQuery()->getResult()));

        $paginationOptions = ['distinct' => true];
        $pageNumber = !empty($params['page']) ? (int) $params['page'] : 1;
        $itemsLimit = !empty($params['limit']) ? (int) $params['limit'] : $ticketRepository::DEFAULT_PAGINATION_LIMIT;

        $pagination = $this->container->get('knp_paginator')->paginate($paginationQuery, $pageNumber, $itemsLimit, $paginationOptions);

        // Process Pagination Response
        $paginationParams = $pagination->getParams();
        $paginationData = $pagination->getPaginationData();

        $paginationParams['page'] = 'replacePage';
        $paginationData['url'] = '#' . $this->container->get('uvdesk.service')->buildPaginationQuery($paginationParams);

        if (in_array('UVDeskSupportCenterBundle', array_keys($this->container->getParameter('kernel.bundles')))) {
            $articleRepository = $this->entityManager->getRepository(Article::class);

            return [
                'tags' => array_map(function ($supportTag) use ($articleRepository) {
                    return [
                        'id' => $supportTag['id'],
                        'name' => $supportTag['name'],
                        'ticketCount' => $supportTag['totalTickets'],
                        'articleCount' => $articleRepository->getTotalArticlesBySupportTag($supportTag['id']),
                    ];
                }, $pagination->getItems()),
                'pagination_data' => $paginationData,
            ];
        } else {
            return [
                'tags' => array_map(function ($supportTag) {
                    return [
                        'id' => $supportTag['id'],
                        'name' => $supportTag['name'],
                        'ticketCount' => $supportTag['totalTickets'],
                    ];
                }, $pagination->getItems()),
                'pagination_data' => $paginationData,
            ];
        }
    }

    public function getTicketInitialThreadDetails(Ticket $ticket)
    {
        $initialThread = $this->entityManager->getRepository(Thread::class)->findOneBy([
            'ticket' => $ticket,
            'threadType' => 'create',
        ]);

        if (!empty($initialThread)) {
            $author = $initialThread->getUser();
            $authorInstance = 'agent' == $initialThread->getCreatedBy() ? $author->getAgentInstance() : $author->getCustomerInstance();
        
            $threadDetails = [
                'id' => $initialThread->getId(),
                'source' => $initialThread->getSource(),
                'messageId' => $initialThread->getMessageId(),
                'threadType' => $initialThread->getThreadType(),
                'createdBy' => $initialThread->getCreatedBy(),
                'message' => html_entity_decode($initialThread->getMessage()),
                'attachments' => $initialThread->getAttachments(),
                'timestamp' => $initialThread->getCreatedAt()->getTimestamp(),
                'createdAt' => $initialThread->getCreatedAt()->format('d-m-Y h:ia'),
                'user' => $authorInstance->getPartialDetails(),
                'cc' => is_array($initialThread->getCc()) ? implode(', ', $initialThread->getCc()) : '',
            ];

            $attachments = $threadDetails['attachments']->getValues();

            if (!empty($attachments)) {
                $uvdeskFileSystemService = $this->container->get('uvdesk.core.file_system.service');

                $threadDetails['attachments'] = array_map(function ($attachment) use ($uvdeskFileSystemService) {
                    return $uvdeskFileSystemService->getFileTypeAssociations($attachment);
                }, $attachments);
            }
        }

        return $threadDetails ?? null;
    }

    public function getCreateReply($ticketId, $firewall = 'member')
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("th,a,u.id as userId")->from(Thread::class, 'th')
                ->leftJoin('th.ticket','t')
                ->leftJoin('th.attachments', 'a')
                ->leftJoin('th.user','u')
                ->andWhere('t.id = :ticketId')
                ->andWhere('th.threadType = :threadType')
                ->setParameter('threadType','create')
                ->setParameter('ticketId',$ticketId)
                ->orderBy('th.id', 'DESC')
                ->getMaxResults(1);

        $threadResponse = $qb->getQuery()->getArrayResult();

        if((!empty($threadResponse[0][0]))) {
            $threadDetails = $threadResponse[0][0];
            $userService = $this->container->get('user.service');
            
            if ($threadDetails['createdBy'] == 'agent') {
                $threadDetails['user'] = $userService->getAgentDetailById($threadResponse[0]['userId']);
            } else {
                $threadDetails['user'] = $userService->getCustomerPartialDetailById($threadResponse[0]['userId']);
            }
            
            $threadDetails['reply'] = html_entity_decode($threadDetails['message']);
            $threadDetails['formatedCreatedAt'] = $this->timeZoneConverter($threadDetails['createdAt']);	
            $threadDetails['timestamp'] = $userService->convertToDatetimeTimezoneTimestamp($threadDetails['createdAt']);
        
            if (!empty($threadDetails['attachments'])) {
                $entityManager = $this->entityManager;
                $uvdeskFileSystemService = $this->container->get('uvdesk.core.file_system.service');

                $threadDetails['attachments'] = array_map(function ($attachment) use ($entityManager, $uvdeskFileSystemService, $firewall) {
                    $attachmentReferenceObject = $entityManager->getReference(Attachment::class, $attachment['id']);
                    return $uvdeskFileSystemService->getFileTypeAssociations($attachmentReferenceObject, $firewall);
                }, $threadDetails['attachments']);
            }
        }
        
        return $threadDetails ?? null;
    }

    public function hasAttachments($ticketId) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("DISTINCT COUNT(a.id) as attachmentCount")->from(Thread::class, 'th')
                ->leftJoin('th.ticket','t')
                ->leftJoin('th.attachments','a')
                ->andWhere('t.id = :ticketId')
                ->setParameter('ticketId',$ticketId);

        return intval($qb->getQuery()->getSingleScalarResult());
    }

    public function getAgentDraftReply()
    {
	    $signature = $this->getUser()->getAgentInstance()->getSignature();
        
        return str_replace( "\n", '<br/>', $signature);
    }

    public function trans($text)
    {
        return $this->container->get('translator')->trans($text);
    }

    public function getAllSources()
    {
        $sources = ['email' => 'Email', 'website' => 'Website'];
        return $sources;
    }

    public function getCustomLabelDetails($container)
    {
        $currentUser = $container->get('user.service')->getCurrentUser();

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(DISTINCT t) as ticketCount,sl.id')->from(Ticket::class, 't')
                ->leftJoin('t.supportLabels','sl')
                ->andwhere('sl.user = :userId')
                ->setParameter('userId', $currentUser->getId())
                ->groupBy('sl.id');

        $ticketCountResult = $qb->getQuery()->getResult();

        $data = array();
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('sl.id,sl.name,sl.colorCode')->from(SupportLabel::class, 'sl')
                ->andwhere('sl.user = :userId')
                ->setParameter('userId', $currentUser->getId());

        $labels = $qb->getQuery()->getResult();

        foreach ($labels as $key => $label) {
            $labels[$key]['count'] = 0;
            foreach ($ticketCountResult as $ticketCount) {
                if(($label['id'] == $ticketCount['id']))
                    $labels[$key]['count'] = $ticketCount['ticketCount'] ?: 0;
            }
        }

        return $labels;
    }

    public function getLabels($request = null)
    {
        static $labels;
        if (null !== $labels)
            return $labels;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('sl')->from(SupportLabel::class, 'sl')
            ->andwhere('sl.user = :userId')
            ->setParameter('userId', $this->getUser()->getId());

        if($request) {
            $qb->andwhere("sl.name LIKE :labelName");
            $qb->setParameter('labelName', '%'.urldecode($request->query->get('query')).'%');
        }

        return $labels = $qb->getQuery()->getArrayResult();
    }

    public function getTicketCollaborators($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("DISTINCT c.id, c.email, CONCAT(c.firstName,' ', c.lastName) AS name, userInstance.profileImagePath, userInstance.profileImagePath as smallThumbnail")->from(Ticket::class, 't')
                ->leftJoin('t.collaborators', 'c')
                ->leftJoin('c.userInstance', 'userInstance')
                ->andwhere('t.id = :ticketId')
                ->andwhere('userInstance.supportRole = :roles')
                ->setParameter('ticketId', $ticketId)
                ->setParameter('roles', 4)
                ->orderBy('name','ASC');

        return $qb->getQuery()->getArrayResult();
    }

    public function getTicketTagsById($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tg')->from(Tag::class, 'tg')
                ->leftJoin('tg.tickets' ,'t')
                ->andwhere('t.id = :ticketId')
                ->setParameter('ticketId', $ticketId);

        return $qb->getQuery()->getArrayResult();
    }

    public function getTicketLabels($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT sl.id,sl.name,sl.colorCode')->from(Ticket::class, 't')
                ->leftJoin('t.supportLabels','sl')
                ->leftJoin('sl.user','slu')
                ->andWhere('slu.id = :userId')
                ->andWhere('t.id = :ticketId')
                ->setParameter('userId', $this->getUser()->getId())
                ->setParameter('ticketId', $ticketId);

        $result = $qb->getQuery()->getResult();
        
        return $result ? $result : [];
    }

    public function getUserLabels()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('sl')->from(SupportLabel::class, 'sl')
                ->leftJoin('sl.user','slu')
                ->andWhere('slu.id = :userId')
                ->setParameter('userId', $this->getUser()->getId());

        $result = $qb->getQuery()->getResult();
        
        return $result ? $result : [];
    }

    public function getTicketLabelsAll($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT sl.id,sl.name,sl.colorCode')->from(Ticket::class, 't')
                ->leftJoin('t.supportLabels','sl')
                ->andWhere('t.id = :ticketId')
                ->setParameter('ticketId', $ticketId);

        $result = $qb->getQuery()->getResult();
        
        return $result ? $result : [];
    }

    public function getManualWorkflow()
    {

        $preparedResponseIds = [];
        $groupIds = [];
        $teamIds = []; 
        $userId = $this->container->get('user.service')->getCurrentUser()->getAgentInstance()->getId();

        $preparedResponseRepo = $this->entityManager->getRepository(PreparedResponses::class)->findAll();

        foreach ($preparedResponseRepo as $pr) {
            if ($userId == $pr->getUser()->getId()) {
                //Save the ids of the saved reply.
                array_push($preparedResponseIds, (int)$pr->getId());
            }
        }

        // Get the ids of the Group(s) the current user is associated with.
        $query = "select * from uv_user_support_groups where userInstanceId =".$userId;
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            array_push($groupIds, $row['supportGroupId']);
        }

        // Get all the saved reply's ids that is associated with the user's group(s).
        $query = "select * from uv_prepared_response_support_groups";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['group_id'], $groupIds)) {
                array_push($preparedResponseIds, (int) $row['savedReply_id']);
            }
        }

        // Get the ids of the Team(s) the current user is associated with.
        $query = "select * from uv_user_support_teams";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            if ($row['userInstanceId'] == $userId) {
                array_push($teamIds, $row['supportTeamId']);
            }
        }

        $query = "select * from uv_prepared_response_support_teams";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['subgroup_id'], $teamIds)) {
                array_push($preparedResponseIds, (int)$row['savedReply_id']);
            }
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT mw')
            ->from(PreparedResponses::class, 'mw')
            ->where('mw.status = 1')
            ->andWhere('mw.id IN (:ids)')
            ->setParameter('ids', $preparedResponseIds);
        
        return $qb->getQuery()->getResult();
    }

    public function getSavedReplies()
    {   
        $savedReplyIds = [];
        $groupIds = [];
        $teamIds = []; 
        $userId = $this->container->get('user.service')->getCurrentUser()->getAgentInstance()->getId();

        $savedReplyRepo = $this->entityManager->getRepository(SavedReplies::class)->findAll();

        foreach ($savedReplyRepo as $sr) {
            if ($userId == $sr->getUser()->getId()) {
                //Save the ids of the saved reply.
                array_push($savedReplyIds, (int)$sr->getId());
            }
        }

        // Get the ids of the Group(s) the current user is associated with.
        $query = "select * from uv_user_support_groups where userInstanceId =".$userId;
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            array_push($groupIds, $row['supportGroupId']);
        }

        // Get all the saved reply's ids that is associated with the user's group(s).
        $query = "select * from uv_saved_replies_groups";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['group_id'], $groupIds)) {
                array_push($savedReplyIds, (int) $row['savedReply_id']);
            }
        }

        // Get the ids of the Team(s) the current user is associated with.
        $query = "select * from uv_user_support_teams";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            if ($row['userInstanceId'] == $userId) {
                array_push($teamIds, $row['supportTeamId']);
            }
        }

        $query = "select * from uv_saved_replies_teams";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['subgroup_id'], $teamIds)) {
                array_push($savedReplyIds, (int)$row['savedReply_id']);
            }
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT sr')
        ->from(SavedReplies::class, 'sr')
        ->Where('sr.id IN (:ids)')
        ->setParameter('ids', $savedReplyIds);
        
        return $qb->getQuery()->getResult();
    }

    public function getPriorities()
    {
        static $priorities;
        if (null !== $priorities)
            return $priorities;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tp')->from(TicketPriority::class, 'tp');

        return $priorities = $qb->getQuery()->getArrayResult();
    }

    public function getTicketLastThread($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("th")->from(Thread::class, 'th')
                ->leftJoin('th.ticket','t')
                ->andWhere('t.id = :ticketId')
                ->setParameter('ticketId',$ticketId)
                ->orderBy('th.id', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function getlastReplyAgentName($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("u.id,CONCAT(u.firstName,' ', u.lastName) AS name,u.firstName")->from(Thread::class, 'th')
                ->leftJoin('th.ticket','t')
                ->leftJoin('th.user', 'u')
                ->leftJoin('u.userInstance', 'userInstance')
                ->andwhere('userInstance.supportRole != :roles')
                ->andWhere('t.id = :ticketId')
                ->andWhere('th.threadType = :threadType')
                ->setParameter('threadType','reply')
                ->andWhere('th.createdBy = :createdBy')
                ->setParameter('createdBy','agent')
                ->setParameter('ticketId',$ticketId)
                ->setParameter('roles', 4)
                ->orderBy('th.id', 'DESC');

        $result = $qb->getQuery()->setMaxResults(1)->getResult();
        return $result ? $result[0] : null;
    }

    public function getLastReply($ticketId, $userType = null) 
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select("th, a, u.id as userId")
            ->from(Thread::class, 'th')
            ->leftJoin('th.ticket','t')
            ->leftJoin('th.attachments', 'a')
            ->leftJoin('th.user','u')
            ->andWhere('t.id = :ticketId')
            ->andWhere('th.threadType = :threadType')
            ->setParameter('threadType','reply')
            ->setParameter('ticketId',$ticketId)
            ->orderBy('th.id', 'DESC')
            ->getMaxResults(1);

        if (!empty($userType)) {
            $queryBuilder->andWhere('th.createdBy = :createdBy')->setParameter('createdBy', $userType);
        }
        
        $threadResponse = $queryBuilder->getQuery()->getArrayResult();
        
        if (!empty($threadResponse[0][0])) {
            $threadDetails = $threadResponse[0][0];
            $userService = $this->container->get('user.service');
            
            if ($threadDetails['createdBy'] == 'agent') {
                $threadDetails['user'] = $userService->getAgentDetailById($threadResponse[0]['userId']);
            } else {
                $threadDetails['user'] = $userService->getCustomerPartialDetailById($threadResponse[0]['userId']);
            }
            
            $threadDetails['reply'] = html_entity_decode($threadDetails['message']);
            $threadDetails['formatedCreatedAt'] = $this->timeZoneConverter($threadDetails['createdAt']);
            $threadDetails['timestamp'] = $userService->convertToDatetimeTimezoneTimestamp($threadDetails['createdAt']);

            if (!empty($threadDetails['attachments'])) {
                $entityManager = $this->entityManager;
                $uvdeskFileSystemService = $this->container->get('uvdesk.core.file_system.service');

                $threadDetails['attachments'] = array_map(function ($attachment) use ($entityManager, $uvdeskFileSystemService) {
                    $attachmentReferenceObject = $this->entityManager->getReference(Attachment::class, $attachment['id']);
                    return $uvdeskFileSystemService->getFileTypeAssociations($attachmentReferenceObject);
                }, $threadDetails['attachments']);
            }
        }

        return $threadDetails ?? null;
    }

    public function getSavedReplyContent($savedReplyId, $ticketId)
    {
        $ticket = $this->entityManager->getRepository(Ticket::class)->find($ticketId);
        $savedReply = $this->entityManager->getRepository(SavedReplies::class)->findOneById($savedReplyId);
        $emailPlaceholders = $this->getSavedReplyPlaceholderValues($ticket, 'customer');

        return $this->container->get('email.service')->processEmailContent($savedReply->getMessage(), $emailPlaceholders, true);
    }

    public function getSavedReplyPlaceholderValues($ticket, $type = "customer")
    {
        $variables = array();
        $variables['ticket.id'] = $ticket->getId();
        $variables['ticket.subject'] = $ticket->getSubject();

        $variables['ticket.status'] = $ticket->getStatus()->getCode();
        $variables['ticket.priority'] = $ticket->getPriority()->getCode();
        if($ticket->getSupportGroup())
            $variables['ticket.group'] = $ticket->getSupportGroup()->getName();
        else
            $variables['ticket.group'] = '';

        $variables['ticket.team'] = ($ticket->getSupportTeam() ? $ticket->getSupportTeam()->getName() : '');

        $customer = $this->container->get('user.service')->getCustomerPartialDetailById($ticket->getCustomer()->getId());
        $variables['ticket.customerName'] = $customer['name'];
        $variables['ticket.customerEmail'] = $customer['email'];
        $userService = $this->container->get('user.service');
      
        $variables['ticket.agentName'] = '';
        $variables['ticket.agentEmail'] = '';
        if ($ticket->getAgent()) {
            $agent = $this->container->get('user.service')->getAgentDetailById($ticket->getAgent()->getId());
            if($agent) {
                $variables['ticket.agentName'] = $agent['name'];
                $variables['ticket.agentEmail'] = $agent['email'];
            }
        }
        
        $router = $this->container->get('router');

        if ($type == 'customer') {
            $ticketListURL = $router->generate('helpdesk_customer_ticket_collection', [
                'id' => $ticket->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        } else {
            $ticketListURL = $router->generate('helpdesk_member_ticket_collection', [
                'id' => $ticket->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $variables['ticket.link'] = sprintf("<a href='%s'>#%s</a>", $ticketListURL, $ticket->getId());

        return $variables;
    }

    public function isEmailBlocked($email, $website) 
    {
        $flag = false;
        $email = strtolower($email);
        $knowlegeBaseWebsite = $this->entityManager->getRepository(KnowledgebaseWebsite::class)->findOneBy(['website' => $website->getId(), 'isActive' => 1]);
        $list = $this->container->get('user.service')->getWebsiteSpamDetails($knowlegeBaseWebsite);

        // Blacklist
        if (!empty($list['blackList']['email']) && in_array($email, $list['blackList']['email'])) {
            // Emails
            $flag = true;
        } elseif (!empty($list['blackList']['domain'])) {
            // Domains
            foreach ($list['blackList']['domain'] as $domain) {
                if (strpos($email, $domain)) {
                    $flag = true;
                    break;
                }
            }
        }

        // Whitelist
        if ($flag) {
            if (isset($email, $list['whiteList']['email']) && in_array($email, $list['whiteList']['email'])) {
                // Emails
                return false;
            } elseif (isset($list['whiteList']['domain'])) {
                // Domains
                foreach ($list['whiteList']['domain'] as $domain) {
                    if (strpos($email, $domain)) {
                        $flag = false;
                    }
                }
            }
        }

        return $flag;
    }

    public function timeZoneConverter($dateFlag)
    {
        $website = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'Knowledgebase']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        $activeUser = $this->container->get('user.service')->getSessionUser();
        $agentTimeZone = !empty($activeUser) ? $activeUser->getTimezone() : null;
        $agentTimeFormat = !empty($activeUser) ? $activeUser->getTimeformat() : null;

        $parameterType = gettype($dateFlag);
        if($parameterType == 'string'){
            if(is_null($agentTimeZone) && is_null($agentTimeFormat)){
                if(is_null($timeZone) && is_null($timeFormat)){
                    $datePattern = date_create($dateFlag);
                    return date_format($datePattern,'d-m-Y h:ia');
                } else {
                    $dateFlag = new \DateTime($dateFlag);
                    $datePattern = $dateFlag->setTimezone(new \DateTimeZone($timeZone));
                    return date_format($datePattern, $timeFormat);
                }
            } else {
                $dateFlag = new \DateTime($dateFlag);
                $datePattern = $dateFlag->setTimezone(new \DateTimeZone($agentTimeZone));
                return date_format($datePattern, $agentTimeFormat);
            }          
        } else {
            if(is_null($agentTimeZone) && is_null($agentTimeFormat)){
                if(is_null($timeZone) && is_null($timeFormat)){
                    return date_format($dateFlag,'d-m-Y h:ia');
                } else {
                    $datePattern = $dateFlag->setTimezone(new \DateTimeZone($timeZone));
                    return date_format($datePattern, $timeFormat);
                }
            } else {
                $datePattern = $dateFlag->setTimezone(new \DateTimeZone($agentTimeZone));
                return date_format($datePattern, $agentTimeFormat);
            }    
        }         
    }

    public function fomatTimeByPreference($dbTime,$timeZone,$timeFormat,$agentTimeZone,$agentTimeFormat)
    {
        if(is_null($agentTimeZone) && is_null($agentTimeFormat)) {
            if(is_null($timeZone) && is_null($timeFormat)){
                $dateTimeZone = $dbTime;
                $timeFormatString = 'd-m-Y h:ia';
            } else {
                $dateTimeZone = $dbTime->setTimezone(new \DateTimeZone($timeZone));
                $timeFormatString = $timeFormat;
            }
        } else {
            $dateTimeZone = $dbTime->setTimezone(new \DateTimeZone($agentTimeZone));
            $timeFormatString = $agentTimeFormat;
        }
        $time['dateTimeZone'] = $dateTimeZone;
        $time['timeFormatString'] = $timeFormatString;
        return $time;
    }
    
    public function isTicketAccessGranted(Ticket $ticket, User $user = null, $firewall = 'members')
    {
        // @TODO: Take current firewall into consideration (access check on behalf of agent/customer)
        if (empty($user)) {
            $user = $this->container->get('user.service')->getSessionUser();
        }

        if (empty($user)) {
            return false;
        } else {
            $agentInstance = $user->getAgentInstance();
    
            if (empty($agentInstance)) {
                return false;
            }
        }

        if ($agentInstance->getSupportRole()->getId() == 3 && in_array($agentInstance->getTicketAccessLevel(), [2, 3, 4])) {
            $accessLevel = $agentInstance->getTicketAccessLevel();

            // Check if user has been given inidividual access
            if ($ticket->getAgent() != null && $ticket->getAgent()->getId() == $user->getId()) {
                return true;
            }
            
            if ($accessLevel == 2 || $accessLevel == 3) {
                // Check if user belongs to a support team assigned to ticket
                $teamReferenceIds = array_map(function ($team) { return $team->getId(); }, $agentInstance->getSupportTeams()->toArray());
                
                if ($ticket->getSupportTeam() != null && in_array($ticket->getSupportTeam()->getId(), $teamReferenceIds)) {
                    return true;
                } else if ($accessLevel == 2) {
                    // Check if user belongs to a support group assigned to ticket
                    $groupReferenceIds = array_map(function ($group) { return $group->getId(); }, $agentInstance->getSupportGroups()->toArray());

                    if ($ticket->getSupportGroup() != null && in_array($ticket->getSupportGroup()->getId(), $groupReferenceIds)) {
                        return true;
                    }
                }
            }

            return false;
        }

        return true;
    }

    public function addTicketCustomFields($thread, $requestCustomFields = [], $filesCustomFields = [])
    {
        $ticket = $thread->getTicket();
        $skipFileUpload = false;
        $customFieldsCollection = $this->entityManager->getRepository(CommunityPackageEntities\CustomFields::class)->findAll();
        foreach ($customFieldsCollection as $customFields) {
            if(in_array($customFields->getFieldType(), ['select', 'checkbox', 'radio']) && !count($customFields->getCustomFieldValues()))
                continue;
            elseif('file' != $customFields->getFieldType() && $requestCustomFields && array_key_exists($customFields->getId(), $requestCustomFields) && $requestCustomFields[$customFields->getId()]) {

                if(count($customFields->getCustomFieldsDependency()) && !in_array($ticket->getType(), $customFields->getCustomFieldsDependency()->toArray()))
                    continue;

                $ticketCustomField = new CommunityPackageEntities\TicketCustomFieldsValues();
                $ticketCustomField->setTicket($ticket);
                //custom field
                $ticketCustomField->setTicketCustomFieldsValues($customFields);
                $ticketCustomField->setValue(json_encode($requestCustomFields[$customFields->getId()]));

                if(in_array($customFields->getFieldType(), ['select', 'checkbox', 'radio'])) {
                    //add custom field values mapping too
                    if(is_array($requestCustomFields[$customFields->getId()])) {
                        foreach ($requestCustomFields[$customFields->getId()] as $value) {
                            if($ticketCustomFieldValues = $this->entityManager->getRepository(CommunityPackageEntities\CustomFieldsValues::class)
                                ->findOneBy(['customFields' => $customFields, 'id' => $value]))
                                $ticketCustomField->setTicketCustomFieldValueValues($ticketCustomFieldValues);
                        }
                    } elseif($ticketCustomFieldValues = $this->entityManager->getRepository(CommunityPackageEntities\CustomFieldsValues::class)
                            ->findOneBy(['customFields' => $customFields, 'id' => $requestCustomFields[$customFields->getId()]]))                                                        
                        $ticketCustomField->setTicketCustomFieldValueValues($ticketCustomFieldValues);
                }

                $this->entityManager->persist($ticketCustomField);
                $this->entityManager->flush();
            } elseif($filesCustomFields && array_key_exists($customFields->getId(), $filesCustomFields) && $filesCustomFields[$customFields->getId()] && !$skipFileUpload) {
                $skipFileUpload = true;
                //upload files
            
                $path = '/custom-fields/ticket/' . $ticket->getId() . '/';
                $fileNames = $this->fileUploadService->uploadFile($filesCustomFields[$customFields->getid()], $path, true);

                if(!empty($fileNames)) {
                    //save files entry to attachment table
                    $newFilesNames = $this->customFieldsService->addFilesEntryToAttachmentTable([$fileNames], $thread);
                    foreach ($newFilesNames as $value) {
                        $ticketCustomField = new CommunityPackageEntities\TicketCustomFieldsValues();
                        $ticketCustomField->setTicket($ticket);
                        //custom field
                        $ticketCustomField->setTicketCustomFieldsValues($customFields);
                        $ticketCustomField->setValue(json_encode(['name' => $value['name'], 'path' => $value['path'], 'id' => $value['id']]));
                        $this->entityManager->persist($ticketCustomField);
                        $this->entityManager->flush();
                    }
                }
            }
        }
    }

    /**
    * return ticket todo ticket increment Id
    */
    public function getTicketTodoById($ticketId) {
        $currentUser = $this->container->get('user.service')->getCurrentUser();
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('td')->from('UVDeskTodoListPackage:Todo', 'td')
                ->andwhere('td.ticket = :ticketId')
                ->andwhere('td.agent = :userId')
                ->setParameter('ticketId', $ticketId)
                ->setParameter('userId', $currentUser->getId());

        return $qb->getQuery()->getArrayResult();
    }

    // return attachemnt for initial thread
    public function getInitialThread($ticketId)
    {
        $firstThread = null;
        $intialThread = $this->entityManager->getRepository(Thread::class)->findBy(['ticket'=>$ticketId]);
        foreach ($intialThread as $key => $value) {
            if($value->getThreadType() == "create"){
                $firstThread = $value;
            }
        }
        return $firstThread;
    }
}
