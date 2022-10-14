<?php

namespace Webkul\UVDesk\AutomationBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webkul\UVDesk\AutomationBundle\Entity\Workflow;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Workflow\Event as WorkflowEvent;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class WorkflowListener
{
    private $container;
    private $entityManager;
    private $registeredWorkflowEvents = [];
    private $registeredWorkflowActions = [];

    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function registerWorkflowEvent(WorkflowEvent $serviceTag)
    {
        $this->registeredWorkflowEvents[] = $serviceTag;
    }

    public function registerWorkflowAction(WorkflowAction $serviceTag)
    {
        $this->registeredWorkflowActions[] = $serviceTag;
    }

    public function getRegisteredWorkflowEvent($eventId)
    {
        foreach ($this->registeredWorkflowEvents as $workflowDefinition) {
            if ($workflowDefinition->getId() == $eventId) {
                /*
                    @NOTICE: Events 'uvdesk.agent.forgot_password', 'uvdesk.customer.forgot_password' will be deprecated 
                    onwards uvdesk/automation-bundle:1.0.2 and uvdesk/core-framework:1.0.3 releases and will be 
                    completely removed with the next major release.

                    Both the events have been mapped to return the 'uvdesk.user.forgot_password' id, so we need to 
                    return the correct definition.
                */
                if ('uvdesk.user.forgot_password' == $eventId) {
                    if (
                        $workflowDefinition instanceof \Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Agent\ForgotPassword 
                        || $workflowDefinition instanceof \Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events\Customer\ForgotPassword
                    ) {
                        continue;
                    }
                }

                return $workflowDefinition;
            }
        }

        return null;
    }
    
    public function getRegisteredWorkflowEvents()
    {
        return $this->registeredWorkflowEvents;
    }

    public function getRegisteredWorkflowActions()
    {
        return $this->registeredWorkflowActions;
    }

    public function executeWorkflow(GenericEvent $event)
    {
        $workflowCollection = $this->entityManager->getRepository(Workflow::class)->getEventWorkflows($event->getSubject());

        /*
            @NOTICE: Events 'uvdesk.agent.forgot_password', 'uvdesk.customer.forgot_password' will be deprecated 
            onwards uvdesk/automation-bundle:1.0.2 and uvdesk/core-framework:1.0.3 releases and will be 
            completely removed with the next major release.

            From uvdesk/core-framework:1.0.3 onwards, instead of the above mentioned events, the one being 
            triggered will be 'uvdesk.user.forgot_password'. Since there still might be older workflows 
            configured to work on either of the two deprecated events, we will need to make an educated guess 
            which one to use (if any) if there's none found for the actual event.
        */
        if (empty($workflowCollection) && 'uvdesk.user.forgot_password' == $event->getSubject()) {
            $user = $event->getArgument('entity');

            if (!empty($user) && $user instanceof \Webkul\UVDesk\CoreFrameworkBundle\Entity\User) {
                $agentForgotPasswordWorkflows = $this->entityManager->getRepository(Workflow::class)->getEventWorkflows('uvdesk.agent.forgot_password');
                $customerForgotPasswordWorkflows = $this->entityManager->getRepository(Workflow::class)->getEventWorkflows('uvdesk.customer.forgot_password');

                if (!empty($agentForgotPasswordWorkflows) || !empty($customerForgotPasswordWorkflows)) {
                    $agentInstance = $user->getAgentInstance();
                    $customerInstance = $user->getCustomerInstance();

                    if (!empty($customerForgotPasswordWorkflows) && !empty($customerInstance)) {
                        // Resort to uvdesk.customer.forgot_password workflows
                        $workflowCollection = $customerForgotPasswordWorkflows;
                    } else if (!empty($agentForgotPasswordWorkflows) && !empty($agentInstance)) {
                        // Resort to uvdesk.agent.forgot_password workflows
                        $workflowCollection = $agentForgotPasswordWorkflows;
                    }
                }
            }
        }
        
        if (!empty($workflowCollection)) {
            foreach ($workflowCollection as $workflow) {
                $totalConditions = 0;
                $totalEvaluatedConditions = 0;

                foreach ($this->evaluateWorkflowConditions($workflow) as $workflowCondition) {
                    $totalEvaluatedConditions++;

                    if (isset($workflowCondition['type']) && $this->checkCondition($workflowCondition, $event->getArgument('entity'))) {
                        $totalConditions++;
                    }

                    if (isset($workflowCondition['or'])) {
                        foreach ($workflowCondition['or'] as $orCondition) {
                            if ($this->checkCondition($orCondition, $event->getArgument('entity'))) {
                                $totalConditions++;
                            }
                        }
                    }
                }

                if ($totalEvaluatedConditions == 0 || $totalConditions >= $totalEvaluatedConditions) {
                    $this->applyWorkflowActions($workflow, $event->getArgument('entity'), $event->hasArgument('thread') ? $event->getArgument('thread') : null);
                }
            }
        }
    }

    private function evaluateWorkflowConditions(Workflow $workflow)
    {
        $index = -1;
        $workflowConditions = [];

        if ($workflow->getConditions() == null) {
            return $workflowConditions;
        }

        foreach ($workflow->getConditions() as $condition) {
            if (!empty($condition['operation']) && $condition['operation'] != "&&") {
                if (!isset($finalConditions[$index]['or'])) {
                    $finalConditions[$index]['or'] = [];
                }

                $workflowConditions[$index]['or'][] = $condition;
            } else {
                $index++;
                $workflowConditions[] = $condition;
            }
        }

        return $workflowConditions;
    }

    private function applyWorkflowActions(Workflow $workflow, $entity, $thread = null)
    {
        foreach ($workflow->getActions() as $attributes) {
            if (empty($attributes['type'])) {
                continue;
            }

            foreach ($this->getRegisteredWorkflowActions() as $workflowAction) {
                if ($workflowAction->getId() == $attributes['type']) {
                    $workflowAction->applyAction($this->container, $entity, isset($attributes['value']) ? $attributes['value'] : '', $thread);
                }
            }
        }
    }

    public function checkCondition($condition, $entity)
    {
        switch ($condition['type']) {
            case 'from_mail':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    return $this->match($condition['match'], $entity->getCustomer()->getEmail(), $condition['value']);
                }

                break;
            case 'to_mail':
                if (isset($condition['value']) && $entity instanceof Ticket && $entity->getMailboxEmail()) {
                    return $this->match($condition['match'], $entity->getMailboxEmail(), $condition['value']);
                }
                
                break;
            case 'subject':
                if (isset($condition['value']) && ($entity instanceof Ticket || $entity instanceof Task)) {
                    return $this->match($condition['match'], $entity->getSubject(), $condition['value']);
                }

                break;
            case 'description':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $reply = $entity->createdThread->getMessage();
                    $reply = rtrim(strip_tags($reply), "\n" );
                    return $this->match($condition['match'], rtrim($reply), $condition['value']);
                }

                break;
            case 'subject_or_description':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $flag = $this->match($condition['match'], $entity->getSubject(), $condition['value']);
                    $createThread = $this->container->get('ticket.service')->getCreateReply($entity->getId(),false);
                    
                    if (!$flag) {
                        $createThread = $this->container->get('ticket.service')->getCreateReply($entity->getId(),false);
                        $createThread['reply'] = rtrim(strip_tags($createThread['reply']), "\n" );

                        $flag = $this->match($condition['match'],$createThread['reply'],$condition['value']);
                    }

                    return $flag;
                }

                break;
            case 'TicketPriority':
                if (isset($condition['value']) && ($entity instanceof Ticket)) {
                    return $this->match($condition['match'], $entity->getPriority()->getId(), $condition['value']);
                }

                break;
            case 'TicketType':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $typeId = $entity->getType() ? $entity->getType()->getId() : 0;
                    return $this->match($condition['match'], $typeId, $condition['value']);
                }

                break;
            case 'TicketStatus':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    return $this->match($condition['match'], $entity->getStatus()->getId(), $condition['value']);
                }

                break;
            case 'stage':
                if (isset($condition['value']) && $entity instanceof Task) {
                    return $this->match($condition['match'], $entity->getStage()->getId(), $condition['value']);
                }

                break;
            case 'source':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    return $this->match($condition['match'], $entity->getSource(), $condition['value']);
                }

                break;
            case 'created':
                if (isset($condition['value']) && ($entity instanceof Ticket || $entity instanceof Task)) {
                    $date = date_format($entity->getCreatedAt(), "d-m-Y h:ia");
                    return $this->match($condition['match'], $date, $condition['value']);
                }

                break;
            case 'agent':
                if (isset($condition['value']) && $entity instanceof Ticket && $entity->getAgent()) {
                    return $this->match($condition['match'], $entity->getAgent()->getId(), (($condition['value'] == 'actionPerformingAgent') ? ($this->container->get('user.service')->getCurrentUser() ? $this->container->get('user.service')->getCurrentUser()->getId() : 0) : $condition['value']));
                }

                break;
            case 'group':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $groupId = $entity->getSupportGroup() ? $entity->getSupportGroup()->getId() : 0;
                    return $this->match($condition['match'], $groupId, $condition['value']);
                }

                break;
            case 'team':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $subGroupId = $entity->getSupportTeam() ? $entity->getSupportTeam()->getId() : 0;
                    return $this->match($condition['match'], $subGroupId, $condition['value']);
                }

                break;
            case 'customer_name':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    $lastThread = $this->container->get('ticket.service')->getTicketLastThread($entity->getId());
                    return $this->match($condition['match'], $entity->getCustomer()->getFullName(), $condition['value']);
                }
                
                break;
            case 'customer_email':
                if (isset($condition['value']) && $entity instanceof Ticket) {
                    return $this->match($condition['match'], $entity->getCustomer()->getEmail(), $condition['value']);
                }

                break;
            case strpos($condition['type'], 'customFields[') == 0:
                $value = null;
                $ticketCfValues = $entity->getCustomFieldValues()->getValues();
                
                foreach ($ticketCfValues as $cfValue) {
                    $mainCf = $cfValue->getTicketCustomFieldsValues();
                    
                    if ($condition['type'] == 'customFields[' . $mainCf->getId() . ']' ) {
                        if (in_array($mainCf->getFieldType(), ['select', 'radio', 'checkbox'])) {
                           $value = json_decode($cfValue->getValue(), true);
                        } else {
                           $value = trim($cfValue->getValue(), '"');
                        }
                        
                        break;
                    }
                }

                if (isset($condition['value']) && $entity instanceof Ticket) {
                    return $this->match($condition['match'], !empty($value) ? $value : '', $condition['value']);
                }

                break;
            default:
                break;
        }

        return false;
    }

    public function match($condition, $haystack, $needle)
    {
        // Filter tags
        if ('string' == gettype($haystack)) {
            $haystack = strip_tags($haystack);
        }

        switch ($condition) {
            case 'is':
                return is_array($haystack) ? in_array($needle, $haystack) : $haystack == $needle;
            case 'isNot':
                return is_array($haystack) ? !in_array($needle, $haystack) : $haystack != $needle;
            case 'contains':
                return strripos($haystack,$needle) !== false ? true : false;
            case 'notContains':
                return strripos($haystack,$needle) === false ? true : false;
            case 'startWith':
                return $needle === "" || strripos($haystack, $needle, -strlen($haystack)) !== FALSE;
            case 'endWith':
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && stripos($haystack, $needle, $temp) !== FALSE);
            case 'before':
                $createdTimeStamp = date('Y-m-d', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d', strtotime($needle . " 23:59:59"));

                return $createdTimeStamp < $conditionTimeStamp ? true : false;
            case 'beforeOn':
                $createdTimeStamp = date('Y-m-d', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d', strtotime($needle . " 23:59:59"));

                return ($createdTimeStamp < $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp) ? true : false;
            case 'after':
                $createdTimeStamp = date('Y-m-d', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d', strtotime($needle . " 23:59:59"));

                return $createdTimeStamp > $conditionTimeStamp ? true : false;
            case 'afterOn':
                $createdTimeStamp = date('Y-m-d', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d', strtotime($needle . " 23:59:59"));
                
                return $createdTimeStamp > $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp ? true : false;
            case 'beforeDateTime':
                $createdTimeStamp = date('Y-m-d h:i:s', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d h:i:s', strtotime($needle));

                return $createdTimeStamp < $conditionTimeStamp ? true : false;
            case 'beforeDateTimeOn':
                $createdTimeStamp = date('Y-m-d h:i:s', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d h:i:s', strtotime($needle));

                return ($createdTimeStamp < $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp) ? true : false;
            case 'afterDateTime':
                $createdTimeStamp = date('Y-m-d h:i:s', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d h:i:s', strtotime($needle));

                return $createdTimeStamp > $conditionTimeStamp ? true : false;
            case 'afterDateTimeOn':
                $createdTimeStamp = date('Y-m-d h:i:s', strtotime($haystack));
                $conditionTimeStamp = date('Y-m-d h:i:s', strtotime($needle));

                return $createdTimeStamp > $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp ? true : false;
            case 'beforeTime':
                $createdTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $haystack));
                $conditionTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $needle));

                return $createdTimeStamp < $conditionTimeStamp ? true : false;
            case 'beforeTimeOn':
                $createdTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $haystack));
                $conditionTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $needle));

                return ($createdTimeStamp < $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp) ? true : false;
            case 'afterTime':
                $createdTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $haystack));
                $conditionTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $needle));

                return $createdTimeStamp > $conditionTimeStamp ? true : false;
            case 'afterTimeOn':
                $createdTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $haystack));
                $conditionTimeStamp = date('Y-m-d H:i A', strtotime('2017-01-01' . $needle));

                return $createdTimeStamp > $conditionTimeStamp || $createdTimeStamp == $conditionTimeStamp ? true : false;
            case 'greaterThan':
                return !is_array($haystack) && $needle > $haystack;
            case 'lessThan':
                return !is_array($haystack) && $needle < $haystack;
            default:
                break;
        }

        return false;
    }
}
