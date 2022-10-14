<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Form as CoreFrameworkBundleForms;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreFrameworkBundleEntities;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\DataProxies as CoreFrameworkBundleDataProxies;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\CoreFrameworkBundle\Tickets\QuickActionButtonCollection;
use Webkul\UVDesk\CoreFrameworkBundle\Services\CustomFieldsService;
use Webkul\UVDesk\CoreFrameworkBundle\Repository\TicketRepository;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\TicketService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\EmailService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket as CoreBundleTicket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus;

class Ticket extends AbstractController
{
    private $userService;
    private $translator;
    private $eventDispatcher;
    private $ticketService;
    private $emailService;
    private $kernel;
    private $customFieldsService;

    public function __construct(UserService $userService, TranslatorInterface $translator, TicketService $ticketService, EmailService $emailService, EventDispatcherInterface $eventDispatcher, KernelInterface $kernel, CustomFieldsService $customFieldsService)
    {
        $this->userService = $userService;
        $this->emailService = $emailService;
        $this->translator = $translator;
        $this->ticketService = $ticketService;
        $this->eventDispatcher = $eventDispatcher;
        $this->kernel = $kernel;
        $this->customFieldsService = $customFieldsService;
    }

    public function listTicketCollection(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        return $this->render('@UVDeskCoreFramework//ticketList.html.twig', [
            'ticketStatusCollection' => $entityManager->getRepository(TicketStatus::class)->findAll(),
            'ticketTypeCollection' => $entityManager->getRepository(TicketType::class)->findByIsActive(true),
            'ticketPriorityCollection' => $entityManager->getRepository(TicketPriority::class)->findAll(),
        ]);
    }

    public function loadTicket($ticketId, QuickActionButtonCollection $quickActionButtonCollection, ContainerInterface $container)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $ticketRepository = $entityManager->getRepository(CoreBundleTicket::class);

        $ticket = $ticketRepository->findOneById($ticketId);
        
        if (empty($ticket)) {
            throw new NotFoundHttpException('Page not found!');
        }
        
        $user = $this->userService->getSessionUser();
        
        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) {
            throw new \Exception('Access Denied', 403);
        }

        $agent = $ticket->getAgent();
        $customer = $ticket->getCustomer();
	 
	if($agent != null && !empty($agent)){	
        $ticketAssignAgent = $agent->getId();
        $currentUser = $user->getId();
	}
        
        // Mark as viewed by agents
        if (false == $ticket->getIsAgentViewed()) {
            $ticket->setIsAgentViewed(true);

            $entityManager->persist($ticket);
            $entityManager->flush();
        }
	
        // Ticket Authorization
        $supportRole = $user->getCurrentInstance()->getSupportRole()->getCode(); 
        switch($supportRole) {
            case 'ROLE_ADMIN':
            case 'ROLE_SUPER_ADMIN':
                break;
            case 'ROLE_AGENT':
                $accessLevel = (int) $user->getCurrentInstance()->getTicketAccessLevel();
                switch($accessLevel) {
                    case TicketRepository::TICKET_GLOBAL_ACCESS:
                        break;
                    case TicketRepository::TICKET_GROUP_ACCESS:
                        $supportGroups = array_map(function($supportGroup) { return $supportGroup->getId(); }, $user->getCurrentInstance()->getSupportGroups()->getValues());                       
                        $ticketAccessableGroups = $ticket->getSupportGroup() ? [$ticket->getSupportGroup()->getId()] : [];
 
                        if ($ticket->getSupportTeam()) {
                            $ticketSupportTeamGroups = array_map(function($supportGroup) { return $supportGroup->getId(); }, $ticket->getSupportTeam()->getSupportGroups()->getValues());
                            $ticketAccessableGroups = array_merge($ticketAccessableGroups, $ticketSupportTeamGroups);
                        }
                        $isAccessableGroupFound = false;
                        foreach($ticketAccessableGroups as $groupId) {
                            if (in_array($groupId, $supportGroups)) {
                                $isAccessableGroupFound = true;
                                break;
                            }
                        }
                        if (!$isAccessableGroupFound && !($ticketAssignAgent == $currentUser)) {
                            throw new NotFoundHttpException('Page not found!');
                        }
                        break;
                    case TicketRepository::TICKET_TEAM_ACCESS:
                        $supportTeams = array_map(function($supportTeam) { return $supportTeam->getId(); }, $user->getCurrentInstance()->getSupportTeams()->getValues());                         
                        $supportTeam = $ticket->getSupportTeam();
                        if (!($supportTeam && in_array($supportTeam->getId(), $supportTeams)) && !($ticketAssignAgent == $currentUser)) {
                            throw new NotFoundHttpException('Page not found!');
                        }
                        break;
                    default:
                        $collaborators = array_map( function ($collaborator) { return $collaborator->getId(); }, $ticket->getCollaborators()->getValues());
                        $accessableAgents = array_merge($collaborators, $ticket->getAgent() ? [$ticket->getAgent()->getId()] : []);
                        if (!in_array($user->getId(), $accessableAgents)) {
                            throw new NotFoundHttpException('Page not found!');
                        }
                        break;
                }
                break;
            default:
                throw new NotFoundHttpException('Page not found!');
        }

        $quickActionButtonCollection->prepareAssets();

        return $this->render('@UVDeskCoreFramework//ticket.html.twig', [
            'ticket' => $ticket,
            'totalReplies' => $ticketRepository->countTicketTotalThreads($ticket->getId()),
            'totalCustomerTickets' => ($ticketRepository->countCustomerTotalTickets($customer, $container) - 1),
            'initialThread' => $this->ticketService->getTicketInitialThreadDetails($ticket),
            'ticketAgent' => !empty($agent) ? $agent->getAgentInstance()->getPartialDetails() : null,
            'customer' => $customer->getCustomerInstance()->getPartialDetails(),
            'currentUserDetails' => $user->getAgentInstance()->getPartialDetails(),
            'supportGroupCollection' => $userRepository->getSupportGroups(),
            'supportTeamCollection' => $userRepository->getSupportTeams(),
            'ticketStatusCollection' => $entityManager->getRepository(TicketStatus::class)->findAll(),
            'ticketTypeCollection' => $entityManager->getRepository(TicketType::class)->findByIsActive(true),
            'ticketPriorityCollection' => $entityManager->getRepository(TicketPriority::class)->findAll(),
            'ticketNavigationIteration' => $ticketRepository->getTicketNavigationIteration($ticket, $container),
            'ticketLabelCollection' => $ticketRepository->getTicketLabelCollection($ticket, $user),
        ]);
    }

    public function saveTicket(Request $request)
    {
        $requestParams = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $response = $this->redirect($this->generateUrl('helpdesk_member_ticket_collection'));

        if ($request->getMethod() != 'POST' || false == $this->userService->isAccessAuthorized('ROLE_AGENT_CREATE_TICKET')) {
            return $response;
        }

        // Get referral ticket if any
        $ticketValidationGroup = 'CreateTicket';
        $referralURL = $request->headers->get('referer');

        if (!empty($referralURL)) {
            $iterations = explode('/', $referralURL);
            $referralId = array_pop($iterations);
            $expectedReferralURL = $this->generateUrl('helpdesk_member_ticket', ['ticketId' => $referralId], UrlGeneratorInterface::ABSOLUTE_URL);

            if ($referralURL === $expectedReferralURL) {
                $referralTicket = $entityManager->getRepository(CoreBundleTicket::class)->findOneById($referralId);

                if (!empty($referralTicket)) {
                    $ticketValidationGroup = 'CustomerCreateTicket';
                }
            }
        }

        $ticketType = $entityManager->getRepository(TicketType::class)->findOneById($requestParams['type']);

        extract($this->customFieldsService->customFieldsValidation($request, 'user'));
        if(!empty($errorFlashMessage)) {
            $this->addFlash('warning', $errorFlashMessage);
        }
        $ticketProxy = new CoreFrameworkBundleDataProxies\CreateTicketDataClass();
        $form = $this->createForm(CoreFrameworkBundleForms\CreateTicket::class, $ticketProxy);

        // Validate Ticket Details
        $form->submit($requestParams);

        if (false == $form->isSubmitted() || false == $form->isValid()) {
            if (false === $form->isValid()) {
                // @TODO: We need to handle form errors gracefully.
                // We should also look into switching to an xhr request instead.
                // $form->getErrors(true);
            }

            return $this->redirect(!empty($referralURL) ? $referralURL : $this->generateUrl('helpdesk_member_ticket_collection'));
        }

        if ('CustomerCreateTicket' === $ticketValidationGroup && !empty($referralTicket)) {
            // Retrieve customer details from referral ticket
            $customer = $referralTicket->getCustomer();
            $customerPartialDetails = $customer->getCustomerInstance()->getPartialDetails();
        } else if (null != $ticketProxy->getFrom() && null != $ticketProxy->getName()) {
            // Create customer if account does not exists
            $customer = $entityManager->getRepository(User::class)->findOneByEmail($ticketProxy->getFrom());

            if (empty($customer) || null == $customer->getCustomerInstance()) {
                $role = $entityManager->getRepository(SupportRole::class)->findOneByCode('ROLE_CUSTOMER');

                // Create User Instance
                $customer = $this->userService->createUserInstance($ticketProxy->getFrom(), $ticketProxy->getName(), $role, [
                    'source' => 'website',
                    'active' => true
                ]);
            }
        }

        $ticketData = [
            'from' => $customer->getEmail(),
            'name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
            'type' => $ticketProxy->getType(),
            'subject' => $ticketProxy->getSubject(),
            // @TODO: We need to enable support for html messages. 
            // Our focus here instead should be to prevent XSS (filter js)
            'message' => str_replace(['&lt;script&gt;', '&lt;/script&gt;'], '', htmlspecialchars($ticketProxy->getReply())),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'type' => $ticketProxy->getType(),
            'role' => 4,
            'source' => 'website',
            'threadType' => 'create',
            'createdBy' => 'agent',
            'customer' => $customer,
            'user' => $this->getUser(),
            'attachments' => $request->files->get('attachments'),
        ];

        $thread = $this->ticketService->createTicketBase($ticketData);

        // Trigger ticket created event
        try {
            $event = new GenericEvent(CoreWorkflowEvents\Ticket\Create::getId(), [
                'entity' =>  $thread->getTicket(),
            ]);

            $this->eventDispatcher->dispatch($event, 'uvdesk.automation.workflow.execute', );
        } catch (\Exception $e) {
            // Skip Automation
        }

        if (!empty($thread)) {
            $ticket = $thread->getTicket();
            if($request->request->get('customFields') || $request->files->get('customFields')) {
                $this->ticketService->addTicketCustomFields($thread, $request->request->get('customFields'), $request->files->get('customFields'));                        
            }
            $this->addFlash('success', $this->translator->trans('Success ! Ticket has been created successfully.'));

            if ($this->userService->isAccessAuthorized('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('helpdesk_member_ticket', ['ticketId' => $ticket->getId()]));
            }
        } else {
            $this->addFlash('warning', $this->translator->trans('Could not create ticket, invalid details.'));
        }

        return $this->redirect(!empty($referralURL) ? $referralURL : $this->generateUrl('helpdesk_member_ticket_collection'));
    }

    public function listTicketTypeCollection(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/ticketTypeList.html.twig');
    }

    public function ticketType(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $errorContext = [];
        $em = $this->getDoctrine()->getManager();

        if($id = $request->attributes->get('ticketTypeId')) {
            $type = $em->getRepository(TicketType::class)->find($id);
            if (!$type) {
                $this->noResultFound();
            }
        } else {
            $type = new CoreFrameworkBundleEntities\TicketType();
        }

        if ($request->getMethod() == "POST") {
            $data = $request->request->all();
            $ticketType = $em->getRepository(TicketType::class)->findOneByCode($data['code']);

            if (!empty($ticketType) && $id != $ticketType->getId()) {
                $this->addFlash('warning', sprintf('Error! Ticket type with same name already exist'));
            } else {
                $type->setCode($data['code']);
                $type->setDescription($data['description']);
                $type->setIsActive(isset($data['isActive']) ? 1 : 0);

                $em->persist($type);
                $em->flush();

                if (!$request->attributes->get('ticketTypeId')) {
                    $this->addFlash('success', $this->translator->trans('Success! Ticket type saved successfully.'));
                } else {
                    $this->addFlash('success', $this->translator->trans('Success! Ticket type updated successfully.'));
                }

                return $this->redirect($this->generateUrl('helpdesk_member_ticket_type_collection'));
            }
        }

        return $this->render('@UVDeskCoreFramework/ticketTypeAdd.html.twig', array(
            'type' => $type,
            'errors' => json_encode($errorContext)
        ));
    }

    public function listTagCollection(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_TAG')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $enabled_bundles = $this->getParameter('kernel.bundles');

        return $this->render('@UVDeskCoreFramework/supportTagList.html.twig', [
            'articlesEnabled' => in_array('UVDeskSupportCenterBundle', array_keys($enabled_bundles)),
        ]);
    }

    public function removeTicketTagXHR($tagId, Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_TAG')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $tag = $em->getRepository(Tag::class)->find($tagId);
            if($tag) {
                $em->remove($tag);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->translator->trans('Success ! Tag removed successfully.');
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function trashTicket(Request $request)
    {
        $ticketId = $request->attributes->get('ticketId');
        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $entityManager->getRepository(CoreBundleTicket::class)->find($ticketId);

        if (!$ticket) {
            $this->noResultFound();
        }

        $user = $this->userService->getSessionUser();
        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) {
            throw new \Exception('Access Denied', 403);
        }

        if (!$ticket->getIsTrashed()) {
            $ticket->setIsTrashed(1);

            $entityManager->persist($ticket);
            $entityManager->flush();
        }

        // Trigger ticket delete event
        $event = new GenericEvent(CoreWorkflowEvents\Ticket\Delete::getId(), [
            'entity' => $ticket,
        ]);

        $this->eventDispatcher->dispatch($event, 'uvdesk.automation.workflow.execute');
        $this->addFlash('success', $this->translator->trans('Success ! Ticket moved to trash successfully.'));

        return $this->redirectToRoute('helpdesk_member_ticket_collection');
    }

    // Delete a ticket ticket permanently
    public function deleteTicket(Request $request)
    {
        $ticketId = $request->attributes->get('ticketId');
        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $entityManager->getRepository(CoreBundleTicket::class)->find($ticketId);

        if (!$ticket) {
            $this->noResultFound();
        }

        $user = $this->userService->getSessionUser();
        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) {
            throw new \Exception('Access Denied', 403);
        }

        $entityManager->remove($ticket);
        $entityManager->flush();

        $this->addFlash('success', $this->translator->trans('Success ! Success ! Ticket Id #'. $ticketId .' has been deleted successfully.'));

        return $this->redirectToRoute('helpdesk_member_ticket_collection');
    }

    public function downloadZipAttachment(Request $request)
    {
        $threadId = $request->attributes->get('threadId');
        $attachmentRepository = $this->getDoctrine()->getManager()->getRepository(Attachment::class);
        $threadRepository = $this->getDoctrine()->getManager()->getRepository(Thread::class);

        $thread = $threadRepository->findOneById($threadId);

        $attachment = $attachmentRepository->findByThread($threadId);

        if (!$attachment) {
            $this->noResultFound();
        }

        $ticket = $thread->getTicket();
        $user = $this->userService->getSessionUser();
        
        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) {
            throw new \Exception('Access Denied', 403);
        }

        $zipname = 'attachments/' .$threadId.'.zip';
        $zip = new \ZipArchive;

        $zip->open($zipname, \ZipArchive::CREATE);
        if (count($attachment)) {
            foreach ($attachment as $attach) {
                $zip->addFile(substr($attach->getPath(), 1));
            }
        }

        $zip->close();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $threadId . '.zip');
        $response->sendHeaders();
        $response->setContent(readfile($zipname));

        return $response;
    }

    public function downloadAttachment(Request $request)
    {   
        $attachmentId = $request->attributes->get('attachmendId');
        $attachmentRepository = $this->getDoctrine()->getManager()->getRepository(Attachment::class);
        $attachment = $attachmentRepository->findOneById($attachmentId);
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        if (!$attachment) {
            $this->noResultFound();
        }

        $ticket = $attachment->getThread()->getTicket();
        $user = $this->userService->getSessionUser();
        
        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) {
            throw new \Exception('Access Denied', 403);
        }

        $path = $this->kernel->getProjectDir() . "/public/". $attachment->getPath();

        $response = new Response();
        $response->setStatusCode(200);

        $response->headers->set('Content-type', $attachment->getContentType());
        $response->headers->set('Content-Disposition', 'attachment; filename='. $attachment->getName());
        $response->headers->set('Content-Length', $attachment->getSize());
        $response->sendHeaders();
        $response->setContent(readfile($path));

        return $response;
    }

    /**
     * If customer is playing with url and no result is found then what will happen
     * @return 
     */
    protected function noResultFound()
    {
        throw new NotFoundHttpException('Not Found!');
    }
}
