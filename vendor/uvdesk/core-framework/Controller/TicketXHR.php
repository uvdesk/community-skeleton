<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreFrameworkBundleEntities;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Webkul\UVDesk\CoreFrameworkBundle\Form as CoreFrameworkBundleForms;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\DataProxies as CoreFrameworkBundleDataProxies;

class TicketXHR extends Controller
{
    public function loadTicketXHR($ticketId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();
    }

    public function bookmarkTicketXHR()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $requestContent = json_decode($request->getContent(), true);
        $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($requestContent['id']);

        if (!empty($ticket)) {
            $ticket->setIsStarred(!$ticket->getIsStarred());

            $entityManager->persist($ticket);
            $entityManager->flush();

            return new Response(json_encode(['alertClass' => 'success']), 200, ['Content-Type' => 'application/json']);
        }

        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function ticketLabelXHR(Request $request)
    {
        $method = $request->getMethod();
        $content = $request->getContent();
        $em = $this->getDoctrine()->getManager();

        if($method == "POST") {
            $data = json_decode($content, true);
            if($data['name'] != "") {
                $label = new SupportLabel();
                $label->setName($data['name']);
                if(isset($data['colorCode']))
                    $label->setColorCode($data['colorCode']);
                $label->setUser($this->get('user.service')->getCurrentUser());
                $em->persist($label);
                $em->flush();

                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Label created successfully.');
                $json['label'] = json_encode([
                    'id' => $label->getId(),
                    'name' => $label->getName(),
                    'colorCode' => $label->getColorCode(),
                    'labelUser' => $label->getUser()->getId(),
                ]);
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Label name can not be blank.');
            }
        } elseif($method == "PUT") {
            $data = json_decode($content, true);
            $label = $em->getRepository('UVDeskCoreFrameworkBundle:SupportLabel')->findOneBy(array('id' => $request->attributes->get('ticketLabelId')));
            if($label) {
                $label->setName($data['name']);
                if(!empty($data['colorCode'])) {
                    $label->setColorCode($data['colorCode']);
                }
                $em->persist($label);
                $em->flush();

                $json['label'] = json_encode([
                    'id' => $label->getId(),
                    'name' => $label->getName(),
                    'colorCode' => $label->getColorCode(),
                    'labelUser' => $label->getUser()->getId(),
                ]);
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Label updated successfully.');
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Invalid label id.');
            }
        } elseif($method == "DELETE") {
            $label = $em->getRepository('UVDeskCoreFrameworkBundle:SupportLabel')->findOneBy(array('id' => $request->attributes->get('ticketLabelId')));
            if($label) {
                $em->remove($label);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Label removed successfully.');
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Invalid label id.');
            }
        }

        return new Response(json_encode($json), 200, ['Content-Type' => 'application/json']);
    }

    public function updateTicketDetails(Request $request)
    {
        $ticketId = $request->attributes->get('ticketId');
        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($ticketId);
       
        if (!$ticket)
            $this->noResultFound();
            
        $error = false;
        $message = '';
        if ($request->request->get('subject') == '') {
            $error = true;
            $message = $this->get('translator')->trans("Error! Subject field is mandatory");
        } elseif ($request->request->get('reply') == '') {
            $error = true;
            $message = $this->get('translator')->trans("Error! Reply field is mandatory");
        }

        if (!$error) {
            $ticket->setSubject($request->request->get('subject'));
            $createThread = $this->get('ticket.service')->getCreateReply($ticket->getId(), false);
            $createThread = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Thread')->find($createThread['id']);
            $createThread->setMessage($request->request->get('reply'));

            $entityManager->persist($createThread);
            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', $this->get('translator')->trans('Success ! Ticket has been updated successfully.'));
        } else {
            $this->addFlash('warning', $message);
        }

        return $this->redirect($this->generateUrl('helpdesk_member_ticket', ['ticketId'=> $ticketId] ));
    }

    public function updateTicketAttributes($ticketId)
    {
        // @TODO: Ticket Voter
        // $this->denyAccessUnlessGranted('VIEW', $ticket);
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $requestContent = $request->request->all() ?: json_decode($request->getContent(), true);
        $ticketId =  $ticketId != 0 ? $ticketId : $requestContent['ticketId'];
        $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($ticketId);
        
        // Validate request integrity
        if (empty($ticket)) {
            $responseContent = [
                'alertClass' => 'danger',
                'alertMessage' => "Unable to retrieve details for ticket #$ticketId.",
            ];

            return new Response(json_encode($responseContent), 200, ['Content-Type' => 'application/json']);
        } else if (!isset($requestContent['attribute'])) {
            $responseContent = [
                'alertClass' => 'danger',
                'alertMessage' => $this->get('translator')->trans("Insufficient details provided."),
            ];
            return new Response(json_encode($responseContent), 400, ['Content-Type' => 'application/json']);
        }

        // Update attribute
        switch ($requestContent['attribute']) {
            case 'agent':
                $agent = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneById($requestContent['value']);
                
                if (empty($agent)) {
                    // User does not exist
                    return new Response(json_encode([
                        'alertClass' => 'danger',
                        'alertMessage' => 'Unable to retrieve agent details',
                    ]), 404, ['Content-Type' => 'application/json']);
                } else {
                    // Check if an agent instance exists for the user
                    $agentInstance = $agent->getAgentInstance();

                    if (empty($agentInstance)) {
                        // Agent does not exist
                        return new Response(json_encode([
                            'alertClass' => 'danger',
                            'alertMessage' => 'Unable to retrieve agent details',
                        ]), 404, ['Content-Type' => 'application/json']);
                    }
                }

                $agentDetails = $agentInstance->getPartialDetails();

                // Check if ticket is already assigned to the agent
                if ($ticket->getAgent() && $agent->getId() === $ticket->getAgent()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket already assigned to ' . $agentDetails['name'],
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    $ticket->setAgent($agent);

                    $entityManager->persist($ticket);
                    $entityManager->flush();

                    // Trigger Agent Assign event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Agent::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
                    
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket successfully assigned to ' . $agentDetails['name'],
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'status':
                $ticketStatus = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketStatus')->findOneById((int) $requestContent['value']);
                
                if (empty($ticketStatus)) {
                    // Selected ticket status does not exist
                    return new Response(json_encode([
                        'alertClass' => 'danger',
                        'alertMessage' => $this->get('translator')->trans('Unable to retrieve status details'),
                    ]), 404, ['Content-Type' => 'application/json']);
                }

                if ($ticketStatus->getId() === $ticket->getStatus()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket status already set to ' . $ticketStatus->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    $ticket->setStatus($ticketStatus);
                    
                    $entityManager->persist($ticket);
                    $entityManager->flush();
                
                    // Trigger ticket status event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Status::getId(), [
                        'entity' => $ticket,
                    ]);
                    
                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket status update to ' . $ticketStatus->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'priority':
                // $this->isAuthorized('ROLE_AGENT_UPDATE_TICKET_PRIORITY');
                $ticketPriority = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketPriority')->findOneById($requestContent['value']);

                if (empty($ticketPriority)) {
                    // Selected ticket priority does not exist
                    return new Response(json_encode([
                        'alertClass' => 'danger',
                        'alertMessage' => 'Unable to retrieve priority details',
                    ]), 404, ['Content-Type' => 'application/json']);
                }

                if ($ticketPriority->getId() === $ticket->getPriority()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket priority already set to ' . $ticketPriority->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    
                    $ticket->setPriority($ticketPriority);
                    $entityManager->persist($ticket);
                    $entityManager->flush();

                    // Trigger ticket Priority event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Priority::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket priority updated to ' . $ticketPriority->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'group':
                $supportGroup = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportGroup')->findOneById($requestContent['value']);
                
                if (empty($supportGroup)) {
                    if ($requestContent['value'] == "") {
                        if ($ticket->getSupportGroup() != null) {
                            $ticket->setSupportGroup(null);
                            $entityManager->persist($ticket);
                            $entityManager->flush();
                        }

                        $responseCode = 200;
                        $response = [
                            'alertClass' => 'success',
                            'alertMessage' => $this->get('translator')->trans('Ticket support group updated successfully'),
                        ];
                    } else {
                        $responseCode = 404;
                        $response = [
                            'alertClass' => 'danger',
                            'alertMessage' => $this->get('translator')->trans('Unable to retrieve support team details'),
                        ];
                    }

                    return new Response(json_encode($response), $responseCode, ['Content-Type' => 'application/json']);;
                }

                if ($ticket->getSupportGroup() != null && $supportGroup->getId() === $ticket->getSupportGroup()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket already assigned to support group ' . $supportGroup->getName(),
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    $ticket->setSupportGroup($supportGroup);
                    $entityManager->persist($ticket);
                    $entityManager->flush();
                    
                    // Trigger Support group event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Group::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket assigned to support group ' . $supportGroup->getName(),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'team':
                $supportTeam = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportTeam')->findOneById($requestContent['value']);

                if (empty($supportTeam)) {
                    if ($requestContent['value'] == "") {
                        if ($ticket->getSupportTeam() != null) {
                            $ticket->setSupportTeam(null);
                            $entityManager->persist($ticket);
                            $entityManager->flush();
                        }

                        $responseCode = 200;
                        $response = [
                            'alertClass' => 'success',
                            'alertMessage' => $this->get('translator')->trans('Ticket support group updated successfully'),
                        ];
                    } else {
                        $responseCode = 404;
                        $response = [
                            'alertClass' => 'danger',
                            'alertMessage' => $this->get('translator')->trans('Unable to retrieve support team details'),
                        ];
                    }

                    return new Response(json_encode($response), $responseCode, ['Content-Type' => 'application/json']);;
                }

                if ($ticket->getSupportTeam() != null && $supportTeam->getId() === $ticket->getSupportTeam()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket already assigned to support team ' . $supportTeam->getName(),
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    $ticket->setSupportTeam($supportTeam);
                    $entityManager->persist($ticket);
                    $entityManager->flush();
                    
                    // Trigger ticket delete event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Team::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket assigned to support team ' . $supportTeam->getName(),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'type':
                // $this->isAuthorized('ROLE_AGENT_UPDATE_TICKET_TYPE');
                $ticketType = $entityManager->getRepository('UVDeskCoreFrameworkBundle:TicketType')->findOneById($requestContent['value']);
                
                if (empty($ticketType)) {
                    // Selected ticket priority does not exist
                    return new Response(json_encode([
                        'alertClass' => 'danger',
                        'alertMessage' => 'Unable to retrieve ticket type details',
                    ]), 404, ['Content-Type' => 'application/json']);
                }

                if (null != $ticket->getType() && $ticketType->getId() === $ticket->getType()->getId()) {
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket type already set to ' . $ticketType->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                } else {
                    $ticket->setType($ticketType);

                    $entityManager->persist($ticket);
                    $entityManager->flush();

                    // Trigger ticket delete event
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Type::getId(), [
                        'entity' => $ticket,
                    ]);

                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);

                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => 'Ticket type updated to ' . $ticketType->getDescription(),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            case 'label':
                $label = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportLabel')->find($requestContent['labelId']);
                if($label) {
                    $ticket->removeSupportLabel($label);
                    $entityManager->persist($ticket);
                    $entityManager->flush();
                    
                    return new Response(json_encode([
                        'alertClass' => 'success',
                        'alertMessage' => $this->get('translator')->trans('Success ! Ticket to label removed successfully.'),
                    ]), 200, ['Content-Type' => 'application/json']);
                }
                break;
            default:
                break;
        }

        return new Response(json_encode([]), 400, ['Content-Type' => 'application/json']);
    }

    public function listTicketCollectionXHR(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $paginationResponse = $this->get('ticket.service')->paginateMembersTicketCollection($request);
           
            return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
        }

        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function updateTicketCollectionXHR(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $massResponse = $this->get('ticket.service')->massXhrUpdate($request);

            return new Response(json_encode($massResponse), 200, ['Content-Type' => 'application/json']);
        }
        return new Response(json_encode([]), 404);
    }
    
    public function loadTicketFilterOptionsXHR(Request $request)
    {
        return new Response(json_encode([]), 404);
    }

    public function saveTicketLabel(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $requestContent = json_decode($request->getContent(), true);
        $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($requestContent['ticketId']);

        if ('POST' == $request->getMethod()) {
            $responseContent = [];
            $user = $this->get('user.service')->getSessionUser();
            $supportLabel = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportLabel')->findOneBy([
                'user' => $user->getId(),
                'name' => $requestContent['name'],
            ]);
            
            if (empty($supportLabel)) {
                $supportLabel = new SupportLabel();
                $supportLabel->setName($requestContent['name']);
                $supportLabel->setUser($user);

                $entityManager->persist($supportLabel);
                $entityManager->flush();
            }

            $ticketLabelCollection = $ticket->getSupportLabels()->toArray();

            if (empty($ticketLabelCollection)) {
                $ticket->addSupportLabel($supportLabel);
                $entityManager->persist($ticket);
                $entityManager->flush();

                $responseContent['alertClass'] = 'success';
                $responseContent['alertMessage'] = 'Label ' . $supportLabel->getName() . ' added to ticket successfully';
            } else {
                $isLabelAlreadyAdded = false;
                foreach ($ticketLabelCollection as $ticketLabel) {
                    if ($supportLabel->getId() == $ticketLabel->getId()) {
                        $isLabelAlreadyAdded = true;
                        break;
                    }
                }

                if (false == $isLabelAlreadyAdded) {
                    $ticket->addSupportLabel($supportLabel);
                    $entityManager->persist($ticket);
                    $entityManager->flush();

                    $responseContent['alertClass'] = 'success';
                    $responseContent['alertMessage'] = 'Label ' . $supportLabel->getName() . ' added to ticket successfully';
                } else {
                    $responseContent['alertClass'] = 'warning';
                    $responseContent['alertMessage'] = 'Label ' . $supportLabel->getName() . ' already added to ticket';
                }
            }

            $responseContent['label'] = [
                'id' => $supportLabel->getId(),
                'name' => $supportLabel->getName(),
                'color' => $supportLabel->getColorCode(),
            ];

            return new Response(json_encode($responseContent), 200, ['Content-Type' => 'application/json']);
        }

        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function getLabels($request = null)
    {
        static $labels;
        if (null !== $labels)
            return $labels;

        $qb = $this->em->createQueryBuilder();
        $qb->select('tl')->from('UVDeskCoreFrameworkBundle:TicketLabel', 'tl')
                ->andwhere('tl.labelUser = :labelUserId')
                ->andwhere('tl.company = :companyId')
                ->setParameter('labelUserId', $this->getUser()->getId())
                ->setParameter('companyId', $this->getCompany()->getId());

        if($request) {
            $qb->andwhere("tl.name LIKE :labelName");
            $qb->setParameter('labelName', '%'.urldecode($request->query->get('query')).'%');
        }

        return $labels = $qb->getQuery()->getArrayResult();
    }

    public function loadTicketSearchFilterOptions(Request $request)
    {
        if (true === $request->isXmlHttpRequest()) {
            switch ($request->query->get('type')) {
                case 'agent':
                    $filtersResponse = $this->get('user.service')->getAgentPartialDataCollection($request);
                    break;
                case 'customer':
                    $filtersResponse = $this->get('user.service')->getCustomersPartial($request);
                    break;
                case 'group':
                    $filtersResponse = $this->get('user.service')->getGroups($request);
                    break;
                case 'team':
                    $filtersResponse = $this->get('user.service')->getSubGroups($request);
                    break;
                case 'tag':
                    $filtersResponse = $this->get('ticket.service')->getTicketTags($request);
                    break;
                case 'label':
                    $searchTerm = $request->query->get('query');
                    $entityManager = $this->getDoctrine()->getManager();

                    $supportLabelQuery = $entityManager->createQueryBuilder()->select('supportLabel')
                        ->from('UVDeskCoreFrameworkBundle:SupportLabel', 'supportLabel')
                        ->where('supportLabel.user = :user')->setParameter('user', $this->get('user.service')->getSessionUser());
                    
                    if (!empty($searchTerm)) {
                        $supportLabelQuery->andWhere('supportLabel.name LIKE :labelName')->setParameter('labelName', '%' . urldecode($searchTerm) . '%');
                    }

                    $supportLabelCollection = $supportLabelQuery->getQuery()->getArrayResult();
                    return new Response(json_encode($supportLabelCollection), 200, ['Content-Type' => 'application/json']);
                    break;
                default:
                    break;
            }
        }

        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function loadTicketCollectionSearchFilterOptionsXHR(Request $request)
    {
        $json = [];
        if ($request->isXmlHttpRequest()) {
            if ($request->query->get('type') == 'agent') {
                $json = $this->get('user.service')->getAgentsPartialDetails($request);
            } elseif ($request->query->get('type') == 'customer') {
                $json = $this->get('user.service')->getCustomersPartial($request);
            } elseif ($request->query->get('type') == 'group') {
                $json = $this->get('user.service')->getGroups($request);
            } elseif ($request->query->get('type') == 'team') {
                $json = $this->get('user.service')->getSubGroups($request);
            } elseif ($request->query->get('type') == 'tag') {
                $json = $this->get('ticket.service')->getTicketTags($request);
            } elseif ($request->query->get('type') == 'label') {
                $json = $this->get('ticket.service')->getLabels($request);
            }
        }

        return new Response(json_encode($json), 200, ['Content-Type' => 'application/json']);
    }

    public function listTicketTypeCollectionXHR(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if (true === $request->isXmlHttpRequest()) {
            $paginationResponse = $this->get('ticket.service')->paginateMembersTicketTypeCollection($request);

            return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function removeTicketTypeXHR($typeId, Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TICKET_TYPE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        if($request->getMethod() == "DELETE") {
            $em = $this->getDoctrine()->getManager();
            $id = $request->attributes->get('typeId');
            $type = $em->getRepository('UVDeskCoreFrameworkBundle:TicketType')->find($id);

            // $this->get('event.manager')->trigger([
            //             'event' => 'type.deleted',
            //             'entity' => $type
            //         ]);

            $em->remove($type);
            $em->flush();

            $json['alertClass'] = 'success';
            $json['alertMessage'] = 'Success ! Type removed successfully.';
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function listTagCollectionXHR(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_TAG')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if (true === $request->isXmlHttpRequest()) {
            $paginationResponse = $this->get('ticket.service')->paginateMembersTagCollection($request);

            return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }

    public function applyTicketPreparedResponseXHR(Request $request)
    {
        $id = $request->attributes->get('id');
        $ticketId = $request->attributes->get('ticketId');
        $ticket = $this->getDoctrine()->getManager()->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($ticketId);

        $event = new GenericEvent($id, [
            'entity' =>  $ticket
        ]);
        
        $this->get('event_dispatcher')->dispatch('uvdesk.automation.prepared_response.execute', $event);
        $this->addFlash('success', 'Success ! Prepared Response applied successfully.');

        return $this->redirect($this->generateUrl('helpdesk_member_ticket',['ticketId' => $ticketId]));
    }
    
    public function loadTicketSavedReplies(Request $request)
    {
        $json = array();
        $data = $request->query->all();

        if ($request->isXmlHttpRequest()) {
            $json['message'] = $this->get('ticket.service')->getSavedReplyContent($data['id'],$data['ticketId']);
        }

        $response = new Response(json_encode($json));
        return $response;
    }

    public function createTicketTagXHR(Request $request)
    { 
        $json = [];
        $content = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($content['ticketId']);
        if($request->getMethod() == "POST") {
            $tag = new CoreFrameworkBundleEntities\Tag();
            if ($content['name'] != "") {
                $checkTag = $em->getRepository('UVDeskCoreFrameworkBundle:Tag')->findOneBy(array('name' => $content['name']));
                if(!$checkTag) {
                    $tag->setName($content['name']);
                    $em->persist($tag);
                    $em->flush();
                    //$json['tag'] = json_decode($this->objectSerializer($tag));
                    $ticket->addSupportTag($tag);
                } else {
                    //$json['tag'] = json_decode($this->objectSerializer($checkTag));
                    $ticket->addSupportTag($checkTag);
                }
                $em->persist($ticket);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Tag added successfully.');
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Please enter tag name.');
            }
        } elseif($request->getMethod() == "DELETE") {
            $tag = $em->getRepository('UVDeskCoreFrameworkBundle:Tag')->findOneBy(array('id' => $request->attributes->get('id')));
            if($tag) {
                $articles = $em->getRepository('UVDeskSupportCenterBundle:ArticleTags')->findOneBy(array('tagId' => $tag->getId()));
                if($articles)
                    foreach ($articles as $entry) {
                        $em->remove($entry);
                    }

                $ticket->removeSupportTag($tag);
                $em->persist($ticket);
                $em->flush();
                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Tag unassigned successfully.');

            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Invalid tag.');
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getSearchFilterOptionsXhr(Request $request)
    {
        $json = [];
        if ($request->isXmlHttpRequest()) {
            if($request->query->get('type') == 'agent') {
                $json = $this->get('user.service')->getAgentsPartialDetails($request);
            } elseif($request->query->get('type') == 'customer') {
                $json = $this->get('user.service')->getCustomersPartial($request);
            } elseif($request->query->get('type') == 'group') {
                $json = $this->get('user.service')->getSupportGroups($request);
            } elseif($request->query->get('type') == 'team') {
                $json = $this->get('user.service')->getSupportTeams($request);
            } elseif($request->query->get('type') == 'tag') {
                $json = $this->get('ticket.service')->getTicketTags($request);
            } elseif($request->query->get('type') == 'label') {
                $json = $this->get('ticket.service')->getLabels($request);
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function updateCollaboratorXHR(Request $request)
    {
        $json = [];
        $content = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('UVDeskCoreFrameworkBundle:Ticket')->find($content['ticketId']);
        if($request->getMethod() == "POST") {
            if($content['email'] == $ticket->getCustomer()->getEmail()) {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Customer can not be added as collaborator.');
            } else {
                $data = array(
                    'from' => $content['email'],
                    'firstName' => ($firstName = ucfirst(current(explode('@', $content['email'])))),
                    'lastName' => ' ',
                    'role' => 4,
                );
                
                $supportRole = $em->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_CUSTOMER');

                $collaborator = $this->get('user.service')->createUserInstance($data['from'], $data['firstName'], $supportRole, $extras = ["active" => true]);
                $checkTicket = $em->getRepository('UVDeskCoreFrameworkBundle:Ticket')->isTicketCollaborator($ticket, $content['email']);
                
                if (!$checkTicket) {
                    $ticket->addCollaborator($collaborator);
                    $em->persist($ticket);
                    $em->flush();
    
                    $ticket->lastCollaborator = $collaborator;
                   
                    if ($collaborator->getCustomerInstance())
                        $json['collaborator'] = $collaborator->getCustomerInstance()->getPartialDetails();
                    else
                        $json['collaborator'] = $collaborator->getAgentInstance()->getPartialDetails();
                    
                    $event = new GenericEvent(CoreWorkflowEvents\Ticket\Collaborator::getId(), [
                        'entity' => $ticket,
                    ]);
    
                    $this->get('event_dispatcher')->dispatch('uvdesk.automation.workflow.execute', $event);
                    
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->get('translator')->trans('Success ! Collaborator added successfully.');
                } else {
                    $json['alertClass'] = 'danger';
                    $message = "Collaborator is already added.";
                    $json['alertMessage'] = $this->get('translator')->trans('Error ! ' . $message); 
                }
            }
        } elseif($request->getMethod() == "DELETE") {
            $collaborator = $em->getRepository('UVDeskCoreFrameworkBundle:User')->findOneBy(array('id' => $request->attributes->get('id')));
            if($collaborator) {
                $ticket->removeCollaborator($collaborator);
                $em->persist($ticket);
                $em->flush();

                $json['alertClass'] = 'success';
                $json['alertMessage'] = $this->get('translator')->trans('Success ! Collaborator removed successfully.');
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Invalid Collaborator.');
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    // Apply quick Response action
    public function getTicketQuickViewDetailsXhr(Request $request)
    {
        $json = [];

        if ($request->isXmlHttpRequest()) {
            $ticketId = $request->query->get('ticketId');
            $json = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:Ticket')->getTicketDetails($request->query,$this->container);
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function updateTicketTagXHR(Request $request, $tagId)
    {
        $content = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        if (isset($content['name']) && $content['name'] != "") {
            $checkTag = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Tag')->findOneBy(array('id' => $tagId));
            if($checkTag) {
                $checkTag->setName($content['name']);
                $entityManager->persist($checkTag);
                $entityManager->flush();
            }

            $json['alertClass'] = 'success';
            $json['alertMessage'] = $this->get('translator')->trans('Success ! Tag updated successfully.');
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function removeTicketTagXHR($tagId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $checkTag = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Tag')->findOneBy(array('id' => $tagId));
        
        if($checkTag) {
            $entityManager->remove($checkTag);
            $entityManager->flush();

            $json['alertClass'] = 'success';
            $json['alertMessage'] = $this->get('translator')->trans('Success ! Tag removed successfully.');
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
