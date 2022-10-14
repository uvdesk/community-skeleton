<?php

namespace Webkul\UVDesk\AutomationBundle\Controller\Automations;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\AutomationBundle\Entity;
use Webkul\UVDesk\AutomationBundle\EventListener\WorkflowListener;
use Webkul\UVDesk\CoreFrameworkBundle\Services\TicketService;

class WorkflowXHR extends AbstractController
{
    private $userService;
    private $translator;
    private $workflowListnerService;
    private $ticketService;
    
    public function __construct(UserService $userService, WorkflowListener $workflowListnerService, TicketService $ticketService,TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->ticketService = $ticketService;
        $this->workflowListnerService = $workflowListnerService;
        $this->translator = $translator;
    }

    public function workflowsListXhr(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = [];
        $repository = $this->getDoctrine()->getRepository(Entity\Workflow::class);
        $json = $repository->getWorkflows($request->query, $container);

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function WorkflowsxhrAction(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $json = [];
        $error = false;
        if($request->isXmlHttpRequest()){
            if($request->getMethod() == 'POST'){
                $em = $this->getDoctrine()->getManager();
                //sort order update
                $workflows = $em->getRepository(Entity\Workflow::class)->findAll();
                   
                $sortOrders = $request->request->get('orders');
                if(count($workflows)) {
                    foreach ($workflows as $id => $workflow) {
                        if(!empty($sortOrders[$workflow->getId()])) {
                            $workflow->setSortOrder($sortOrders[$workflow->getId()]);
                            $em->persist($workflow);
                        } else {
                            $error = true;
                            break;                        
                        }
                    }
                    $em->flush();
                }
                if(!$error) {
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->translator->trans('Success! Order has been updated successfully.');
                }
            }
            elseif($request->getMethod() == 'DELETE') {
                //$this->isAuthorized(self::ROLE_REQUIRED_AUTO);

                $em = $this->getDoctrine()->getManager();
                $id = $request->attributes->get('id');
                //$workFlow = $this->getWorkflow($id, 'Events');
                $workFlow = $em->getRepository(Entity\Workflow::class)
                            ->findOneBy(array('id' => $id));

                if (!empty($workFlow)) {
                    $em->remove($workFlow);
                    $em->flush();
                } else {
                    $error = true;
                }

                if (!$error) {
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->translator->trans('Success! Workflow has been removed successfully.');
                }
            }
        }
        if($error){
            $json['alertClass'] = 'danger';
            $json['alertMessage'] = $this->translator->trans('Warning! You are not allowed to perform this action.');
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function getWorkflowConditionOptionsXHR($entity, Request $request)
    {
        $error = false;
        $json = $results = array();
        $supportedConditions = ['TicketPriority', 'TicketType', 'TicketStatus', 'source', 'agent', 'group','team', 'agent_name', 'agent_email', 'stage'];

        if (!$request->isXmlHttpRequest()) {
            throw new Exception('', 404);
        } else {
            if ($request->getMethod() != 'GET' || !in_array($entity, $supportedConditions)) {
                throw new Exception('', 404);
            }
        }

        switch ($entity) {
            case 'team':
                $json = json_encode($this->userService->getSupportTeams());
                break;
            case 'group':
                $json = $this->userService->getSupportGroups();
                break;
            case 'stage':
                $json = $this->get('task.service')->getStages();
                break;
            case 'TicketType':
                $json = $this->ticketService->getTypes();
                break;
            case 'agent':
            case 'agent_name':
                $defaultAgent = ['id' => 'actionPerformingAgent', 'name' => 'Action Performing Agent'];
                $agentList = $this->userService->getAgentPartialDataCollection();
                array_push($agentList, $defaultAgent);

                $json = json_encode(array_map(function($item) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                }, $agentList));

                break;
            case 'agent_email':
                $json = json_encode(array_map(function($item) {
                    return [
                        'id' => $result['id'],
                        'name' => $result['email'],
                    ];
                }, $this->userService->getAgentsPartialDetails()));

                break;
            case 'source':
                $allSources = $this->ticketService->getAllSources();
                $results = [];
                foreach($allSources as $key => $source) {
                        $results[] = [
                                    'id' => $key,
                                    'name' => $source,
                        ];
                };
                $json = json_encode($results);
                $results = [];
                break;
            case 'TicketStatus':
            case 'TicketPriority':
                $json = json_encode(array_map(function($item) {
                    return [
                        'id' => $item->getId(),
                        'name' => $item->getCode(),
                    ];
                }, $this->getDoctrine()->getRepository("Webkul\\UVDesk\\CoreFrameworkBundle\\" . ucfirst($entity))->findAll()));

                break;
            default:
                $json = [];
                break;
        }

        // if (!empty($results)) {
        //     $ignoredArray = ['__initializer__', '__cloner__', '__isInitialized__', 'description', 'color', 'company', 'createdAt', 'users', 'isActive'];
        //     $json = $this->getSerializeObj($ignoredArray)->serialize($results, 'json');
        // }

        return new Response(is_array($json) ? json_encode($json) : $json, 200, ['Content-Type' => 'application/json']);
    }

    public function getWorkflowActionOptionsXHR($entity, Request $request, ContainerInterface $container)
    {
        foreach ($this->workflowListnerService->getRegisteredWorkflowActions() as $workflowAction) {
            if ($workflowAction->getId() == $entity) {
                $options = $workflowAction->getOptions($container);
                
                if (!empty($options)) {
                    return new Response(json_encode($options), 200, ['Content-Type' => 'application/json']);
                }

                break;
            }
        }

        return new Response(json_encode([
            'alertClass' => 'danger',
            'alertMessage' => 'Warning! You are not allowed to perform this action.',
        ]), 200, ['Content-Type' => 'application/json']);
    }
}
