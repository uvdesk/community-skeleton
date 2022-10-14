<?php

namespace Webkul\UVDesk\AutomationBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AutomationService
{
	private $container;
	private $requestStack;
    private $entityManager;

	public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager, TranslatorInterface $translator)
	{
		$this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function getWorkflowEvents()
    {
        return [
            FunctionalGroup::USER => $this->translator->trans('User'),
            FunctionalGroup::AGENT => $this->translator->trans('Agent'),
            FunctionalGroup::CUSTOMER => $this->translator->trans('Customer'),
            FunctionalGroup::TICKET => $this->translator->trans('Ticket'),
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

            $ticketEventCollection[$functionalGroup][$workflowDefinition->getId()] = $this->translator->trans($workflowDefinition->getDescription());
        }

        return $ticketEventCollection;
    }

    public function getWorkflowConditions()
    {
        $conditions = [
            'ticket' => [
                'mail' => [
                    [
                        'lable' => $this->translator->trans('From Email'),
                        'value' => 'from_mail',
                        'match' => 'email'
                    ],
                    [
                        'lable' => $this->translator->trans('To Email'),
                        'value' => 'to_mail',
                        'match' => 'email'
                    ],
                ],
                'ticket' => [
                    [
                        'lable' => $this->translator->trans('Subject'),
                        'value' => 'subject',
                        'match' => 'string'
                    ],
                    [
                        'lable' => $this->translator->trans('Description'),
                        'value' => 'description',
                        'match' => 'string'
                    ],
                    [
                        'lable' => $this->translator->trans('Subject or Description'),
                        'value' => 'subject_or_description',
                        'match' => 'string'
                    ],
                    [
                        'lable' => $this->translator->trans('Priority'),
                        'value' => 'TicketPriority',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Type'),
                        'value' => 'TicketType',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Status'),
                        'value' => 'TicketStatus',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Source'),
                        'value' => 'source',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Created'),
                        'value' => 'created',
                        'match' => 'date'
                    ],
                    [
                        'lable' => $this->translator->trans('Agent'),
                        'value' => 'agent',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Group'),
                        'value' => 'group',
                        'match' => 'select'
                    ],
                    [
                        'lable' => $this->translator->trans('Team'),
                        'value' => 'team',
                        'match' => 'select'
                    ],
                ],
                'customer' => [
                    [
                        'lable' => $this->translator->trans('Customer Name'),
                        'value' => 'customer_name',
                        'match' => 'string'
                    ],
                    [
                        'lable' => $this->translator->trans('Customer Email'),
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
                    'lable' => $this->translator->trans('Is Equal To'),
                    'value' => 'is'
                ],
                [
                    'lable' => $this->translator->trans('Is Not Equal To'),
                    'value' => 'isNot'
                ],
                [
                    'lable' => $this->translator->trans('Contains'),
                    'value' => 'contains'
                ],
                [
                    'lable' => $this->translator->trans('Does Not Contain'),
                    'value' => 'notContains'
                ],
            ],
            'string' => [
                [
                    'lable' => $this->translator->trans('Is Equal To'),
                    'value' => 'is'
                ],
                [
                    'lable' => $this->translator->trans('Is Not Equal To'),
                    'value' => 'isNot'
                ],
                [
                    'lable' => $this->translator->trans('Contains'),
                    'value' => 'contains'
                ],
                [
                    'lable' => $this->translator->trans('Does Not Contain'),
                    'value' => 'notContains'
                ],
                [
                    'lable' => $this->translator->trans('Starts With'),
                    'value' => 'startWith'
                ],
                [
                    'lable' => $this->translator->trans('Ends With'),
                    'value' => 'endWith'
                ],
            ],
            'select' => [
                [
                    'lable' => $this->translator->trans('Is Equal To'),
                    'value' => 'is'
                ],
                [
                    'lable' => $this->translator->trans('Is Not Equal To'),
                    'value' => 'isNot'
                ],
            ],
            'date' => [
                [
                    'lable' => $this->translator->trans('Before'),
                    'value' => 'before'
                ],
                [
                    'lable' => $this->translator->trans('Before On'),
                    'value' => 'beforeOn'
                ],
                [
                    'lable' => $this->translator->trans('After'),
                    'value' => 'after'
                ],
                [
                    'lable' => $this->translator->trans('After On'),
                    'value' => 'afterOn'
                ],
            ],
            'datetime' => [
                [
                    'lable' => $this->translator->trans('Before'),
                    'value' => 'beforeDateTime'
                ],
                [
                    'lable' => $this->translator->trans('Before On'),
                    'value' => 'beforeDateTimeOn'
                ],
                [
                    'lable' => $this->translator->trans('After'),
                    'value' => 'afterDateTime'
                ],
                [
                    'lable' => $this->translator->trans('After On'),
                    'value' => 'afterDateTimeOn'
                ],
            ],
            'time' => [
                [
                    'lable' => $this->translator->trans('Before'),
                    'value' => 'beforeTime'
                ],
                [
                    'lable' => $this->translator->trans('Before On'),
                    'value' => 'beforeTimeOn'
                ],
                [
                    'lable' => $this->translator->trans('After'),
                    'value' => 'afterTime'
                ],
                [
                    'lable' => $this->translator->trans('After On'),
                    'value' => 'afterTimeOn'
                ],
            ],
            'number' => [
                [
                    'lable' => $this->translator->trans('Is Equal To'),
                    'value' => 'is'
                ],
                [
                    'lable' => $this->translator->trans('Is Not Equal To'),
                    'value' => 'isNot'
                ],
                [
                    'lable' => $this->translator->trans('Contains'),
                    'value' => 'contains'
                ],
                [
                    'lable' => $this->translator->trans('Greater Than'),
                    'value' => 'greaterThan'
                ],
                [
                    'lable' => $this->translator->trans('Less Than'),
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

            $workflowActions[$functionalGroup][$workflowDefinition->getId()] = $this->translator->trans($workflowDefinition->getDescription());
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

            $preparedResponseActions[$functionalGroup][$preparedResponseDefinition->getId()] = $this->translator->trans($preparedResponseDefinition->getDescription());
        }

        return $preparedResponseActions;
    }
}
