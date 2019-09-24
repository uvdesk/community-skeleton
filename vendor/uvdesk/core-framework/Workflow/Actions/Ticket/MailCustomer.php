<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Workflow\Actions\Ticket;

use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Webkul\UVDesk\AutomationBundle\Workflow\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\Workflow\Action as WorkflowAction;

class MailCustomer extends WorkflowAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.mail_customer';
    }

    public static function getDescription()
    {
        return 'Mail to customer';
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
        }, $entityManager->getRepository('UVDeskCoreFrameworkBundle:EmailTemplates')->findAll());

        return $emailTemplateCollection;
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null, $thread = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        switch (true) {
            case $entity instanceof CoreEntities\Ticket:
                $currentThread = $entity->currentThread;
                $createdThread = $entity->createdThread;

                $emailTemplate = $entityManager->getRepository('UVDeskCoreFrameworkBundle:EmailTemplates')->findOneById($value);

                if (empty($emailTemplate)) {
                    break;
                }

                $attachments = [];
                if (!empty($createdThread)) {
                    $threadAttachments = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Attachment')->findByThread($createdThread);

                    foreach ($threadAttachments as $attachment) {
                        $attachments[] = $_SERVER['DOCUMENT_ROOT'] . $attachment->getPath();
                    }
                }

                $ticketPlaceholders = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(), $ticketPlaceholders);
  
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(), $ticketPlaceholders);
   
                $emailHeaders = ['References' => $entity->getReferenceIds()];
                
                if (!empty($currentThread) && null != $currentThread->getMessageId()) {
                    $emailHeaders['In-Reply-To'] = $currentThread->getMessageId();
                }

                $cc = $bcc = [];
                if ($thread !== null){
                    $cc = $thread->getCc();
                    $bcc = $thread->getBcc();
                }

                $messageId = $container->get('email.service')->sendMail($subject, $message, $entity->getCustomer()->getEmail(), $emailHeaders, $entity->getMailboxEmail(), $attachments, $cc, $bcc);
                
                if (!empty($messageId)) {
                    $createdThread->setMessageId($messageId);
                    $entityManager->persist($createdThread);
                    $entityManager->flush();
                }

                break;
            default:
                break;
        }
    }
}
