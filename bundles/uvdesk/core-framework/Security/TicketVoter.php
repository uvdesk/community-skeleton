<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class TicketVoter extends Voter
{
    const MEMBER_VIEW = 'AGENT_VIEW';
    const CUSTOMER_VIEW = 'CUSTOMER_VIEW';

    private $container;
    private $decisionManager;

    public function __construct(ContainerInterface $container, AccessDecisionManagerInterface $decisionManager)
    {
        $this->container = $container;
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::MEMBER_VIEW, self::CUSTOMER_VIEW])) {
            return false;
        }

        return $subject instanceof \Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
    }

    protected function voteOnAttribute($attribute, $ticket, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof \Webkul\UVDesk\SupportBundle\Entity\User) {
            return false;
        }
        
        switch ($attribute) {
            case self::MEMBER_VIEW:
                if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
                    return true;
                } else if ($this->decisionManager->decide($token, ['ROLE_AGENT'])) {
                    $userInstance = $user->getAgentInstance();
                    dump($userInstance->getTicketAccessLevel());
                    die;

                    // switch ($userInstance->getTicketAccessLevel()) {
                    //     case TICKET::AGENT_GLOBAL_ACCESS:
                    //         return true;
                    //     case TICKET::AGENT_GROUP_ACCESS:
                    //         // $userGroupAccess = (bool)$user->getGroups()->contains($ticket->getGroup());
                    //         // $userTeamAccess = (bool)$user->getUserSubGroup()->contains($ticket->getSubGroup());
                    //         // $access = $userGroupAccess ? $userGroupAccess : $userTeamAccess;
                    //         break;
                    //     case TICKET::AGENT_TEAM_ACCESS:
                    //         // $access = (bool)($user->getUserSubGroup()->contains($ticket->getSubGroup()));
                    //         break;
                    //     case TICKET::AGENT_INDIVIDUAL_ACCESS:
                    //         return (bool) ($user->getId() === $ticket->getAgent()->getId());
                    //         break;
                    //     default:
                    //         break;
                    // }
                }

                break;
            case self::CUSTOMER_VIEW:
                if ($ticket->getIsTrashed()) {
                    return false;
                }
                
                if ($ticket->getCustomer() == $user) {
                    return true;
                } else {
                    // $flag = 0;
                    // $collaborators = $ticket->getCollaborators();

                    // if(count($collaborators)) {
                    //     foreach ($collaborators as $collaborator) {
                    //         if($collaborator == $user)
                    //             $flag = 1;
                    //     }
                    //     if($flag)
                    //         return true;    
                    //     else
                    //         return false;    
                    // }
                }
                
                break;
            default:
                break;
        }

        return false;
    }

    // protected function isGranted($attribute, $ticket, $user = null)
    // {
    //     if (!is_object($user)) {
	//         return false;
	//     }
        
    //     if($attribute == 'FRONT_VIEW') {
    //         if($ticket->getIsTrashed())
    //             return false;
    //         if($ticket->getCustomer() == $user)
    //             return true;
    //         else {
    //             $flag = 0;
    //             $collaborators = $ticket->getCollaborators();
    //             if(count($collaborators)) {
    //                 foreach ($collaborators as $collaborator) {
    //                     if($collaborator == $user)
    //                         $flag = 1;
    //                 }
    //                 if($flag)
    //                     return true;    
    //                 else
    //                     return false;    
    //             }
    //         } 
    //     } else {
            // if($user->getRole() == 'ROLE_AGENT') {
            //     switch($user->getDetail()['agent']->getTicketView()){
            //         case UserData::GLOBAL_ACCESS:
            //             $access = true;
            //         break;
            //         case UserData::GROUP_ACCESS:
            //             $userGroupAccess = (bool)$user->getGroups()->contains($ticket->getGroup());
            //             $userTeamAccess = (bool)$user->getUserSubGroup()->contains($ticket->getSubGroup());
            //             $access = $userGroupAccess ? $userGroupAccess : $userTeamAccess;
            //         break;
            //         case UserData::TEAM_ACCESS:
            //             $access = (bool)($user->getUserSubGroup()->contains($ticket->getSubGroup()));
            //         break;
            //         case UserData::INDIVIDUAL_ACCESS:
            //         default:
            //             $access = (bool)($ticket->getAgent() == $user);
            //         break;
            //     }
            //     if(!$access)
            //         $access = (bool)($ticket->getAgent() == $user);
            //     return $access;    

            //     // if($ticket->getAgent() == $user)
            //     //     return true;
            //     // else {
            //     //     $flag = 0;
            //     //     $agentGroups = $user->getGroups();
            //     //     if($ticket->getGroup()) {
            //     //         foreach ($agentGroups as $group) {
            //     //             if($group->getId() == $ticket->getGroup()->getId())
            //     //                 $flag = 1;
            //     //         }
            //     //         if($flag)
            //     //             return true;    
            //     //         else
            //     //             return false;    
            //     //     } else {
                        
            //     //     }
            //     // } 
            // } else {
            //     return true;
            // }
    //     }
    // }
}