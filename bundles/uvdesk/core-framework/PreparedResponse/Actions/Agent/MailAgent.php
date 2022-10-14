<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Agent;

use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;

class MailAgent extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.agent.mail_agent';
    }

    public static function getDescription()
    {
        return "Mail to agent";
    }

    public static function getFunctionalGroup()
    {
        return FunctionalGroup::AGENT;
    }
    
    public static function getOptions(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        return array_map(function ($emailTemplate) {
            return [
                'id' => $emailTemplate->getId(),
                'name' => $emailTemplate->getName(),
            ];
        }, $entityManager->getRepository(EmailTemplates::class)->findAll());
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        switch (true) {
            // Agent created
            case $entity instanceof CoreEntities\User:
                $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value);

                if (empty($emailTemplate)) {
                    // @TODO: Send default email template
                    return;
                }

                $emailPlaceholders = $container->get('email.service')->getEmailPlaceholderValues($entity, 'agent');
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(), $emailPlaceholders);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(), $emailPlaceholders);
                
                $messageId = $container->get('email.service')->sendMail($subject, $message, $entity->getEmail(), []);
                break;
            // Ticket created
            case $entity instanceof CoreEntities\Ticket:
                $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value);

                if (empty($emailTemplate)) {
                    break;
                }

                $ticketPlaceholders = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(), $ticketPlaceholders);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(), $ticketPlaceholders);

                $messageId = $container->get('email.service')->sendMail($subject, $message, $entity->getCustomer()->getEmail(), [
                    'In-Reply-To' => $entity->getUniqueReplyTo(),
                    'References' => $entity->getReferenceIds(),
                ]);

                if (!empty($messageId)) {
                    $thread = $entity->createdThread;
                    $thread->setMessageId($messageId);

                    $entityManager->persist($thread);
                    $entityManager->flush();
                }

                $emailTemplate = $container->get('email.service')->getEmailTemplate($action['value']['value'], $entity->getCompany()->getId());

                // $emails = $this->getAgentMails($action['value']['for'], (($ticketAgent = $object->getAgent()) ? $ticketAgent->getEmail() : ''));

                // if($emails && $emailTemplate) {
                //     $mailData = array();
                //     if($object instanceof Ticket) {
                //         $createThread = $this->container->get('ticket.service')->getCreateReply($object->getId(), false);
                //         $mailData['references'] = $createThread['messageId'];
                //         $mailData['replyTo'] = $object->getUniqueReplyTo();
                //     }

                //     $mailData['email'] = $emails;
                //     $requestParam = $this->request->getCurrentRequest()->request->all();

                //     // if(isset($requestParam['cccol'])) {
                //     //     $mailData['cc'] = $requestParam['cccol'];
                //     // }
                //     // if(isset($requestParam['bcc'])) {
                //     //     $mailData['bcc'] = $requestParam['bcc'];
                //     // }

                //     $this->updateAttachmentPlaceholderFlag($emailTemplate->getMessageInline());

                //     $placeHolderValues = $this->container->get('ticket.service')->getTicketPlaceholderValues($object,'agent');

                //     $mailData['subject'] = $this->container->get('email.service')
                //                                 ->getProcessedSubject($emailTemplate->getSubject(),$placeHolderValues);
                //     $mailData['message'] = $this->container->get('email.service')
                //                                 ->getProcessedTemplate($emailTemplate->getMessageInline(),$placeHolderValues);

                //     // Filtering
                //     foreach($mailData['email'] as $email) {
                //         if ($this->container->get('default.service')->hasPermissionForEmail($email))
                //             $unfilteredEmails[] = $email;
                //         else
                //             $filteredEmails[] = $email;
                //     }


                //     if (!empty($filteredEmails)) {
                //         $filteredMailData = $mailData;
                //         $filteredMailData['email'] = $filteredEmails;
                //         $filteredMailData['subject'] = $this->container->get('default.service')->applyWebkulFilter($filteredMailData['subject'], ['email']);
                //         $filteredMailData['message'] = $this->container->get('default.service')->applyWebkulFilter($filteredMailData['message'], ['email']);

                //         $this->sendMail($filteredMailData);
                //     }
                //     if (!empty($unfilteredEmails)) {
                //         $unfilteredMailData = $mailData;
                //         $unfilteredMailData['email'] = $unfilteredEmails;

                //         $this->sendMail($unfilteredMailData);
                //     }
                // }
                break;
            default:
                break;
        }
    }
}
