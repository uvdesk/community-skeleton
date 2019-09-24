<?php

namespace Webkul\UVDesk\AutomationBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AutomationService
{
	private $container;
	private $requestStack;
    private $entityManager;

	public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager)
	{
		$this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function getWorkflowEvents()
    {
        return [
            FunctionalGroup::AGENT => 'Agent',
            FunctionalGroup::CUSTOMER => 'Customer',
            FunctionalGroup::TICKET => 'Ticket',
        ];
    }

    public function getWorkflowEventValues()
    {
        $ticketEventCollection = [];

        foreach ($this->container->get('uvdesk.automations.workflows')->getRegisteredWorkflowEvents() as $workflowDefinition) {
            $functionalGroup = $workflowDefinition->getFunctionalGroup();

            if (!isset($ticketEventCollection[$functionalGroup])) {
                $ticketEventCollection[$functionalGroup] = [];
            }

            $ticketEventCollection[$functionalGroup][$workflowDefinition->getId()] = $workflowDefinition->getDescription();
        }

        return $ticketEventCollection;
    }

    public function getWorkflowConditions()
    {
        $conditions = [
            'ticket' => [
                'mail' => [
                    [
                        'lable' => 'From Email',
                        'value' => 'from_mail',
                        'match' => 'email'
                    ],
                    [
                        'lable' => 'To Email',
                        'value' => 'to_mail',
                        'match' => 'email'
                    ],
                ],
                'ticket' => [
                    [
                        'lable' => 'Subject',
                        'value' => 'subject',
                        'match' => 'string'
                    ],
                    [
                        'lable' => 'Description',
                        'value' => 'description',
                        'match' => 'string'
                    ],
                    [
                        'lable' => 'Subject or Description',
                        'value' => 'subject_or_description',
                        'match' => 'string'
                    ],
                    [
                        'lable' => 'Priority',
                        'value' => 'TicketPriority',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Type',
                        'value' => 'TicketType',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Status',
                        'value' => 'TicketStatus',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Source',
                        'value' => 'source',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Created',
                        'value' => 'created',
                        'match' => 'date'
                    ],
                    [
                        'lable' => 'Agent',
                        'value' => 'agent',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Group',
                        'value' => 'group',
                        'match' => 'select'
                    ],
                    [
                        'lable' => 'Team',
                        'value' => 'team',
                        'match' => 'select'
                    ],
                ],
                'customer' => [
                    [
                        'lable' => 'Customer Name',
                        'value' => 'customer_name',
                        'match' => 'string'
                    ],
                    [
                        'lable' => 'Customer Email',
                        'value' => 'customer_email',
                        'match' => 'email'
                    ],
                ],
            ],
        ];
        
        return $conditions;
    }

    public function getWorkflowMatchConditions()
    {
        return [
            'email' => [
                [
                    'lable' => 'Is Equal To',
                    'value' => 'is'
                ],
                [
                    'lable' => 'Is Not Equal To',
                    'value' => 'isNot'
                ],
                [
                    'lable' => 'Contains',
                    'value' => 'contains'
                ],
                [
                    'lable' => 'Does Not Contain',
                    'value' => 'notContains'
                ],
            ],
            'string' => [
                [
                    'lable' => 'Is Equal To',
                    'value' => 'is'
                ],
                [
                    'lable' => 'Is Not Equal To',
                    'value' => 'isNot'
                ],
                [
                    'lable' => 'Contains',
                    'value' => 'contains'
                ],
                [
                    'lable' => 'Does Not Contain',
                    'value' => 'notContains'
                ],
                [
                    'lable' => 'Starts With',
                    'value' => 'startWith'
                ],
                [
                    'lable' => 'Ends With',
                    'value' => 'endWith'
                ],
            ],
            'select' => [
                [
                    'lable' => 'Is Equal To',
                    'value' => 'is'
                ],
                [
                    'lable' => 'Is Not Equal To',
                    'value' => 'isNot'
                ],
            ],
            'date' => [
                [
                    'lable' => 'Before',
                    'value' => 'before'
                ],
                [
                    'lable' => 'Before On',
                    'value' => 'beforeOn'
                ],
                [
                    'lable' => 'After',
                    'value' => 'after'
                ],
                [
                    'lable' => 'After On',
                    'value' => 'afterOn'
                ],
            ],
            'datetime' => [
                [
                    'lable' => 'Before',
                    'value' => 'beforeDateTime'
                ],
                [
                    'lable' => 'Before On',
                    'value' => 'beforeDateTimeOn'
                ],
                [
                    'lable' => 'After',
                    'value' => 'afterDateTime'
                ],
                [
                    'lable' => 'After On',
                    'value' => 'afterDateTimeOn'
                ],
            ],
            'time' => [
                [
                    'lable' => 'Before',
                    'value' => 'beforeTime'
                ],
                [
                    'lable' => 'Before On',
                    'value' => 'beforeTimeOn'
                ],
                [
                    'lable' => 'After',
                    'value' => 'afterTime'
                ],
                [
                    'lable' => 'After On',
                    'value' => 'afterTimeOn'
                ],
            ],
            'number' => [
                [
                    'lable' => 'Is Equal To',
                    'value' => 'is'
                ],
                [
                    'lable' => 'Is Not Equal To',
                    'value' => 'isNot'
                ],
                [
                    'lable' => 'Contains',
                    'value' => 'contains'
                ],
                [
                    'lable' => 'Greater Than',
                    'value' => 'greaterThan'
                ],
                [
                    'lable' => 'Less Than',
                    'value' => 'lessThan'
                ],
            ],
        ];
    }

    public function getWorkflowActions($force = false)
    {
        $workflowActions = [];
        
        // @TODO: Add minimum required access levels to workflow actions to restrict usage
        foreach ($this->container->get('uvdesk.automations.workflows')->getRegisteredWorkflowActions() as $workflowDefinition) {
            $functionalGroup = $workflowDefinition->getFunctionalGroup();

            if (!isset($workflowActions[$functionalGroup])) {
                $workflowActions[$functionalGroup] = [];
            }

            $workflowActions[$functionalGroup][$workflowDefinition->getId()] = $workflowDefinition->getDescription();
        }

        return $workflowActions;
    }

    public function getPreparedResponseActions($force = false)
    {
        $preparedResponseActions = [];

        // @TODO: Add minimum required access levels to prepared response actions to restrict usage
        foreach ($this->container->get('uvdesk.automations.prepared_responses')->getRegisteredPreparedResponseActions() as $preparedResponseDefinition) {
            $functionalGroup = $preparedResponseDefinition->getFunctionalGroup();

            if (!isset($preparedResponseActions[$functionalGroup])) {
                $preparedResponseActions[$functionalGroup] = [];
            }

            $preparedResponseActions[$functionalGroup][$preparedResponseDefinition->getId()] = $preparedResponseDefinition->getDescription();
        }

        return $preparedResponseActions;
    }
}
