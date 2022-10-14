<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;

class MailAgent extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.mail_agent';
    }

    public static function getDescription()
    {
        return "Mail to agent";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::TICKET;
    }

    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $emailTemplateCollection = array_map(function ($emailTemplate) {
            return [
                'id' => $emailTemplate->getId(),
                'name' => $emailTemplate->getName(),
            ];
        }, $entityManager->getRepository(EmailTemplates::class)->findAll());

        $agentCollection = array_map(function ($agent) {
            return [
                'id' => $agent['id'],
                'name' => $agent['name'],
            ];
        }, $container->get('user.service')->getAgentPartialDataCollection());

        array_unshift($agentCollection, [
            'id' => 'responsePerforming',
            'name' => 'Response Performing Agent',
        ], [
            'id' => 'assignedAgent',
            'name' => 'Assigned Agent',
        ]);

        return [
            'partResults' => $agentCollection,
            'templates' => $emailTemplateCollection,
        ];
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        
        if($entity instanceof Ticket) {
            $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value['value']);
            $emails = self::getAgentMails($value['for'], (($ticketAgent = $entity->getAgent()) ? $ticketAgent->getEmail() : ''), $container);
            
            if($emails && $emailTemplate) {
                $mailData = array();
                if($entity instanceof Ticket) {
                    $createThread = $container->get('ticket.service')->getCreateReply($entity->getId(), false);
                    $mailData['references'] = $createThread['messageId'];
                }
                $mailData['email'] = $emails;
                
                $placeHolderValues   = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(),$placeHolderValues);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(),$placeHolderValues);

                foreach($mailData['email'] as $email){
                    $messageId = $container->get('email.service')->sendMail($subject, $message, $email);
                }
            } else {
                // Email Template/Emails Not Found. Disable Workflow/Prepared Response
                // $this->disableEvent($event, $entity);
            }
        }

    }

    public static function getAgentMails($for, $currentEmails, $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $agentMails = [];
        foreach ($for as $agent) {
            if($agent == 'assignedAgent'){
                if(is_array($currentEmails))
                    $agentMails = array_merge($agentMails, $currentEmails);
                else
                    $agentMails[] = $currentEmails;
            }elseif($agent == 'responsePerforming' && is_object($currentUser = $container->get('security.tokenstorage')->getToken()->getUser())) //add current user email if any
                $agentMails[] = $currentUser->getEmail();
            
            elseif($agent == 'baseAgent'){ //add selected user email if any
                if(is_array($currentEmails))
                    $agentMails = array_merge($agentMails, $currentEmails);
                else
                    $agentMails[] = $currentEmails;
            }elseif((int)$agent){
                $qb = $entityManager->createQueryBuilder();
                $email = $qb->select('u.email')->from(User::class, 'u')
                            ->andwhere("u.id = :userId")
                            ->setParameter('userId', $agent)
                            ->getQuery()->getResult()
                        ;
                if(isset($email[0]['email']))
                    $agentMails[] = $email[0]['email'];
            }
        }
        return array_filter($agentMails);
    }
}
