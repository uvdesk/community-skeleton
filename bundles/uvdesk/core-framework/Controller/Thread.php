<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread as TicketThread;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\TicketService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\EmailService;
use Symfony\Component\HttpKernel\KernelInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\FileUploadService;

class Thread extends AbstractController
{
    private $userService;
    private $translator;
    private $eventDispatcher;
    private $ticketService;
    private $emailService;
    private $kernel;
    private $fileUploadService;

    public function __construct(UserService $userService, TranslatorInterface $translator, TicketService $ticketService, EmailService $emailService, EventDispatcherInterface $eventDispatcher, KernelInterface $kernel, FileUploadService $fileUploadService)
    {
        $this->kernel = $kernel;
        $this->userService = $userService;
        $this->emailService = $emailService;
        $this->translator = $translator;
        $this->ticketService = $ticketService;
        $this->eventDispatcher = $eventDispatcher;
        $this->fileUploadService = $fileUploadService;
    }

    public function saveThread($ticketId, Request $request)
    {
        $params = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();

        $ticket = $entityManager->getRepository(Ticket::class)->findOneById($ticketId);

        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket)) {
            throw new \Exception('Access Denied', 403);
        }

        if (empty($ticket)) {
            throw new \Exception('Ticket not found', 404);
        } else if ('POST' !== $request->getMethod()) {
            throw new \Exception('Invalid Request', 403);
        }

        if (empty($params)) {
            return $this->redirect($request->headers->get('referer') ?: $this->generateUrl('helpdesk_member_ticket_collection'));
        } else if ('note' == $params['threadType'] && false == $this->userService->isAccessAuthorized('ROLE_AGENT_ADD_NOTE')) {
            // Insufficient user privilege to create a note
            throw new \Exception('Insufficient Permisions', 400);
        }

        // // Deny access unles granted ticket view permission
        // $this->denyAccessUnlessGranted('AGENT_VIEW', $ticket);

        // Check if reply content is empty
        $parsedMessage = trim(strip_tags($params['reply'], '<img>'));
        $parsedMessage = str_replace('&nbsp;', '', $parsedMessage);
        $parsedMessage = str_replace(' ', '', $parsedMessage);

        if (null == $parsedMessage) {
            $this->addFlash('warning', $this->translator->trans('Reply content cannot be left blank.'));
        }

        // @TODO: Validate file attachments
        // if (true !== $this->get('file.service')->validateAttachments($request->files->get('attachments'))) {
        //     $this->addFlash('warning', "Invalid attachments.");
        // }
        
	    // $adminReply =  str_replace(['<p>','</p>'],"",$params['reply']);

        $threadDetails = [
            'user' => $this->getUser(),
            'createdBy' => 'agent',
            'source' => 'website',
            'threadType' => strtolower($params['threadType']),
            'message' => str_replace(['&lt;script&gt;', '&lt;/script&gt;'], '', htmlspecialchars($params['reply'])),
            'attachments' => $request->files->get('attachments')
        ];

        if(!empty($params['status'])){
            $ticketStatus = $entityManager->getRepository(TicketStatus::class)->findOneByCode($params['status']);
            $ticket->setStatus($ticketStatus);
        }
        if (isset($params['to'])) {
            $threadDetails['to'] = $params['to'];
        }

        if (isset($params['cc'])) {
            $threadDetails['cc'] = $params['cc'];
        }

        if (isset($params['cccol'])) {
            $threadDetails['cccol'] = $params['cccol'];
        }

        if (isset($params['bcc'])) {
            $threadDetails['bcc'] = $params['bcc'];
        }

        // Create Thread
        $thread = $this->ticketService->createThread($ticket, $threadDetails);
        // $this->addFlash('success', ucwords($params['threadType']) . " added successfully.");

        // @TODO: Remove Agent Draft Thread
        // @TODO: Trigger Thread Created Event

        // @TODO: Cross Review
        // check for thread types
        switch ($thread->getThreadType()) {
            case 'note':
                $event = new GenericEvent(CoreWorkflowEvents\Ticket\Note::getId(), [
                    'entity' =>  $ticket,
                    'thread' =>  $thread
                ]);

                $this->eventDispatcher->dispatch($event, 'uvdesk.automation.workflow.execute');

                // @TODO: Render response on the basis of event response (if propogation was stopped or not)
                $this->addFlash('success', $this->translator->trans('Note added to ticket successfully.'));
                break;
            case 'reply':
                $event = new GenericEvent(CoreWorkflowEvents\Ticket\AgentReply::getId(), [
                    'entity' =>  $ticket,
                    'thread' =>  $thread
                ]);

                $this->eventDispatcher->dispatch($event, 'uvdesk.automation.workflow.execute');

                // @TODO: Render response on the basis of event response (if propogation was stopped or not)
                $this->addFlash('success', $this->translator->trans('Success ! Reply added successfully.'));
                break;
            case 'forward':
                // Prepare headers
                $headers = ['References' => $ticket->getReferenceIds()];

                if (null != $ticket->currentThread->getMessageId()) {
                    $headers['In-Reply-To'] = $ticket->currentThread->getMessageId();
                }

                // Prepare attachments
                $attachments = $entityManager->getRepository(Attachment::class)->findByThread($thread);

                $projectDir = $this->kernel->getProjectDir();
                $attachments = array_map(function($attachment) use ($projectDir) {
                return str_replace('//', '/', $projectDir . "/public" . $attachment->getPath());
                }, $attachments);

                $message = '<html><body style="background-image: none"><p>'.html_entity_decode($thread->getMessage()).'</p></body></html>';
                // Forward thread to users
                try {
                    $messageId = $this->emailService->sendMail($params['subject'] ?? ("Forward: " . $ticket->getSubject()), $message, $thread->getReplyTo(), $headers, $ticket->getMailboxEmail(), $attachments ?? [], $thread->getCc() ?: [], $thread->getBcc() ?: []);
    
                    if (!empty($messageId)) {
                        $thread->setMessageId($messageId);
    
                        $entityManager->persist($createdThread);
                        $entityManager->flush();
                    }
                } catch (\Exception $e) {
                    // Do nothing ...
                    // @TODO: Log exception
                }

                // @TODO: Render response on the basis of event response (if propogation was stopped or not)
                $this->addFlash('success', $this->translator->trans('Reply added to the ticket and forwarded successfully.'));
                break;
            default:
                break;
        }

        // Check if ticket status needs to be updated
        $updateTicketToStatus = !empty($params['status']) ? (trim($params['status']) ?: null) : null;

        if (!empty($updateTicketToStatus) && $this->userService->isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS')) {
            $ticketStatus = $entityManager->getRepository(TicketStatus::class)->findOneById($updateTicketToStatus);

            if (!empty($ticketStatus) && $ticketStatus->getId() === $ticket->getStatus()->getId()) {
                $ticket->setStatus($ticketStatus);

                $entityManager->persist($ticket);
                $entityManager->flush();

                // @TODO: Trigger Ticket Status Updated Event
            }
        }

        // Redirect to either Ticket View | Ticket Listings
        if ('redirect' === $params['nextView']) {
            return $this->redirect($this->generateUrl('helpdesk_member_ticket_collection'));
        }
        
        return $this->redirect($this->generateUrl('helpdesk_member_ticket', ['ticketId' => $ticket->getId()]));
    }

    public function updateThreadXHR(Request $request)
    {
        $json = [];
        $em = $this->getDoctrine()->getManager();
        $content = json_decode($request->getContent(), true);
        $thread = $em->getRepository(TicketThread::class)->find($request->attributes->get('threadId'));
        $ticket = $thread->getTicket();
        $user = $this->userService->getSessionUser();

        // Proceed only if user has access to the resource
        if ( (!$this->userService->getSessionUser()) || (false == $this->ticketService->isTicketAccessGranted($ticket, $user)) ) 
        {
            throw new \Exception('Access Denied', 403);
        }

        if ($request->getMethod() == "PUT") {
            // $this->isAuthorized('ROLE_AGENT_EDIT_THREAD_NOTE');
            if (str_replace(' ','',str_replace('&nbsp;','',trim(strip_tags($content['reply'], '<img>')))) != "") {
                $thread->setMessage($content['reply']);
                $em->persist($thread);
                $em->flush();

                $ticket->currentThread = $thread;

                // Trigger agent reply event
                $event = new GenericEvent(CoreWorkflowEvents\Ticket\ThreadUpdate::getId(), [
                    'entity' =>  $ticket,
                ]);

                $this->eventDispatcher->dispatch($event, 'uvdesk.automation.workflow.execute');

                $json['alertMessage'] = $this->translator->trans('Success ! Thread updated successfully.');
                $json['alertClass'] = 'success';
            } else {
                $json['alertMessage'] = $this->translator->trans('Error ! Reply field can not be blank.');
                $json['alertClass'] = 'error';
            }
        }

        return new Response(json_encode($json), 200, ['Content-Type' => 'application/json']);
    }

    public function threadXHR(Request $request)
    {
        $json = array();
        $content = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository(Ticket::class)->findOneById($content['ticketId']); 

        // Proceed only if user has access to the resource
        if (false == $this->ticketService->isTicketAccessGranted($ticket)){
            throw new \Exception('Access Denied', 403);
        }
        
        $threadId = $request->attributes->get('threadId');

        if ($request->getMethod() == "DELETE") {
            $thread = $em->getRepository(TicketThread::class)->findOneBy(array('id' => $threadId, 'ticket' => $content['ticketId']));
            $projectDir = $this->kernel->getProjectDir();
            
            if ($thread) {
                $this->fileUploadService->fileRemoveFromFolder($projectDir."/public/assets/threads/".$threadId);
                // Trigger thread deleted event
                //  $event = new GenericEvent(CoreWorkflowEvents\Ticket\ThreadUpdate::getId(), [
                //     'entity' =>  $ticket,
                // ]);
                // $this->eventDispatcher->dispatch('uvdesk.automation.workflow.execute', $event);

                $em->remove($thread);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->translator->trans('Success ! Thread removed successfully.');
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->translator->trans('Error ! Invalid thread.');
            }
        } elseif ($request->getMethod() == "PATCH") {
            $thread = $em->getRepository(TicketThread::class)->findOneBy(array('id' => $request->attributes->get('threadId'), 'ticket' => $content['ticketId']));

            if ($thread) {
                if ($content['updateType'] == 'lock') {
                    $thread->setIsLocked($content['isLocked']);
                    $em->persist($thread);
                    $em->flush();

                    $json['alertMessage'] = $this->translator->trans($content['isLocked'] ? 'Success ! Thread locked successfully.' : 'Success ! Thread unlocked successfully.');
                    $json['alertClass'] = 'success';
                } elseif ($content['updateType'] == 'bookmark') {
                    $thread->setIsBookmarked($content['bookmark']);
                    $em->persist($thread);
                    $em->flush();

                    $json['alertMessage'] = $this->translator->trans($content['bookmark'] ? 'Success ! Thread pinned successfully.' : 'Success ! unpinned removed successfully.');
                    $json['alertClass'] = 'success';
                }
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->translator->trans('Error ! Invalid thread.');
            }
        }

        return new Response(json_encode($json), 200, ['Content-Type' => 'application/json']);
    }
}
