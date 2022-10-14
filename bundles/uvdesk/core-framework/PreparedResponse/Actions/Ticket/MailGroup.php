<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\PreparedResponse\Actions\Ticket;

use Webkul\UVDesk\AutomationBundle\PreparedResponse\FunctionalGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\AutomationBundle\PreparedResponse\Action as PreparedResponseAction;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\EmailTemplates;

class MailGroup extends PreparedResponseAction
{
    public static function getId()
    {
        return 'uvdesk.ticket.mail_group';
    }

    public static function getDescription()
    {
        return "Mail to group";
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

        $groupCollection = array_map(function ($supportGroup) {
            return [
                'id' => $supportGroup['id'],
                'name' => $supportGroup['name'],
            ];
        }, $container->get('user.service')->getSupportGroups());

        array_unshift($groupCollection, [
            'id' => 'assignedGroup',
            'name' => 'Assigned Group',
        ]);

        return [
            'partResults' => $groupCollection,
            'templates' => $emailTemplateCollection,
        ];
    }

    public static function applyAction(ContainerInterface $container, $entity, $value = null)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $emailTemplate = $entityManager->getRepository(EmailTemplates::class)->findOneById($value['value']);
        
        if($entity instanceof Ticket && $emailTemplate) {
            $mailData = array();
            if($entity instanceof Ticket) {
                $createThread = $container->get('ticket.service')->getCreateReply($entity->getId(),false);
                $mailData['references'] = $createThread['messageId'];
            }
            $to = array();
            foreach ($value['for'] as $grp) {
                foreach ($container->get('user.service')->getUsersByGroupId( (($grp == 'assignedGroup' && $entity->getSupportGroup()) ? $entity->getSupportGroup()->getId() : $grp)) as $agent) {
                    $to[] = $agent['email'];
                }
            }
            if(count($to)) {
                $mailData['email'] = $to;
                $placeHolderValues   = $container->get('email.service')->getTicketPlaceholderValues($entity);
                $subject = $container->get('email.service')->processEmailSubject($emailTemplate->getSubject(),$placeHolderValues);
                $message = $container->get('email.service')->processEmailContent($emailTemplate->getMessage(),$placeHolderValues);

                foreach($mailData['email'] as $email){
                    $messageId = $container->get('email.service')->sendMail($subject, $message, $email);
                }
            }
        } else {
            if (!$emailTemplate) {
                // Email Template Not Found. Disable Workflow/Prepared Response
                //$this->disableEvent($event, $object);
            }
        }  
    }         
}
