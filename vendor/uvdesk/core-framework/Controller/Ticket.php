<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\CoreFrameworkBundle\Form as CoreFrameworkBundleForms;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreFrameworkBundleEntities;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\DataProxies as CoreFrameworkBundleDataProxies;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\CoreFrameworkBundle\Tickets\QuickActionButtonCollection;

class Ticket extends Controller
{
    public function listTicketCollection(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        return $this->render('@UVDeskCoreFramework//ticketList.html.twig', [
            'ticketStatusCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketStatus')->findAll(),
            'ticketTypeCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findByIsActive(true),
            'ticketPriorityCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findAll(),
        ]);
    }

    public function loadTicket($ticketId, QuickActionButtonCollection $quickActionButtonCollection)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $userRepository = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User');
        $ticketRepository = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket');

        $ticket = $ticketRepository->findOneById($ticketId);

        if (empty($ticket)) {
            throw new \Exception('Page not found');
        } else {
            // $this->denyAccessUnlessGranted('VIEW', $ticket);

            // Mark as viewed by agents
            if (false == $ticket->getIsAgentViewed()) {
                $ticket->setIsAgentViewed(true);

                $entityManager->persist($ticket);
                $entityManager->flush();
            }
        }

        // ( in_array($this->getUser()->getRole(), ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN']) 
        // ?: (in_array('ROLE_AGENT_AGENT_KICK', $this->get('user.service')->getAgentPrivilege($this->getUser()->getId()))) )

        $agent = $ticket->getAgent();
        $customer = $ticket->getCustomer();
        $user = $this->get('user.service')->getSessionUser();

        $quickActionButtonCollection->prepareAssets();
       
        return $this->render('@UVDeskCoreFramework//ticket.html.twig', [
            'ticket' => $ticket,
            'totalReplies' => $ticketRepository->countTicketTotalThreads($ticket->getId()),
            'totalCustomerTickets' => $ticketRepository->countCustomerTotalTickets($customer),
            'initialThread' => $this->get('ticket.service')->getTicketInitialThreadDetails($ticket),
            'ticketAgent' => !empty($agent) ? $agent->getAgentInstance()->getPartialDetails() : null,
            'customer' => $customer->getCustomerInstance()->getPartialDetails(),
            'currentUserDetails' => $user->getAgentInstance()->getPartialDetails(),
            'supportGroupCollection' => $userRepository->getSupportGroups(),
            'supportTeamCollection' => $userRepository->getSupportTeams(),
            'ticketStatusCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketStatus')->findAll(),
            'ticketTypeCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findByIsActive(true),
            'ticketPriorityCollection' => $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findAll(),
            'ticketNavigationIteration' => $ticketRepository->getTicketNavigationIteration($ticket, $this->container),
            'ticketLabelCollection' => $ticketRepository->getTicketLabelCollection($ticket, $user),
        ]);
    }
    
    public function saveTicket(Request $request)
    {
        $requestParams = $request->request->all();
        $entityManager = $this->getDoctrine()->getManager();
        $response = $this->redirect($this->generateUrl('helpdesk_member_ticket_collection'));

        if ($request->getMethod() != 'POST' || false == $this->get('user.service')->isAccessAuthorized('ROLE_AGENT_CREATE_TICKET')) {
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
                $referralTicket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($referralId);
                
                if (!empty($referralTicket)) {
                    $ticketValidationGroup = 'CustomerCreateTicket';
                }
            }
        }

        $ticketType = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findOneById($requestParams['type']);

        $ticketProxy = new CoreFrameworkBundleDataProxies\CreateTicketDataClass();
        $form = $this->createForm(CoreFrameworkBundleForms\CreateTicket::class, $ticketProxy);

        // Validate Ticket Details
        $form->submit($requestParams);
        if (false == $form->isSubmitted() || false == $form->isValid()) {
            if (false === $form->isValid()) {
                dump($form->getErrors(true));
                die;
            }

            return $this->redirect(!empty($referralURL) ? $referralURL : $this->generateUrl('helpdesk_member_ticket_collection'));
        }
        
        if ('CustomerCreateTicket' === $ticketValidationGroup && !empty($referralTicket)) {
            // Retrieve customer details from referral ticket
            $customer = $referralTicket->getCustomer();
            $customerPartialDetails = $customer->getCustomerInstance()->getPartialDetails();
        } else if (null != $ticketProxy->getFrom() && null != $ticketProxy->getName()) {
            // Create customer if account does not exists
            $customer = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($ticketProxy->getFrom());

            if (empty($customer) || null == $customer->getCustomerInstance()) {
                $role = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_CUSTOMER');
                
                // Create User Instance
                $customer = $this->get('user.service')->createUserInstance($ticketProxy->getFrom(), $ticketProxy->getName(), $role, [
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
            'message' => htmlentities($ticketProxy->getReply()),
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
       
        $thread = $this->get('ticket.service')->createTicketBase($ticketData);

        // Trigger ticket created event
        try {
            $event = new GenericEvent(CoreWorkflowEvents\Ticket\Create::getId(), [
                'entity' =>  $thread->getTicket(),
            ]);
    
            $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
        } catch (\Exception $e) {
            // Skip Automation
        }

        if (!empty($thread)) {
            $ticket = $thread->getTicket();
            $request->getSession()->getFlashBag()->set('success', sprintf('Success! Ticket #%s has been created successfully.', $ticket->getId()));

            if ($this->get('user.service')->isAccessAuthorized('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('helpdesk_member_ticket', ['ticketId' => $ticket->getId()]));
            }
        } else {
            $request->getSession()->getFlashBag()->set('warning', $this->get('translator')->trans('Could not create ticket, invalid details.'));
        }

        return $this->redirect(!empty($referralURL) ? $referralURL : $this->generateUrl('helpdesk_member_ticket_collection'));
    }

    public function listTicketTypeCollection(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/ticketTypeList.html.twig');
    }

    public function ticketType(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $errorContext = [];
        $em = $this->getDoctrine()->getManager();

        if($id = $request->attributes->get('ticketTypeId')) {
            $type = $em->getRepository('UVDeskCoreFrameworkBundle:TicketType')->find($id);
            if (!$type) {
                $this->noResultFound();
            }
        } else {
            $type = new CoreFrameworkBundleEntities\TicketType();
        }

        if ($request->getMethod() == "POST") {
            $data = $request->request->all();
            $ticketType = $em->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findOneByCode($data['code']);
            
            if (!empty($ticketType) && $id != $ticketType->getId()) {
                $this->addFlash('warning', sprintf($this->get('translator')->trans('Error! Ticket type with same name already exist')));
            } else {
                $type->setCode($data['code']);
                $type->setDescription($data['description']);
                $type->setIsActive(isset($data['isActive']) ? 1 : 0);
                
                $em->persist($type);
                $em->flush();

                if (!$request->attributes->get('ticketTypeId')) {
                    $this->addFlash('success', sprintf($this->get('translator')->trans('Success! Ticket type saved successfully.')));
                } else {
                    $this->addFlash('success', sprintf($this->get('translator')->trans('Success! Ticket type updated successfully.')));
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
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TAG')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $enabled_bundles = $this->container->getParameter('kernel.bundles');

        return $this->render('@UVDeskCoreFramework/supportTagList.html.twig', [
            'articlesEnabled' => in_array('UVDeskSupportCenterBundle', array_keys($enabled_bundles)),
        ]);
    }

    public function removeTicketTagXHR($tagId, Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TAG')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $tag = $em->getRepository('UVDeskCoreFrameworkBundle:Tag')->find($tagId);
            if($tag) {
                $em->remove($tag);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Tag removed successfully.');
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
        $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($ticketId);

        if (!$ticket) {
            $this->noResultFound();
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
        
        $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
        $this->addFlash('success',$this->get('translator')->trans('Success ! Ticket moved to trash successfully.'));

        return $this->redirectToRoute('helpdesk_member_ticket_collection');
    }

    public function downloadZipAttachment(Request $request)
    {
        $threadId = $request->attributes->get('threadId');
        $attachmentRepository = $this->getDoctrine()->getManager()->getRepository('UVDeskCoreFrameworkBundle:Attachment');
        
        $attachment = $attachmentRepository->findByThread($threadId);

        if (!$attachment) {
            $this->noResultFound();
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
        $attachmendId = $request->attributes->get('attachmendId');
        $attachmentRepository = $this->getDoctrine()->getManager()->getRepository('UVDeskCoreFrameworkBundle:Attachment');
        $attachment = $attachmentRepository->findOneById($attachmendId);
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        if (!$attachment) {
            $this->noResultFound();
        }

        $path = $this->get('kernel')->getProjectDir() . "/public/". $attachment->getPath();

        $response = new Response();
        $response->setStatusCode(200);
        
        $response->headers->set('Content-type', $attachment->getContentType());
        $response->headers->set('Content-Disposition', 'attachment; filename='. $attachment->getName());
        $response->sendHeaders();
        $response->setContent(readfile($path));
        
        return $response;
    }
}
