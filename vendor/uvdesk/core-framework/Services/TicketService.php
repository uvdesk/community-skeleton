<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TicketService
{
    protected $container;
	protected $requestStack;
    protected $entityManager;
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function getRandomRefrenceId($email = null)
    {
        $email = !empty($email) ? $email : $this->container->getParameter('uvdesk.support_email.id');
        $emailDomain = substr($email, strpos($email, '@'));

        return sprintf("<%s%s>", TokenGenerator::generateToken(20, '0123456789abcdefghijklmnopqrstuvwxyz'), $emailDomain);
    }

    public function getUser() {
        return $this->container->get('user.service')->getCurrentUser();
    }

    public function getDefaultType()
    {
        $typeCode = $this->container->getParameter('uvdesk.default.ticket.type');
        $ticketType = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findOneByCode($typeCode);

        return !empty($ticketType) ? $ticketType : null;
    }

    public function getDefaultStatus()
    {
        $statusCode = $this->container->getParameter('uvdesk.default.ticket.status');
        $ticketStatus = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketStatus')->findOneByCode($statusCode);

        return !empty($ticketStatus) ? $ticketStatus : null;
    }

    public function getDefaultPriority()
    {
        $priorityCode = $this->container->getParameter('uvdesk.default.ticket.priority');
        $ticketPriority = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findOneByCode($priorityCode);

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
        $ticketTypeCollection = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findByIsActive(true);
        
        return $twigTemplatingEngine->render('@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig', [
            'ticketTypeCollection' => $ticketTypeCollection
        ]);
    }

    public function createTicket(array $params = [])
    {
        $thread = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread')->findOneByMessageId($params['messageId']);

        if (empty($thread)) {
            $user = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($params['from']);

            if (empty($user) || null == $user->getCustomerInstance()) {
                $role = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode($params['role']);
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

        foreach ($threadData as $property => $value) {
            if (!empty($value)) {
                $callable = 'set' . ucwords($property);
                
                if (method_exists($thread, $callable)) {
                    $thread->$callable($value);
                }
            }
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
            } else {
                // Ticket has been updated by customer, mark as agent view | reply pending
                $ticket->setIsAgentViewed(false);
                $ticket->setIsReplied(false);
            }

            $this->entityManager->persist($ticket);
        } else if ('create' === $threadData['threadType']) {
            $ticket->setIsReplied(false);
            $this->entityManager->persist($ticket);
        }
        
        $ticket->currentThread = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread')->getTicketCurrentThread($ticket);
        
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
        $qb->select('tp.id','tp.code As name')->from('UVDeskCoreFrameworkBundle:TicketType', 'tp')
                ->andwhere('tp.isActive = 1');

        return $types = $qb->getQuery()->getArrayResult();
    }

    public function getStatus()
    {
        static $statuses;
        if (null !== $statuses)
            return $statuses;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('ts')->from('UVDeskCoreFrameworkBundle:TicketStatus', 'ts');
        // $qb->orderBy('ts.sortOrder', Criteria::ASC);

        return $statuses = $qb->getQuery()->getArrayResult();
    }

    public function getTicketTotalThreads($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(th.id) as threadCount')->from('UVDeskCoreFrameworkBundle:Ticket', 't')
            ->leftJoin('t.threads', 'th')
            ->andWhere('t.id = :ticketId')
            ->andWhere('th.threadType = :threadType')
            ->setParameter('threadType','reply')
            ->setParameter('ticketId', $ticketId);

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(t.id) as threadCount')->from('UVDeskCoreFrameworkBundle:Thread', 't')
            ->andWhere('t.ticket = :ticketId')
            ->andWhere('t.threadType = :threadType')
            ->setParameter('threadType','reply')
            ->setParameter('ticketId', $ticketId);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTicketTags($request = null)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tg')->from('UVDeskCoreFrameworkBundle:Tag', 'tg');

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
        $agentTimeZone = $activeUser->getTimezone();
        $agentTimeFormat = $activeUser->getTimeformat();

        $ticketRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');

        $website = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneBy(['code' => 'helpdesk']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        $supportGroupReference = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->getUserSupportGroupReferences($activeUser);
        $supportTeamReference  = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->getUserSupportTeamReferences($activeUser);

        // Get base query
        $baseQuery = $ticketRepository->prepareBaseTicketQuery($activeUser, $supportGroupReference, $supportTeamReference, $params);
        $ticketTabs = $ticketRepository->getTicketTabDetails($activeUser, $params);

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
            ->from('UVDeskCoreFrameworkBundle:Ticket', 'ticket')
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
                'hasAttachments' => $ticketHasAttachments
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
                'predefind' => $this->getPredefindLabelDetails($this->container, $params),
                'custom' => $this->getCustomLabelDetails($this->container),
            ],
          
        ];
    }
    
    public function getPredefindLabelDetails($container, $params)
    {
        $currentUser = $container->get('user.service')->getCurrentUser();
        $data = array();
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $ticketRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');
        $queryBuilder->select('COUNT(DISTINCT ticket.id) as ticketCount')->from('UVDeskCoreFrameworkBundle:Ticket', 'ticket')
            ->leftJoin('ticket.agent', 'agent');
        
        if ($currentUser->getRoles()[0] != 'ROLE_SUPER_ADMIN') {
            $queryBuilder->andwhere('agent = ' . $currentUser->getId());
        }
        
        $queryBuilder->andwhere('ticket.isTrashed != 1');

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
        $mineQb->andWhere("agent = :agentId")
                ->setParameter('agentId', $currentUser->getId());
        $data['mine'] = $mineQb->getQuery()->getSingleScalarResult();

        // for starred tickets count
        $starredQb = clone $queryBuilder;
        $starredQb->andwhere('ticket.isStarred = 1');
        $data['starred'] = $starredQb->getQuery()->getSingleScalarResult();

        // for trashed tickets count
        $trashedQb = clone $queryBuilder;
        $trashedQb->where('ticket.isTrashed = 1');
        if ($currentUser->getRoles()[0] != 'ROLE_SUPER_ADMIN') {
            $trashedQb->andwhere('agent = ' . $currentUser->getId());
        }
        $data['trashed'] = $trashedQb->getQuery()->getSingleScalarResult();

        return $data;
    }

    public function paginateMembersTicketThreadCollection(Ticket $ticket, Request $request)
    {
        $params = $request->query->all();
        $entityManager = $this->entityManager;
        $activeUser = $this->container->get('user.service')->getSessionUser();

        $agentTimeZone = $activeUser->getTimezone();
        $agentTimeFormat = $activeUser->getTimeformat();
        
        $threadRepository = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread');
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

        $website = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneBy(['code' => 'helpdesk']);
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
        $permissionMessages = [
            'trashed' => ['permission' => 'ROLE_AGENT_DELETE_TICKET', 'message' => 'Success ! Tickets moved to trashed successfully.'],
            'delete' => ['permission' =>  'ROLE_AGENT_DELETE_TICKET', 'message' => 'Success ! Tickets removed successfully.'],
            'restored' => ['permission' =>  'ROLE_AGENT_RESTORE_TICKET', 'message' => 'Success ! Tickets restored successfully.'],
            'agent' => ['permission' =>  'ROLE_AGENT_ASSIGN_TICKET', 'message' => 'Success ! Agent assigned successfully.'],
            'status' => ['permission' =>  'ROLE_AGENT_UPDATE_TICKET_STATUS', 'message' => 'Success ! Tickets status updated successfully.'],
            'type' => ['permission' =>  'ROLE_AGENT_ASSIGN_TICKET_TYPE', 'message' => 'Success ! Tickets type updated successfully.'],
            'group' => ['permission' =>  'ROLE_AGENT_ASSIGN_TICKET_GROUP', 'message' => 'Success ! Tickets group updated successfully.'],
            'team' => ['permission' =>  'ROLE_AGENT_ASSIGN_TICKET_GROUP', 'message' => 'Success ! Tickets team updated successfully.'],
            'priority' => ['permission' =>  'ROLE_AGENT_UPDATE_TICKET_PRIORITY', 'message' => 'Success ! Tickets priority updated successfully.'],
            'label' => ['permission' =>  '', 'message' => 'Success ! Tickets added to label successfully.']
        ];
        $json = array();
        $data = $request->request->get('data');
        
        $ids = $data['ids'];        
        foreach ($ids as $id) {
            $ticket = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($id);
            if(!$ticket)
                continue;

            switch($data['actionType']) {
                case 'trashed':
                    $ticket->setIsTrashed(1);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();                  
                    break;
                case 'delete':

                    $this->entityManager->remove($ticket);
                    $this->entityManager->flush();
                    break;
                case 'restored':
                    $ticket->setIsTrashed(0);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                   
                    break;
                case 'agent':
                    $flag = 0;
                    $agent = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->find($data['targetId']);
                    $targetAgent = $agent->getUserInstance()['agent'] ? $agent->getUserInstance()['agent']->getName() : 'UnAssigned';
                    if($ticket->getAgent() != $agent) {
                        $ticketAgent = $ticket->getAgent();
                        $currentAgent = $ticketAgent ? ($ticketAgent->getUserInstance()['agent'] ? $ticketAgent->getUserInstance()['agent']->getName() : 'UnAssigned') : 'UnAssigned';

                        $notePlaceholders = $this->getNotePlaceholderValues(
                                $currentAgent,
                                $targetAgent,
                                'agent'
                            );
                        $flag = 1;
                    }

                    $ticket->setAgent($agent);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                    break;
                case 'status':
                    $status = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketStatus')->find($data['targetId']);
                    $flag = 0;
                    if($ticket->getStatus() != $status) {
                        $notePlaceholders = $this->getNotePlaceholderValues(
                                $ticket->getStatus()->getCode(),
                                $status->getCode(),
                                'status'
                            );
                        $flag = 1;
                    }
                    $ticket->setStatus($status);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                    break;
                case 'type':
                    $type = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->find($data['targetId']);
                    $flag = 0;
                    if($ticket->getType() != $type) {
                        $notePlaceholders = $this->getNotePlaceholderValues(
                                $ticket->getType() ? $ticket->getType()->getCode() :'UnAssigned',
                                $type->getCode(),
                                'status'
                            );
                        $flag = 1;
                    }
                    $ticket->setType($type);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                    break;
                case 'group':
                    $group = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportGroup')->find($data['targetId']);
                    $flag = 0;
                    if($ticket->getSupportGroup() != $group) {
                        $notePlaceholders = $this->getNotePlaceholderValues(
                                    $ticket->getSupportGroup() ? $ticket->getSupportGroup()->getName() : 'UnAssigned',
                                    $group ? $group->getName() :'UnAssigned',
                                    'group'
                                );
                        $flag = 1;
                    }
                    $ticket->setSupportGroup($group);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                    break;
                case 'team':
                    $team = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportTeam')->find($data['targetId']);
                    $flag = 0;
                    if($ticket->getSupportTeam() != $team){
                        $notePlaceholders = $this->getNotePlaceholderValues(
                                $ticket->getSupportTeam() ? $ticket->getSupportTeam()->getName() :'UnAssigned',
                                $team ? $team->getName() :'UnAssigned',
                                'team'
                            );
                        $flag = 1;
                    }
                    $ticket->setSupportTeam($team);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();
                    break;
                case 'priority':
                    $flag = 0;
                    $priority = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->find($data['targetId']);
                   
                    if($ticket->getPriority() != $priority) {
                        $notePlaceholders = $this->getNotePlaceholderValues(
                                    $ticket->getPriority()->getCode(),
                                    $priority->getCode(),
                                    'priority'
                                );
                        $flag = 1;
                    }
                    $ticket->setPriority($priority);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();

                    
                    break;
                case 'label':
                    $label = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportLabel')->find($data['targetId']);
                    if($label && !$this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->isLabelAlreadyAdded($ticket, $label))
                        $ticket->addSupportLabel($label);
                    $this->entityManager->persist($ticket);
                    $this->entityManager->flush();
                    break;
            }
        }
        return [
            'alertClass' => 'success',
            'alertMessage' => $permissionMessages[$data['actionType']]['message'],
        ];
    }

    public function getNotePlaceholderValues($currentProperty,$targetProperty,$type = "", $details = null)
    {
        $variables = array();

        $variables['type.previousType'] = ($type == 'type') ? $currentProperty : '';
        $variables['type.updatedType'] = ($type == 'type') ? $targetProperty : '';

        $variables['status.previousStatus'] = ($type == 'status') ? $currentProperty : '';
        $variables['status.updatedStatus'] = ($type == 'status') ? $targetProperty : '';

        $variables['group.previousGroup'] = ($type == 'group') ? $currentProperty : '';
        $variables['group.updatedGroup'] = ($type == 'group') ? $targetProperty : '';

        $variables['team.previousTeam'] = ($type == 'team') ? $currentProperty : '';
        $variables['team.updatedTeam'] = ($type == 'team') ? $targetProperty : '';

        $variables['priority.previousPriority'] = ($type == 'priority') ? $currentProperty : '';
        $variables['priority.updatedPriority'] = ($type == 'priority') ? $targetProperty : '';

        $variables['agent.previousAgent'] = ($type == 'agent') ? $currentProperty : '';
        $variables['agent.updatedAgent'] = ($type == 'agent') ? $targetProperty : '';

        if($details) {
            $variables['agent.responsePerformingAgent'] = $details;
        } else {
            $detail = $this->getUser()->getUserInstance();
            $variables['agent.responsePerformingAgent'] = !empty($detail['agent']) ? $detail['agent']->getName() : '';
        }
        return $variables;
    }

    public function paginateMembersTicketTypeCollection(Request $request)
    {
        // Get base query
        $params = $request->query->all();
        $ticketRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');
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
        $ticketRepository = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');
        $baseQuery = $ticketRepository->prepareBasePaginationTagsQuery($params);

        // Apply Pagination
        $paginationResultsQuery = clone $baseQuery;
        $paginationResultsQuery->select('COUNT(supportTag.id)');
        $paginationQuery = $baseQuery->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY)->setHint('knp_paginator.count', $paginationResultsQuery->getQuery()->getResult());

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
            $articleRepository = $this->entityManager->getRepository('UVDeskSupportCenterBundle:Article');

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
        $initialThread = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread')->findOneBy([
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
        $qb->select("th,a,u.id as userId")->from('UVDeskCoreFrameworkBundle:Thread', 'th')
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
        $qb->select("DISTINCT COUNT(a.id) as attachmentCount")->from('UVDeskCoreFrameworkBundle:Thread', 'th')
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
        $qb->select('COUNT(DISTINCT t) as ticketCount,sl.id')->from("UVDeskCoreFrameworkBundle:Ticket", 't')
                ->leftJoin('t.supportLabels','sl')
                ->andwhere('sl.user = :userId')
                ->setParameter('userId', $currentUser->getId())
                ->groupBy('sl.id');

        $ticketCountResult = $qb->getQuery()->getResult();

        $data = array();
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('sl.id,sl.name,sl.colorCode')->from("UVDeskCoreFrameworkBundle:SupportLabel", 'sl')
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
        $qb->select('sl')->from('UVDeskCoreFrameworkBundle:SupportLabel', 'sl')
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
        $qb->select("DISTINCT c.id, c.email, CONCAT(c.firstName,' ', c.lastName) AS name, userInstance.profileImagePath, userInstance.profileImagePath as smallThumbnail")->from('UVDeskCoreFrameworkBundle:Ticket', 't')
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
        $qb->select('tg')->from('UVDeskCoreFrameworkBundle:Tag', 'tg')
                ->leftJoin('tg.tickets' ,'t')
                ->andwhere('t.id = :ticketId')
                ->setParameter('ticketId', $ticketId);

        return $qb->getQuery()->getArrayResult();
    }

    public function getTicketLabels($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT sl.id,sl.name,sl.colorCode')->from('UVDeskCoreFrameworkBundle:Ticket', 't')
                ->leftJoin('t.supportLabels','sl')
                ->leftJoin('sl.user','slu')
                ->andWhere('slu.id = :userId')
                ->andWhere('t.id = :ticketId')
                ->setParameter('userId', $this->getUser()->getId())
                ->setParameter('ticketId', $ticketId);

        $result = $qb->getQuery()->getResult();
        
        return $result ? $result : [];
    }

    public function getManualWorkflow()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT mw')->from('UVDeskAutomationBundle:PreparedResponses', 'mw');
        $qb->andwhere('mw.status = 1');
        
        return $qb->getQuery()->getResult();
    }

    public function getSavedReplies()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('DISTINCT sr')->from('UVDeskCoreFrameworkBundle:SavedReplies', 'sr');
        return $qb->getQuery()->getResult();
    }

    public function getPriorities()
    {
        static $priorities;
        if (null !== $priorities)
            return $priorities;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('tp')->from('UVDeskCoreFrameworkBundle:TicketPriority', 'tp');

        return $priorities = $qb->getQuery()->getArrayResult();
    }

    public function getTicketLastThread($ticketId)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("th")->from('UVDeskCoreFrameworkBundle:Thread', 'th')
                ->leftJoin('th.ticket','t')
                ->andWhere('t.id = :ticketId')
                ->setParameter('ticketId',$ticketId)
                ->orderBy('th.id', 'DESC');

        return $qb->getQuery()->setMaxResults(1)->getSingleResult();
    }

    public function getlastReplyAgentName($ticketId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("u.id,CONCAT(u.firstName,' ', u.lastName) AS name,u.firstName")->from('UVDeskCoreFrameworkBundle:Thread', 'th')
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
            ->from('UVDeskCoreFrameworkBundle:Thread', 'th')
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
        $ticket = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($ticketId);
        $savedReply = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:SavedReplies')->findOneById($savedReplyId);
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
            $variables['ticket.group'] = $ticket->getSupportGroups()->getName();
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

    public function isEmailBlocked($email, $website) 
    {
        $flag = false;
        $email = strtolower($email);
        $knowlegeBaseWebsite = $this->entityManager->getRepository('UVDeskSupportCenterBundle:KnowledgebaseWebsite')->findOneBy(['website' => $website->getId(), 'isActive' => 1]);
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
        $website = $this->entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneBy(['code' => 'helpdesk']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        $activeUser = $this->container->get('user.service')->getSessionUser();
        $agentTimeZone = $activeUser->getTimezone();
        $agentTimeFormat = $activeUser->getTimeformat();

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
}

