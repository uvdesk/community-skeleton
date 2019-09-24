<?php

namespace Webkul\UVDesk\AutomationBundle\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Webkul\UVDesk\AutomationBundle\Entity as AutomationEntities;

class AutomationWorkflowFixtures extends DoctrineFixture
{
    private static $seeds = [
        [
            'name' => 'Customer Created',
            'description' => 'Send customer a welcome email after their account has been created.',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:2;a:2:{s:4:"type";s:29:"uvdesk.customer.mail_customer";s:5:"value";s:1:"8";}}',
            'status' => '1',
            'sort_order' => '1',
            'events' => ['uvdesk.customer.created']
        ],
        [
            'name' => 'Agent Created',
            'description' => 'Send agent a welcome email when their account is created.',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:1;a:2:{s:4:"type";s:23:"uvdesk.agent.mail_agent";s:5:"value";s:1:"3";}}',
            'status' => '1',
            'sort_order' => '2',
            'events' => ['uvdesk.agent.created']
        ],
        [
            'name' => 'Customer Forgot Password',
            'description' => 'Send customer an email on forgot password action.',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:1;a:2:{s:4:"type";s:29:"uvdesk.customer.mail_customer";s:5:"value";s:1:"9";}}',
            'status' => '1',
            'sort_order' => '2',
            'events' => ['uvdesk.customer.forgot_password']
        ],
        [
            'name' => 'Agent Forgot Password',
            'description' => 'Send agent an email to reset password',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:1;a:2:{s:4:"type";s:23:"uvdesk.agent.mail_agent";s:5:"value";s:1:"4";}}',
            'status' => '1',
            'sort_order' => '3',
            'events' => ['uvdesk.agent.forgot_password']
        ],
        [
            'name' => 'Ticket Created',
            'description' => 'Automate actions when ticket is created.',
            'conditions' => 'N;',
            'actions' => 'a:3:{i:0;a:2:{s:4:"type";s:27:"uvdesk.ticket.mail_customer";s:5:"value";s:1:"7";}i:1;a:2:{s:4:"type";s:26:"uvdesk.ticket.assign_agent";s:5:"value";s:18:"responsePerforming";}i:2;a:2:{s:4:"type";s:24:"uvdesk.ticket.mail_agent";s:5:"value";a:2:{s:3:"for";a:1:{i:0;s:13:"assignedAgent";}s:5:"value";s:1:"2";}}}',
            'status' => '1',
            'sort_order' => '5',
            'events' => ['uvdesk.ticket.created']
        ],
        [
            'name' => 'Agent Replied on Ticket',
            'description' => 'Send customer an email when reply is added on ticket.',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:2;a:2:{s:4:"type";s:27:"uvdesk.ticket.mail_customer";s:5:"value";s:1:"1";}}',
            'status' => '1',
            'sort_order' => '5',
            'events' => ['uvdesk.ticket.agent_reply']
        ],
        [
            'name' => 'Customer Replied on Ticket',
            'description' => 'Send agent an email when reply is added on ticket.',
            'conditions' => 'N;',
            'actions' => 'a:1:{i:1;a:2:{s:4:"type";s:24:"uvdesk.ticket.mail_agent";s:5:"value";a:2:{s:3:"for";a:1:{i:0;s:13:"assignedAgent";}s:5:"value";s:1:"6";}}}',
            'status' => '1',
            'sort_order' => '5',
            'events' => ['uvdesk.ticket.customer_reply']
        ],
    ];

    public function load(ObjectManager $entityManager)
    {
        $availableWorkflows = $entityManager->getRepository('UVDeskAutomationBundle:Workflow')->findAll();

        if (empty($availableWorkflows)) {
            foreach (self::$seeds as $baseEvent) {
                $workflow_actions = unserialize($baseEvent['actions']);
                
                ($workflow = new AutomationEntities\Workflow())
                    ->setConditions([])
                    ->setDateAdded(new \DateTime)
                    ->setDateUpdated(new \DateTime)
                    ->setIsPredefind(true)
                    ->setActions($workflow_actions)
                    ->setName($baseEvent['name'])
                    ->setStatus($baseEvent['status'])
                    ->setSortOrder($baseEvent['sort_order'])
                    ->setDescription($baseEvent['description']);
                
                $entityManager->persist($workflow);
                $entityManager->flush();
    
                foreach ($baseEvent['events'] as $eventValue) {
                    $eventObj = new AutomationEntities\WorkflowEvents();
                    $eventObj->setEventId($workflow->getId());
                    $eventObj->setEvent($eventValue);
                    $eventObj->setWorkflow($workflow);
                    $entityManager->persist($eventObj);
                }
                $entityManager->flush();
            }
        }
    }
}
