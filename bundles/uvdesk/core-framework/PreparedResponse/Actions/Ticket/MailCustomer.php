<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;

class MailCustomer extends PreparedResponseAction
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

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');

        switch (true) {
            case $entity instanceof CoreEntities\Ticket:
                // $currentThread = $entity->currentThread;
                // $createdThread = $entity->createdThread;

                $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value);

                if (empty($emailTemplate)) {
                    break;
                }
                $ticketPlaceholders = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(), $ticketPlaceholders);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(), $ticketPlaceholders);

                $emailHeaders = ['References' => $entity->getReferenceIds()];
                // if (null != $currentThread->getMessageId()) {
                //     $emailHeaders['In-Reply-To'] = $currentThread->getMessageId();
                // }

                $messageId = $container->get('email.service')->sendMail($subject, $message, $entity->getCustomer()->getEmail(), $emailHeaders, $entity->getMailboxEmail());
                // if (!empty($messageId)) {
                //     $createdThread->setMessageId($messageId);

                //     $entityManager->persist($createdThread);
                //     $entityManager->flush();
                // }
                break;
            default:
                break;
        }
    }
}
