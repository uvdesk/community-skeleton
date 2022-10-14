<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;

class MailCustomer extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.mail_customer';
    }

    public static function getDescription()
    {
        return "Mail to customer";
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

        return $emailTemplateCollection;
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null, $thread = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        switch (true) {
            case $entity instanceof CoreEntities\Ticket:
                $currentThread = isset($entity->currentThread) ? $entity->currentThread : '';
                $createdThread = isset($entity->createdThread) ? $entity->createdThread : '';
                
                $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value);

                if (empty($emailTemplate)) {
                    break;
                }

                // Only process attachments if required in the message body
                // @TODO: Revist -> Maybe we should always include attachments if they are provided??
                $attachments = [];
                if (!empty($createdThread) && (strpos($emailTemplate->getMessage(), '{%ticket.attachments%}') !== false || strpos($emailTemplate->getMessage(), '{% ticket.attachments %}') !== false)) {
                    $attachments = array_map(function($attachment) use ($container) { 
                        return str_replace('//', '/', $container->get('kernel')->getProjectDir() . "/public" . $attachment->getPath());
                    }, $entityManager->getRepository(Attachment::class)->findByThread($createdThread));
                }

                $ticketPlaceholders = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(), $ticketPlaceholders);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(), $ticketPlaceholders);
                $thread = ($thread != null) ? $thread : $createdThread;
                $ticketCollaborators = (($thread != null) && !empty($thread->getTicket()) && $thread != "" ) ? $thread->getTicket()->getCollaborators() : [];

              $headers = ['References' => $entity->getReferenceIds()]; 
                if (!empty($thread)) {
                    $headers = ['References' => $entity->getReferenceIds()];
                
                    if (!empty($currentThread) && null != $currentThread->getMessageId()) {
                        $headers['In-Reply-To'] = $currentThread->getMessageId();
                    }

                    $messageId = $container->get('email.service')->sendMail($subject, $message, $entity->getCustomer()->getEmail(), $headers, $entity->getMailboxEmail(), $attachments ?? []);

                    if (!empty($messageId)) {
                        $updatedReferenceIds = $entity->getReferenceIds() . ' ' . $messageId;            
                        $entity->setReferenceIds($updatedReferenceIds);

                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }

                    if($thread->getCc() || $thread->getBcc() || $ticketCollaborators != null && count($ticketCollaborators) > 0) {
                        self::sendCcBccMail($container, $entity, $thread, $subject, $attachments, $ticketCollaborators, $message);
                    }
                    
                } else {
                    if (!empty($entity->getReferenceIds())) {
                        $headers = ['References' => $entity->getReferenceIds()];
                        }
                    
                    $message = $container->get('email.service')->sendMail($subject, $message, $entity->getCustomer()->getEmail(),$headers);
                }
                break;
            default:
                break;
        }
    }

    public static function sendCcBccMail($container, $entity, $thread, $subject, $attachments, $ticketCollaborators, $message = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $collabrator = array();
        $cc = array();

        if($thread->getCc() != null){
            foreach($thread->getCc() as $EmailCC){
                if($entityManager->getRepository(Ticket::class)->isTicketCollaborator($thread->getTicket(), $EmailCC) != false){
                    $collabrator[] = $EmailCC;
                }else{
                    $cc[] = $EmailCC;
                }
           }   
        }

        $emailOfcollabrator = !empty($thread) && $thread->getCreatedBy() == "collaborator" ? $thread->getUser()->getEmail() : null;
        if ($collabrator != null && !empty($collabrator) || $ticketCollaborators != null && !empty($ticketCollaborators)) {
            if (count($collabrator) == 0 && count($ticketCollaborators) > 0 && !empty($ticketCollaborators) && empty($collabrator)) {
                foreach ($ticketCollaborators as $collaborator) {
                    if (!empty($collaborator->getEmail()) && $collaborator->getEmail() != $emailOfcollabrator) {
                        $collabrator[] = $collaborator->getEmail();
                    }
                }
            }

            $messageId = $container->get('email.service')->sendMail($subject, $message, null, [], $entity->getMailboxEmail(), $attachments ?? [], $collabrator ?? [], []); 
            if (!empty($messageId)) {
            $updatedReferenceIds = $entity->getReferenceIds() . ' ' . $messageId;            
            $entity->setReferenceIds($updatedReferenceIds);

            $entityManager->persist($entity);
            $entityManager->flush();
            }

           if($collabrator != null && $thread->getCc()!= null && count($thread->getCc()) == count($collabrator) && $thread->getBcc() != null){
            $message = '<html><body style="background-image: none"><p>'.html_entity_decode($thread->getMessage()).'</p></body></html>';
            $messageId = $container->get('email.service')->sendMail($subject, $message, null, [], $entity->getMailboxEmail(), $attachments ?? [], [], $thread->getBcc() ?? []);  
           }
        }

        if($cc != null && !empty($cc)){
            $message = '<html><body style="background-image: none"><p>'.html_entity_decode($thread->getMessage()).'</p></body></html>';
            $messageId = $container->get('email.service')->sendMail($subject, $message, null, [], $entity->getMailboxEmail(), $attachments ?? [], $cc ?? [], $thread->getBcc() ?? []);    
        }
           
        if($thread->getBcc() != null && $thread->getCc() == null){
            $message = '<html><body style="background-image: none"><p>'.html_entity_decode($thread->getMessage()).'</p></body></html>';
            $messageId = $container->get('email.service')->sendMail($subject, $message, null, [], $entity->getMailboxEmail(), $attachments ?? [], $thread->getCc() ?? [], $thread->getBcc() ?? []);  
        }
    }
}
